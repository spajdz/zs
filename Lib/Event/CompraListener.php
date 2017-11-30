<?php
App::uses('CakeEventListener', 'Event');
App::uses('View', 'View');
class CompraListener implements CakeEventListener
{
	public $View				= null;
	public $Configuracion		= null;
	public $Email				= null;
	public $Reserva				= null;
	public $Lista				= null;
	public $sender				= null;
	public $staff_compras		= null;
	public $staff_reservas		= null;

	public function implementedEvents()
	{
		return array(
			'Model.Compra.afterSave'	=> 'enviarEmail'
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
			$this->Reserva				= ClassRegistry::init('Reserva');
			$this->Lista				= ClassRegistry::init('Lista');

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
			$this->staff_compras		= $this->Configuracion->findByNombre('MAIL_STAFF_COMPRAS');
			$this->staff_reservas		= $this->Configuracion->findByNombre('MAIL_STAFF_RESERVAS');
		}

		/**
		 * Html del correo
		 */
		$compra					= $evento->data;
		$this->View->set(compact('compra'));

		/**
		 * Verifica si la compra fue por uniformes por colegio, para agregar el nombre del colegio
		 */

		/**
		if ( $compra['Compra']['lista'] )
		{
			$listas_id		= array_unique(Hash::extract($compra, 'DetalleCompra.{n}.lista_id'));
			$listas			= $this->Lista->find('all', array(
				'conditions'		=> array('Lista.id' => $listas_id)
			));
			$colegio		= $listas[0]['Lista']['nombre_colegio'];
			$this->View->set(compact('colegio'));
		}
		*/
		$html					= $this->View->render('compra', 'default');

		/**
		 * Guarda el mail a enviar al usuario
		 */

		$this->Email->create();
		$this->Email->save(array(
			'asunto'					=> sprintf('Notificación de Compra - OC %d', $compra['Compra']['id']),
			'destinatario_email'		=> $compra['Usuario']['email'],
			'destinatario_nombre'		=> sprintf('%s %s %s', $compra['Usuario']['nombre'], $compra['Usuario']['apellido_paterno'], $compra['Usuario']['apellido_materno']),
			'remitente_email'			=> $this->sender['Configuracion']['valor'],
			'remitente_nombre'			=> $this->sender['Configuracion']['adicional'],
			'cc'						=> null,
			'bcc'						=> $this->staff_compras['Configuracion']['valor'],
			'origen'					=> null,
			'via'						=> null,
			'procesado'					=> false,
			'enviado'					=> false,	
			// 'procesado'					=> 1,
			// 'enviado'					=> 1,
			'reintentos'				=> 0,
			'html'						=> $html,
			'atachado'					=> null,
			'traza'						=> null,
		));

		/**
		 * Si es reserva, envia los contratos al usuario
		 */
		if ( $compra['Compra']['reserva'] )
		{
			$reservas_id	= array_unique(Hash::extract($compra, 'DetalleCompra.{n}.reserva_id'));
			$reservas		= $this->Reserva->find('all', array(
				'conditions'		=> array('Reserva.id' => $reservas_id)
			));

			foreach ( $reservas as &$reserva )
			{
				$cantidad			= 0;
				$total				= 0;

				/**
				 * Leyenda de colegio
				 */
				$this->Reserva->usarDsBooks();
				$leyenda			= $this->Reserva->query("SELECT GIEN FROM MAEEN WHERE LVEN = '{$reserva['Reserva']['LVEN']}' AND SUBSTRING(KOEN, 11, 1) = 'T'");
				if ( ! empty($leyenda[0][0]['GIEN']) )
				{
					$reserva['Reserva']['leyenda']		= $leyenda[0][0]['GIEN'];
				}
				$this->Reserva->usarDsLocal();

				foreach ( $compra['DetalleCompra'] as $detalle )
				{
					if ( $detalle['reserva_id'] == $reserva['Reserva']['id'] )
					{
						$cantidad		= ($cantidad + $detalle['cantidad']);
						$total			= ($total + $detalle['total']);
					}
				}

				$reserva['Reserva']['cantidad']		= $cantidad;
				$reserva['Reserva']['total']		= $total;

				$this->View->hasRendered		= false;
				$this->View->set(compact('reserva'));
				$html					= $this->View->render('reserva', 'default');
				$this->Email->create();
				$this->Email->save(array(
					'asunto'					=> sprintf('Contrato de Reserva - %s %s - OC %d', $reserva['Reserva']['nombre_alumno'], $reserva['Reserva']['apellido_alumno'], $compra['Compra']['id']),
					'destinatario_email'		=> $compra['Usuario']['email'],
					'destinatario_nombre'		=> sprintf('%s %s %s', $compra['Usuario']['nombre'], $compra['Usuario']['apellido_paterno'], $compra['Usuario']['apellido_materno']),
					'remitente_email'			=> $this->sender['Configuracion']['valor'],
					'remitente_nombre'			=> $this->sender['Configuracion']['adicional'],
					'cc'						=> null,
					'bcc'						=> $this->staff_reservas['Configuracion']['valor'],
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
	}
}
