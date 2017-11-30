<?php
App::uses('AppController', 'Controller');
class TarifaDespachosController extends AppController
{
	public function ajax_tarifa($comuna_id = null)
	{
		$this->layout		= 'ajax';
		$data				= array('Total' => 0);

		if ( ! empty($comuna_id) )
		{
			$carro					= $this->Carro->estado();
			$valor_despacho			= $this->TarifaDespacho->calcular($comuna_id, $carro['Peso']);
			if ( $valor_despacho )
			{
				$data			= array(
					'Total'			=> $valor_despacho,
					'Info'			=> array(
						'extrema'				=> $this->TarifaDespacho->extrema,
						'observacion_extrema'	=> $this->TarifaDespacho->observacion_extrema
					)
				);
			}
		}

		$this->set(compact('data'));
	}

	public function admin_masivo()
	{
		if ( $this->request->is('post') )
		{
			extract($this->request->data['TarifaDespacho']['archivo']);
			if ( empty($error) && ( ( $gestor = fopen($tmp_name, 'r') ) !== FALSE ) )
			{
				$data				= array();

				while ( ( $datos = fgetcsv($gestor, 0, ';') ) !== FALSE )
				{
					/** Comparamos si se esta en la cabecera de la tabla */
					if ( $datos[0] == 'KOCI' )
					{
						continue;
					}
					/**  Convert character encoding */
					$datos[1]	=	mb_convert_encoding($datos[1], 'UTF-8', 'ASCII');
					$datos[11]	=	mb_convert_encoding($datos[11], 'UTF-8', 'ASCII');
					/** Remeplazmos el caracter especial ¥ por Ñ*/
					$datos[1]	=	str_replace('¥', 'Ñ', $datos[1]);

					/**
						Consultamos  en nuestra bd local el id de la comuna, relacionado
						con los valores de KOCM y KOCI que corresponden a atributos de
						las tablas comuna y region respectivamente.
					*/
					$comuna		= $this->TarifaDespacho->Comuna->obtenerComuna(str_pad((int) $datos[0], 3, '0', STR_PAD_LEFT), $datos[1]);

					if ( $comuna )
					{
						array_push($data, array(
							'TarifaDespacho'	=> array(
								'comuna_id'					=> (! empty($comuna['Comuna']['id']) ? $comuna['Comuna']['id'] : $this->TarifaDespacho->Comuna->id),
								'KOCI'						=> $datos[0],
								'KOCM'						=> $datos[1],
								'peso150'					=> $datos[3],
								'peso300'					=> $datos[4],
								'peso600'					=> $datos[5],
								'peso1000'					=> $datos[6],
								'peso1500'					=> $datos[7],
								'adicional'					=> $datos[8],
								'domicilio'					=> true,
								'observacion_domicilio'		=> $datos[9],
								'extrema'					=> $datos[10],
								'observacion_extrema'		=> $datos[11]
							)
						));
					}
				}
				fclose($gestor);
				if ( $data )
				{
					/**
					 * Nombre DB
					 */
					$db			= $this->getDatasource()->config['database'];

					/**
					 * Limpia la tabla de tarifas
					 */
					$this->TarifaDespacho->query(sprintf("
						DELETE FROM [%s].[dbo].[ec_tarifa_despachos];
						DBCC CHECKIDENT ('[%s].[dbo].[ec_tarifa_despachos]', RESEED, 0)
					", $db, $db));

					/**
					 * Guarda las nuevas tarifas de despacho
					 */
					$this->TarifaDespacho->saveAll($data);
					$this->Session->setFlash('Carga masiva ejecutada correctamente.', null, array(), 'success');
				}
			}
		}
	}

	public function admin_index()
	{
		/**
		 * Inicio busqueda
		 */
		if ( $this->request->is('post') )
		{
			$busqueda = array();
			extract($this->request->data['TarifaDespacho']);

			if ( ! empty($region_id) )
			{
				// Obtenemos el ID de la region que se esta filtrando como busqueda
				$busqueda['region']			= $region_id;
			}
			// Se envia el filro como parametro URL
			$this->redirect(array('filtro' => $busqueda));
		}

		$paginacion		=	array(
			'contain'		=> array('Comuna' => 'Region'),
			'conditions'	=> array(),
			'order'			=> array(
				'TarifaDespacho.KOCI'	=>	'ASC',
				'Comuna.nombre'			=>	'ASC'
			),
			'limit'			=> 10
		);
		/** Se obtienen parametros de tipo 'named' */
		if ( ! empty($this->params['named']['filtro']) )
		{
			$filtros			=	$this->params['named'];
		}

		if ( ! empty($filtros) )
		{
			$paginacion['conditions']	= array('TarifaDespacho.KOCI' => str_pad($filtros['filtro']['region'], 3, '0', STR_PAD_LEFT));
		}
		$this->paginate	=	$paginacion;
		$tarifas		= $this->paginate();
		// Obtenemos las regiones
		$regiones			= $this->TarifaDespacho->Comuna->Region->find('list');
		$this->set(compact('tarifas', 'regiones', 'filtros'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->TarifaDespacho->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->TarifaDespacho->save($this->request->data) )
			{
				$this->Session->setFlash("Registro editado correctamente", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
			}
		}
		else
		{
			$this->request->data	= $this->TarifaDespacho->find('first', array(
				'conditions'	=> array('TarifaDespacho.id' => $id)
			));
		}
	}
}
