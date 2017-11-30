<?php
App::uses('AppController', 'Controller');
class ListasController extends AppController
{
	public function cambiar_colegio()
	{
		/**
		 * Comprueba que el usuario este logeado
		 */
		if ( ! $this->Auth->user() )
		{
			$this->Session->write('Flujo.loginPending', array('controller' => 'listas', 'action' => 'add'));
			$this->redirect(array('controller' => 'usuarios', 'action' => 'login'));
		}

		$this->Carro->vaciar();
		$this->Session->delete('Flujo.Lista');
		$this->redirect(array('action' => 'add'));
	}

	public function colegio()
	{
		/**
		 * Comprueba que el usuario este logeado
		 */
		if ( ! $this->Auth->user() )
		{
			$this->Session->write('Flujo.loginPending', array('controller' => 'listas', 'action' => 'add'));
			$this->redirect(array('controller' => 'usuarios', 'action' => 'login'));
		}

		if ( $this->request->is('post') )
		{

			if ( ! empty($this->request->data['Lista']['colegio_id']) )
			{
				$this->Session->write('Flujo.Lista.colegio_id', $this->request->data['Lista']['colegio_id']);
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
		// prx($this->request->data);
		/**
		 * Recibo los datos post y los escribo en sesion
		 */
		if ( $this->request->is('post') )
		{
			if ( ! empty($this->request->data['Lista']['colegio_id']) )
			{
				$this->Carro->vaciar();
				$this->Session->write('Flujo.Lista.colegio_id', $this->request->data['Lista']['colegio_id']);
				$this->Session->write('Flujo.Lista.nivel_id', $this->request->data['Lista']['nivel_id']);
			}
		}
		if ( $this->Session->check('Flujo.Lista.colegio_id') )
		{
			$colegio_id		= $this->Session->read('Flujo.Lista.colegio_id');
			$nivel_id		= $this->Session->read('Flujo.Lista.nivel_id');
		}

		/**
		 * Comprueba que el usuario este logeado
		 */
		if ( ! $this->Auth->user() )
		{
			$this->Session->write('Flujo.loginPending', array('controller' => 'listas', 'action' => 'add'));
			$this->redirect(array('controller' => 'usuarios', 'action' => 'login'));
		}

		/**
		 * Recibe los datos para crear la lista
		 */
		if ( $this->request->is('post') )
		{
			if ( $this->Session->check('Flujo.Lista') )
			{
				$this->request->data		= array_merge_recursive($this->request->data, array(
					'Lista'		=> array(
						'usuario_id'	=> $this->Auth->user('id'),
					)
				));

				if ( $this->Lista->save($this->request->data) )
				{
					$this->redirect(array('action' => 'add'));
				}
			}
			$this->Session->setFlash('Error al guardar la lista. Por favor intenta nuevamente.', null, array(), 'danger');
		}

		/**
		 * Datos colegio
		 */
		if ( ! empty($colegio_id) )
		{
			$colegio		= $this->Lista->Colegio->find('first', array(
				'conditions'		=> array(
					'Colegio.id'		=> $colegio_id
				),
				'contain'			=> array('Nivel')
			));

			$listas			= $this->Lista->find('all', array(
				'conditions'		=> array(
					'Lista.usuario_id'		=> $this->Auth->user('id'),
					'Lista.colegio_id'		=> $colegio_id,
					'Lista.activo'			=> true
				),
				'contain'			=> array('Nivel'),
				'order'				=> array('Lista.id' => 'DESC')
			));
		}

		if ( ! empty($listas) )
		{
			/**
			 * Recorre las listas y agrega los textos al carro
			 */
			foreach ( $listas as $index => $lista )
			{
				$this->NivelesProducto		= ClassRegistry::init('NivelesProducto');
				$niveles_productos			= $this->NivelesProducto->getProductosIdsNivel($lista['Lista']['nivel_id']);

				$productos			= $this->Lista->DetalleCompra->Producto->find('all', array(
					'conditions'	=> array(
						'Producto.colegio_id'	=> $lista['Lista']['colegio_id'],
						'Producto.listado'		=> 1,
						'Producto.activo'		=> 1,
						'Producto.stock >='		=> 1,
						// 'Producto.id'			=> $niveles_productos
					),
					'contain'		=> array('Nivel', 'ProductoHijo')
				));
				$listas[$index]['Producto'] = $productos;

				if ( ! $productos )
				{
					$this->Session->setFlash(sprintf('El nivel %s no tiene productos, se eliminó de la lista de productos.', $lista['Nivel']['nombre']), null, array(), 'info');

					/**
					 * Desactiva la lista
					 */
					$this->Lista->save(array(
						'id'            => $lista['Lista']['id'],
						'activo'        => false
					), array(
						'callbacks'     => false
					));
					$this->redirect(array('action' => 'add'));
				}
			}
		}

		/**
		 * Lista de colegios para autocomplete
		 */
		$colegios		= $this->Lista->Colegio->find('all', array(
			'fields'		=> array(
				'Colegio.id',
				'Colegio.nombre'
			)
		));

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Uniformes por colegio');
		$this->set('title', 'Uniformes por colegio');
		$this->set(compact('colegio', 'colegios', 'listas'));
	}

	public function confirmar()
	{
		if ( ! $this->request->is('post') )
		{
			$this->redirect(array('action' => 'add'));
		}

		$this->Carro->vaciar();

		foreach ( $this->request->data as $lista )
		{
			/**
			 * Referencia catalogo
			 */
			$catalogo		= sprintf('lista.%d', $lista['Lista']['id']);

			foreach ( $lista['Producto'] as $producto )
			{
				extract($producto);
				$producto		= $this->Lista->DetalleCompra->Producto->findById($id);
				$stock			= $this->Lista->DetalleCompra->Producto->verificarStock($producto['Producto']['isbn']);

				if ( ! $this->Carro->producto($producto['Producto']['id'], $catalogo) )
				{
					$this->Carro->agregar($producto['Producto']['id'], $cantidad, $catalogo, $producto, array(
						'lista_id'  => $lista['Lista']['id']
					));
				}
				if ( ! $stock )
				{
					$this->Session->setFlash('Algunos productos no tienen stock.', null, array(), 'danger');
				}
			}
		}

		$this->redirect(array('controller' => 'direcciones', 'action' => 'add'));
	}

	public function resumen()
	{

		/**
		 * Comprueba que el usuario este logeado
		 */
		if ( ! $this->Auth->user() )
		{
			$this->Session->write('Flujo.loginPending', array('controller' => 'listas', 'action' => 'add'));
			$this->redirect(array('controller' => 'usuarios', 'action' => 'login'));
		}

		/**
		 * Comprueba que exista un colegio seleccionado
		 */
		if ( ! ( $colegio = $this->Session->read('Flujo.Lista.colegio_id') ) )
		{
			$this->redirect(array('action' => 'add'));
		}

		/**
		 * Elimina productos del carro que no sean de listas
		 */
		$catalogos		= $this->Carro->catalogos();

		foreach ( $catalogos as $catalogo )
		{
			if ( $catalogo !== 'lista' )
			{
				$this->Carro->eliminarCatalogo($catalogo);
			}
		}

		/**
		 * Comprueba que existan productos en el carro
		 */
		$productos			= $this->Carro->productos('lista');
		// prx(! $productos);
		$carro				= $this->Carro->estado();
		if ( ! $productos || ! $carro['Cantidad'] )
		{
			$this->redirect('/');
		}

		/**
		 * Comprueba que el usuario haya seleccionado una direccion
		 */
		if ( ! $direccion_id = $this->Session->read('Flujo.Carro.direccion_id') )
		{
			$this->redirect(array('controller' => 'direcciones', 'action' => 'add'));
		}
		$this->Lista->DetalleCompra->Compra->Direccion->id		= $direccion_id;
		if ( ! $this->Lista->DetalleCompra->Compra->Direccion->exists() )
		{
			$this->redirect(array('controller' => 'direcciones', 'action' => 'add'));
		}

		/**
		 * Comprueba si existe una compra en proceso
		 */
		if ( ( $compra_id = $this->Session->read('Flujo.Carro.compra_id') ) && $this->Lista->DetalleCompra->Compra->pendiente($compra_id) )
		{
			$this->Lista->DetalleCompra->Compra->id			= $compra_id;
		}

		/**
		 * Guarda la compra en estado pendiente
		 */
		$compra				= $this->Lista->DetalleCompra->Compra->registrarCarro($productos, $direccion_id, $carro['Peso'], false, true);
		$this->Session->write('Flujo.Carro.compra_id', $compra['Compra']['id']);

		/**
		 * Lista de listas y productos
		 */
		$listas			= $this->Lista->find('all', array(
			'conditions'		=> array(
				'Lista.usuario_id'		=> $this->Auth->user('id'),
				'Lista.activo'			=> true,
				'Lista.colegio_id'		=> $colegio
				/*
				'Lista.created >='	=> sprintf('%d-01-01', date('Y')),
				'Lista.created <='	=> sprintf('%d-12-31', date('Y'))
				*/
			),
			'contain'			=> array('Colegio', 'Nivel'),
			'order'				=> array('Lista.id' => 'DESC')
		));

		/**
		 * Si existe error al guardar la compra, devuelve al usuario a la pagina de dirección
		 * para reintentar la operacion
		 */
		if ( ! $compra )
		{
			$this->redirect(array('controller' => 'direcciones', 'action' => 'add'));
		}
		$this->Session->write('Flujo.Carro.pendiente', false);

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Lista de uniforme', array('action' => 'add'));
		BreadcrumbComponent::add('Despacho', array('controller' => 'direcciones', 'action' => 'add'));
		BreadcrumbComponent::add('Resumen');
		$this->set('title', 'Resumen de lista');
		$this->set(compact('colegio', 'listas', 'compra'));
	}

	public function webpay()
	{
		/**
		 * Comprueba que el usuario este logeado
		 */
		if ( ! $this->Auth->user() )
		{
			$this->redirect(array('action' => 'resumen'));
		}

		/**
		 * Comprueba si existe una compra en proceso
		 */
		if ( ! ( $compra_id = $this->Session->read('Flujo.Carro.compra_id') ) || ! $this->Lista->DetalleCompra->Compra->pendiente($compra_id) )
		{
			$this->redirect(array('action' => 'resumen'));
		}

		/**
		 * Comprueba que el calculo de despacho y resumen de la compra sea el final
		 */
		if ( ! $this->Session->check('Flujo.Carro.pendiente') || $this->Session->read('Flujo.Carro.pendiente') === true )
		{
			$this->redirect(array('action' => 'resumen'));
		}

		/**
		 * Obtiene los datos necesarios de la compra
		 */
		$compra			= $this->Lista->DetalleCompra->Compra->find('first', array(
			'fields'			=> array('Compra.id', 'Compra.total'),
			'conditions'		=> array('Compra.id' => $compra_id),
			'callbacks'			=> false
		));

		/**
		 * Datos necesarios para comenzar el flujo con webpay
		 */
		$webpay			= array(
			'gateway'			=> Router::url($this->Transbank->cgiPath['pago'], true),
			'oc'				=> $compra['Compra']['id'],
			'monto'				=> sprintf('%d00', $compra['Compra']['total']),
			'exito'				=> Router::url(array('controller' => 'listas', 'action' => 'exito'), true),
			'fracaso'			=> Router::url(array('controller' => 'listas', 'action' => 'fracaso'), true)
		);

		$this->layout		= 'ajax';
		$this->set(compact('webpay'));
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
		if ( $compra_id && ! $this->Lista->DetalleCompra->Compra->exists($compra_id) )
		{
			$this->redirect('/');
		}

		/**
		 * Si viene desde webpay, debe informar ID
		 */
		if ( $this->request->is('post') )
		{
			if ( empty($this->request->data['TBK_ORDEN_COMPRA']) || ! $this->Lista->DetalleCompra->Compra->exists($this->request->data['TBK_ORDEN_COMPRA']) )
			{
				$this->redirect(array('action' => 'add'));
			}
			$compra_id		= $this->request->data['TBK_ORDEN_COMPRA'];
		}

		/**
		 * Obtiene el detalle completo de la compra
		 */
		$compra			= $this->Lista->DetalleCompra->Compra->find('first', array(
			'conditions'		=> array('Compra.id' => $compra_id),
			'contain'			=> array(
				'Usuario',
				'DetalleCompra'		=> array('Producto', 'Lista'),
				'EstadoCompra',
				'Direccion'			=> array('Comuna' => array('Region')),
			)
		));

		/**
		 * Comprueba que la compra sea lista y pertenezca al usuario logeado
		 */
		if ( $compra['Compra']['usuario_id'] != $this->Auth->user('id') )
		{
			$this->redirect('/');
		}

		$compra['Compra']['tipo_pago']		= TransbankComponent::tipoPago($compra['Compra']['tbk_tipo_pago']);
		$compra['Compra']['tipo_cuota']		= TransbankComponent::tipoCuota($compra['Compra']['tbk_tipo_pago']);

		$listas_id		= array_unique(Hash::extract($compra, 'DetalleCompra.{n}.lista_id'));
		$listas			= $this->Lista->find('all', array(
			'conditions'		=> array('Lista.id' => $listas_id)
		));

		/**
		 * Limpia la sesion
		 */
		$this->Carro->vaciar();
		$this->Session->delete('Flujo.Lista');
		$this->Session->delete('Flujo.Carro');

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Lista de uniforme', array('action' => 'add'));
		BreadcrumbComponent::add('Compra exitosa');
		$this->set('title', 'Compra exitosa');

		$this->set(compact('compra', 'listas'));
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
		if ( ( $id = $this->Session->read('Flujo.Carro.compra_id') ) && $id == $TBK_ORDEN_COMPRA && ( $this->Lista->DetalleCompra->Compra->pendiente($id) || $this->Lista->DetalleCompra->Compra->rechazada($id) ) )
		{
			$this->Lista->DetalleCompra->Compra->cambiarEstado($id, 'RECHAZO_TRANSBANK');
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
		BreadcrumbComponent::add('Lista de uniforme', array('action' => 'add'));
		BreadcrumbComponent::add('Compra fracasada');
		$this->set('title', 'Compra fracasada');
		$this->set(compact('id'));
	}

	public function ajax_eliminar()
	{
		$this->layout	= 'ajax';
		$data			= array('success' => false);

		if ( $this->request->is('post') )
		{
			extract($this->request->data['Lista']);
			if ( ! empty($id) )
			{
				$lista		= $this->Lista->find('first', array(
					'conditions'		=> array(
						'Lista.id'			=> $id,
						'Lista.usuario_id'	=> $this->Auth->user('id')
					),
					'callbacks'			=> false
				));
				if ( $lista )
				{
					$save		= $this->Lista->save(array(
						'id'			=> $id,
						'activo'		=> false
					), array(
						'callbacks'		=> false
					));

					if ( $save )
					{
						$data			= array(
							'success'		=> true,
							'info'			=> array('Carro' => $this->Carro->estado())
						);
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
			extract($this->request->data['Lista']);
			if ( ! empty($id) && ! empty($lista_id) )
			{
				$activar			= !! $activar;
				$catalogo			= sprintf('lista.%d', $lista_id);
				$producto			= $this->Carro->producto($id, $catalogo);
				$cantidad			= ($activar ? 1 : 0);
				$stock				= true;

				/**
				 * Check stock
				 */
				prx($id);
				if ( $activar )
				{
					$stock				= $this->Lista->DetalleCompra->Producto->verificarStock($producto['Data']['Producto']['isbn']);
					if ( ! $stock )
					{
						$data			= array(
							'success'		=> false,
							'error'			=> 'SIN_STOCK'
						);
					}
				}

				if ( $producto && $stock && ( $actualizar = $this->Carro->actualizar($id, $cantidad, $catalogo) ) )
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
			extract($this->request->data['Lista']);
			if ( ! empty($lista_id) )
			{
				$catalogo			= sprintf('lista.%d', $lista_id);
				$productos			= $this->Carro->productos($catalogo);
				$activar			= ($activar == 'true');
				$cantidad			= ($activar ? 1 : 0);
				$sinstock			= array();

				if ( $productos )
				{
					foreach ( $productos[$catalogo]['Productos'] as $producto_id => $producto )
					{
						/**
						 * Check stock
						 */
						if ( $activar )
						{
							$stock				= $this->Lista->DetalleCompra->Producto->verificarStock($producto['Data']['Producto']['isbn']);
							if ( ! $stock )
							{
								$sinstock[] = $producto_id;
							}
							else
							{
								$actualizar		= $this->Carro->actualizar($producto_id, $cantidad, $catalogo);
							}
						}
						else
						{
							$actualizar		= $this->Carro->actualizar($producto_id, $cantidad, $catalogo);
						}
					}

					$data		= array(
						'success'		=> true,
						'info'			=> $actualizar,
						'sinstock'		=> $sinstock
					);
				}
			}
		}

		$this->set(compact('data'));
	}
}
