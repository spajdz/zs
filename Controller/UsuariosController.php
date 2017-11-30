<?php
App::uses('AppController', 'Controller');
class UsuariosController extends AppController
{
	public function edit()
	{
		if ( ! $this->Auth->user() )
		{
			$this->redirect('/');
		}

		if ( $this->request->is('post') )
		{
			if ( $this->Usuario->save($this->request->data) )
			{
				$this->Session->setFlash('Datos actualizados correctamente.', null, array(), 'success');
			}
			else
			{
				$this->Session->setFlash('Error al actualizar tus datos. Por favor, intenta nuevamente.', null, array(), 'danger');
			}
		}
		else
		{
			$this->request->data		= $this->Usuario->find('first', array(
				'conditions'		=> array('Usuario.id' => $this->Auth->user('id'))
			));
		}

		$tipoUsuarios	= $this->Usuario->TipoUsuario->find('list');
		$this->set(compact('tipoUsuarios'));
	}

	public function recuperar($hash = null)
	{
		if ( $this->Auth->user() )
		{
			$this->redirect('/');
		}

		if ( $hash )
		{
			$usuario		= $this->Usuario->findByCodigo($hash);
			if ( $usuario )
			{
				$this->Session->write('Flujo.recuperar', $hash);
				$this->redirect(array('action' => 'cambiar_clave'));
			}
			else
			{
				$this->redirect(array('action' => 'recuperar'));
			}
		}

		if ( $this->request->is('post') )
		{
			if ( ! empty($this->request->data['Usuario']['email']) && ( $usuario = $this->Usuario->findByEmail($this->request->data['Usuario']['email']) ) )
			{
				$hash					= Security::hash($this->request->data['Usuario']['email'] . uniqid());
				$this->Usuario->id		= $usuario['Usuario']['id'];
				if ( $this->Usuario->saveField('codigo', $hash) )
				{
					$this->Session->setFlash('Te hemos enviado a tu email las instrucciones para recuperar tu contraseña.', null, array(), 'success');
					$this->redirect(array('action' => 'login'));
				}
			}
			$this->Session->setFlash('El email no está registrado como usuario.', null, array(), 'danger');
		}
	}

	public function cambiar_clave()
	{
		if ( ! $this->Session->check('Flujo.recuperar') )
		{
			$this->redirect(array('action' => 'recuperar'));
		}
		$hash			= $this->Session->read('Flujo.recuperar');
		$usuario		= $this->Usuario->findByCodigo($hash);
		if ( ! $usuario )
		{
			$this->redirect(array('action' => 'recuperar'));
		}

		if ( $this->request->is('post') )
		{
			$this->Usuario->id							= $usuario['Usuario']['id'];
			$this->request->data['Usuario']['id']		= $usuario['Usuario']['id'];
			$this->request->data['Usuario']['codigo']	= null;
			if ( $this->Usuario->save($this->request->data) )
			{
				$this->Session->setFlash('Tu contraseña fue cambiada con éxito. Por favor, inicia sesión.', null, array(), 'success');
				$this->redirect(array('action' => 'login'));
			}
			else
			{
				$this->Session->setFlash('Error al cambiar tu contraseña. Por favor, intenta nuevamente.', null, array(), 'danger');
			}
		}
	}

	public function add()
	{
		if ( $this->Auth->user() )
		{
			$this->redirect('/');
		}
		if ( $this->request->is('post') )
		{
			$this->Usuario->create();
			if ( $usuario = $this->Usuario->save($this->request->data) )
			{
				$this->Auth->login($usuario['Usuario']);
				$this->Session->setFlash('Gracias por registrarte!', null, array(), 'success');
				if ( $this->Session->check('Flujo.loginPending') )
				{
					$this->redirect($this->Session->consume('Flujo.loginPending'));
				}
				$this->redirect('/');
			}
		}
		$tipoUsuarios	= $this->Usuario->TipoUsuario->find('list');

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Registro');
		$this->set('title', 'Registro de usuario');

		$this->set(compact('tipoUsuarios'));
	}

	public function login()
	{
		if ( $this->Auth->user() )
		{
			$this->redirect('/');
		}
		if ( $this->request->is('post') )
		{
			if ( $this->Auth->login() )
			{
				if ( $this->Session->check('Flujo.loginPending') )
				{
					$this->redirect($this->Session->consume('Flujo.loginPending'));
				}
				$this->redirect('/');
			}
			else
			{
				$this->Session->setFlash('Email o contraseña incorrectos. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Iniciar sesión');
		$this->set('title', 'Iniciar sesión');
	}

	public function logout()
	{
		$this->Session->destroy();
		$this->Auth->logout();
		$this->redirect('/');
	}

	public function admin_login()
	{
		if ( $this->request->is('post') )
		{
			if ( $this->Auth->login() )
				$this->redirect($this->Auth->redirectUrl());
			else
				$this->Session->setFlash('Nombre de usuario y/o clave incorrectos.', null, array(), 'danger');
		}
	}

	public function admin_logout()
	{
		$this->redirect($this->Auth->logout());
	}

	public function admin_view($id = null)
	{
		if ( ! $this->Usuario->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$usuario		= $this->Usuario->find('first', array(
			'conditions'		=> array('Usuario.id' => $id),
			'contain'			=> array(
				'TipoUsuario',
				'Compra',
				'Direccion',
				'Lista',
				'Reserva'
			)
		));
		$this->set(compact('usuario'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Usuario->create();
			if ( $this->Usuario->save($this->request->data) )
			{
				$this->Session->setFlash('Registro agregado correctamente.', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}

		$tipoUsuarios = $this->Usuario->TipoUsuario->find (
			'list',
			array (
				'conditions' => array(
					'TipoUsuario.activo' => 1
				)
			)
		);
		$tipoPagos = $this->Usuario->TipoPago->find (
			'list',
			array (
				'conditions' => array(
					'TipoPago.activo' => 1
				)
			)
		);

		$this->set(compact('tipoUsuarios', 'tipoPagos'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Usuario->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Usuario->save($this->request->data) )
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
			$this->request->data = $this->Usuario->find(
				'first',
				array(
					'conditions' => array(
						'Usuario.id' => $id
					),
					'contain' => array(
						'TipoPago'
					)
				)
			);
		}

		$tipoUsuarios = $this->Usuario->TipoUsuario->find (
			'list',
			array (
				'conditions' => array(
					'TipoUsuario.activo' => 1
				)
			)
		);

		$tipoPagos = $this->Usuario->TipoPago->find (
			'list',
			array (
				'conditions' => array(
					'TipoPago.activo' => 1
				)
			)
		);

		$this->set(compact('tipoUsuarios', 'tipoPagos'));
	}

	public function admin_delete($id = null)
	{
		$this->Usuario->id = $id;
		if ( ! $this->Usuario->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		$this->Usuario->id = $id;
        if ( $this->Usuario->save(array('activo' => 0)))
        {
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}

		$this->Session->setFlash('Error al eliminar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	public function admin_excel()
	{
		/** Obtenemos los filtros de busqueda  */
		$filtros			=	$this->params['named'];
		$condicionFiltros	=	$this->Usuario->condicionesFiltros($filtros);

		$usuarios		= $this->Usuario->find('all', array(
			'conditions'		=> ( $condicionFiltros ? $condicionFiltros: ''),
			'contain'		=> array('TipoUsuario'),
			'order'			=> array('Usuario.created' => 'DESC')
		));

		$this->set(compact('usuarios'));
	}

	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0,
			'conditions'	=> array(
				'Usuario.activo' => 1
			)
		);
		$usuarios	= $this->paginate();
		$this->set(compact('usuarios'));
	}

	public function admin_exportar()
	{
		$datos			= $this->Usuario->find('all', array(
			'recursive'				=> -1
		));
		$campos			= array_keys($this->Usuario->_schema);
		$modelo			= $this->Usuario->alias;

		$this->set(compact('datos', 'campos', 'modelo'));
	}

}
