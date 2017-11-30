<?php
App::uses('AppController', 'Controller');
class DescuentosController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$descuentos	= $this->paginate();
		$this->set(compact('descuentos'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Descuento->create();
			if ( $this->Descuento->save($this->request->data) )
			{
				$this->Session->setFlash("Registro agregado correctamente (ID {$this->Descuento->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		$tipoDescuentos	= $this->Descuento->TipoDescuento->find('list');
		$administradores	= $this->Descuento->Administrador->find('list');
		$compras	= $this->Descuento->Compra->find('list');
		$usuarios	= $this->Descuento->Usuario->find('list');
		$this->set(compact('tipoDescuentos', 'administradores', 'compras', 'usuarios'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Descuento->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Descuento->save($this->request->data) )
			{
				$this->Session->setFlash("Registro editado correctamente (ID {$this->Descuento->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		else
		{
			$this->request->data	= $this->Descuento->find('first', array(
				'conditions'	=> array('Descuento.id' => $id)
			));
		}
		$tipoDescuentos	= $this->Descuento->TipoDescuento->find('list');
		$administradores	= $this->Descuento->Administrador->find('list');
		$compras	= $this->Descuento->Compra->find('list');
		$usuarios	= $this->Descuento->Usuario->find('list');
		$this->set(compact('tipoDescuentos', 'administradores', 'compras', 'usuarios'));
	}

	public function admin_delete($id = null)
	{
		$this->Descuento->id = $id;
		if ( ! $this->Descuento->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Descuento->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
}
