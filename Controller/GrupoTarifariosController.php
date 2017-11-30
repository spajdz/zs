<?php
App::uses('AppController', 'Controller');
class GrupoTarifariosController extends AppController
{
	public function admin_index()
	{
		$this->paginate		= array(
			'recursive'			=> 0
		);
		$grupoTarifarios	= $this->paginate();
		$this->set(compact('grupoTarifarios'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->GrupoTarifario->create();
			if ( $this->GrupoTarifario->saveAll($this->request->data) )
			{
				$this->Session->setFlash("Registro agregado correctamente", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
			}
		}

		$querys				= $this->GrupoTarifario->Query->find('list', array(
			'conditions'		=> array('Query.revision'		=> false),
			'order'				=> array('Query.identificador'	=> 'ASC')
		));
		$administradores	= $this->GrupoTarifario->Administrador->find('list');

		$this->set(compact('querys', 'administradores'));
	}

	public function admin_edit( $id = null )
	{
		if ( ! $this->GrupoTarifario->exists( $id ) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			// Agregamos la relacion con usuario_grupo_tarifario
			$this->GrupoTarifario->bindHABTM();
			$this->GrupoTarifario->UsuarioGrupoTarifario->deleteALL(array(
				'grupo_tarifario_id' => $this->request->data['GrupoTarifario']['id']
			));
			if ( $this->GrupoTarifario->saveAll($this->request->data) )
			{
				$this->Session->setFlash("Registro editado correctamente", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
			}
		}
		else
		{
			$this->request->data	= $this->GrupoTarifario->find('first', array(
				'conditions'	=> array('GrupoTarifario.id' => $id),
				'contain'		=> array('Usuario' => array('TipoUsuario'))
			));
		}

		$querys				= $this->GrupoTarifario->Query->find('list');
		$administradores	= $this->GrupoTarifario->Administrador->find('list');

		$this->set(compact('querys', 'administradores'));
	}

	public function admin_delete($id = null)
	{
		$this->GrupoTarifario->id = $id;
		if ( ! $this->GrupoTarifario->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->GrupoTarifario->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	/**
	 * admin_ajax_usuariosTarifarios()
	 * Funcion que permite obtener el listado de clientes filtrados por un parametro, que es enviado por
	 * una funcion ajax en solicitud de un autocompltear
	 */
	public function admin_ajax_usuariosTarifarios()
	{
		$this->layout		= 'ajax';
		$data				= array();

		if ( $this->request->is('post') && ! empty($this->request->data['query']) )
		{
			/**
			 * Obtenemos los usuarios que estan registrados en grupos tarifarios existentes
			 */
			$this->GrupoTarifario->bindHABTM();
			$usuariosGrupoTarifario	= $this->GrupoTarifario->UsuarioGrupoTarifario->find('all', array(
				'fields'	=>	array('UsuarioGrupoTarifario.usuario_id')
			));
			$excluir_ids	 	= array_unique(Hash::extract($usuariosGrupoTarifario, '{n}.UsuarioGrupoTarifario.usuario_id'));
			$search 			= $this->request->data['query'];
			$usuarios			= $this->GrupoTarifario->Usuario->find('all', array(
			   'conditions'		=> array(
					'Usuario.activo'	=> 1,
					'Usuario.id !='		=> $excluir_ids,
					'OR'				=> array(
						array('Usuario.nombre LIKE'				=> sprintf('%%%s%%', $search)),
						array('Usuario.apellido_paterno LIKE'	=> sprintf('%%%s%%', $search)),
						array('Usuario.apellido_materno LIKE'	=> sprintf('%%%s%%', $search)),
						array('Usuario.email LIKE'				=> sprintf('%%%s%%', $search)),
						array('Usuario.celular LIKE'			=> sprintf('%%%s%%', $search)),
					)
				),
				'fields'		=> array(
					'Usuario.id',
					'Usuario.nombre_completo',
					'Usuario.nombre',
					'Usuario.email',
					'Usuario.celular',
					'TipoUsuario.nombre'
				),
				'contain'		=> array('TipoUsuario')
			));
		}
		$this->set(compact('usuarios'));
	}

	/**
	 * Funcion que permite activar un grupo tarifario
	 */
	public function admin_activar($id = null)
	{
		$this->GrupoTarifario->id = $id;
		if ( ! $this->GrupoTarifario->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		if ( $this->GrupoTarifario->saveField('activo', true) )
		{
			$this->Session->setFlash('Registro activado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al activar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	/**
	 * Funcion que permite activar un grupo tarifario
	 */
	public function admin_desactivar($id = null)
	{
		$this->GrupoTarifario->id = $id;
		if ( ! $this->GrupoTarifario->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		if ( $this->GrupoTarifario->saveField('activo', false) )
		{
			$this->Session->setFlash('Registro desactivado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al desactivar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
}
