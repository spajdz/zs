<?php
App::uses('Component', 'Controller');
App::import('Vendor', 'Webpay.OneclickWS', array('file' => 'oneclick/OneclickWS.php'));
App::import('Vendor', 'Webpay.SoapValidation', array('file' => 'oneclick/wss/soap-validation.php'));

class OneclickComponent extends Component
{
	public $components = array('Session');
	public $Controller = null;
	private $OneclickWS;

	/**
	* Función en donde se carga el archivo que contiene las rutas de los certificados, firmas y endpoints
	*/
	public function initialize(Controller $controller)
	{
		$this->Controller = $controller;
		try
		{
			Configure::load('webpay');
		}
		catch ( Exception $e )
		{
			throw new Exception('No se encontró el archivo Config/webpay.php');
		}
	}

	/**
	* Función que se conecta con el WS de Oneclick
	*/
	private function connect()
	{
		$this->OneclickWS = new OneclickWS(Configure::read('Webpay.Oneclick.endpoint'));
	}

	/**
	* Función que valida que las firmas y certificados de respuesta son correctos
	*/
	private function validate()
	{
		$xmlResponse = $this->OneclickWS->soapClient->__getLastResponse();
		$soapValidation = new SoapValidation($xmlResponse, Configure::read('Webpay.Oneclick.server_cert'));
		if ( ! $soapValidation->getValidationResult() )
		{
			throw new Exception('Respuesta de Oneclick no está correctamente firmada o el certificado de servidor es incorrecto.');
		}
		CakeLog::write('debug', $xmlResponse);
	}

	/**
	* Función que inicia el proceso de inscripción con Transbank
	*/
	public function initInscripcion($username = null, $email = null, $responseURL = null)
	{
		if ( ! $username || ! $email || ! $responseURL )
		{
			throw new Exception('Faltan datos de entrada ($username, $email, $responseURL)');
		}

		/**
		* Se realiza la conexión con el WS
		*/
		$this->connect();

		/**
		 * Datos de inscripción
		 * username 	Contiene el username del usuario
		 * email 		Contiene el email del usuario
		 * responseURL	Contiene la URL a la cual se redirige cuando termina la inscripción
		 */
		$oneClickInscriptionInput = new oneClickInscriptionInput();
		$oneClickInscriptionInput->username = $username;
		$oneClickInscriptionInput->email = $email;
		$oneClickInscriptionInput->responseURL = $responseURL;

		/**
		* Se envian los datos mediante el WS
		*/
		$oneClickInscriptionResponse = $this->OneclickWS->initInscription(array('arg0' => $oneClickInscriptionInput));

		/**
		* Se obtiene y valida la respuesta del WS
		*/
		$this->validate();

		/**
		* Se procesa la respuesta
		*/
		$oneClickInscriptionOutput = $oneClickInscriptionResponse->return;

		$this->Session->write('Webpay.Oneclick.initInscripcion', $oneClickInscriptionOutput);
		
		$tokenOneClick = $oneClickInscriptionOutput->token;
		$inscriptionURL = $oneClickInscriptionOutput->urlWebpay;

		$this->Controller->redirect(array('controller' => 'oneclick', 'action' => 'inscripcionOneclick', '?' => array('token' => $tokenOneClick, 'url' => $inscriptionURL), 'plugin' => 'webpay'));
	}

	/**
	* Función que finaliza una inscripción
	*/
	public function finishInscripcion($token = null)
	{
		if ( ! $token )
		{
			throw new Exception('Faltan datos de entrada ($token)');
		}

		/**
		* Se realiza la conexión con el WS
		*/
		$this->connect();

		/**
		* Datos de inscripción
		* $token 	Contiene el token de la transacción entregado por Transbank
		*/
		$oneClickFinishInscriptionInput = new oneClickFinishInscriptionInput();
		$oneClickFinishInscriptionInput->token = $token;

		/**
		* Se envian los datos mediante el WS
		*/
		$oneClickFinishInscriptionResponse = $this->OneclickWS->finishInscription(array('arg0' => $oneClickFinishInscriptionInput));

		/**
		* Se obtiene y valida la respuesta del WS
		*/
		$this->validate();

		/**
		* Se procesa la respuesta
		*/
		$oneClickFinishInscriptionOutput = $oneClickFinishInscriptionResponse->return;

		$this->Session->write('Webpay.Oneclick.finishInscripcion', $oneClickFinishInscriptionOutput);
		
		return $oneClickFinishInscriptionOutput;
	}

	/**
	* Función que da de baja a un usuario de Oneclick
	*/
	public function removeUser($tbkUser = null, $username = null)
	{
		if ( ! $tbkUser || ! $username )
		{
			throw new Exception('Faltan datos de entrada ($tbkUser, $username)');
		}

		/**
		* Se realiza la conexión con el WS
		*/
		$this->connect();

		/**
		* Datos de inscripción
		* tbkUser	Contiene el token del usuario enviado por transbank al inscribir al usuario en Oneclick
		* username 	Contiene el username con el que se creo el usuario al inscribirse a Oneclick
		*/
		$oneClickRemoveUserInput = new oneClickPayInput();
		$oneClickRemoveUserInput->tbkUser = $tbkUser;
		$oneClickRemoveUserInput->username = $username;

		/**
		* Se envian los datos mediante el WS
		*/
		$oneClickRemoveUserResponse = $this->OneclickWS->removeUser(array('arg0' => $oneClickRemoveUserInput));

		/**
		* Se obtiene y valida la respuesta del WS
		*/
		$this->validate();

		/**
		 * Se procesa la respuesta
		 */
		$oneClickRemoveUserOutput = $oneClickRemoveUserResponse->return;

		$this->Session->write('Webpay.Oneclick.removeUser', (bool) $oneClickRemoveUserOutput);

		return $oneClickRemoveUserOutput;
	}

	/**
	* Función para autorizar un pago con Oneclick
	*/
	public function authorize($amount = null, $buyOrder = null, $tbkUser = null, $username = null)
	{
		if ( ! $amount || ! $buyOrder || ! $tbkUser || ! $username )
		{
			throw new Exception('Faltan datos de entrada ($amount, $buyOrder, $tbkUser, $username)');
		}

		/**
		* Se realiza la conexión con el WS
		*/
		$this->connect();

		/**
		* Datos de inscripción
		* amount 		Contiene el monto del pago
		* buyorder 		Contiene el número de la orden de Compra
		* tbkUser 		Contiene el token de usuario enviado por Transbank
		* username 		Contiene el username del usuario en transbank
		*/
		$oneClickPayInput = new oneClickPayInput();
		$oneClickPayInput->amount = $amount;
		$oneClickPayInput->buyOrder = $buyOrder;
		$oneClickPayInput->tbkUser = $tbkUser;
		$oneClickPayInput->username = $username;


		/**
		* Se envian los datos mediante el WS
		*/
		$authorizeResponse = $this->OneclickWS->authorize(array('arg0' => $oneClickPayInput));
		if ( ! is_object($authorizeResponse) )
		{
			throw new Exception('Error al realizar pago');
		}

		/**
		* Se obtiene y valida la respuesta del WS
		*/
		$this->validate();

		/**
		* Se procesa la respuesta
		*/
		$oneClickPayOutput = $authorizeResponse->return;

		$this->Session->write('Webpay.Oneclick.authorize', $oneClickPayOutput);

		return $oneClickPayOutput;
	}

	/**
	* Función para reversar una venta
	*/
	public function codeReverseOneClick($buyorder = null)
	{
		if ( ! $buyorder )
		{
			throw new Exception('Faltan datos de entrada ($buyorder)');
		}

		/**
		* Se realiza la conexión con el WS
		*/
		$this->connect();

		/**
		* Datos de inscripción
		* buyorder 	Contiene el número de la Orden de Compra
		*/
		$oneClickReverseInput = new oneClickReverseInput();
		$oneClickReverseInput->buyorder = $buyorder;

		/**
		* Se envian los datos mediante el WS
		*/
		$codeReverseOneClickResponse = $this->OneclickWS->codeReverseOneClick(array('arg0' => $oneClickReverseInput));

		/**
		* Se obtiene y valida la respuesta del WS
		*/
		$this->validate();

		/**
		* Se procesa la respuesta
		*/
		$oneClickReverseOutput = $codeReverseOneClickResponse->return;

		debug( (int) $oneClickReverseOutput->reverseCode );

		$this->Session->write('Webpay.Oneclick.codeReverseOneClick', $oneClickReverseOutput);
		
		return $oneClickReverseOutput;
	}
}
