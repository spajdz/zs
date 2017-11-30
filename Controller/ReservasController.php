<?php
App::uses('AppController', 'Controller');
class ReservasController extends AppController
{
	/*
	public function testemail()
	{
		$compra			= $this->Reserva->DetalleCompra->Compra->find('first', array(
			'conditions'		=> array('Compra.id' => 33426),
			'contain'			=> array(
				'Usuario',
				'DetalleCompra'		=> array('Producto', 'Lista', 'Reserva'),
				'EstadoCompra',
				'Direccion'			=> array('Comuna' => array('Region')),
			)
		));

		$reservas_id	= array_unique(Hash::extract($compra, 'DetalleCompra.{n}.reserva_id'));
		$reservas		= $this->Reserva->find('all', array(
			'conditions'		=> array('Reserva.id' => $reservas_id)
		));

		foreach ( $reservas as &$reserva )
		{
			$cantidad			= 0;
			$total				= 0;

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

			$this->set(compact('compra', 'reserva', 'cantidad'));
			$this->viewPath			= 'Emails' . DS . 'html';
			$this->layoutPath		= 'Emails' . DS . 'html';
			$html					= $this->render('reserva', 'default');
			echo $html;
			exit;
		}
		prx('heh');
	}
	*/

	/**
	 * Deshabilitado a peticion de Pamela Dubo
	 * Alvaro <2016-11-01>
	 * Modificado: Steven <2016-19-01>
	 * 	Desde el Backend (Modulo configuraciones), se puede habilitar
	 * 	o deshabilitar las reservas
	 */
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->redirect('/');

		/**
			Se obtiene la configuracion del reservar, y asi saber si
			esta esta habilitada o no
		*/
		$this->Configuracion        = ClassRegistry::init('Configuracion');
		$config_reserva		= $this->Configuracion->find('first', array(
			'conditions'		=> array('Configuracion.nombre' => 'RESERVA'),
			'fields'			=> array('activo')
		));
		if ( ! $config_reserva['Configuracion']['activo'] )
		{
			$this->redirect('/');
		}
		/**
		 * Comprueba que el usuario este logeado
		 */
		if ( ! $this->Auth->user() )
		{
			$this->Session->write('Flujo.loginPending', array('controller' => 'reservas', 'action' => 'add'));
			$this->redirect(array('controller' => 'usuarios', 'action' => 'login'));
		}
	}

	public function cambiar_colegio()
	{
		/**
		 * Comprueba que el usuario este logeado
		 */
		if ( ! $this->Auth->user() )
		{
			$this->Session->write('Flujo.loginPending', array('controller' => 'reservas', 'action' => 'add'));
			$this->redirect(array('controller' => 'usuarios', 'action' => 'login'));
		}

		$this->Carro->vaciar();
		$this->Session->delete('Flujo.Reserva');
		$this->redirect(array('action' => 'add'));
	}

	public function colegio()
	{
		/**
		 * Comprueba que el usuario este logeado
		 */
		if ( ! $this->Auth->user() )
		{
			$this->Session->write('Flujo.loginPending', array('controller' => 'reservas', 'action' => 'add'));
			$this->redirect(array('controller' => 'usuarios', 'action' => 'login'));
		}

		if ( $this->request->is('post') )
		{
			$colegios			= $this->Reserva->getColegiosReserva();
			foreach ( $colegios as $id => $colegio )
			{
				$colegios[$colegio['lista']] = $colegio;
				unset($colegios[$id]);
			}

			if ( ! empty($this->request->data['Reserva']['colegio']) && isset($colegios[$this->request->data['Reserva']['colegio']]) )
			{
				$this->Session->write('Flujo.Reserva.Colegio', $colegios[$this->request->data['Reserva']['colegio']]);
				$this->Carro->vaciar();
			}
			else
			{
				$this->Session->setFlash('Debes seleccionar un colegio.', null, array(), 'danger');
			}
		}
		$this->redirect(array('action' => 'add'));
	}

	public function add()
	{
		/**
		 * Comprueba que el usuario este logeado
		 */
		if ( ! $this->Auth->user() )
		{
			$this->Session->write('Flujo.loginPending', array('controller' => 'reservas', 'action' => 'add'));
			$this->redirect(array('controller' => 'usuarios', 'action' => 'login'));
		}

		/**
		 * Recibe los datos para crear la reserva
		 */
		if ( $this->request->is('post') )
		{
			if ( $this->Session->check('Flujo.Reserva.Colegio') )
			{
				$colegio					= $this->Session->read('Flujo.Reserva.Colegio');
				$this->request->data		= array_merge_recursive($this->request->data, array(
					'Reserva'		=> array(
						'LVEN'				=> $colegio['lista'],
						'nombre_colegio'	=> $colegio['nombre'],
						'codigo_colegio'	=> $colegio['codigo']
					)
				));
				if ( $this->Reserva->save($this->request->data) )
				{
					$this->redirect(array('action' => 'add'));
				}
			}
			$this->Session->setFlash('Error al guardar la reserva. Por favor intenta nuevamente.', null, array(), 'danger');
		}

		/**
		 * Colegio no seleccionado
		 */
		$colegio			= $this->Session->read('Flujo.Reserva.Colegio');
		$reservas			= array();
		$niveles			= array();
		if ( ! $colegio )
		{
			$colegios			= $this->Reserva->getColegiosReserva();
			if ( ! $colegios )
			{
				$this->redirect('/');
			}
			$colegios			= Hash::combine($colegios, '{n}.lista', '{n}.nombre');
		}

		/**
		 * Colegio seleccionado
		 */
		if ( $colegio )
		{
			$reservas			= $this->Reserva->find('all', array(
				'conditions'		=> array(
					'Reserva.usuario_id'	=> $this->Auth->user('id'),
					'Reserva.activo'		=> true,
					'Reserva.LVEN'			=> $colegio['lista']
					/*
					'Reserva.created >='	=> sprintf('%d-01-01', date('Y')),
					'Reserva.created <='	=> sprintf('%d-12-31', date('Y'))
					*/
				),
				'order'				=> array('Reserva.id' => 'DESC')
			));
			$niveles			= $this->Reserva->getNiveles($colegio['lista']);
			if ( ! empty($niveles) )
			{
				$niveles			= Hash::combine($niveles, '{n}.name', '{n}.name');
			}
		}

		if ( $reservas )
		{
			/**
			 * Recorre las reservas y agrega los uniformes al carro
			 */
			foreach ( $reservas as $index => &$reserva )
			{
				$textos					= (array) $this->Reserva->getTextos(
					$reserva['Reserva']['LVEN'],
					$reserva['Reserva']['nivel']
				);

				/**
				 * Si no tiene textos, elimina la reserva y redirecciona  al home de reserva
				 */
				if ( empty($textos) || empty($textos[0]) )
				{
					$this->Reserva->id	= $reserva['Reserva']['id'];
					if ( $this->Reserva->delete($reserva['Reserva']['id']) )
					{
						$this->redirect('/reservas');
					}
					else
					{
						unset($reservas[$index]);
					}
					//$this->Session->setFlash('Alguna de tus reservas no tienen uniformes asociados. Por favor revisa los datos.', null, array(), 'danger');
				}
				foreach ( $textos as $texto )
				{
					/**
					 * Agrega el producto al carro
					 */
					$lista		= sprintf('reserva.%d', $reserva['Reserva']['id']);
					if ( ! $this->Carro->producto($texto['Producto']['id'], $lista) )
					{
						$this->Carro->agregar($texto['Producto']['id'], 1, $lista, $texto, array(
							'reserva_id'	=> $reserva['Reserva']['id']
						));
					}

					/**
					 * Guarda el producto en la DB
					 */
					$this->Reserva->DetalleCompra->Producto->saveReserva($texto);
				}
			}

			/**
			 * Elimina productos del carro que no sean de reservas
			 */
			$catalogos		= $this->Carro->catalogos();
			foreach ( $catalogos as $catalogo )
			{
				if ( $catalogo !== 'reserva' )
				{
					$this->Carro->eliminarCatalogo($catalogo);
				}
			}
		}

		/**
		 * Lista de productos de la reserva
		 */
		$productos		= $this->Carro->productos('reserva');

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Reserva de uniformes');
		$this->set('title', 'Reserva de uniformes');

		$this->set(compact('colegio', 'colegios', 'niveles', 'reservas', 'productos'));
	}

	public function resumen()
	{
		/**
		 * Comprueba que el usuario este logeado
		 */
		if ( ! $this->Auth->user() )
		{
			$this->Session->write('Flujo.loginPending', array('controller' => 'reservas', 'action' => 'add'));
			$this->redirect(array('controller' => 'usuarios', 'action' => 'login'));
		}

		/**
		 * Comprueba que exista un colegio seleccionado
		 */
		if ( ! ( $colegio = $this->Session->read('Flujo.Reserva.Colegio') ) )
		{
			$this->redirect(array('action' => 'add'));
		}

		/**
		 * Lista de reservas y productos
		 */
		$reservas			= $this->Reserva->find('all', array(
			'conditions'		=> array(
				'Reserva.usuario_id'	=> $this->Auth->user('id'),
				'Reserva.activo'		=> true,
				'Reserva.LVEN'			=> $colegio['lista']
				/*
				'Reserva.created >='	=> sprintf('%d-01-01', date('Y')),
				'Reserva.created <='	=> sprintf('%d-12-31', date('Y'))
				*/
			),
			'order'				=> array('Reserva.id' => 'DESC')
		));
		foreach ( $reservas as &$reserva )
		{
			$catalogo				= sprintf('reserva.%d', $reserva['Reserva']['id']);
			$productos				= $this->Carro->productos($catalogo);
			$reserva['Productos']	= $productos[$catalogo]['Productos'];
			$reserva['Meta']		= $productos[$catalogo]['Meta'];
		}

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Reserva de uniformes', array('action' => 'add'));
		BreadcrumbComponent::add('Resumen');
		$this->set('title', 'Resumen de reserva');

		$this->set(compact('colegio', 'reservas', 'productos'));
	}

	public function pagar()
	{
		/**
		 * Comprueba que el usuario este logeado
		 */
		if ( ! $this->Auth->user() )
		{
			$this->Session->write('Flujo.loginPending', array('controller' => 'reservas', 'action' => 'add'));
			$this->redirect(array('controller' => 'usuarios', 'action' => 'login'));
		}

		/**
		 * Comprueba que existan productos en el carro
		 */
		$productos			= $this->Carro->productos('reserva');
		if ( empty($productos['reserva']) )
		{
			$this->redirect(array('action' => 'add'));
		}

		/**
		 * Comprueba si existe una compra en proceso
		 */
		if ( ( $id = $this->Session->read('Flujo.Reserva.compra_id') ) && $this->Reserva->DetalleCompra->Compra->pendiente($id) )
		{
			$this->Reserva->DetalleCompra->Compra->id			= $id;
		}

		/**
		 * Guarda la compra en estado pendiente
		 */
		$compra				= $this->Reserva->DetalleCompra->Compra->registrarCarro($productos, null, 0, true);
		$this->Session->write('Flujo.Reserva.compra_id', $compra['Compra']['id']);

		/**
		 * Si existe error al guardar la compra, devuelve al usuario a la pagina de resumen
		 * para reintentar la operacion
		 */
		if ( ! $compra )
		{
			$this->redirect(array('action' => 'resumen'));
		}

		/**
		 * Verifica si es necesario pasar por webpay
		 */
		if ( $compra['Compra']['total'] )
		{
			/**
			 * Datos necesarios para comenzar el flujo con webpay
			 */
			$webpay			= array(
				'gateway'			=> Router::url($this->Transbank->cgiPath['pago'], true),
				'oc'				=> $compra['Compra']['id'],
				'monto'				=> sprintf('%d00', $compra['Compra']['total']),
				'exito'				=> Router::url(array('controller' => 'reservas', 'action' => 'exito'), true),
				'fracaso'			=> Router::url(array('controller' => 'reservas', 'action' => 'fracaso'), true)
			);

			$this->layout		= 'ajax';
			$this->set(compact('webpay'));
		}

		/**
		 * Si la reserva no tiene seleccion de productos, pasa al detalle de reserva
		 */
		else
		{
			$this->Reserva->DetalleCompra->Compra->cambiarEstado($compra['Compra']['id'], 'PAGADO', null, true, false);
			$this->redirect(array('action' => 'exito', $compra['Compra']['id']));
		}
	}

	public function exito($compra_id = null)
	{
		/**
		 * Comprueba que el usuario este logeado
		 */
		if ( ! $this->Auth->user() )
		{
			$this->redirect('/');
		}

		/**
		 * Comprueba que la compra exista
		 */
		if ( $compra_id && ! $this->Reserva->DetalleCompra->Compra->exists($compra_id) )
		{
			$this->redirect('/');
		}

		/**
		 * Si viene desde webpay, debe informar ID
		 */
		if ( $this->request->is('post') )
		{
			if ( empty($this->request->data['TBK_ORDEN_COMPRA']) || ! $this->Reserva->DetalleCompra->Compra->exists($this->request->data['TBK_ORDEN_COMPRA']) )
			{
				$this->redirect(array('action' => 'add'));
			}
			$compra_id		= $this->request->data['TBK_ORDEN_COMPRA'];
		}

		/**
		 * Obtiene el detalle completo de la compra
		 */
		$compra			= $this->Reserva->DetalleCompra->Compra->find('first', array(
			'conditions'		=> array('Compra.id' => $compra_id),
			'contain'			=> array(
				'Usuario',
				'DetalleCompra'		=> array('Producto', 'Reserva'),
				'EstadoCompra',
				'Direccion'			=> array('Comuna' => array('Region')),
			)
		));

		/**
		 * Comprueba que la compra sea reserva y pertenezca al usuario logeado
		 */
		if ( ! $compra || ! $compra['Compra']['reserva'] || $compra['Compra']['usuario_id'] != $this->Auth->user('id') )
		{
			$this->redirect('/');
		}

		$compra['Compra']['tipo_pago']		= TransbankComponent::tipoPago($compra['Compra']['tbk_tipo_pago']);
		$compra['Compra']['tipo_cuota']		= TransbankComponent::tipoCuota($compra['Compra']['tbk_tipo_pago']);

		$reservas_id	= array_unique(Hash::extract($compra, 'DetalleCompra.{n}.reserva_id'));
		$reservas		= $this->Reserva->find('all', array(
			'conditions'		=> array('Reserva.id' => $reservas_id)
		));

		foreach ( $reservas as &$reserva )
		{
			$total	= 0;
			foreach ( $compra['DetalleCompra'] as $producto )
			{
				if ( $producto['Reserva']['id'] == $reserva['Reserva']['id'] )
				{
					$total	+= $producto['cantidad'];
				}
			}
			$reserva['Reserva']['reserva']	= (bool) $total;
		}

		/**
		 * Limpia la sesion
		 */
		$this->Carro->vaciar();
		$this->Session->delete('Flujo.Reserva');
		$this->Session->delete('Flujo.Carro');

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Reserva de uniformes', array('action' => 'add'));
		BreadcrumbComponent::add('Reserva exitosa');
		$this->set('title', 'Reserva exitosa');

		$this->set(compact('compra', 'reservas'));
	}

	public function fracaso()
	{
		/**
		 * Comprueba que venga desde el cgi de webpay
		 */
		extract($this->request->data);
		if ( ! $this->Auth->user() || ! $this->request->is('post') || empty($TBK_ORDEN_COMPRA) )
		{
			$this->redirect('/');
		}

		/**
		 * Si existe una compra en proceso, en estado pendiente y corresponde
		 * a la oc informada por webpay, cambia el estado a rechazo
		 */
		if ( ( $id = $this->Session->read('Flujo.Carro.compra_id') ) && $id == $TBK_ORDEN_COMPRA && ( $this->Compra->pendiente($id) || $this->Compra->rechazada($id) ) )
		{
			$this->Compra->cambiarEstado($id, 'RECHAZO_TRANSBANK');
			//$this->redirect(array('action' => 'resumen'));
		}
		/**
		 * Si no existe la oc o no cumple con las condiciones, informamos numero de oc de webpay
		 */
		else
		{
			$id = $TBK_ORDEN_COMPRA;
		}

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Reserva de uniformes', array('action' => 'add'));
		BreadcrumbComponent::add('Reserva fracasada');
		$this->set('title', 'Reserva fracasada');
		$this->set(compact('id'));
	}

	/*
	public function ajax_colegios()
	{
		$this->layout		= 'ajax';
		$data				= array();

		if ( $this->request->is('post') && ! empty($this->request->data['query']) )
		{
			$data		= $this->Reserva->getColegios($this->request->data['query']);
		}

		$this->set(compact('data'));
	}

	public function ajax_niveles()
	{
		$this->layout		= 'ajax';
		$data				= array();

		if ( $this->request->is('post') && ! empty($this->request->data['query']) )
		{
			$data		= $this->Reserva->getNiveles($this->request->data['query']);
		}

		$this->set(compact('data'));
	}
	*/

	public function ajax_eliminar()
	{
		$this->layout	= 'ajax';
		$data			= array('success' => false);

		if ( $this->request->is('post') )
		{
			extract($this->request->data['Reserva']);
			if ( ! empty($id) )
			{
				$reserva		= $this->Reserva->find('first', array(
					'conditions'		=> array(
						'Reserva.id'			=> $id,
						'Reserva.usuario_id'	=> $this->Auth->user('id')
					),
					'callbacks'			=> false
				));
				if ( $reserva )
				{
					if ( $this->Carro->eliminarCatalogo(sprintf('reserva.%d', $id)) )
					{
						$data			= array(
							'success'		=> true,
							'info'			=> array('Carro' => $this->Carro->estado())
						);
						$this->Session->write('Flujo.Carro.pendiente', true);

						// TODO: ELIMINAR RESERVA? PUEDE ESTAR ASOCIADA A UNA COMPRA ANTERIOR
						/**
						 * Desactiva la reserva
						 */
						$this->Reserva->save(array(
							'id'			=> $id,
							'activo'		=> false
						), array(
							'callbacks'		=> false
						));
					}
				}
			}
		}

		$this->set(compact('data'));
	}

	public function ajax_activar()
	{
		$this->layout	= 'ajax';
		$data			= array('success' => false);

		if ( $this->request->is('post') )
		{
			extract($this->request->data['Reserva']);
			if ( ! empty($id) && ! empty($reserva_id) )
			{
				$catalogo			= sprintf('reserva.%d', $reserva_id);
				$producto			= $this->Carro->producto($id, $catalogo);
				$cantidad			= ((bool) $activar ? 1 : 0);

				if ( $producto && ( $actualizar = $this->Carro->actualizar($id, $cantidad, $catalogo) ) )
				{
					$data		= array(
						'success'		=> true,
						'info'			=> $actualizar
					);
				}
			}
		}

		$this->set(compact('data'));
	}

	public function ajax_activar_todos()
	{
		$this->layout	= 'ajax';
		$data			= array('success' => false);

		if ( $this->request->is('post') )
		{
			extract($this->request->data['Reserva']);
			if ( ! empty($reserva_id) )
			{
				$catalogo			= sprintf('reserva.%d', $reserva_id);
				$productos			= $this->Carro->productos($catalogo);
				$activar			= ($activar == 'true');
				$cantidad			= ($activar ? 1 : 0);

				if ( $productos )
				{
					foreach ( $productos[$catalogo]['Productos'] as $producto_id => $productos )
					{
						$actualizar		= $this->Carro->actualizar($producto_id, $cantidad, $catalogo);
					}

					$data		= array(
						'success'		=> true,
						'info'			=> $actualizar
					);
				}
			}
		}

		$this->set(compact('data'));
	}
}
