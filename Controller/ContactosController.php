<?php
App::uses('AppController', 'Controller');
class ContactosController extends AppController
{
	public function add()
	{
		if ( $this->request->is('post') )
		{
			$this->Contacto->create();
			if ( $this->Contacto->save($this->request->data) )
			{
				$this->Session->setFlash('Mensaje enviado correctamente. Nos contactaremos contigo a la brevedad.', null, array(), 'success');
				$this->request->data		= null;
			}
			else
			{
				$this->Session->setFlash('Error al enviar tu mensaje. Por favor intenta nuevamente.', null, array(), 'danger');
			}
		}

		/**
		 * Datos de usuario logeado
		 */
		if ( $this->Auth->user() )
		{
			$usuario		= $this->Auth->user();
		}

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Contáctanos ahora');
		$this->set('title', 'Contáctanos ahora');

		$this->set(compact('regiones', 'usuario'));
	}

	public function index()
	{
		if($this->request->is('post')){
			if ($this->Contacto->validates()) {

				$redirect = '';
				if(!empty($this->request->data['Contacto']['redirect'])){
					$redirect = $this->request->data['Contacto']['redirect'];
					unset($this->request->data['Contacto']['redirect']);
				}

				if(!empty($this->request->data['Contacto']['mayoristas'])){
					$this->request->data['Contacto']['mensaje'] = 'Solicitud Ingreso Mayoristas: '.$this->request->data['Contacto']['mensaje'];
				}

				if(!empty($this->request->data['Contacto']['servicios'])){
	                $servicio = $this->Servicio->find('first',array(
	                    'fields' => array('titulo', 'slug'),
	                    'conditions' => array(
	                        'Servicio.id' => $this->request->data['Contacto']['servicios']
	                        )
	                    )
	                );

	                $servicioNombre = $servicioRes['Servicio']['titulo'];

					$this->request->data['Contacto']['mensaje'] = 'Solicitud de Servicio ('.$servicioNombre.')<br><br><STRONG>Mensaje usuario</STRONG>:'.$this->request->data['Contacto']['mensaje'];
				}

				if(!empty($this->request->data['Contacto']['tipo_contacto'])){
					$this->request->data['Contacto']['tipo_contacto_id'] = $this->request->data['Contacto']['tipo_contacto'];
					unset($this->request->data['Contacto']['tipo_contacto']);
				}

				//NOTA: EL ARREGLO DE DATOS FINAL A ENVIAR SE HACE EN EL MODEL::BEFORESAVE
				$this->Contacto->create();
				if ( $this->Contacto->save($this->request->data) )
				{

					// ENVIAR A SISTEMA DE LANDING
					$formularioId = '';
					$campos = array();
					if(!empty($this->request->data['Contacto']['formulario']) && $this->request->data['Contacto']['formulario'] == 'contactanos' ){
						$formularioId = 'ZSMOTORS-CONTACTO';

						$campos['nombre'] 		= $this->request->data['Contacto']['nombre'];
						$campos['email'] 		= $this->request->data['Contacto']['email'];
						$campos['telefono'] 	= $this->request->data['Contacto']['telefono'];
						$campos['comentario'] 	= $this->request->data['Contacto']['mensaje'];
						$campos['origen'] 		= $this->request->data['Contacto']['origen'];
						$campos['utm_source'] 	= $this->request->data['Contacto']['utm_source'];
						$campos['utm_medium'] 	= $this->request->data['Contacto']['utm_medium'];
						$campos['utm_campaign']	= $this->request->data['Contacto']['utm_campaign'];
						$campos['utm_term'] 	= $this->request->data['Contacto']['utm_term'];
						$campos['utm_content'] 	= $this->request->data['Contacto']['utm_content'];
						$campos['scid'] 		= $this->request->data['Contacto']['scid'];
						$campos['gclid'] 		= $this->request->data['Contacto']['gclid'];
					}

					// if(!empty($formularioId)){
					// 	$endpoint		= curl_init();
					// 	curl_setopt_array($endpoint, array(
					// 		CURLOPT_URL					=> 'http://landings.reach-latam.com/api/1.0/leads.json',
					// 		CURLOPT_POST				=> true,
					// 		CURLOPT_POSTFIELDS			=> urldecode(http_build_query(array(
					// 			'_method'					=> 'POST',
					// 			'Cliente'		=> array(
					// 				'identificador'		=> 'ZSMOTORS-CL',
					// 				'clave'				=> urlencode('P&F<y`BsP9+[-VJ:;Z')
					// 			),
					// 			'Formulario'	=> array(
					// 				'identificador'		=> $formularioId
					// 			),
					// 			'Campo'			=> $campos,
					// 		))),
					// 		CURLOPT_RETURNTRANSFER		=> true,
					// 		CURLOPT_VERBOSE				=> true,
					// 		CURLINFO_HEADER_OUT			=> true,
					// 		CURLOPT_TIMEOUT				=> 2000
					// 	));
					// 	$resultado		= curl_exec($endpoint);
					// 	$err			= curl_errno($endpoint);
					// 	curl_close($endpoint);
					
					// }

					$this->redirect(array('controller' => $redirect));
				}
				else
				{
					$this->Session->setFlash('Error al enviar los registros. Por favor intenta nuevamente.', null, array(), 'danger');
					$this->redirect(array('controller' => $redirect, 'action' => $redirectAction, $redirectParam));
				}


			}else{
				$this->Session->setFlash('Error al enviar los registros. Por favor intenta nuevamente.', null, array(), 'danger');
				$this->redirect(array('controller' => $redirect, 'action' => $redirectAction));
			}

		}
	}

	public function admin_index()
	{

		/**
		 * Inicio busqueda
		 */
		if ( $this->request->is('post') )
		{
			$busqueda		= array();
			extract($this->request->data['Contacto']);

			// Información de busqueda libre
			if ( ! empty($libre) )
			{
				$busqueda['buscar']				= $libre;
			}
			// Informacion de busqueda por region
			if ( ! empty($region_id) )
			{
				$busqueda['region']				= $region_id;
			}
			// Informacion de busqueda por comuna
			if ( ! empty($comuna_id) )
			{
				$busqueda['comuna']				= $comuna_id;
			}
			$this->redirect(array('filtro' => $busqueda));

		}

		/**
		 * Paginacion + Filtros
		 * Se declara la paginacion con sus respectivos atributos, pero dejando
		 * las condiciones vacias
		 */
		//$this->paginate		= array(
		$paginacion		= array(
			'contain'			=> array(
				'Usuario',
				'Comuna' => array('Region'),
				'Administrador'
			),
			'order'				=> array('Contacto.created' => 'DESC')
		);

		$filtros			=	$this->params['named'];
		$condicionFiltros	=	$this->Contacto->condicionesFiltros($filtros);
		if ( ! empty($condicionFiltros) )
		{
			$paginacion['conditions']	= $condicionFiltros;
		}
		$this->paginate		= $paginacion;
		$contactos			= $this->paginate();

		$regiones			= $this->Contacto->Comuna->Region->find('list');

		$this->set(compact('contactos', 'regiones', 'filtros'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Contacto->create();
			if ( $this->Contacto->save($this->request->data) )
			{
				$this->Session->setFlash("Registro agregado correctamente (ID {$this->Contacto->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		$usuarios	= $this->Contacto->Usuario->find('list');
		$comunas	= $this->Contacto->Comuna->find('list');
		$administradores	= $this->Contacto->Administrador->find('list');
		$this->set(compact('usuarios', 'comunas', 'administradores'));
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Contacto->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Contacto->save($this->request->data) )
			{
				$this->Session->setFlash("Registro editado correctamente (ID {$this->Contacto->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		else
		{
			$this->request->data	= $this->Contacto->find('first', array(
				'conditions'	=> array('Contacto.id' => $id)
			));
		}
		$usuarios	= $this->Contacto->Usuario->find('list');
		$comunas	= $this->Contacto->Comuna->find('list');
		$administradores	= $this->Contacto->Administrador->find('list');
		$this->set(compact('usuarios', 'comunas', 'administradores'));
	}

	public function admin_delete($id = null)
	{
		$this->Contacto->id = $id;
		if ( ! $this->Contacto->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Contacto->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}
}
