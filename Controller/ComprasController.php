<?php
App::uses('AppController', 'Controller');
class ComprasController extends AppController
{
	public $commerceId = 597020000541;
	// public $commerceId = 597032470963;
	public function resumen()
	{
		/**
		 * Comprueba que el usuario este logeado
		 */
		if ( ! $this->Auth->user() )
		{
			$this->Session->write('Flujo.loginPending', array('controller' => 'direcciones', 'action' => 'add'));
			$this->redirect(array('controller' => 'usuarios', 'action' => 'login'));
		}

		/**
		 * Comprueba que existan productos en el carro
		 */
		$productos			= $this->Carro->productos('catalogo');

		$carro				= $this->Carro->estado();
		if ( ! $carro['Cantidad'] )
		{
			$this->redirect('/');
		}

		/**
		 * Comprueba que el usuario haya seleccionado una direccion
		 */

		if ( $this->Session->read('Flujo.Carro.retiro_tienda') == 0 && ! $direccion_id = $this->Session->read('Flujo.Carro.direccion_id') )
		{
			$this->redirect(array('controller' => 'direcciones', 'action' => 'add'));
		}

		if($this->Session->read('Flujo.Carro.retiro_tienda') == 0){
			$this->Compra->Direccion->id		= $direccion_id;
			if ( ! $this->Compra->Direccion->exists() )
			{
				$this->redirect(array('controller' => 'direcciones', 'action' => 'add'));
			}
		}else{
			if(empty($direccion_id)){
				$direccion_id = '';
			}
		}
		/**
		 * Comprueba si existe una compra en proceso
		 */
		if ( ( $id = $this->Session->read('Flujo.Carro.compra_id') ) && $this->Compra->pendiente($id) )
		{
			$this->Compra->id			= $id;
		}

		/**
		 * Guarda la compra en estado pendiente
		 */
		$retiro_tienda = $this->Session->read('Flujo.Carro.retiro_tienda');
		$tienda_retiro = $this->Session->read('Flujo.Carro.tienda_retiro');
		$observacion_retiro_tienda = $this->Session->read('Flujo.Carro.observacion_retiro_tienda');
		$compra	= $this->Compra->registrarCarro($productos, $direccion_id, $carro['Peso'], false, false,$retiro_tienda, $tienda_retiro,$observacion_retiro_tienda );
		$this->Session->write('Flujo.Carro.compra_id', $compra['Compra']['id']);
		
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
		BreadcrumbComponent::add('Carro de compras', array('controller' => 'productos', 'action' => 'carro'));
		BreadcrumbComponent::add('Despacho', array('controller' => 'direcciones', 'action' => 'add'));
		BreadcrumbComponent::add('Resumen de compra');
		$this->set('title', 'Resumen de compra');
		$this->set(compact('compra'));
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
		if ( ! ( $id = $this->Session->read('Flujo.Carro.compra_id') ) || ! $this->Compra->pendiente($id) )
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
		$compra			= $this->Compra->find('first', array(
			'fields'			=> array('Compra.id', 'Compra.total'),
			'conditions'		=> array('Compra.id' => $id),
			'callbacks'			=> false
		));

		/**
		 * Datos necesarios para comenzar el flujo con webpay
		 */
		$tipoTransaccion		= 'TR_NORMAL_WS';
		$codigoComercio 		= $this->commerceId;
		$idComercio 			= $this->commerceId;
		$ordenCompra 			= date('Y').date('m').date('d').date('H').date('i').date('s').rand(0,9).rand(0,9).rand(0,9);
		$sesionId				= '';
		$urlRetorno				= Router::url(array('controller' => 'compras', 'action' => 'responsePagoSimultaneo'), true);
		$urlFinal 				= Router::url(array('controller' => 'compras', 'action' => 'exito'), true);
		$monto 					= $compra['Compra']['total'];

		$this->Compra->id = $id;
		if(!$this->Compra->save(array('tbk_orden_compra' => $ordenCompra ))){
			prx($this->Compra->validationErrors);
		}

		/**
		* Se guarda la oc en sesion para luego poder compararla con la respuesta de transbank
		*/
		$this->Session->write("OC", $ordenCompra);

		try
		{
			$this->PagoSimultaneo->initTransaccion( $tipoTransaccion, $idComercio, $ordenCompra, $sesionId, $urlRetorno, $urlFinal, $codigoComercio, $monto );
		}
		catch ( Exception $e )
		{
			$this->redirect( array('action' => 'fracaso') );
		}

		$this->layout		= 'ajax';
		$this->set(compact('webpay'));
	}

	public function responsePagoSimultaneo(){
		if ($this->request->is('post')) {
			if (isset($this->request->data['token_ws'])) {
				try {
					$estadoTransaccion = $this->PagoSimultaneo->getTransaccionResult($this->request->data['token_ws']);
					$this->Session->write("estadoTransaccion", $estadoTransaccion);

				} catch (Exception $e) {
					$this->redirect(array('controller' => 'compras', 'action' => 'fracaso'));
				}

				if (isset($estadoTransaccion['tbk_respuesta'])){
					if ($estadoTransaccion['tbk_respuesta'] == 0) {

						if ( !($id = $this->Session->read('Flujo.Carro.compra_id')) || !($oc = $this->Session->read('OC')) ||  $oc != $estadoTransaccion['tbk_orden_compra']){

							$this->redirect(array('action' => 'resumen'));
						}

						$data		= array(
							'id'							=> $id,
							'tbk_orden_compra'				=> $estadoTransaccion['tbk_orden_compra'],
							'tbk_tipo_transaccion'			=> 'TR_NORMAL_WS',
							'tbk_respuesta'					=> $estadoTransaccion['tbk_respuesta'],
							'tbk_monto'						=> $estadoTransaccion['tbk_monto'],
							'tbk_codigo_autorizacion'		=> $estadoTransaccion['tbk_codigo_autorizacion'],
							'tbk_final_numero_tarjeta'		=> $estadoTransaccion['tbk_final_numero_tarjeta'],
							'tbk_fecha_transaccion'		=> $estadoTransaccion['tbk_fecha_transaccion'],
							'tbk_id_transaccion'			=> $estadoTransaccion['token_ws'],
							'tbk_tipo_pago'					=> $estadoTransaccion['tbk_tipo_pago'],
							'tbk_numero_cuotas'				=> $estadoTransaccion['tbk_numero_cuotas'],
							'tbk_vci'						=> $estadoTransaccion['tbk_vci'],
						);

						$this->Compra->set($data);
						if ( ! $this->Compra->validates() || ! $this->Compra->save($data) )
						{
							$this->Compra->cambiarEstado($id, 'RECHAZO_COMERCIO', 'POST Transbank no pasa validación DB', 1, 0);

							$this->redirect(array('controller' => 'compras', 'action' => 'fracaso'));
						}
						
						$compra			= $this->Compra->find('first',array(
							'conditions' => array(
								'Compra.id' => $id
							)
						));
						if (  $compra['Compra']['total'] != $estadoTransaccion['tbk_monto'] )
						{
							$this->Compra->cambiarEstado($id, 'RECHAZO_COMERCIO', 'Monto informado por Transbank no concuerda', 0, 0);

							$this->redirect(array('controller' => 'compras', 'action' => 'fracaso'));
						}

						$aceptado = true;
						$this->Compra->cambiarEstado($id, 'PAGADO', null, 1, false);

						if(is_object($this->PagoSimultaneo->acknowledgeTransaccion($this->Session->read('token')))){
							
							$this->layout = 'ajax';
							$this->set(compact('estadoTransaccion'));
						}
					}
				}else{
					/**
					* Se le informa a Transbank que se recibio respuesta
					*/
					$acknowledgeTransaccion = $this->PagoSimultaneo->acknowledgeTransaccion($this->Session->read('token'));

					if ( $estadoTransaccion != 0 ) {

						/**
						* Se redirecciona a la pagina de pago rechazado
						*/
						$this->redirect(array('controller' => 'compras', 'action' => 'pagoRechazado'));
					}
				}
			}else{
				/**
				* Si no se recibe el token se redirecciona a la pagina de pago rechazado
				*/
				$this->redirect(array('controller' => 'compras', 'action' => 'pagoRechazado'));
			}
		}
	}

	public function exito()
	{
		/**
		 * Comprueba que venga informada la oc
		 */
	
		if ( ! $this->Auth->user())
		{
			$this->redirect('/');
		}

		/**
		 * Comprueba que exista una compra en proceso, en estado pagado
		 * y corresponda a la oc informada por webpay
		 */
		if ( ! ( $id = $this->Session->read('Flujo.Carro.compra_id') ) || ! $this->Compra->pagada($id) )
		{
			$this->redirect(array('action' => 'resumen'));
		}

		/**
		 * Vacia el carro de compras
		 */
		$this->Carro->vaciar();
		$this->Session->delete('Flujo.Carro');

		/**
		 * Datos de compra
		 */
		$compra			= $this->Compra->find('first', array(
			'conditions'		=> array('Compra.id' => $id),
			'contain'			=> array(
				'Usuario',
				'DetalleCompra'		=> array('Producto'),
				'EstadoCompra',
				'Direccion'			=> array('Comuna' => array('Region')),
				'Sucursal'
			)
		));

		/**
		 * Tipo de pago y cuota
		 */
		$compra['Compra']['tipo_pago']		= TransbankComponent::tipoPago($compra['Compra']['tbk_tipo_pago']);
		$compra['Compra']['tipo_cuota']		= TransbankComponent::tipoCuota($compra['Compra']['tbk_tipo_pago']);

		/**
		 * Fecha y hora normalizadas
		 */
		$fecha			= DateTime::createFromFormat(
			'md-His',
			sprintf('%s-%s', $compra['Compra']['tbk_fecha_transaccion'], $compra['Compra']['tbk_hora_transaccion'])
		);
		if ( $fecha )
		{
			$compra['Compra']['tbk_fecha_transaccion']		= $fecha->format('Y-m-d');
			$compra['Compra']['tbk_hora_transaccion']		= $fecha->format('H:i:s');
		}

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Carro de compras', array('controller' => 'productos', 'action' => 'carro'));
		BreadcrumbComponent::add('Compra exitosa');
		$this->set('title', 'Compra exitosa');
		$this->set(compact('compra'));
	}

	public function fracaso()
	{
		/**
		 * Comprueba que venga desde el cgi de webpay
		 */
		if ( ! $this->Auth->user())
		{
			$this->redirect('/');
		}

		/**
		 * Si existe una compra en proceso, en estado pendiente y corresponde
		 * a la oc informada por webpay, cambia el estado a rechazo
		 */
		if ( ( $id = $this->Session->read('Flujo.Carro.compra_id') ) && ( $this->Compra->pendiente($id) || $this->Compra->rechazada($id) ) )
		{
			$this->Compra->cambiarEstado($id, 'RECHAZO_TRANSBANK');
		}

		$compra = $this->Compra->find('first', array(
			'conditions' => array(
				'Compra.id' => $id
			) 
		));

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Carro de compras', array('controller' => 'productos', 'action' => 'carro'));
		BreadcrumbComponent::add('Compra fracasada');
		$this->set('title', 'Compra fracasada');
		$this->set(compact('id', 'compra'));
	}

	
	public function index()
	{
		if ( ! $this->Auth->user() )
		{
			$this->redirect('/');
		}

		$compras			= $this->Compra->find('all', array(
			'conditions'		=> array('Compra.usuario_id' => $this->Auth->user('id')),
			'contain'			=> array('Usuario', 'EstadoCompra', 'Direccion'),
			'order'				=> array('Compra.created' => 'DESC')
		));
		$this->set(compact('compras'));
	}

	public function view($id = null)
	{
		if ( ! $this->Auth->user() )
		{
			$this->redirect('/');
		}

		$this->Compra->id = $id;
		if ( ! $this->Compra->exists() && $id != null)
		{
			$this->Session->setFlash(sprintf('La OC %d no existe', $id), null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		$compra		= $this->Compra->find('first', array(
			'conditions'		=> array(
				'Compra.id'				=> $id,
				'Compra.usuario_id'		=> $this->Auth->user('id')
			),
			'contain'			=> array(
				'Usuario',
				'DetalleCompra'		=> array('Producto'),
				'EstadoCompra',
				'Direccion'			=> array('Comuna' => array('Region')),
				'Despacho'
			)
		));
		if ( ! $compra )
		{
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Tipo de pago y cuota
		 */
		$compra['Compra']['tipo_pago']		= TransbankComponent::tipoPago($compra['Compra']['tbk_tipo_pago']);
		$compra['Compra']['tipo_cuota']		= TransbankComponent::tipoCuota($compra['Compra']['tbk_tipo_pago']);

		/**
		 * Fecha y hora normalizadas
		 */
		$fecha			= DateTime::createFromFormat(
			'md-His',
			sprintf('%s-%s', $compra['Compra']['tbk_fecha_transaccion'], $compra['Compra']['tbk_hora_transaccion'])
		);
		if ( $fecha )
		{
			$compra['Compra']['tbk_fecha_transaccion']		= $fecha->format('Y-m-d');
			$compra['Compra']['tbk_hora_transaccion']		= $fecha->format('H:i:s');
		}
		$this->set(compact('compra'));
	}


	/**
	 * Index
	 * Método que permite obtener el listado de las ordenes de compra, y así
	 * poderlas listar
	 *
	 */
	public function admin_index()
	{
		/**
		 * Inicio busqueda
		 */
		if ( $this->request->is('post') )
		{
			$busqueda		= array();
			extract($this->request->data['Compra']);

			// Información de busqueda libre
			if ( ! empty($libre) )
			{
				$busqueda['buscar']				= $libre;
			}
			// Fecha de inicio
			if ( ! empty($fecha_inicio) )
			{
				$busqueda['fecha_min']			= $fecha_inicio;
			}
			// Fecha final
			if ( ! empty($fecha_fin) )
			{
				$busqueda['fecha_max']			= $fecha_fin;
			}
			// Estado de compra/reserva
			if( ! empty($estado_compra_id) )
			{
				$busqueda['estado']				= $estado_compra_id;
			}
			// Rango por Id de compra/reserva
			if ( ! empty($rango_oc) )
			{
				list($oc_min, $oc_max)			= explode(';', $rango_oc);
				$busqueda['oc_min']				= $oc_min;
				$busqueda['oc_max']				= $oc_max;
			}
			// Rango por Valor de compra/reserva
			if ( ! empty($rango_monto) )
			{
				list($monto_min, $monto_max)	= explode(';', $rango_monto);
				$busqueda['monto_min']			= $monto_min;
				$busqueda['monto_max']			= $monto_max;
			}
			

			$this->redirect(array('filtro' => $busqueda));
		}

		/**
		 * Paginacion + Filtros
		 * Se declara la paginacion con sus respectivos atributos, pero dejando
		 * las condiciones vacias
		 */
		$paginacion			= array(
			'contain'			=> array('Usuario', 'EstadoCompra'),
			'conditions'		=> array(),
			'order'				=> array('Compra.created' => 'DESC'),
			'limit'				=> 20
		);

		/** Se obtienen parametros de tipo 'named' */
		$filtros			=	$this->params['named'];
		$condicionFiltros	=	$this->Compra->condicionesFiltros($filtros);

		if ( ! empty($condicionFiltros) )
		{
			$paginacion['conditions']	= $condicionFiltros;
		}
		$this->paginate		= $paginacion;
		$compras			= $this->paginate();

		/** obtenemos los valor limites para los sliders */
		$limites			= array(
			'oc_primera'		=> 0,
			'oc_ultima'			=> 0,
			'monto_minimo'		=> 0,
			'monto_maximo'		=> 0
		);
		if ( $this->Compra->find('first') )
		{
			$limites			= array(
				/** Primera OC resgistrada */
				'oc_primera'		=> $this->Compra->find('first', array(
					'fields'			=> array('Compra.id'),
					'order'				=> array('Compra.id' => 'ASC')
				))['Compra']['id'],
				/** Ultima OC registrada */
				'oc_ultima'			=> $this->Compra->find('first', array(
					'fields'			=> array('Compra.id'),
					'order'				=> array('Compra.id' => 'DESC')
				))['Compra']['id'],
				/** Valor minimo de las OC registradas */
				'monto_minimo'		=> $this->Compra->find('first', array(
					'fields'			=> array('Compra.total'),
					'order'				=> array('Compra.total' => 'ASC')
				))['Compra']['total'],
				/** Valor maximo de las OC registradas */
				'monto_maximo'		=> $this->Compra->find('first', array(
					'fields'			=> array('Compra.total'),
					'order'				=> array('Compra.total' => 'DESC')
				))['Compra']['total'],
			);
		}
		/** Obtenenos los estados de las compras registrados */
		$estadoCompras			= $this->Compra->EstadoCompra->find('list');
		$this->set(compact('filtros', 'compras', 'limites', 'estadoCompras'));
	}

	public function admin_excel()
	{
		/** Obtenemos los filtros de busqueda  */
		$filtros			=	$this->params['named'];
		$condicionFiltros	=	$this->Compra->condicionesFiltros($filtros);
		/** Se obtienen el listado de las compras, de acuerdo con los filtros establecidos */
		$compras			=	$this->Compra->find('all', array(
			'contain'			=> array('Usuario', 'EstadoCompra'),
			'conditions'		=> ( $condicionFiltros ? $condicionFiltros: ''),
			'order'				=> array('Compra.created' => 'DESC')
		));
		$this->set(compact('compras'));
	}

	/**
	 * View
	 * Funcion que permite ver en detalle una compra determinada por su Id
	 *
	 */
	public function admin_view($id = null)
	{
		$this->Compra->id = $id;
		if ( ! $this->Compra->exists() && $id != null)
		{
			$this->Session->setFlash(sprintf('La OC %d no existe', $id), null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		$compra			= $this->Compra->find('first', array(
			'conditions'		=> array('Compra.id' => $id),
			'contain'			=> array(
				'Usuario',
				'DetalleCompra'		=> array('Producto'),
				'EstadoCompra',
				'Direccion'			=> array('Comuna' => array('Region')),
			)
		));

		/**
		 * Tipo de pago y cuota
		 */
		$compra['Compra']['tipo_pago']		= TransbankComponent::tipoPago($compra['Compra']['tbk_tipo_pago']);
		$compra['Compra']['tipo_cuota']		= TransbankComponent::tipoCuota($compra['Compra']['tbk_tipo_pago']);

		/**
		 * Fecha y hora normalizadas
		 */
		$fecha			= DateTime::createFromFormat(
			'md-His',
			sprintf('%s-%s', $compra['Compra']['tbk_fecha_transaccion'], $compra['Compra']['tbk_hora_transaccion'])
		);
		if ( $fecha )
		{
			$compra['Compra']['tbk_fecha_transaccion']		= $fecha->format('Y-m-d');
			$compra['Compra']['tbk_hora_transaccion']		= $fecha->format('H:i:s');
		}

		$this->set(compact('compra'));
	}

	/**
	 * Summary
	 * @return			object						Description
	 */
	public function admin_dashboard()
	{
		// mes anterior al actual
		$mesOperacional	= date('m', strtotime('-1 month'));
		// obtenemos las fechas del primer y ultimo dia del mes actual
		$fecha			= ultimosMeses(date('Y-m-d'), 2);
		/** Obtenemos las información de los Widgets */
		$widgets 		= $this->Compra->widgetsDashboard($fecha, $mesOperacional);
		/** Obtenenos los estados de las compras registrados */
		$estados_compra						= array(
			'estados'								 =>	$this->Compra->EstadoCompra->find('list')
		);
		/** Obtenemos las fechas del primer y ultimo dia de los ultimos 6 meses */
		$fechas = ultimosMeses(date('Y-m-d'), 6);
		/** Arreglo que contiene la cantidad de registros por estados de los ultimos 6 meses */
		$cantidad_estado = array();
		foreach ($fechas AS $fecha )
		{
			$datos_mes = array();
			foreach( $estados_compra['estados'] AS $index => $estados )
			{
				$total = 0;
				$condiciones = array(
					'conditions'	=>	array(
						'Compra.estado_compra_id'	=> $index,
						'Compra.created >='			=> sprintf('%s 00:00:00', $fecha['inicio']),
						'Compra.created <='			=> sprintf('%s 23:59:59', $fecha['fin'])
					)
				);
				$total = $this->Compra->find('count', $condiciones);
				$datos_mes[$index] = $total;
			}
			array_push($cantidad_estado, array('y' => $fecha['fin']) + $datos_mes);
		}
		/** Arreglo que contiene el valor acumulado de compras, reservas y listas en los ultimos 6 meses */
		$valores_oc = array();
		foreach ($fechas AS $fecha )
		{
			/** Valor del acumulado por concepto de compras */
			$valor 				= $this->Compra->valorTotalRegistroOC($fecha['inicio'], $fecha['fin'], false, false);
			/** Valor del acumulado por concepto de reservas */
			$valor_reserva 		= $this->Compra->valorTotalRegistroOC($fecha['inicio'], $fecha['fin'], true, false);
			/** Valor del acumulado por concepto de listas */
			$valor_lista 		= $this->Compra->valorTotalRegistroOC($fecha['inicio'], $fecha['fin'], false, true);

			array_push($valores_oc, array('y' => $fecha['fin']) + $valor + $valor_reserva + $valor_lista);
		}
		// Obtenemos la informacion de los ultimos 4 registros de compras
		$datos_compras		=	$this->Compra->registrosOC(false,false,4);
		
		$this->set(compact('widgets', 'estados_compra', 'cantidad_estado', 'valores_oc', 'datos_compras','datos_reserva', 'datos_listas'));
	}

	/**
	 * Funcion que permite actualizar el estado de OC a 5, cuando esta es anulada
	 * @param			Object			$id			ID de OC
	 */
	public function admin_anular($id = null)
	{
		$this->Compra->id = $id;
		if ( ! $this->Compra->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		if ( $this->Compra->saveField('estado_compra_id', 5) )
		{
			$this->Session->setFlash('Orden de compra anulada correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al anular la orden de compra. Por favor intentalo nuevamente.', null, array(), 'sucess');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_tracking()
	{
		//
	}
}
