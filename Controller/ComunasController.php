<?php
App::uses('AppController', 'Controller');
class ComunasController extends AppController
{
	public function ajax_region()
	{
		$this->layout		= 'ajax';
		$data				= array('' => '-- Selecciona una comuna');
		if ( $this->request->is('post') )
		{
			$dataModelo		= current($this->request->data);
			if ( ! empty($dataModelo['region_id']) )
			{
				$this->Comuna->Region->id	= $dataModelo['region_id'];
				if ( $this->Comuna->Region->exists() )
				{
					$data			= $data + array_unique($this->Comuna->find('list', array(
						'conditions'		=> array('Comuna.region_id' => $this->Comuna->Region->id),
						'order'				=> array('Comuna.nombre' => 'DESC'),
                        //'group'				=> array('Comuna.nombre')
					)));
				}
			}
		}
		$this->set(compact('data'));
	}

	/**
	 */
	public function admin_masivo( $carga = null )
	{
		if ( ! empty($carga) && $carga == 'cargar' )
		{
			// Carga masiva de los productos.
			$cargaMasiva	=	$this->Comuna->ejecutarCargaMasiva('MASIVO_REGIONES');

			$this->Session->setFlash(sprintf('El tiempo de carga del registro de los productos fue de %s ', $cargaMasiva), null, array(), 'success');
		}

		$this->redirect(array('controller' => 'productos', 'action' => 'masivo'));
	}

}
