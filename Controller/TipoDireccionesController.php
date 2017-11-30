<?php
App::uses('AppController', 'Controller');
class TipoDireccionesController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$tipoDirecciones	= $this->paginate();
		$this->set(compact('tipoDirecciones'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->TipoDireccion->create();
			if ( $this->TipoDireccion->save($this->request->data) )
			{
				$this->Session->setFlash('Registro agregado correctamente.', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->TipoDireccion->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->TipoDireccion->save($this->request->data) )
			{
				$this->Session->setFlash('Registro editado correctamente', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}
		else
		{
			$this->request->data	= $this->TipoDireccion->find('first', array(
				'conditions'	=> array('TipoDireccion.id' => $id)
			));
		}
	}

	public function admin_delete($id = null)
	{
		$this->TipoDireccion->id = $id;
		if ( ! $this->TipoDireccion->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->TipoDireccion->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_exportar()
	{
		$datos			= $this->TipoDireccion->find('all', array(
			'recursive'				=> -1
		));
		$campos			= array_keys($this->TipoDireccion->_schema);
		$modelo			= $this->TipoDireccion->alias;

		$this->set(compact('datos', 'campos', 'modelo'));
	}
}
