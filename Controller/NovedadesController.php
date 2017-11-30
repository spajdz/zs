<?php
App::uses('AppController', 'Controller');
class NovedadesController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0,
			'limit'				=> 20
		);
		$novedades	= $this->paginate();
		$this->set(compact('novedades'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Novedad->create();
			if ( $this->Novedad->save($this->request->data) )
			{
				$this->Session->setFlash("Registro agregado correctamente", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		$administradores	= $this->Novedad->Administrador->find('list');
		$this->set(compact('administradores'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Novedad->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Novedad->save($this->request->data) )
			{
				$this->Session->setFlash("Registro editado correctamente", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		else
		{
			$this->request->data	= $this->Novedad->find('first', array(
				'conditions'	=> array('Novedad.id' => $id)
			));
		}
		$administradores	= $this->Novedad->Administrador->find('list');
		$this->set(compact('administradores'));
	}

	public function admin_delete($id = null)
	{
		$this->Novedad->id = $id;
		if ( ! $this->Novedad->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Novedad->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_activar($id = null)
	{
		$this->Novedad->id = $id;
		if ( ! $this->Novedad->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->Novedad->saveField('activo', true) )
		{
			$this->Session->setFlash('Registro activado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al activar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_desactivar($id = null)
	{
		$this->Novedad->id = $id;
		if ( ! $this->Novedad->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->Novedad->saveField('activo', false) )
		{
			$this->Session->setFlash('Registro desactivado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al desactivar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	//  *********** FUNCIONES DE LA PARTE DEL FRONTEND ***********

	/**
	 * Funcion que permite obtener las novedades que se encuentren activas
	 */
	public function index()
	{
		/** Obtenemos las 2 ultimas novedades */
		$ultimas_novedades 	= $this->Novedad->find('all', array(
			'conditions'		=> array('Novedad.activo' 	=> true),
			'order'				=> array('Novedad.id'		=> 'DESC'),
			'limit'				=> 2
		));

		$excluir_ids		= array_unique(Hash::extract($ultimas_novedades, '{n}.Novedad.id'));
		$this->paginate		= array(
			'conditions'		=> array(
				'Novedad.activo' 	=> true,
				'Novedad.id !='		=> $excluir_ids,
			),
			'recursive'			=> 0,
			'limit'				=> 4
		);
		$novedades			= $this->paginate();

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Novedades', array('action' => 'index'));

		$this->set(compact('novedades', 'ultimas_novedades'));
	}

	public function view($id = null)
	{
		$this->Novedad->id	=	$id;
		if( ! $this->Novedad->exists() && $id != null)
		{
			$this->Session->setFlash(sprintf('El N° de novedad %d no existe.', $id), null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$novedad 			=	$this->Novedad->find('first', array(
			'conditions'		=> array(
				'Novedad.activo' 	=> true,
				'Novedad.id'		=> $id
			)
		));

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Novedades', array('action' => 'index'));
		BreadcrumbComponent::add($novedad['Novedad']['titulo']);

		$this->set(compact('novedad'));
	}
}
