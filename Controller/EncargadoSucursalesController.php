<?php
App::uses('AppController', 'Controller');
class EncargadoSucursalesController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$encargadoSucursales	= $this->paginate();
		$this->set(compact('encargadoSucursales'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->EncargadoSucursal->create();
			if ( $this->EncargadoSucursal->save($this->request->data) )
			{
				$this->Session->setFlash('Registro agregado correctamente.', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}
		$sucursales	= $this->EncargadoSucursal->Sucursal->find('list');
		$this->set(compact('sucursales'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->EncargadoSucursal->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->EncargadoSucursal->save($this->request->data) )
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
			$this->request->data	= $this->EncargadoSucursal->find('first', array(
				'conditions'	=> array('EncargadoSucursal.id' => $id)
			));
		}
		$sucursales	= $this->EncargadoSucursal->Sucursal->find('list');
		$this->set(compact('sucursales'));
	}

	public function admin_delete($id = null)
	{
		$this->EncargadoSucursal->id = $id;
		if ( ! $this->EncargadoSucursal->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->EncargadoSucursal->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_exportar()
	{
		$datos			= $this->EncargadoSucursal->find('all', array(
			'recursive'				=> -1
		));
		$campos			= array_keys($this->EncargadoSucursal->_schema);
		$modelo			= $this->EncargadoSucursal->alias;

		$this->set(compact('datos', 'campos', 'modelo'));
	}

	public function admin_activar($id = null)
	{
		$this->EncargadoSucursal->id = $id;
		if ( ! $this->EncargadoSucursal->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->EncargadoSucursal->saveField('activo', true) )
		{
			$this->Session->setFlash('Registro activado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al activar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_desactivar($id = null)
	{
		$this->EncargadoSucursal->id = $id;
		if ( ! $this->EncargadoSucursal->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->EncargadoSucursal->saveField('activo', false) )
		{
			$this->Session->setFlash('Registro desactivado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al desactivar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
}
