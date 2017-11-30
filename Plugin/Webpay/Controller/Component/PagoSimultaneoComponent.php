<?php
App::uses('Component', 'Controller');
App::import('Vendor', 'Webpay.PagoSimultaneoWS', array('file' => 'pagoSimultaneo/PagoSimultaneoWS.php'));
App::import('Vendor', 'Webpay.SoapValidation', array('file' => 'pagoSimultaneo/wss/soap-validation.php'));

class PagoSimultaneoComponent extends Component
{
	public $components = array('Session');
	public $Controller = null;

	private $PagoSimultaneoWS;
	private $AnulacionWS;

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
	* Función que se conecta con el WS de Pago Simultaneo
	*/
	private function connect()
	{
		$this->PagoSimultaneoWS = new PagoSimultaneoWS(Configure::read('Webpay.PagoSimultaneo.endpoint'));
	}

	/**
	* Función que valida que las firmas y certificados de respuesta son correctos
	*/
	private function validate()
	{
		$xmlResponse = $this->PagoSimultaneoWS->soapClient->__getLastResponse();
		$soapValidation = new SoapValidation($xmlResponse, Configure::read('Webpay.PagoSimultaneo.server_cert'));

		if ( ! $soapValidation->getValidationResult() )
		{
			throw new Exception('Respuesta de Transbank no está correctamente firmada o el certificado de servidor es incorrecto.');
		}

		CakeLog::write('debug', $xmlResponse);
	}

	/**
	* Función inicia el proceso con Transbank
	*/
	public function initTransaccion( $transactionType = null, $commerceId = null, $buyOrder = null, $sessionId = null, $returnUrl = null, $finalUrl = null , $commerceCode = null, $amount = null)
	{
		/**
		* Se realiza la conexión con el WS
		*/
		$this->connect();

		/** Datos de la transacción:
		* $transactionType 	Especifica que se hará el proceso de pago simultaneo, siempre es TR_NORMAL_WS
		* $commerceId 		Contiene el id de comercio que entrega transbank
		* $sesionId 		No se utilizará
		* $buyOrder 		Es generado siguiendo el formato YYYYmmddHHmmssabc en donde a, b y c son numeros aleatorios
		* $returnUrl 		Indica a que URL redirige transbank luego de autorizar la compra
		* $finalUrl 		Indica a que URL redirije transbank luego de que se realiza el pago
		* $commerceCode 	Contiene el id de comercio que entrega transbank
		* $amount 			Contiene el monto a pagar por el usuario
		*/

		$wsInitTrasaccionInput = new wsInitTransactionInput();
		$wsInitTrasaccionDetail = new wsTransactionDetail();

		$wsInitTrasaccionInput->wSTransactionType = $transactionType;
		$wsInitTrasaccionInput->commerceId = $commerceId;
		$wsInitTrasaccionInput->sessionId = $sessionId;
		$wsInitTrasaccionInput->buyOrder = $buyOrder;
		$wsInitTrasaccionInput->returnURL = $returnUrl;
		$wsInitTrasaccionInput->finalURL = $finalUrl;

		/**
		* $wsInitTrasaccionDetail	Contiene los datos de la transacción, se envia en forma de lista 
		*/
		$wsInitTrasaccionDetail->commerceCode = $commerceCode;
		$wsInitTrasaccionDetail->buyOrder = $buyOrder;
		$wsInitTrasaccionDetail->amount = $amount;

		$wsInitTrasaccionInput->transactionDetails = $wsInitTrasaccionDetail;

		/**
		* Se envian los datos mediante el WS
		*/
		$initTransaccionResponse = $this->PagoSimultaneoWS->initTransaction(
			array(
				"wsInitTransactionInput" => $wsInitTrasaccionInput
			)
		);

		/**
		* Se obtiene y valida la respuesta del WS
		*/
		$this->validate();
		
		/**
		* Se procesa la respuesta
		*/
		$wsInitTransaccionOutput = $initTransaccionResponse->return;

		$this->Session->write('Webpay.PagoSimultaneo.initTransaction', $wsInitTransaccionOutput);

		$tokenPagoSimultaneo = $wsInitTransaccionOutput->token;
		$urlRedirect = $wsInitTransaccionOutput->url;

		/**
		* Se guarda el token de la transacción en sesion
		*/
		$this->Session->write('token', $tokenPagoSimultaneo);

		$this->Controller->redirect(array('controller' => 'pagosimultaneo', 'action' => 'transaccion', '?' => array('token' => $tokenPagoSimultaneo, 'url' => $urlRedirect), 'plugin' => 'webpay'));

	}

	public function getTransaccionResult($token_ws){
		/**
		* Se realiza la conexión con el WS
		*/
		$this->connect();

		/** Datos de la transacción:
		* $token_ws 	Contiene el token de la transacción entregado por Transbank
		*/
		$getTransactionResult = new getTransactionResult();
		$getTransactionResult->tokenInput = $token_ws;

		/**
		* Se envian los datos mediante el WS
		*/
		$getTransactionResultResponse = $this->PagoSimultaneoWS->getTransactionResult($getTransactionResult);

		if (!$getTransactionResultResponse) {
			throw new Exception('Error');
		}

		/**
		* Se obtiene y valida la respuesta del WS
		*/

		$transactionResultOutput = $getTransactionResultResponse->return;
		$this->validate();

		/**
		* Datos recibidos:
		* urlRedirection		URL en la cual se va a continuar el flujo de la compra
		* detailOutput 			Contiene el detalle del resultado de la transacción como:
		*						cod. autorización,tipo de pago, cod. respuesta, monto,
		*						cod. comercio y orden de compra
		* carddetails 			Contiene los datos de la tarjeta utilizada en la transacción
		* accountingDate		Contiene la fecha de la autorización  formato MMDD 
		* transactionDate		Contiene la fecha y hora de la autorización	 formato: MMDDHHmm 
		* vci 					Resultado de la autenticación para comercios Webpay Plus y/o 3D Secure
		*/

		$url 						= $transactionResultOutput->urlRedirection;
		$wsTransactionDetailOutput 	= $transactionResultOutput->detailOutput;
		$carddetails 				= $transactionResultOutput->cardDetail;
		$accountingDate 			= $transactionResultOutput->accountingDate;
		$transactionDate 			= $transactionResultOutput->transactionDate;
		$vci 						= $transactionResultOutput->VCI;

		/**
		* Datos recibidos en el wsTransactionDetailOutput
		*/
		$authorizationCode 			= $wsTransactionDetailOutput->authorizationCode;
		$paymentTypeCode 			= $wsTransactionDetailOutput->paymentTypeCode;
		$responseCode 				= $wsTransactionDetailOutput->responseCode;
		$sharesNumber 				= $wsTransactionDetailOutput->sharesNumber;
		$amount 					= $wsTransactionDetailOutput->amount;
		$commerceCode				= $wsTransactionDetailOutput->commerceCode;
		$buyOrder 					= $wsTransactionDetailOutput->buyOrder;

		/**
		* Datos recibidos en el carddetails
		*/
		$cardNumber 				= $carddetails->cardNumber;
		$cardExpirationDate 		= $carddetails->cardExpirationDate;

		/**
		* Si el código de respuesta es 0 la transacción  está autorizada
		*/
		if ($responseCode == 0) {
				/**
				* Se obtienen  los detalles de la compra
				*/
				$detallesCompra = array(
					'token_ws'					=> $token_ws,
					'url_comprobante'			=> $url,
					'tbk_codigo_autorizacion' 	=> $authorizationCode,
					'tbk_tipo_pago'				=> $paymentTypeCode,
					'tbk_respuesta'				=> $responseCode,
					'tbk_numero_cuotas'			=> $sharesNumber,
					'tbk_monto'					=> $amount,
					'cod_comercio'				=> $commerceCode,
					'tbk_orden_compra'			=> $buyOrder,
					'tbk_final_numero_tarjeta'	=> $cardNumber,
					'tbk_fecha_transaccion'		=> $transactionDate,
					'tbk_vci'					=> $vci
				);

			return $detallesCompra;
		}else{
			return $responseCode;
		}

	}

	public function acknowledgeTransaccion($token_ws){
		/**
		* Se realiza la conexión con el WS
		*/
		$this->connect();

		/** Datos de la transacción:
		* $token_ws 	Contiene el token de la transacción entregado por Transbank
		*/
		$acknowledgeTransaction = new acknowledgeTransaction();
		$acknowledgeTransaction->tokenInput = $token_ws;

		/**
		* Se envian los datos mediante el WS
		*/
		$acknowledgeTransactionResponse = $this->PagoSimultaneoWS->acknowledgeTransaction($acknowledgeTransaction);

		/**
		* Se valida la respuesta del WS
		*/
		$this->validate();

		return $acknowledgeTransactionResponse;

	}

	/**
	* 	ANULACIÓN DE TRANSACCIONES
	*/

	/**
	* Función que permite anular una transacción de pago Webpay.
	*
	* @param $authorizationCode Código de autorización de la transacción que se requiere anular.
	* @param $authorizedAmount  Monto autorizado de la transacción que se requiere anular.
	* @param $buyOrder 			Orden de compra de la transacción que se requiere anular
	* @param $commerceId 		Código de comercio que realizó la transacción
	* @param $nullifyAmount 	Monto que se desea anular de la transacción
	*/
	public function anularCompra($authorizationCode = null, $authorizedAmount = null, $buyOrder = null, $commerceId = null, $nullifyAmount = null)
	{
		/**
		* 	Se importa el WS de Anulación y se crea la conexión
		*/
		App::import('Vendor', 'Webpay.AnulacionWS', array('file' => 'anulacion/AnulacionWS.php'));
		$this->AnulacionWS = new AnulacionWS(Configure::read('Webpay.Anulacion.endpoint'));

		/** Datos de la transacción:
		* $authorizationCode 	Contiene el código de autorización entregado por Transbank
		* $commerceId			Contiene el código del comercio entregado por Transbank
		* $buyOrder				Contiene la Orden de compra que se quiere anular
		* $authorizedAmount		Contiene monto total de la compra
		* $nullifyAmount		Contiene monto que se desea anular
		*/
		
		$nullificationInput 					= new nullificationInput();
		$nullificationInput->authorizationCode 	= $authorizationCode;
		$nullificationInput->commerceId 		= $commerceId;
		$nullificationInput->buyOrder 			= $buyOrder;
		$nullificationInput->authorizedAmount 	= $authorizedAmount;
		$nullificationInput->nullifyAmount 		= $nullifyAmount;

		/**
		* Se envian los datos mediante el WS
		*/
		$nullificationOutput = $this->AnulacionWS->nullify(
			array( 'nullificationInput' => $nullificationInput )
		);

		/**
		* Se valida la respuesta del WS
		*/
		$this->validateNullify();

		return $nullificationOutput->return;

	}

	/**
	* Función que valida que las firmas y certificados de respuesta son correctos para la anulación
	*/
	private function validateNullify()
	{

		App::import('Vendor', 'Webpay.SoapValidation', array('file' => 'anulacion/wss/soap-validation.php'));

		$xmlResponse = $this->AnulacionWS->soapClient->__getLastResponse();

		$soapValidation = new SoapValidation($xmlResponse, Configure::read('Webpay.Anulacion.server_cert'));
		if ( ! $soapValidation->getValidationResult() )
		{
			throw new Exception('Respuesta de Transbank no está correctamente firmada o el certificado de servidor es incorrecto.');
		}

		CakeLog::write('debug', $xmlResponse);
	}

}
