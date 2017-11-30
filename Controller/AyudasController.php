<?php
App::uses('AppController', 'Controller');
class AyudasController extends AppController
{
	public function index($slug = null)
	{
		$temas			= $this->Ayuda->Tema->find('all', array(
			'order'			=> array('Tema.orden' => 'ASC')
		));

		if ( ! $temas )
		{
			$this->redirect('/');
		}

		if ( ! $slug || ! ( $actual = $this->Ayuda->Tema->findBySlug($slug) ) )
		{
			$this->redirect(array('action' => 'index', $temas[0]['Tema']['slug']));
		}

		$ayudas		= $this->Ayuda->find('all', array(
			'contain'			=> array('Tema'),
			'conditions'		=> array(
				'Tema.slug'			=> $slug,
				'Ayuda.activo'		=> true
			),
			'order'				=> array(
				'Ayuda.orden'		=> 'ASC'
			)
		));

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Ayuda', array('action' => 'index'));
		BreadcrumbComponent::add($actual['Tema']['nombre']);
		$this->set('title', 'Ayuda');

		$this->set(compact('temas', 'actual', 'ayudas'));
	}

	public function admin_ajax_reorden()
	{
		$this->layout			= 'ajax';
		$this->autoRender		= false;

		if ( $this->request->is('post') )
		{
			if ( ! empty($this->request->data['Ayuda']['orden']) )
			{
				$data			= array();
				foreach ( $this->request->data['Ayuda']['orden'] as $id => $orden )
				{
					array_push($data, array(
						'Ayuda'		=> array(
							'id'			=> $id,
							'orden'			=> $orden
						)
					));
				}
				$this->Ayuda->saveAll($data);
			}
		}
	}

	public function admin_index()
	{
		$ayudas		= $this->Ayuda->find('all', array(
			'contain'		=> array('Tema', 'Administrador'),
			'order'			=> array(
				'Ayuda.tema_id'		=> 'ASC',
				'Ayuda.orden'		=> 'ASC'
			)
		));
		$temas			= $this->Ayuda->Tema->find('all', array(
			'order'			=> array('Tema.orden' => 'ASC'),
			'contain'		=> array(
				'Ayuda'		=> array(
					'order'			=> array('Ayuda.orden' => 'ASC'),
					'Administrador'
				)
			)
		));
		$this->set(compact('temas'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Ayuda->create();
			if ( $this->Ayuda->save($this->request->data) )
			{
				$this->Session->setFlash("Registro agregado correctamente (ID {$this->Ayuda->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		$temas	= $this->Ayuda->Tema->find('list');
		$administradores	= $this->Ayuda->Administrador->find('list');
		$this->set(compact('temas', 'administradores'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Ayuda->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Ayuda->save($this->request->data) )
			{
				$this->Session->setFlash("Registro editado correctamente (ID {$this->Ayuda->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		else
		{
			$this->request->data	= $this->Ayuda->find('first', array(
				'conditions'	=> array('Ayuda.id' => $id)
			));
		}
		$temas	= $this->Ayuda->Tema->find('list');
		$administradores	= $this->Ayuda->Administrador->find('list');
		$this->set(compact('temas', 'administradores'));
	}

	public function admin_delete($id = null)
	{
		$this->Ayuda->id = $id;
		if ( ! $this->Ayuda->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Ayuda->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_activar($id = null)
	{
		$this->Ayuda->id = $id;
		if ( ! $this->Ayuda->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->Ayuda->saveField('activo', true) )
		{
			$this->Session->setFlash('Registro activado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al activar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_desactivar($id = null)
	{
		$this->Ayuda->id = $id;
		if ( ! $this->Ayuda->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->Ayuda->saveField('activo', false) )
		{
			$this->Session->setFlash('Registro desactivado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al desactivar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
}
