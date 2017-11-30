<?php
App::uses('AppController', 'Controller');
class EstadoComprasController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$estadoCompras	= $this->paginate();
		$this->set(compact('estadoCompras'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->EstadoCompra->create();
			if ( $this->EstadoCompra->save($this->request->data) )
			{
				$this->Session->setFlash("Registro agregado correctamente (ID {$this->EstadoCompra->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->EstadoCompra->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->EstadoCompra->save($this->request->data) )
			{
				$this->Session->setFlash("Registro editado correctamente (ID {$this->EstadoCompra->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		else
		{
			$this->request->data	= $this->EstadoCompra->find('first', array(
				'conditions'	=> array('EstadoCompra.id' => $id)
			));
		}
	}

	public function admin_delete($id = null)
	{
		$this->EstadoCompra->id = $id;
		if ( ! $this->EstadoCompra->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->EstadoCompra->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
}
