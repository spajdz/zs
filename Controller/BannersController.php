<?php
App::uses('AppController', 'Controller');
class BannersController extends AppController
{
	public function admin_ajax_reorden()
	{
		$this->layout			= 'ajax';
		$this->autoRender		= false;
		if ( $this->request->is('post') )
		{
			if ( ! empty($this->request->data['Banner']['orden']) )
			{
				$data			= array();
				foreach ( $this->request->data['Banner']['orden'] as $id => $orden )
				{
					array_push($data, array(
						'Banner'		=> array(
							'id'			=> $id,
							'orden'			=> $orden
						)
					));
				}
				$this->Banner->saveAll($data);
			}
		}
	}

	public function admin_index()
	{
		$banners		= $this->Banner->find('all', array(
			'contain'		=> array('Administrador', 'Pagina'),
			'order'			=> array('Banner.orden' => 'ASC'),
			'conditions'	=> array(
				'NOT' => array(
					'Banner.pagina_id' => 2
				)
			)
		));

		$this->set(compact('banners'));
	}

	public function admin_add($cuadroshome = null)	
	{
		if ( $this->request->is('post') )
		{
			$this->request->data	= $this->Banner->normalizaFechaVacia($this->request->data, array('fecha_inicio', 'fecha_fin'));
			if(!empty($cuadroshome)){
				$this->request->data['Banner']['pagina_id'] = 2;
			}
			// prx($this->request->data);
			$this->Banner->create();
			if ( $this->Banner->save($this->request->data) )
			{
				$this->Session->setFlash("Registro agregado correctamente", null, array(), 'success');
				if(!empty($cuadroshome)){
					$this->redirect(array('action' => 'cuadroshome'));
				}
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
			}
		}

		$paginas		= $this->Banner->Pagina->find('list', array('conditions' => array(
			'NOT' => array(
				'Pagina.id' => 2
			)
		)));
		$this->set(compact('paginas', 'cuadroshome'));
	}

	public function admin_edit($id = null,$cuadroshome = null)
	{
		if ( ! $this->Banner->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			$this->request->data	= $this->Banner->normalizaFechaVacia($this->request->data, array('fecha_inicio', 'fecha_fin'));
			if($this->request->data['Banner']['imagen']['name']==''){
				unset($this->request->data['Banner']['imagen']);
			}	
			if ( $this->Banner->save($this->request->data) )
			{
				$this->Session->setFlash("Registro editado correctamente", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		else
		{
			$this->request->data	= $this->Banner->find('first', array(
				'conditions'	=> array('Banner.id' => $id)
			));
		}

		$paginas	= $this->Banner->Pagina->find('list');

        $ImagenActual = "";
        if ($this->request->data['Banner']['imagen']) {
            $ImagenActual = $this->request->data['Banner']['imagen']['mini'];
        }

        $this->set(compact('paginas', 'ImagenActual', 'cuadroshome'));

	}

	public function admin_cuadroshome()
	{
		$banners		= $this->Banner->find('all', array(
			'contain'		=> array('Administrador', 'Pagina'),
			'order'			=> array('Banner.orden' => 'ASC'),
			'conditions' => array(
				'Banner.pagina_id' => 2
			)
		));

		$this->set(compact('banners'));
	}

	public function admin_delete($id = null)
	{
		$this->Banner->id = $id;
		if ( ! $this->Banner->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index' ));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Banner->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_activar($id = null)
	{
		$this->Banner->id = $id;
		if ( ! $this->Banner->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index') );
		}

		if ( $this->Banner->save(array('activo'=> true, 'eliminado' => false)))
		{
			$this->Session->setFlash('Registro activado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index') );
		}
		$this->Session->setFlash('Error al activar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');

		$this->redirect(array('action' => 'index') );
	}

	public function admin_desactivar($id = null)
	{
		$this->Banner->id = $id;
		if ( ! $this->Banner->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index') );
		}

		if ( $this->Banner->save(array('activo'=> false, 'eliminado' => true)))
		{
			$this->Session->setFlash('Registro desactivado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index') );
		}
		$this->Session->setFlash('Error al desactivar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');

		$this->redirect(array('action' => 'index') );
	}

}
