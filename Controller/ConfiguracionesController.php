<?php
App::uses('AppController', 'Controller');
class ConfiguracionesController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'conditions'		=> array('Configuracion.oculto' => false),
			'order'				=> array('Configuracion.nombre' => 'ASC'),
			'recursive'			=> 0
		);
		$configuraciones	= $this->paginate();
		$this->set(compact('configuraciones'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->request->data	= $this->Configuracion->normalizaFechaVacia($this->request->data, array('fecha_inicio', 'fecha_fin'));
			$this->Configuracion->create();
			if ( $this->Configuracion->save($this->request->data) )
			{
				$this->Session->setFlash("Registro agregado correctamente", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		$administradores	= $this->Configuracion->Administrador->find('list');
		$this->set(compact('administradores'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Configuracion->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			$this->request->data	= $this->Configuracion->normalizaFechaVacia($this->request->data, array('fecha_inicio', 'fecha_fin'));
			if ( $this->Configuracion->save($this->request->data) )
			{
				$this->Session->setFlash("Registro editado correctamente", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		else
		{
			$this->request->data	= $this->Configuracion->find('first', array(
				'conditions'	=> array('Configuracion.id' => $id)
			));
		}
		$administradores	= $this->Configuracion->Administrador->find('list');
		$this->set(compact('administradores'));
	}

	public function admin_delete($id = null)
	{
		$this->Configuracion->id = $id;
		if ( ! $this->Configuracion->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Configuracion->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
}
