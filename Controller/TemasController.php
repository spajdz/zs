<?php
App::uses('AppController', 'Controller');
class TemasController extends AppController
{
	public function admin_ajax_reorden()
	{
		$this->layout			= 'ajax';
		$this->autoRender		= false;

		if ( $this->request->is('post') )
		{
			if ( ! empty($this->request->data['Tema']['orden']) )
			{
				$data			= array();
				foreach ( $this->request->data['Tema']['orden'] as $id => $orden )
				{
					array_push($data, array(
						'Tema'		=> array(
							'id'			=> $id,
							'orden'			=> $orden
						)
					));
				}
				$this->Tema->saveAll($data);
			}
		}
	}

	public function admin_index()
	{
		$temas		= $this->Tema->find('all', array(
			'order'			=> array('Tema.orden' => 'ASC')
		));
		$this->set(compact('temas'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Tema->create();
			if ( $this->Tema->save($this->request->data) )
			{
				$this->Session->setFlash("Registro agregado correctamente (ID {$this->Tema->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Tema->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Tema->save($this->request->data) )
			{
				$this->Session->setFlash("Registro editado correctamente (ID {$this->Tema->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		else
		{
			$this->request->data	= $this->Tema->find('first', array(
				'conditions'	=> array('Tema.id' => $id)
			));
		}
	}

	public function admin_delete($id = null)
	{
		$this->Tema->id = $id;
		if ( ! $this->Tema->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Tema->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_activar($id = null)
	{
		$this->Tema->id = $id;
		if ( ! $this->Tema->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->Tema->saveField('activo', true) )
		{
			$this->Session->setFlash('Registro activado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al activar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_desactivar($id = null)
	{
		$this->Tema->id = $id;
		if ( ! $this->Tema->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->Tema->saveField('activo', false) )
		{
			$this->Session->setFlash('Registro desactivado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al desactivar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
}
