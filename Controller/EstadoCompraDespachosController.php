<?php
App::uses('AppController', 'Controller');
class EstadoCompraDespachosController extends AppController
{
	public $components	= array('Paginator');
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$estadoCompraDespachos	= $this->paginate();
		$this->set(compact('estadoCompraDespachos'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->EstadoCompraDespacho->create();
			if ( $this->EstadoCompraDespacho->save($this->request->data) )
			{
				$this->Session->setFlash("Registro agregado correctamente (ID {$this->EstadoCompraDespacho->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->EstadoCompraDespacho->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->EstadoCompraDespacho->save($this->request->data) )
			{
				$this->Session->setFlash("Registro editado correctamente (ID {$this->EstadoCompraDespacho->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		else
		{
			$this->request->data	= $this->EstadoCompraDespacho->find('first', array(
				'conditions'	=> array('EstadoCompraDespacho.id' => $id)
			));
		}
	}

	public function admin_delete($id = null)
	{
		$this->EstadoCompraDespacho->id = $id;
		if ( ! $this->EstadoCompraDespacho->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->EstadoCompraDespacho->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
}
