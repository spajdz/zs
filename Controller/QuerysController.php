<?php
App::uses('AppController', 'Controller');
class QuerysController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'conditions'		=> array('Query.revision' => false),
			'order'				=> array('Query.identificador' => 'ASC'),
			'recursive'			=> 0
		);
		$querys	= $this->paginate();
		$this->set(compact('querys'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Query->create();
			if ( $this->Query->save($this->request->data) )
			{
				$this->Session->setFlash("Registro agregado correctamente (ID {$this->Query->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		$administradores	= $this->Query->Administrador->find('list');
		$this->set(compact('administradores'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Query->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Query->save($this->request->data) )
			{
				$query			= $this->Query->find('first', array(
					'fields'			=> array('Query.id', 'Query.identificador'),
					'conditions'		=> array('Query.id' => $id),
					'callbacks'			=> false
				));
				$this->Query->deleteCache('Query', $query['Query']['identificador']);

				$this->Session->setFlash("Registro editado correctamente (ID {$this->Query->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		else
		{
			$this->request->data	= $this->Query->find('first', array(
				'conditions'	=> array('Query.id' => $id)
			));
		}
		$identificadores		= $this->Query->Identificador->find('all', array(
			'conditions'	=> array('Identificador.query_id' => $id)
		));
		$versiones				= $this->Query->find('all', array(
			'conditions'			=> array(
				'Query.id !='			=> $id,
				'Query.identificador'	=> $this->request->data['Query']['identificador']
			),
			'order'					=> array('Query.version' => 'DESC'),
			'contain'				=> array('Administrador')
		));
		$this->set(compact('identificadores', 'versiones'));
	}

	public function admin_eliminarCache($id = null)
	{
		if ( ! $this->Query->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		$query			= $this->Query->find('first', array(
			'fields'			=> array('Query.id', 'Query.identificador'),
			'conditions'		=> array('Query.id' => $id),
			'callbacks'			=> false
		));

		if ( $this->Query->deleteCache('Query', $query['Query']['identificador']) )
		{
			$this->Session->setFlash("Cache eliminado correctamente", null, array(), 'success');
		}
		else
		{
			$this->Session->setFlash('Error al eliminar el cache. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		$this->redirect(array('action' => 'index'));
	}

	public function admin_delete($id = null)
	{
		$this->Query->id = $id;
		if ( ! $this->Query->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Query->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_restore($id = null)
	{
		$this->Query->id = $id;
		if ( ! $this->Query->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->Query->restore() )
		{
			$this->Session->setFlash('Query restaurada correctamente', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al resturar la query. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
}
