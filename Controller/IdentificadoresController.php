<?php
App::uses('AppController', 'Controller');
class IdentificadoresController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$identificadores	= $this->paginate();
		$this->set(compact('identificadores'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Identificador->create();
			if ( $this->Identificador->save($this->request->data) )
			{
				$this->Session->setFlash("Registro agregado correctamente (ID {$this->Identificador->id})");
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.');
		}
		$querys	= $this->Identificador->Query->find('list', array(
			'conditions'		=> array('Query.revision' => false)
		));
		$this->set(compact('querys'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Identificador->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Identificador->save($this->request->data) )
			{
				$this->Session->setFlash("Registro editado correctamente (ID {$this->Identificador->id})");
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.');
		}
		else
		{
			$this->request->data	= $this->Identificador->find('first', array(
				'conditions'	=> array('Identificador.id' => $id)
			));
		}
		$querys	= $this->Identificador->Query->find('list', array(
			'conditions'		=> array('Query.revision' => false)
		));
		$this->set(compact('querys'));
	}

	public function admin_delete($id = null)
	{
		$this->Identificador->id = $id;
		if ( ! $this->Identificador->exists() )
		{
			$this->Session->setFlash('Registro inválido.');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Identificador->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intentalo nuevamente.');
		$this->redirect(array('action' => 'index'));
	}
}
