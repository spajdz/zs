<?php
App::uses('AppController', 'Controller');
class CategoriasController extends AppController
{

	public function admin_index()
	{
        if ( $this->request->is('post') )
        {
        	//Elimino todas las categorias seleccionadas anteriormente
        	$this->Categoria->updateAll(array('Categoria.menu' => 0), array('Categoria.menu' => 1));

        	//Se carga el nuevo menu
        	$error_carga = false;
            foreach ($this->request->data['categoriasSeleccionadas'] as $key => $value){
            	$this->Categoria->id = $value;
	            if (!$this->Categoria->saveField('menu',1)){
	            	$error_carga = true;
	            }
            }
            if(!$error_carga){
           		$this->Session->setFlash('Menu guardado correctamente.', null, array(), 'success');
            }else{
                $this->Session->setFlash('Error al guardar todo el Menu. Por favor intenta nuevamente.', null, array(), 'danger');
            }
        }	
		$categorias = $this->Categoria->find('threaded',array(
				'fields'=>array(
					'id'
					,'nombre'
					,'slug'
					,'parent_id'
					,'menu'
				),
				'conditions' => array(
					'Categoria.parent_id' => 3
				)
			)
		);
		
		$this->set(compact('categorias'));
	}
	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Categoria->create();
			if ( $this->Categoria->save($this->request->data) )
			{
				$this->Session->setFlash("Registro agregado correctamente (ID {$this->Categoria->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
			}
		}
		$parents	= $this->Categoria->Parent->find('list');
		$this->set(compact('parents'));
	}
	public function admin_edit($id = null)
	{
		if ( ! $this->Categoria->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Categoria->save($this->request->data) )
			{
				$this->Session->setFlash("Registro editado correctamente (ID {$this->Categoria->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		else
		{
			$this->request->data	= $this->Categoria->find('first', array(
				'conditions'	=> array('Categoria.id' => $id)
			));
		}
		$parents	= $this->Categoria->Parent->find('list');
		$this->set(compact('parents'));
	}
	public function admin_delete($id = null)
	{
		$this->Categoria->id = $id;
		if ( ! $this->Categoria->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ( $this->Categoria->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
}
