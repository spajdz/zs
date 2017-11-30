<?php
App::uses('CakeEventListener', 'Event');
App::uses('View', 'View');
class ContactoListener implements CakeEventListener
{
	public $View				= null;
	public $Configuracion		= null;
	public $Email				= null;
	public $sender				= null;
	public $staff				= null;


	public function implementedEvents()
	{
		return array(
			'Model.Contacto.afterSave'	=> 'enviarEmail'
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
		}

		$this->enviarEmailAdministrador($evento);
	}

	public function enviarEmailAdministrador(CakeEvent $evento)
	{
		/**
		 * Html del correo
		 */
		$contacto					= $evento->data;
		$this->View->hasRendered	= false;
		$this->View->set(compact('contacto'));

		$vista = 'consultas/vista_consulta_general';
		$asunto = 'Formulario de Contacto';

		if(!empty($contacto['Contacto']['tipo_contacto_id']) && $contacto['Contacto']['tipo_contacto_id'] == 3){
			$vista = 'consultas/vista_consulta_inscripcion_mayorista';
			$asunto = 'Formulario inscripción cliente mayorista';
		}

		if( !empty($contacto['Contacto']['tipo_contacto_id']) && $contacto['Contacto']['tipo_contacto_id'] == 4){
			$vista = 'consultas/vista_consulta_producto';
			$asunto = 'Formulario consulta producto';
		}

		$html 	= $this->View->render($vista, 'default');

		/**
		 * Guarda el mail a enviar al usuario
		 */
		$this->Email->create();
		$this->Email->save(array(
			'asunto'					=> $asunto,
			'destinatario_email'		=> 'stephanie.pinero@reach-latam.com',
			'destinatario_nombre'		=> 'Administrador',
			'remitente_email'			=> 'sitio@zsmotor.cl',
			'remitente_nombre'			=> 'Zsmotor',
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
		$contacto					= $evento->data;
		$this->View->hasRendered	= false;
		$this->View->set(compact('contacto'));
		$html						= $this->View->render('contacto_staff', 'default');

		/**
		 * Guarda el mail a enviar al staff
		 */
		$this->Email->create();
		$this->Email->save(array(
			'asunto'					=> 'Contacto Web',
			'destinatario_email'		=> $this->staff['Configuracion']['valor'],
			'destinatario_nombre'		=> 'Staff Contacto Hookipa',
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
