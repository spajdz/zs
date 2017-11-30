<?php
App::uses('CakeEventListener', 'Event');
App::uses('View', 'View');
class CompraEntregaDespachoListener implements CakeEventListener
{
	public $View				= null;
	public $Configuracion		= null;
	public $Email				= null;
	public $sender				= null;
	public $staff				= null;


	public function implementedEvents()
	{
		return array(
			'Model.CompraEntregaDespacho.entregaDespacho'	=> 'enviarEmail'
		);
	}

	public function enviarEmail(CakeEvent $evento)
	{
		/**
		 * Instancia las clases necesarias e inicializa la configuracion
		 * requerida para guardar los emails
		 */
		if ( ! $this->View || ! $this->Configuracion || ! $this->Email )
		{
			/**
			 * Instancias
			 */
			$this->View					= new View();
			$this->Configuracion		= ClassRegistry::init('Configuracion');
			$this->Email				= ClassRegistry::init('Email');

			/**
			 * Configuracion
			 */
			$this->View->viewPath		= 'Emails' . DS . 'html';
			$this->View->layoutPath		= 'Emails' . DS . 'html';

			/**
			 * Sender y staff mail
			 */
			$this->Configuracion		= ClassRegistry::init('Configuracion');
			$this->sender				= $this->Configuracion->findByNombre('MAILING_VENTAS');
			$this->staff				= $this->Configuracion->findByNombre('MAIL_STAFF_COMPRAS');
		}

		$this->enviarEmailUsuario($evento);
		//$this->enviarEmailStaff($evento);
	}

	public function enviarEmailUsuario(CakeEvent $evento)
	{
		/**
		 * Html del correo
		 */
		$compra					= $evento->data;
		$this->View->hasRendered	= false;
		$this->View->set(compact('compra'));
		$html						= $this->View->render('entrega_despacho_oc_usuario', 'default');

		/**
		 * Guarda el mail a enviar al usuario
		 */
		$this->Email->create();
		$this->Email->save(array(
			'asunto'					=> sprintf('Notificación de entrega - OC %d', $compra['Compra']['id']),
			'destinatario_email'		=> $compra['Usuario']['email'],
			'destinatario_nombre'		=> sprintf('%s %s %s', $compra['Usuario']['nombre'], $compra['Usuario']['apellido_paterno'], $compra['Usuario']['apellido_materno']),
			'remitente_email'			=> $this->sender['Configuracion']['valor'],
			'remitente_nombre'			=> $this->sender['Configuracion']['adicional'],
			'cc'						=> null,
			'bcc'						=> null,
			'origen'					=> null,
			'via'						=> null,
			'procesado'					=> false,
			'enviado'					=> false,
			'reintentos'				=> 0,
			'html'						=> $html,
			'atachado'					=> null,
			'traza'						=> null,
		));
	}

	public function enviarEmailStaff(CakeEvent $evento)
	{
		/**
		 * Html del correo
		 */
		$compra					= $evento->data;
		$this->View->hasRendered	= false;
		$this->View->set(compact('datosCV'));
		$html						= $this->View->render('trabaja_nosotros_staff', 'default');

		/**
		 * Guarda el mail a enviar al staff
		 */
		$this->Email->create();
		$this->Email->save(array(
			'asunto'					=> 'Trabaja con Nosotros',
			'destinatario_email'		=> $this->staff['Configuracion']['valor'],
			'destinatario_nombre'		=> 'Staff Trabaja con Nosotros Hookipa',
			'remitente_email'			=> $this->sender['Configuracion']['valor'],
			'remitente_nombre'			=> $this->sender['Configuracion']['adicional'],
			'cc'						=> null,
			'bcc'						=> null,
			'origen'					=> null,
			'via'						=> null,
			'procesado'					=> false,
			'enviado'					=> false,
			'reintentos'				=> 0,
			'html'						=> $html,
			'atachado'					=> null,
			'traza'						=> null,
		));
	}
}
