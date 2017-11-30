<?php
App::uses('AppController', 'Controller');
class TextosController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$textos	= $this->paginate();
		$this->set(compact('textos'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Texto->create();
			if ( $this->Texto->save($this->request->data) )
			{
				$this->Session->setFlash("Registro agregado correctamente (ID {$this->Texto->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		$administradores	= $this->Texto->Administrador->find('list');
		$this->set(compact('administradores'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Texto->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Texto->save($this->request->data) )
			{
				$this->Session->setFlash("Registro editado correctamente (ID {$this->Texto->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		else
		{
			$this->request->data	= $this->Texto->find('first', array(
				'conditions'	=> array('Texto.id' => $id)
			));
		}
		$administradores	= $this->Texto->Administrador->find('list');
		$this->set(compact('administradores'));
	}

	public function admin_delete($id = null)
	{
		$this->Texto->id = $id;
		if ( ! $this->Texto->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Texto->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	/**
	 * Funcion que permite activar un texto desde el listado del mismo
	 * @param			Object			$id			Id del texto a activar
	 */
	public function admin_activar($id = null)
	{
		$this->Texto->id = $id;
		if ( ! $this->Texto->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		if ( $this->Texto->saveField('activo', true) )
		{
			$this->Session->setFlash('Registro activado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al activar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
	/**
	 * Funcion que permite desactivar un texto desde el listado del mismo
	 * @param			Object			$id			Id del texto a activar
	 */
	public function admin_desactivar($id = null)
	{
		$this->Texto->id = $id;
		if ( ! $this->Texto->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		if ( $this->Texto->saveField('activo', false) )
		{
			$this->Session->setFlash('Registro desactivado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al desactivar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
}
