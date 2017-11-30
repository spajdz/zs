<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('View', 'View');
class EnviarEmailsShell extends AppShell
{
	public $uses			= array('Email');
	public $CakeEmail		= null;
	public $host			= 'www.hookipa.cl';
	public $db			    = null;

	public function main()
	{
		$this->db		= ConnectionManager::getDataSource('default')->config['database'];
		$this->out(sprintf('Ejecutando envio de emails pendientes en %s', $this->db));
		$this->hr();

		/**
		 * Instancia CakeEmail
		 */
		if ( ! $this->CakeEmail || ! $this->View )
		{
			$this->CakeEmail			= new CakeEmail();
		}

		/**
		 * Obtiene los mails que no han sido enviados
		 */
		$emails				= $this->Email->find('all', array(
			'conditions'		=> array(
				'Email.enviado'		=> false
			),
			'callbacks'			=> false
		));

		/**
		 * Estadisticas de envio
		 */
		$total				= count($emails);
		$procesados			= 0;
		$enviados			= 0;
		$erroneos			= 0;

		/**
		 * Recorre todos los mails e intenta el envio
		 */
		foreach ( $emails as $email )
		{
			// $this->out('test');
			if ( $this->enviar($email) )
			{
				$enviados++;
			}
			else
			{
				$erroneos++;
			}
			$procesados++;
		}

		/**
		 * Imprime las estadisticas
		 */
		$this->out(sprintf('%s: %02d', str_pad('Emails por enviar', 35), $total));
		$this->out(sprintf('%s: %02d', str_pad('Emails procesados', 35), $procesados));
		$this->out(sprintf('%s: %02d', str_pad('Emails enviados correctamente', 35), $enviados));
		$this->out(sprintf('%s: %02d', str_pad('Emails con error de envio', 35), $erroneos));
		$this->hr();
	}

	public function enviar($datos = array())
	{
		// phpinfo();return true;
		if ( ! $datos )
		{
			return false;
		}

		try
		{
			$this->CakeEmail
				->reset()
				->config('fidelizador')
				->emailFormat('html')
				->domain($this->host)
				->addHeaders(array('X-Mailer' => 'Hookipa - Reach Latam'))
				->from(array($datos['Email']['remitente_email'] => $datos['Email']['remitente_nombre']))
				->subject(sprintf('%s', $datos['Email']['asunto']));

			/**
			 * Destinatarios
			 */
			$destinatarios			= array_map(function($email) { return trim($email); }, explode(',', $datos['Email']['destinatario_email']));
			foreach ( $destinatarios as $destinatario )
			{
				// $this->out($destinatario);
				$this->CakeEmail->addTo($destinatario, $datos['Email']['destinatario_nombre']);
			}

			if ( $datos['Email']['cc'] )
			{
				$copias					= array_map(function($email) { return trim($email); }, explode(',', $datos['Email']['cc']));
				foreach ( $copias as $copia )
				{
					$this->CakeEmail->addCc($copia);
				}
			}
			if ( $datos['Email']['bcc'] )
			{
				$copiasOcultas			= array_map(function($email) { return trim($email); }, explode(',', $datos['Email']['bcc']));
				foreach ( $copiasOcultas as $copiaOculta )
				{
					$this->CakeEmail->addBcc($copiaOculta);
				}
			}

			$formato		= true;
		}
		catch ( SocketException $e )
		{
			$formato		= false;
		}

		if ( ! $formato )
		{
			return false;
		}

		try
		{
			$this->CakeEmail->send($datos['Email']['html']);
			$enviado		= true;
		}
		catch ( SocketException $e )
		{
			$enviado		= false;
		}
		finally
		{
			$this->Email->id		= $datos['Email']['id'];
			$this->Email->save(array(
				'procesado'			=> true,
				'enviado'			=> $enviado,
				'reintentos'		=> ($datos['Email']['reintentos'] + 1)
			));
		}

		return $enviado;
	}
}
