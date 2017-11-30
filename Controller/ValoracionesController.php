<?php
App::uses('AppController', 'Controller');
class ValoracionesController extends AppController
{
	/**
	 *	Funcion que permite realizar el registro de la valoracon del producto
	 */
	public function ajax_valorizacion()
	{
		$this->layout	= 'ajax';
		$data			= array('success' => false);
		if ( $this->request->is('post') )
		{
			if ( ! $this->Session->check(sprintf('Flujo.valorizacion.%d', $this->request->data['Valoracion']['producto_id'])) )
			{
				if ( $this->Valoracion->save($this->request->data) )
				{
					$data			= array('success' => true);
					$this->Session->write(sprintf('Flujo.valorizacion.%d', $this->request->data['Valoracion']['producto_id']), true);
				}
			}
		}
		$this->set(compact('data'));
	}
}
