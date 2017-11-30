<?php
App::uses('AppController', 'Controller');
class PerfilesController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$perfiles	= $this->paginate();
		$this->set(compact('perfiles'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Perfil->create();
			if ( $this->Perfil->save($this->request->data) )
			{
				$this->Session->setFlash("Registro agregado correctamente");
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.');
			}
		}
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Perfil->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Perfil->save($this->request->data) )
			{
				$this->Session->setFlash("Registro editado correctamente");
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.');
		}
		else
		{
			$this->request->data	= $this->Perfil->find('first', array(
				'conditions'	=> array('Perfil.id' => $id)
			));
		}
	}

	public function admin_delete($id = null)
	{
		$this->Perfil->id = $id;
		if ( ! $this->Perfil->exists() )
		{
			$this->Session->setFlash('Registro inválido.');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Perfil->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intentalo nuevamente.');
		$this->redirect(array('action' => 'index'));
	}
}
