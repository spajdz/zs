<?php
App::uses('AppController', 'Controller');
class TipoDescuentosController extends AppController
{
	public $components	= array('Paginator', 'Flash', 'Session');
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$tipoDescuentos	= $this->paginate();
		$this->set(compact('tipoDescuentos'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->TipoDescuento->create();
			if ( $this->TipoDescuento->save($this->request->data) )
			{
				$this->Session->setFlash("Registro agregado correctamente (ID {$this->TipoDescuento->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->TipoDescuento->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->TipoDescuento->save($this->request->data) )
			{
				$this->Session->setFlash("Registro editado correctamente (ID {$this->TipoDescuento->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		else
		{
			$this->request->data	= $this->TipoDescuento->find('first', array(
				'conditions'	=> array('TipoDescuento.id' => $id)
			));
		}
	}

	public function admin_delete($id = null)
	{
		$this->TipoDescuento->id = $id;
		if ( ! $this->TipoDescuento->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->TipoDescuento->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
}
