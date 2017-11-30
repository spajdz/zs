<?php
App::uses('AppController', 'Controller');
class SucursalesController extends AppController
{
	public $uses = array('Sucursal','Banner');
	public function admin_index()
	{
		$sucursales = $this->Sucursal->find('all', array(
				'contain' => array(
					'TipoSucursal'
				)
			)
		);		
		$this->set(compact('sucursales'));
	}
	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Sucursal->create();
			$this->request->data['Sucursal']['slug'] = strtolower(Inflector::slug($this->request->data['Sucursal']['nombre'], '-'));
			if ( $this->Sucursal->save($this->request->data) )
			{
				$this->Session->setFlash('Registro agregado correctamente.', null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Error al guardar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
			
			}
		}
		$tipoSucursales	= $this->Sucursal->TipoSucursal->find('list');
		$servicios	= $this->Sucursal->Servicio->find('list');
		$this->set(compact('tipoSucursales','servicios'));
	}
	public function admin_edit($id = null)
	{
		if ( ! $this->Sucursal->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		if ( $this->request->is('post') || $this->request->is('put') )
		{
			$this->request->data['Sucursal']['slug'] = strtolower(Inflector::slug($this->request->data['Sucursal']['nombre'], '-'));
			if($this->request->data['Sucursal']['imagen']['error'] != 0)
			{
				unset($this->request->data['Sucursal']['imagen']);
			}
			if ( $this->Sucursal->save($this->request->data) )
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
			$this->request->data	= $this->Sucursal->find('first', array(
				'conditions'	=> array('Sucursal.id' => $id),
				'contain'	=> array('Servicio')
			));
		}
		$tipoSucursales	= $this->Sucursal->TipoSucursal->find('list');
		$servicios	= $this->Sucursal->Servicio->find('list');
		$FotoActual = "";
		if ($this->request->data['Sucursal']['imagen']) {
			$FotoActual = $this->request->data['Sucursal']['imagen']['mini'];
		}
		$this->set(compact('tipoSucursales', 'FotoActual','servicios'));
	}
	public function admin_delete($id = null)
	{
		$this->Sucursal->id = $id;
		if ( ! $this->Sucursal->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ( $this->Sucursal->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intenta nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
	public function admin_exportar()
	{
		$datos			= $this->Sucursal->find('all', array(
			'recursive'				=> -1
		));
		$campos			= array_keys($this->Sucursal->_schema);
		$modelo			= $this->Sucursal->alias;
		$this->set(compact('datos', 'campos', 'modelo'));
	}

	public function index(){	

		$banners	= $this->Banner->find('all', array(
			'conditions'		=> array(
				'Banner.activo' 	=> 1,
				'Banner.pagina_id' 	=> 3
			),
			'order'				=> 'orden',
			'fields'			=> array(
				'Banner.id'
				,'Banner.nombre'
				,'Banner.imagen'
				,'Banner.link'
				,'Banner.enlace_externo'
				,'Banner.texto'
			) 	
		));

		$miniBanner = $this->Banner->find('first', array(
			'conditions'		=> array(
				'Banner.activo' 	=> 1,
				'Banner.pagina_id' 	=> 4
			),
			'order'				=> 'orden',
			'fields'			=> array(
				'Banner.id'
				,'Banner.nombre'
				,'Banner.imagen'
				,'Banner.link'
				,'Banner.enlace_externo'
				,'Banner.texto'
			),
			'limit' => 1 	
		));

		$sucursales = $this->Sucursal->find('all', array(
				'conditions' => array(
					'Sucursal.activo' => 1
					,'Sucursal.tipo_sucursal_id' => 1
				),
				'contain' => array(
					'Servicio' => array(
						'fields' => array(
							'Servicio.nombre',
							'Servicio.slug'
						)
					)
				)
			)
		);

		$distribuidores = $this->Sucursal->find('all', array(
				'conditions' => array(
					'Sucursal.activo' => 1
					,'Sucursal.tipo_sucursal_id' => 2
				),
				'contain' => array(
					'Servicio' => array(
						'fields' => array(
							'Servicio.nombre',
							'Servicio.slug'
						)
					)
				)
			)
		);

		$this->set(compact('banners', 'miniBanner', 'sucursales', 'distribuidores'));
	}
}
