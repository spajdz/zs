<?php
App::uses('AppController', 'Controller');
class ColegiosController extends AppController
{
	public function index()
	{
		$colegios		= $this->Colegio->find('all', array(
			'fields'			=> array('Colegio.id', 'Colegio.nombre', 'Colegio.codigo'),
			'conditions'		=> array(
				//'Colegio.nivel_count >'	=> 0,
				'Colegio.activo'		=> true
			),
			'contain'			=> array('Nivel'),
			'order'				=> array('Colegio.nombre' => 'ASC')
		));

		if ( ! $colegios )
		{
			$this->redirect('/');
		}

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Nuestros Colegios');
		$this->set('title', 'Nuestros Colegios');
		$this->set(compact('colegios'));
	}

	public function verificar(){
		$colegios		= $this->Colegio->find('all', array(
			'fields'			=> array('Colegio.id', 'Colegio.nombre', 'Colegio.codigo'),
			'conditions'		=> array(
				'Colegio.activo'		=> true
			),
		));

		$this->set(compact('colegios'));
	}
}
