<?php
App::uses('CakeEventListener', 'Event');
App::uses('View', 'View');
class UsuarioListener implements CakeEventListener
{
	public function implementedEvents()
	{
		return array(
			'Model.Usuario.afterSave.created'		=> 'enviarEmailBienvenida',
			'Model.Usuario.afterSave.recuperar'		=> 'enviarEmailRecuperar'
		);
	}

	public function enviarEmailBienvenida(CakeEvent $evento)
	{
		/**
		 * Html del correo
		 */
		$this->View					= new View();
		$usuario					= $evento->data;
		$this->View->viewPath		= 'Emails' . DS . 'html';
		$this->View->layoutPath		= 'Emails' . DS . 'html';
		$html						= $this->View->render('registro', 'default');

		/**
		 * Sender
		 */
		$this->Configuracion		= ClassRegistry::init('Configuracion');
		$sender						= $this->Configuracion->findByNombre('MAILING_CONTACTO');
		$staff						= $this->Configuracion->findByNombre('MAIL_STAFF_REGISTRO');

		/**
		 * Guarda el email a enviar
		 */
		$this->Email				= ClassRegistry::init('Email');
		$this->Email->create();
		$this->Email->save(array(
			'asunto'					=> 'Registro de usuario',
			'destinatario_email'		=> $usuario['Usuario']['email'],
			'destinatario_nombre'		=> sprintf('%s %s %s', $usuario['Usuario']['nombre'], $usuario['Usuario']['apellido_paterno'], $usuario['Usuario']['apellido_materno']),
			'remitente_email'			=> $sender['Configuracion']['valor'],
			'remitente_nombre'			=> $sender['Configuracion']['adicional'],
			'cc'						=> null,
			'bcc'						=> $staff['Configuracion']['valor'],
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

	public function enviarEmailRecuperar(CakeEvent $evento)
	{
		/**
		 * Html del correo
		 */
		$this->View					= new View();
		$usuario					= $evento->data;
		$this->View->viewPath		= 'Emails' . DS . 'html';
		$this->View->layoutPath		= 'Emails' . DS . 'html';
		$this->View->set(compact('usuario'));
		$html						= $this->View->render('recuperar_clave', 'default');

		/**
		 * Sender
		 */
		$this->Configuracion		= ClassRegistry::init('Configuracion');
		$sender						= $this->Configuracion->findByNombre('MAILING_CONTACTO');

		/**
		 * Guarda el email a enviar
		 */
		$this->Email				= ClassRegistry::init('Email');
		$this->Email->create();
		$this->Email->save(array(
			'asunto'					=> 'Recuperación de contraseña',
			'destinatario_email'		=> $usuario['Usuario']['email'],
			'destinatario_nombre'		=> sprintf('%s %s %s', $usuario['Usuario']['nombre'], $usuario['Usuario']['apellido_paterno'], $usuario['Usuario']['apellido_materno']),
			'remitente_email'			=> $sender['Configuracion']['valor'],
			'remitente_nombre'			=> $sender['Configuracion']['adicional'],
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
