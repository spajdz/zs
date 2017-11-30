<?php
App::uses('AppController', 'Controller');
class NoticiasController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$noticias	= $this->paginate();
		$this->set(compact('noticias'));
	}
	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Noticia->create();
			$this->request->data['Noticia']['slug'] = strtolower(Inflector::slug($this->request->data['Noticia']['titulo'], '-'));
			if ( $this->Noticia->save($this->request->data) )
			{
				$this->Session->setFlash('Registro agregado correctamente.', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}
	}
	public function admin_edit($id = null)
	{
		if ( ! $this->Noticia->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		if ( $this->request->is('post') || $this->request->is('put') )
		{
			$this->request->data['Noticia']['slug'] = strtolower(Inflector::slug($this->request->data['Noticia']['titulo'], '-'));
			if(empty($this->request->data['Noticia']['imagen']) || $this->request->data['Noticia']['imagen']['size'] == 0){
				unset($this->request->data['Noticia']['imagen']);
			}
			if ( $this->Noticia->save($this->request->data) )
			{
				$this->Session->setFlash('Registro editado correctamente', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}
		else
		{
			$this->request->data	= $this->Noticia->find('first', array(
				'conditions'	=> array('Noticia.id' => $id)
			));
		}
		$FotoActual = "";
		if ($this->request->data['Noticia']['imagen']) {
			$FotoActual = $this->request->data['Noticia']['imagen']['mini'];
		}
		$this->set(compact('FotoActual'));
	}
	public function admin_delete($id = null)
	{
		$this->Noticia->id = $id;
		if ( ! $this->Noticia->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ( $this->Noticia->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
	public function admin_exportar()
	{
		$datos			= $this->Noticia->find('all', array(
			'recursive'				=> -1
		));
		$campos			= array_keys($this->Noticia->_schema);
		$modelo			= $this->Noticia->alias;
		$this->set(compact('datos', 'campos', 'modelo'));
	}
	public function admin_activar($id = null)
	{
		$this->Noticia->id = $id;
		if ( ! $this->Noticia->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		if ( $this->Noticia->saveField('activo', true) )
		{
			$this->Session->setFlash('Registro activado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al activar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
	public function admin_desactivar($id = null)
	{
		$this->Noticia->id = $id;
		if ( ! $this->Noticia->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		if ( $this->Noticia->saveField('activo', false) )
		{
			$this->Session->setFlash('Registro desactivado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al desactivar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
}
