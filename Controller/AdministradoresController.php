<?php
App::uses('AppController', 'Controller');
class AdministradoresController extends AppController
{
	public function admin_login()
	{
		$this->layout		= 'login';
		if ( $this->request->is('post') )
		{
			if ( $this->Auth->login() )
			{
				//$this->redirect($this->Auth->redirectUrl());
				/**
				 * Permiso de acceso al modulo
				 */
				$permiso_usuario	= json_decode($this->Auth->user('Perfil')['permisos']);
				$perfil_usuario		= $this->Auth->user('perfil_id');
				if ( permisosPerfilBackend( $perfil_usuario, $permiso_usuario, 'dashboard' ) )
				{
					$this->redirect(array('controller' => 'compras', 'action' => 'dashboard', 'admin' => true));
				}else
				{
					$modulo_home = obtenerPrimerModuloPermiso($permiso_usuario);
					$this->redirect(array('controller' => $modulo_home, 'action' => 'index', 'admin' => true));
				}
			}
			else
			{
				$this->Session->setFlash('Nombre de usuario y/o clave incorrectos.', null, array(), 'danger');
			}
		}
	}

	public function admin_logout()
	{
		$this->redirect($this->Auth->logout());
	}

	public function admin_lock()
	{
		$this->layout		= 'login';

		if ( ! $this->request->is('post') )
		{
			if ( ! $this->Session->check('Admin.lock') )
			{
				$this->Session->write('Admin.lock', array(
					'status'		=> true,
					'referer'		=> $this->referer()
				));
			}
		}
		else
		{
			$administrador		= $this->Administrador->findById($this->Auth->user('id'));
			if ( $this->Auth->password($this->request->data['Administrador']['clave']) === $administrador['Administrador']['clave'] )
			{
				$referer		= $this->Session->read('Admin.lock.referer');
				$this->Session->delete('Admin.lock');
				$this->redirect($referer);
			}
			else
				$this->Session->setFlash('Clave incorrecta.', null, array(), 'danger');
		}
	}

	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$administradores	= $this->paginate();
		$this->set(compact('administradores'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Administrador->create();
			if ( $this->Administrador->save($this->request->data) )
			{
				$this->Session->setFlash("Registro agregado correctamente (ID {$this->Administrador->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		$perfiles	= $this->Administrador->Perfil->find('list');
		$this->set(compact('perfiles'));
	}

	public function edit1(){
		$this->Administrador->id = 1;

		prx($this->Administrador->save(array('clave' => 'admin')));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Administrador->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Administrador->save($this->request->data) )
			{
				$this->Session->setFlash("Registro editado correctamente (ID {$this->Administrador->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		else
		{
			$this->request->data	= $this->Administrador->find('first', array(
				'conditions'	=> array('Administrador.id' => $id)
			));
		}
		$perfiles	= $this->Administrador->Perfil->find('list');
		$this->set(compact('perfiles'));
	}

	public function admin_delete($id = null)
	{
		$this->Administrador->id = $id;
		if ( ! $this->Administrador->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Administrador->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
}
