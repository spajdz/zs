<?php
App::uses('AppController', 'Controller');
class ProductosController extends AppController
{
	public $uses = array('Producto', 'Categoria', 'Carga', 'ProductosCarga','Banner');
	// ZSMOTOR
	public function home(){
		$categoria = 'home';
		$banners	= $this->Banner->find('all', array(
			'conditions'		=> array(
				'Banner.activo' 	=> 1,
				'Banner.pagina_id' 	=> 1
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

		$cuadrosHome = $this->Banner->find('all', array(
			'conditions'		=> array(
				'Banner.activo' 	=> 1,
				'Banner.pagina_id' 	=> 2
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

		$this->set(compact('banners', 'categoria', 'cuadrosHome'));
	}

	public function index($categoria = null){
		$limite		= ($this->Session->check('Catalogo.Preferencias.limite') ? $this->Session->read('Catalogo.Preferencias.limite') : 10);

		if ( isset($this->params->params['named']['limite']) && in_array($this->params->params['named']['limite'], array(2,10,20, 30, 40)) )
		{
			$limite				= $this->params->params['named']['limite'];
			$this->Session->write('Preferencias.limite', $limite);
		}

		$condiciones['Producto.activo'] = 1;

		if(!empty($categoria)){
			switch ($categoria) {
				case 'neumaticos':
					$condiciones['Producto.categoria_id'] = 2;
					break;
				case 'llantas':
					$condiciones['Producto.categoria_id'] = 1;
					break;
				case 'accesorios':
					$condiciones['Producto.categoria_id'] = 3;
					break;
				default:
					break;
			}
		}else{
			$categoria = 'home';
		}

		// prx($condiciones);
	
		$this->paginate	= array(
			'conditions' => $condiciones,
			'limit' => $limite,
			'fields' => array(
				'Producto.sku'
				,'Producto.id'
				,'Producto.categoria_id'
				,'Producto.nombre'
				,'Producto.slug'
				,'Producto.stock'
				,'Producto.precio_publico'
				,'Producto.oferta_publico'
				,'Producto.oferta_mayorista'
				,'Producto.dcto_publico'
				,'Producto.dcto_mayorista'
				,'Producto.preciofinal_publico'
				,'Producto.preciofinal_mayorista'
				,'Producto.precio_mayorista'
			),
			'contain' => array(
				'Marca' => array(
					'fields' => array(
						'Marca.id',
						'Marca.slug'
					)
				)
			)
		);
		$productos	= $this->paginate();


		$this->set(compact('productos', 'categoria', 'categoria_id', 'limite'));
	}

	public function categoria($slugcat=null, $slugsubcat = null){
		if(empty($slugcat)){
			$this->redirect('/');
		}

		$categoria = $this->Categoria->find('first', array(
			'conditions' => array(
				'Categoria.activo' 	=> 1,
				'Categoria.slug'	=> $slugcat
			)
		));


		if(empty($categoria)){
			$this->redirect('/');
		}

		$condiciones['Producto.activo'] = 1;

		$limite		= ($this->Session->check('Catalogo.Preferencias.limite') ? $this->Session->read('Catalogo.Preferencias.limite') : 2);

		if ( isset($this->params->params['named']['limite']) && in_array($this->params->params['named']['limite'], array(2,10,20, 30, 40)) )
		{
			$limite				= $this->params->params['named']['limite'];
			$this->Session->write('Preferencias.limite', $limite);
		}

		if(!empty($slugsubcat)){
			$subcategoria = $this->Categoria->find('first', array(
				'conditions' => array(
					'Categoria.activo' => 1,
					'Categoria.slug'	=> $slugsubcat,
					'Categoria.parent_id' => $categoria['Categoria']['id']
				)
			));

			if(empty($subcategoria)){
				$this->redirect('/categoria/'.$categoria['Categoria']['slug']);
			}

			$condiciones['Producto.categoria_id'] = $subcategoria['Categoria']['id'];
		}else{
			$subcategorias = $this->Categoria->find('list', array(
				'conditions' => array(
					'OR' => array(
						'Categoria.parent_id' => $categoria['Categoria']['id'],
						'Categoria.id'	=> $categoria['Categoria']['id']
					)
				),
				'fields' => array(
					'Categoria.id'
				)
			));	

			$condiciones['Producto.categoria_id'] = $subcategorias;
		}

		$this->paginate	= array(
			'conditions'	=> $condiciones,
			'limit' 		=> $limite,
			'contain' 		=> array(
				'Marca'
			)
		);
		$productos	= $this->paginate();
		$categoria = 'accesorios';
		$this->set(compact('productos', 'limite', 'categoria'));
	}

	public function categorias($categoria = null, $categoria_b = null,  $subcategoria_b = null, $subsubcategoria_b = null){

		if(empty($categoria)){
			$this->Producto->redirect('/');
		}

		if(empty($categoria_b)){
			$this->redirect('/'.$categoria);
		}

		$limite		= ($this->Session->check('Catalogo.Preferencias.limite') ? $this->Session->read('Catalogo.Preferencias.limite') : 10);

		if ( isset($this->params->params['named']['limite']) && in_array($this->params->params['named']['limite'], array(2,10,20, 30, 40)) )
		{
			$limite				= $this->params->params['named']['limite'];
			$this->Session->write('Preferencias.limite', $limite);
		}

		$condiciones['Producto.activo'] = 1;

		if($categoria == 'neumaticos'){
			$condiciones['Producto.categoria_id'] = 2;
			$condiciones['Producto.ancho'] = trim($categoria_b);
			if(!empty($subcategoria_b)){
				$condiciones['Producto.perfil'] = trim($subcategoria_b);
				if(!empty($subsubcategoria_b)){
					$condiciones['Producto.aro'] = trim($subsubcategoria_b);
				}
			}
		}else if($categoria == 'llantas'){
			$condiciones['Producto.categoria_id'] = 1;
			$condiciones['Producto.aro'] = trim($categoria_b);
			if(!empty($subcategoria_b)){
				$condiciones['OR']['Producto.apernadura1'] = trim($subcategoria_b);
				$condiciones['OR']['Producto.apernadura2'] = trim($subcategoria_b);
			}
		}

		$this->paginate	= array(
				'conditions'	=> $condiciones,
				'limit' 		=> $limite,
				'contain' 		=> array(
					'Marca'
				)
			);
		$productos	= $this->paginate();

		$this->set(compact('productos', 'limite', 'categoria'));
	}

	public function filtros(){
		$limite		= ($this->Session->check('Catalogo.Preferencias.limite') ? $this->Session->read('Catalogo.Preferencias.limite') : 2);

		if ( isset($this->params->params['named']['limite']) && in_array($this->params->params['named']['limite'],array(2,10,20, 30, 40)) )
		{
			$limite				= $this->params->params['named']['limite'];
			$this->Session->write('Preferencias.limite', $limite);
		}

		if($this->request->is('post')){
			if(!empty($this->request->data['Producto']['filtro'])){
				$this->Session->write('Filtro.texto', $this->request->data['Producto']['filtro']);
			}

			if(!empty($this->request->data['Producto']['categoria'])){
				$this->Session->write('Filtro.categoria', $this->request->data['Producto']['categoria']);
			}
		}

		if(!$texto_busqueda = $this->Session->read('Filtro.texto')){
			$this->redirect('/');
		}

		$condiciones['Producto.activo'] = 1;

		if($categoria = $this->Session->read('Filtro.categoria')){
			if($categoria == 'neumaticos'){
				$condiciones['Producto.categoria_id'] = 2; 
			}else if($categoria == 'llantas'){
				$condiciones['Producto.categoria_id'] = 1; 
			}else if($categoria == 'accesorios'){
				$condiciones['Producto.categoria_id <>'] = array(1,2); 
			}
		}

		if(!empty($texto_busqueda)){
			$this->paginate	= array(
				'conditions' => array(
					'OR' => array(
						'Producto.sku LIKE' 		=>  sprintf('%%%s%%', $texto_busqueda),
						'Producto.nombre LIKE' 		=>  sprintf('%%%s%%', $texto_busqueda),
						'Producto.descripcion LIKE' =>  sprintf('%%%s%%', $texto_busqueda),
						'Producto.apernaduras LIKE' =>  sprintf('%%%s%%', $texto_busqueda),
						'Producto.apernadura1 LIKE' =>  sprintf('%%%s%%', $texto_busqueda),
						'Producto.apernadura2 LIKE' =>  sprintf('%%%s%%', $texto_busqueda),
						'Producto.aro LIKE' 		=>  sprintf('%%%s%%', $texto_busqueda),
						'Producto.ancho LIKE' 		=>  sprintf('%%%s%%', $texto_busqueda),
						'Producto.perfil LIKE' 		=>  sprintf('%%%s%%', $texto_busqueda),
					),
					'AND' => $condiciones
				),
				'limit' => $limite,
				'contain' => array(
					'Marca'
				)
			);
			$productos	= $this->paginate();
		}
		$this->set(compact('productos', 'categoria', 'limite'));
	}

	public function view($categoria_slug = null, $marca_slug=null, $producto_slug = null)
    {
    	$usuario = array();
		if ( $this->Auth->user() )
		{ 
			$usuario = $this->Auth->user();
		} 

        $marca_slug  = $this->request->params['marca'];
        
        $producto_slug = $this->request->params['slug'];
        $urlCompartir = $categoria_slug.'/'.$marca_slug.'/ficha/'.$producto_slug;

		$producto = $this->Producto->find(
			'first', array(
			'conditions' => array(
				'Producto.slug' => $producto_slug,
				'Producto.activo' => 1,
			),
			'contain' => array(
				'Marca',
				'Categoria'=>array('Parent')
				)
			)
		);
		
		if(empty($producto)){
			$this->redirect('/'.$categoria_slug.'/');
		}

		$marca_id = $producto['Producto']['marca_id'];
		$marca = $this->Producto->Marca->find('all', array(
			'conditions' => array(
				'Marca.id' => $marca_id
			))
		);

		$tipo =  $producto['Producto']['categoria_id'];
		$categoria = '';
		switch ($tipo) {
			case '1':
				$categoria = 'llantas';
				break;
			case '2':
				$categoria = 'neumaticos';
				break;
			case '3':
				$categoria = 'accesorios';
				break;
			default:
				$categoria = 'home';
				break;
		}

		$this->set('CFG_PageTitle', $producto['Producto']['nombre']. " " .$producto['Marca']['nombre']. " " .$producto['Producto']['descripcion']);

		$this->set('CFG_PageDescription', $producto['Producto']['nombre']. " " .$producto['Marca']['nombre']. " " .$producto['Producto']['descripcion']);

		$this->set('CFG_PageKeywords', $producto['Producto']['nombre']. ", " .$producto['Marca']['nombre']);

		$this->set('title', 'Productos');

		//facebook
		$this->set('CFG_CargarMetaCompartir', true);
		$categoria_slug = $tipo;

		BreadcrumbComponent::add($tipo,'/'.strtolower($tipo));

		if(!empty($producto['Categoria'][0]) && $producto['Categoria'][0]['producto_tipo_id'] == 3){
			BreadcrumbComponent::add($producto['Categoria'][0]['nombre'],'/categoria/'.strtolower($producto['Categoria'][0]['Parent']['slug']).'/'.strtolower($producto['Categoria'][0]['slug']));
		}
		BreadcrumbComponent::add($producto['Producto']['nombre']);

		$this->set(
			compact('producto_tipo_slug',
				'producto',
				'categoria'
			)
		);
	}

	public function ajax_agregar()
	{
		$this->layout	= 'ajax';
		$data			= array('success' => false);

		if ( $this->request->is('post') )
		{
			extract($this->request->data['Producto']);

			
			if ( ! empty($id) && ! empty($cantidad) )
			{
				$producto		= $this->Producto->find('first', array(
					'conditions'			=> array(
						'Producto.id' 		=> $id,
						'Producto.activo'	=> 1
					),
					'callbacks'			=> false
				));

				/**
				 * Checkea el stock del producto
				 */
				if ( $producto )
				{
					$stock = $producto['Producto']['stock'];
					$actual				= $this->Carro->producto($id);
					$cantidad_actual	= 0;
					if ( ! empty($actual['Meta']['Cantidad']) )
					{
						$cantidad_actual	= (int) $actual['Meta']['Cantidad'];
					}
					$cantidad_total		= ($cantidad + $cantidad_actual);

					if ( ! $stock )
					{
						$data			= array(
							'success'		=> false,
							'error'			=> 'SIN_STOCK'
						);
					}
					else
					{
						if ( $stock < $cantidad_total )
						{
							$data			= array(
								'success'		=> false,
								'error'			=> 'SIN_STOCK_SUFICIENTE',
								'stock'			=> $stock,
								'actual'		=> $cantidad_actual
							);
						}
						else
						{
							$catalogo		= '';
							if ( $agregar = $this->Carro->agregar($id, $cantidad, $catalogo, $producto) )
							{
								$data			= array(
									'success'		=> true,
									'info'			=> $agregar,
									'stock'			=> $stock,
									'actual'		=> $cantidad_actual
									/*
									'producto'		=> $agregar,
									'carro'			=> $this->Carro->estado()
									*/
								);
								$this->Session->write('Flujo.Carro.pendiente', true);
							}
						}
					}
				}
			}
		}

		$this->set(compact('data'));
	}

	public function carro()
	{
		/**
		 * Verifica si hay productos en catalogo
		 */
		$productos			= $this->Carro->productos('catalogo');
		if ( ! $productos )
		{
			$this->redirect('/');
		}

		$carro				= $this->Carro->estado();

		/**
		 * Verifica el stock de cada producto
		 */
		foreach ( $productos['catalogo']['Productos'] as $catalogo_id => &$producto )
		{
			$stock = $producto['Data']['Producto']['stock'];
			/**
			 * Si tiene stock, verifica que la cantidad no supere el maximo stock
			 */
			if ($stock)
			{
				if($stock < $producto['Meta']['Cantidad']){
					$this->Carro->actualizar($catalogo_id, $stock, 'catalogo', $producto['Data']);
					$producto['Meta']['Cantidad'] = $stock;
					// $this->Session->setFlash('Uno o más productos se actualizaron en cantidad debido a stock insuficiente.', null, array(), 'info');
				}
			}
			else
			{
				$this->Carro->eliminar($catalogo_id);
				$this->Session->setFlash('Uno o más productos fueron removidos de tu carro de compras debido a falta de stock.', null, array(), 'danger');
			}
		}

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Carro de compras');
		$this->set('title', 'Carro de compras');

		$this->set(compact('productos', 'carro'));
	}

	public function ajax_actualizar()
	{
		$this->layout	= 'ajax';
		$data			= array('success' => false);

		if ( $this->request->is('post') )
		{
			extract($this->request->data['Producto']);
			if ( ! empty($id) && ! empty($cantidad) )
			{
				$producto		= $this->Carro->producto($id);

				/**
				 * Checkea el stock del producto
				 */
				if ( $producto )
				{
					$stock				= $producto['Data']['Producto']['stock'];
					if ( ! $stock )
					{
						$data			= array(
							'success'		=> false,
							'error'			=> 'SIN_STOCK'
						);
					}
					else
					{
						if ( $stock < $cantidad )
						{
							$data			= array(
								'success'		=> false,
								'error'			=> 'SIN_STOCK_SUFICIENTE',
								'stock'			=> $stock
							);
						}
						else
						{
							$catalogo		= '';
							if ( $actualizar = $this->Carro->actualizar($id, $cantidad, $catalogo, $producto) )
							{
								$data			= array(
									'success'		=> true,
									'info'			=> $actualizar
								);
								$this->Session->write('Flujo.Carro.pendiente', true);
							}
						}
					}
				}
			}
		}

		$this->set(compact('data'));
	}

	//FIXME: PASAR ESTO A CONSOLA 
	public function carga_masiva(){
		$this->Result = '';
    	$this->pxp = 300;

    	$this->endpoint = 'http://200.29.13.186:8091/WebService1.asmx?WSDL';

    	$this->auto		= true;
		$this->carga_id	= null;

    	set_time_limit(0);

    	/**
		 * Verifica que no se esté ejecutando una carga masiva anterior
		 */
		$anterior		= $this->Carga->find('first', array(
			'fields'		=> array('Carga.id'),
			'conditions'	=> array('Carga.ejecutando' => true),
			'order'			=> array('Carga.id' => 'DESC')
		));

		if(!empty($anterior)){
			prx('Error: Carga masiva en ejecución.');
		}

		/**
		 * Ingresa los datos de la carga actual
		 */
		$this->Carga->create();
		$this->Carga->save(array(
			'identificador'		=> sprintf('%s-%s', ($this->auto ? 'AUTO' : 'MANUAL'), date('Ymd-His') ),
			'ejecutando'		=> true,
			'manual'			=> !! $this->auto
		));
		$this->carga_id		= $this->Carga->id;

        App::import('Vendor', 'nusoap', array('file' => 'nusoap/nusoap.php'));

        $ws = new nusoap_client($this->endpoint, 'wsdl');
        $ws->setGlobalDebugLevel(0);
        $err = $ws->getError();

        if ($err) {
            $this->out('Error WS');
        }

        $param = array('Registros' => $this->pxp, 'Pagina' => 1, 'TipoResultado' => 1);
		$result = $ws->call('Ws_ListarProductosXpagina', array('parameters' => $param), '', '', false, true);

		if(!$ws->fault && !$ws->getError()){
			if(!empty($result['Ws_ListarProductosXpaginaResult']['diffgram'])){
				$this->Producto->query('TRUNCATE TABLE sitio_productos_cargas');

				for($i=1; $i <= $result['Ws_ListarProductosXpaginaResult']['diffgram']['NewDataSet']['Table1']['TotalPaginas']; $i++){
				// for($i=1; $i <= 10; $i++){
					pr(sprintf('PAGINA WS %d', $i));

					$parametros = array('Registros' => $this->pxp, 'Pagina' => $i, 'TipoResultado' => 0);
					$productos = $ws->call('Ws_ListarProductosXpagina', array('parameters' => $parametros), '', '', false, true);

					if(!$ws->fault && !$ws->getError()){
						if(!empty($productos['Ws_ListarProductosXpaginaResult']['diffgram'])){
							foreach ($productos['Ws_ListarProductosXpaginaResult']['diffgram']['NewDataSet']['Table'] as $producto) {
								$sku			= trim($producto['CODIGO']);
								$nombre		 = trim(ucwords(mb_strtolower(utf8_encode($producto['DESCRIPCION']))));
								$slugdescripcion = str_replace('/', '-', $nombre.' '.$sku);

								$slug = strtolower(Inflector::slug($slugdescripcion, '-'));

								$apernaduras = '';
								$apernaduras1 = '';
								$apernaduras2 = '';
								if($producto['CATEGORIAS'] == 3 && !empty($producto['APERNADURAS'])){
									$apernaduras = $producto['APERNADURAS'];
									$array_apernaduras = explode('/', $producto['APERNADURAS']);
									$apernaduras1 = (!empty($array_apernaduras[0])) ? trim($array_apernaduras[0]) : '';
									$apernaduras = (!empty($array_apernaduras[1])) ? trim($array_apernaduras[1]) : '';
								}

								$this->ProductosCarga->create();
								
								if(!$this->ProductosCarga->save(array(
									'sku' => $sku
									,'nombre' => $nombre
									,'slug' => $slug
									,'descripcion' => (empty($producto['DESCRIP']) || is_array($producto['DESCRIP'])) ? '' : utf8_encode($producto['DESCRIP'])
									,'stock' => trim($producto['STOCK'])
									,'precio_publico' => trim($producto['PRECIO_PUBLICO'])
									,'dcto_publico' => trim($producto['DSCTO_PUBLICO'])
									,'preciofinal_publico' => trim($producto['PRECIOFINAL_PUBLICO'])
									,'precio_mayorista' => trim($producto['PRECIO_MAYORISTA'])
									,'dcto_mayorista' => trim($producto['DSCTO_MAYORISTA'])
									,'preciofinal_mayorista' => trim($producto['PRECIOFINAL_MAYORISTA'])
									,'preciofinal_mayorista' => trim($producto['PRECIOFINAL_MAYORISTA'])
									,'categoria' =>  (empty($producto['CATEGORIA']) || is_array($producto['CATEGORIA'])) ? '' : trim(utf8_encode($producto['CATEGORIA']))
									,'subcategoria' => (empty($producto['SUBCATEGORIA']) || is_array($producto['SUBCATEGORIA'])) ? '' : trim(utf8_encode($producto['SUBCATEGORIA']))
									,'subsubcategoria' => (empty($producto['SUBSUBCATEGORIA']) || is_array($producto['SUBSUBCATEGORIA'])) ? '' : trim(utf8_encode($producto['SUBSUBCATEGORIA']))
									,'marca' => (empty($producto['MARCA']) || is_array($producto['MARCA'])) ? '' : trim(utf8_encode($producto['MARCA']))
									,'activo' => trim($producto['ACTIVO'])
									,'ficha' => (empty($producto['FICHA']) || is_array($producto['FICHA'])) ? '' : trim(utf8_encode($producto['FICHA']))
									// ,'id_erp' => (!empty($producto['ID'])) ? trim($producto['ID']) : NULL
									,'stock_fisico' => trim($producto['STOCK_FI'])
									,'super_familia' => (empty($producto['SUPER_FAM']) || is_array($producto['SUPER_FAM'])) ? '' : trim(utf8_encode($producto['SUPER_FAM']))
									,'familia' => (empty($producto['FAMILIA']) || is_array($producto['FAMILIA'])) ? '' : trim(utf8_encode($producto['FAMILIA']))
									,'categoria_id' => trim($producto['CATEGORIAS'])
									,'stock_seguridad' => trim($producto['STOCK_SEGURIDAD'])
									,'apernaduras' => $apernaduras
									,'apernadura1' => $apernaduras1
									,'apernadura2' => $apernaduras2
									,'aro' => (empty($producto['ARO']) || is_array($producto['ARO'])) ? 0 : trim($producto['ARO'])
									,'ancho' => ($producto['CATEGORIAS'] == 1) ? trim(utf8_encode($producto['ANCHO_LLANTA'])) : ((empty($producto['ANCHO']) || is_array($producto['ANCHO'])) ? '' : trim(utf8_encode($producto['ANCHO'])))
									,'perfil' => (empty($producto['PERFIL']) || is_array($producto['PERFIL'])) ? '' : trim(utf8_encode($producto['PERFIL']))
									,'oferta_mayorista' => trim($producto['OFERTA_MAYORISTA'])
									,'oferta_publico' => trim($producto['OFERTA_PUBLICO'])
									,'fecha_modificacion' => trim($producto['FECHA'])
									,'hora_modificacion' => trim($producto['HORA'])
									,'stock_b015' => trim($producto['STKB015'])
									,'stock_b301' => trim($producto['STKB301'])
									,'stock_b401' => trim($producto['STKB401'])
									,'stock_b701' => trim($producto['STKB701'])
									,'stock_b901' => trim($producto['STKB901'])
									,'stock_bclm' => trim($producto['STKBCLM'])
									,'stock_bvtm' => trim($producto['STKBVTM'])
									,'stock_blco' => trim($producto['STKBLCO'])
								))){
									continue;
								}
							}
						}
						
					}else{
						pr('Error en llamada al WS');
						pr($result);
						prx($ws->getError());
					}
				}

				$this->Producto->query('CALL masivo_productos');
				pr('Productos Cargados en base de datos');
			}
		}else{
			pr('Error en llamada al WS');
			pr($result);
			prx($ws->getError());
		}

        prx($result);

	}

	public function admin_index()
	{
		if ( $this->request->is('post') )
		{
			$busqueda		= array();
			extract($this->request->data['Producto']);
			if (!empty($sku)){
				$busqueda['buscar']	= $sku;
			}
			if(!empty($categoria_id)){
				$busqueda['categoria_id']	= $categoria_id;
			}
			if(!empty($marca)){
				$busqueda['marca']	= $marca;
			}
			$this->redirect(array('filtro' => $busqueda));
		}
 
		$paginacion			= array(
			'contain'		=> array('Marca'),
			'order'				=> array('Producto.created' => 'DESC'),
			'limit'				=> 10
		);
		$filtros			=	$this->params['named'];
		$condicionFiltros	=	$this->Producto->condicionesFiltros($filtros);
		if(!empty($condicionFiltros)){
			$paginacion['conditions'] = $condicionFiltros;
		}
		$this->paginate		= $paginacion;
		$productos			= $this->paginate();

		$marcas = $this->Producto->Marca->find('list');
		$categorias	= $this->Producto->Categoria->find('list', array('conditions' => array('id' => array(1,2,3))));

		$this->set(compact('productos', 'marcas', 'categorias'));
	}

	// HOOKIPA
	public function home_hookipa()
	{
		$this->Banner        		= ClassRegistry::init('Banner');
		$this->Configuracion        = ClassRegistry::init('Configuracion');

		$destacados			= $this->Producto->find('all', array(
			'conditions'		=> array(
				'Producto.destacado'	=> true,
				'Producto.activo'		=> true,
				'Producto.listado'		=> true,
				'Producto.stock >='		=> 1,
				'Producto.articulo !='	=> ''
			),
			'contain'			=> array('Colegio', 'ProductoHijo'),
			'limit'				=> 4,
			'order'				=> 'NEWID()'
		));

		$masvendidos		= $this->Producto->find('all', array(
			'conditions'		=> array(
				'Producto.masvendido'	=> true,
				'Producto.activo'		=> true,
				'Producto.listado'		=> true,
				'Producto.stock >='		=> 1,
				'Producto.articulo !='	=> ''
			),
			'contain'			=> array('Colegio', 'ProductoHijo'),
			'limit'				=> 4,
			'order'				=> 'NEWID()'
		));

		$banners			= $this->Banner->find('all', array(
			'conditions'				=> array(
				'Banner.activo'			=> 1
			),
			'order'			=> array('Banner.orden' => 'ASC')
		));


		$this->Colegio     = ClassRegistry::init('Colegio');
		$colegios		= $this->Colegio->find('all', array(
			'fields'			=> array('Colegio.id', 'Colegio.nombre', 'Colegio.codigo'),
			'conditions'		=> array(
				'Colegio.nivel_count >'	=> 0,
				'Colegio.activo'		=> true
			),
			'contain'			=> array('Nivel'),
			'order'				=> array('Colegio.nombre' => 'ASC')
		));

		if ( ! $colegios )
		{
			$this->redirect('/');
		}

		$this->set(compact('destacados', 'masvendidos', 'banners', 'colegios'));
	}

	public function index_hookipa()
	{
		$tipo_catalogo		= '';

		/**
		 * Categorias pasadas como slugs a traves de la URL.
		 * Si el request llega sin parametros, es porque no está
		 * usando la URL amigable.
		 */
		$pass				= $this->params['pass'];
		if ( ! $pass )
		{
			$this->redirect('/');
		}

		/**
		 * Siempre el primer parametro de los slugs es la lista (catalogo).
		 * Si la lista no corresponde a los 3 tipos de catalogos
		 * es porque no está usando la URL amigable.
		 */
		$mapeo				= array(
			'catalogo'			=> 'Catálogo',
			'deportes'			=> 'Hookipa Sport'
		);
		$lista				= $this->Producto->lista(array_shift($pass));
		$tipo_catalogo		= ($lista['slug']);

		if ( ! in_array($lista['slug'], array_keys($mapeo)) )
		{
			$this->redirect('/');
		}
		$lista['nombre']	= $mapeo[$lista['slug']];

		/**
		 * Verifica que los slugs pasados por la URL sean válidos
		 */
		$verificacion		= $this->Producto->Categoria->verificar($lista['slug'], $pass);
		if ( ! $verificacion['valido'] )
		{
			$this->redirect('/catalogo' . $verificacion['redirect']);
		}

		/**
		 * Lista de categorias
		 */
		$categorias			= $this->Producto->Categoria->arbol($lista['slug'], $verificacion['categorias']);

		/**
		 * Categoria por defecto (nivel 1)
		 */
		if ( $verificacion['nivel'] === 0 && count($categorias) === 1 )
		{
			$this->redirect(array('action' => 'index', 'lista' => 'catalogo', $categorias[0]['Categoria']['slug']));
		}

		/**
		 * Normaliza la vista de pagina
		 */
		$vista				= ($this->Session->check('Catalogo.Preferencias.vista') ? $this->Session->read('Catalogo.Preferencias.vista') : 'grilla');
		if ( isset($this->params->params['named']['vista']) && in_array($this->params->params['named']['vista'], array('lista', 'grilla')) )
		{
			$vista				= $this->params->params['named']['vista'];
			$this->Session->write('Catalogo.Preferencias.vista', $vista);
		}

		/**
		 * Normaliza el limite por pagina
		 */
		$limite				= ($this->Session->check('Catalogo.Preferencias.limite') ? $this->Session->read('Catalogo.Preferencias.limite') : 12);
		if ( isset($this->params->params['named']['limite']) && in_array($this->params->params['named']['limite'], array(12, 36, 48)) )
		{
			$limite				= $this->params->params['named']['limite'];
			$this->Session->write('Catalogo.Preferencias.limite', $limite);
		}

		/**
		 * Lista de productos
		 */
		$conditions			= array(
			'Producto.activo'			=> true,
			'Producto.listado'			=> true,
			'Producto.articulo !='		=> '',
			'Producto.colegio_id !='	=> 109
		);

		if ( $verificacion['idclasif'] )
		{
			$conditions["Producto.IDBTBCLASIF{$verificacion['nivel']}"]		= $verificacion['idclasif'];
		}

		/**
		 * Verifica si se seleccionó un colegio
		 */
		if ( ! empty($this->request->params['named']['colegio']) )
		{
			$conditions['Producto.codigo_colegio']	= (int) $this->request->params['named']['colegio'];
			$limite = 1000;
		}

		$this->paginate		= array(
			'conditions'		=> $conditions,
			'contain'			=> array('ProductoHijo'),
			'limit'				=> $limite,
			'order'				=> array('Producto.articulo' => 'ASC')
		);
		$productos			= $this->paginate();

		/**
		 * Nombre categoria actual
		 */
		$nombre_categoria	= (
			! empty($verificacion['categorias']) ?
			$verificacion['categorias'][(count($verificacion['categorias']) - 1)]['Categoria']['nombre'] :
			$lista['nombre']
		);

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add($lista['nombre'], ($verificacion['categorias'] ? array('action' => 'index', 'lista' => $lista['slug']) : null));
		$this->set('title', $lista['nombre']);
		$x			= 0;
		$slugs		= array();
		foreach ( $verificacion['categorias'] as $categoria )
		{
			array_push($slugs, $categoria['Categoria']['slug']);
			BreadcrumbComponent::add($categoria['Categoria']['nombre'], (++$x == count($verificacion['categorias']) ? null : array('action' => 'index', 'lista' => $lista['slug']) + $slugs));
			$this->set('title', $categoria['Categoria']['nombre']);
		}

		$this->Configuracion        = ClassRegistry::init('Configuracion');

		$this->set(compact(
			'pass',
			'lista',
			'verificacion',
			'categorias',
			'productos',
			'vista',
			'limite',
			'nombre_categoria',
			'tipo_catalogo'
		));
	}

	public function view_hookipa($codigo = null)
	{
		$productoRecomendados	=	array();
		$masvendidos			=	array();

		$producto		= $this->Producto->find('first', array(
			'conditions'		=> array(
				'Producto.codigo'	=> $codigo,
				'Producto.activo'	=> true,
				'Producto.listado'	=> true,
				'AND'				=> array(
					'OR'				=> array(
						'Producto.catalogo'			=> true,
						'Producto.deportes'			=> true,
						'Producto.bits'				=> true
					)
				)
			),
			'contain'			=> array('Colegio','ProductoHijo'),
			'limit'				=> 1,
			'order'				=> 'NEWID()'
		));


		if ( ! $codigo || ! $producto )
		{
			throw new NotFoundException('Producto no encontrado');
		}

		/**
		 * Lista de productos
		 */
		$lista				= $this->Producto->lista($producto);

		/**
		 * Lista de categorias
		 */
		$cats_producto		= $this->Producto->Categoria->categoriasProducto($producto);
		$categorias			= $this->Producto->Categoria->arbol($lista['slug'], $cats_producto);

		/**
		 * Productos Recomendados
		 */
		$productoRecomendados	= $this->Producto->find('all', array(
			'conditions'		=> array(
				'Producto.codigo !='		=> $codigo,
				'Producto.stock >'		=> 0,
				'Producto.listado'		=> 1,
				'Producto.activo'		=> true
			),
			'limit'				=> 3,
			'order'				=> 'NEWID()',
			'callbacks'			=> false
		));

		/**
		 * Valorizacion del producto
		 */
		$valoracion			= $this->Producto->Valoracion->find('first', array(
			'conditions'		=> array('Valoracion.producto_id'	=>	$producto['Producto']['id']),
			'fields'			=> array(
				'COUNT(Valoracion.id) AS cantidad',
				'(SUM(Valoracion.estrellas) / COUNT(Valoracion.id)) AS promedio'
			)
		));
		$valoracion_bloqueada = $this->Session->check(sprintf('Flujo.valorizacion.%d', $producto['Producto']['id']));

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add($lista['nombre'], ($cats_producto ? array('action' => 'index', 'lista' => $lista['slug']) : null));
		$x			= 0;
		$slugs		= array();
		foreach ( $cats_producto as $categoria )
		{
			array_push($slugs, $categoria['Categoria']['slug']);
			BreadcrumbComponent::add($categoria['Categoria']['nombre'], array('action' => 'index', 'lista' => $lista['slug']) + $slugs);
		}
		BreadcrumbComponent::add($producto['Producto']['articulo']);
		$this->set('title', $producto['Producto']['articulo']);

		$this->set(compact(
			'categorias',
			'lista',
			'cats_producto',
			'producto',
			'valoracion',
			'valoracion_bloqueada',
			'productoRecomendados',
			'tipo_catalogo'
		));
	}

	public function buscar()
	{
		if ( $this->request->is('post') )
		{
			if ( ! empty($this->request->data['Producto']['criterio']) )
			{
				$this->Session->write('Flujo.CriterioBusqueda', $this->request->data['Producto']['criterio']);
			}
		}

		if ( ! $criterio = $this->Session->read('Flujo.CriterioBusqueda') )
		{
			$this->redirect('/');
		}

		/**
		 * Lista de uniformes
		 */
		$lista				= $this->Producto->lista();

		/**
		 * Verifica que los slugs pasados por la URL sean válidos
		 */
		$verificacion		= $this->Producto->Categoria->verificar($lista['slug'], array());
		if ( ! $verificacion['valido'] )
		{
			$this->redirect('/catalogo' . $verificacion['redirect']);
		}

		/**
		 * Lista de categorias
		 */
		$categorias			= $this->Producto->Categoria->arbol($lista['slug'], $verificacion['categorias']);

		/**
		 * Normaliza la vista de pagina
		 */
		$vista				= ($this->Session->check('Catalogo.Preferencias.vista') ? $this->Session->read('Catalogo.Preferencias.vista') : 'grilla');
		if ( isset($this->params->params['named']['vista']) && in_array($this->params->params['named']['vista'], array('lista', 'grilla')) )
		{
			$vista				= $this->params->params['named']['vista'];
			$this->Session->write('Catalogo.Preferencias.vista', $vista);
		}

		/**
		 * Normaliza el limite por pagina
		 */
		$limite				= ($this->Session->check('Catalogo.Preferencias.limite') ? $this->Session->read('Catalogo.Preferencias.limite') : 12);
		if ( isset($this->params->params['named']['limite']) && in_array($this->params->params['named']['limite'], array(12, 36, 48)) )
		{
			$limite				= $this->params->params['named']['limite'];
			$this->Session->write('Catalogo.Preferencias.limite', $limite);
		}

		/**
		 * Busqueda de productos paginados
		 */

		// Obtenemos los IDs de la categorias, si la busqueda corresponde a algun nombre
		$dataCategoria		=	$this->Producto->Categoria->find('list', array(
			'conditions'		=> array(
				'Categoria.nombre LIKE'		=> sprintf('%%%s%%', $criterio)
			),
			'fields'			=> array('Categoria.idclasif')
		));

		$this->paginate		= array(
			'conditions'		=> array(
				(  empty ($dataCategoria) ? array(
						'OR'	=> array(
							'Producto.isbn LIKE'		=> sprintf('%%%s%%', $criterio),
							'Producto.nombre LIKE'		=> sprintf('%%%s%%', $criterio),
							'Producto.precio LIKE'		=> sprintf('%%%s%%', $criterio),
							'Producto.descripcion LIKE'	=> sprintf('%%%s%%', $criterio)
						)
					) : array(
						'OR'	=> array(
							'Producto.IDBTBCLASIF1'		=> $dataCategoria,
							'Producto.IDBTBCLASIF2'		=> $dataCategoria,
							'Producto.IDBTBCLASIF3'		=> $dataCategoria,
							'Producto.IDBTBCLASIF4'		=> $dataCategoria
						)
					)
				),
				'AND'	=> array(
					'OR'	=> array(
						'Producto.catalogo'			=> true,
						'Producto.deportes'			=> true,
						'Producto.bits'				=> true
					)
				)
			),
			'contain'			=> array('Categoria','ProductoHijo'),
			'limit'				=> $limite,
			'order'				=> array('Producto.NOKOPR' => 'ASC')
		);
		//prx($this->paginate);
		$productos			= $this->paginate();

		$this->Configuracion        = ClassRegistry::init('Configuracion');

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Búsqueda de productos');
		$this->set('title', sprintf('Búsqueda de productos: %s', $criterio));

		$this->set(compact('lista', 'verificacion', 'categorias', 'productos', 'vista', 'limite'));
	}

	public function ajax_agregar_hookipa()
	{
		$this->layout	= 'ajax';
		$data			= array('success' => false);

		if ( $this->request->is('post') )
		{
			extract($this->request->data['Producto']);


			if ( ! empty($id) && ! empty($cantidad) )
			{
				/**
				 * Elimina los catalogos si es necesario
				 */
				if ( $wipe == 1 )
				{
					$this->Carro->eliminarCatalogo('reserva');
					$this->Carro->eliminarCatalogo('lista');
				}

				/**
				 * Verifica si existen catalogos pendientes
				 */
				$catalogos		= $this->Carro->catalogos();
				if ( in_array('reserva', $catalogos) )
				{
					$data			= array(
						'success'		=> false,
						'error'			=> 'RESERVA_PENDIENTE'
					);
				}
				elseif ( in_array('lista', $catalogos) )
				{
					$data			= array(
						'success'		=> false,
						'error'			=> 'LISTA_PENDIENTE'
					);
				}
				/**
				 * Sigue con el proceso de agregar producto
				 */
				else
				{
					$producto		= $this->Producto->find('first', array(
						'conditions'		=> array('Producto.id' => $id),
						'callbacks'			=> false
					));

					/**
					 * Checkea el stock del producto
					 */
					if ( $producto )
					{
						$stock				= $this->Producto->verificarStock($producto['Producto']['isbn']);
						$actual				= $this->Carro->producto($id);
						$cantidad_actual	= 0;
						if ( ! empty($actual['Meta']['Cantidad']) )
						{
							$cantidad_actual	= (int) $actual['Meta']['Cantidad'];
						}
						$cantidad_total		= ($cantidad + $cantidad_actual);

						if ( ! $stock )
						{
							$data			= array(
								'success'		=> false,
								'error'			=> 'SIN_STOCK'
							);
						}
						else
						{
							if ( $this->Producto->stock < $cantidad_total )
							{
								$data			= array(
									'success'		=> false,
									'error'			=> 'SIN_STOCK_SUFICIENTE',
									'stock'			=> $this->Producto->stock,
									'actual'		=> $cantidad_actual
								);
							}
							else
							{
								$catalogo		= $this->Producto->lista($producto)['slug'];
								if ( $agregar = $this->Carro->agregar($id, $cantidad, $catalogo, $producto) )
								{
									$data			= array(
										'success'		=> true,
										'info'			=> $agregar,
										'stock'			=> $this->Producto->stock,
										'actual'		=> $cantidad_actual
										/*
										'producto'		=> $agregar,
										'carro'			=> $this->Carro->estado()
										*/
									);
									$this->Session->write('Flujo.Carro.pendiente', true);
								}
							}
						}
					}
				}
			}
		}

		$this->set(compact('data'));
	}

	public function ajax_actualizar_hookipa()
	{
		$this->layout	= 'ajax';
		$data			= array('success' => false);

		if ( $this->request->is('post') )
		{
			extract($this->request->data['Producto']);
			if ( ! empty($id) && ! empty($cantidad) )
			{
				$producto		= $this->Carro->producto($id);

				/**
				 * Checkea el stock del producto
				 */
				if ( $producto )
				{
					$stock				= $this->Producto->verificarStock($producto['Data']['Producto']['isbn'],$producto['Meta']['Catalogo']);
					if ( ! $stock )
					{
						$data			= array(
							'success'		=> false,
							'error'			=> 'SIN_STOCK'
						);
					}
					else
					{
						if ( $this->Producto->stock < $cantidad )
						{
							$data			= array(
								'success'		=> false,
								'error'			=> 'SIN_STOCK_SUFICIENTE',
								'stock'			=> $this->Producto->stock
							);
						}
						else
						{
							$catalogo		= $this->Producto->lista($producto['Data'])['slug'];
							if ( $actualizar = $this->Carro->actualizar($id, $cantidad, $catalogo, $producto) )
							{
								$data			= array(
									'success'		=> true,
									'info'			=> $actualizar
								);
								$this->Session->write('Flujo.Carro.pendiente', true);
							}
						}
					}
				}
			}
		}

		$this->set(compact('data'));
	}

	public function ajax_eliminar()
	{
		$this->layout	= 'ajax';
		$data			= array('success' => false);

		if ( $this->request->is('post') )
		{
			extract($this->request->data['Producto']);
			if ( ! empty($id) )
			{
				$producto		= $this->Carro->producto($id);
				if ( $producto && ($eliminar = $this->Carro->eliminar($id)) )
				{
					$data			= array(
						'success'		=> true,
						'info'			=> $eliminar
					);
					$this->Session->write('Flujo.Carro.pendiente', true);
				}
			}
		}

		$this->set(compact('data'));
	}

	public function vaciar()
	{
		$this->Carro->vaciar();
		$this->redirect('/');
	}

	public function carro_hookipa()
	{
		/**
		 * Verifica si hay productos en reserva
		 */
		$reserva			= $this->Carro->productos('reserva');
		if ( $reserva )
		{
			$this->redirect(array('controller' => 'reservas', 'action' => 'add'));
		}

		/**
		 * Verifica si hay productos en uniformes por colegio
		 */
		$lista				= $this->Carro->productos('lista');
		if ( $lista )
		{
			$this->redirect(array('controller' => 'listas', 'action' => 'add'));
		}

		/**
		 * Verifica si hay productos en catalogo
		 */
		$productos			= $this->Carro->productos('catalogo');
		if ( ! $productos )
		{
			$this->redirect('/');
		}

		$carro				= $this->Carro->estado();

		/**
		 * Verifica el stock de cada producto
		 */
		foreach ( $productos['catalogo']['Productos'] as $catalogo_id => &$producto )
		{
			$stock		= $this->Producto->verificarStock($producto['Data']['Producto']['isbn']);

			/**
			 * Si tiene stock, verifica que la cantidad no supere el maximo stock
			 */
			if ( $stock )
			{
				if ( $this->Producto->stock < $producto['Meta']['Cantidad'] )
				{
					$this->Carro->actualizar($catalogo_id, $this->Producto->stock, 'catalogo', $producto['Data']);
					$producto['Meta']['Cantidad'] = $this->Producto->stock;
					$this->Session->setFlash('Uno o más productos se actualizaron en cantidad debido a stock insuficiente.', null, array(), 'info');
				}
			}

			/**
			 * Si no tiene stock, lo elimina del carro
			 */
			else
			{
				$this->Carro->eliminar($catalogo_id);
				$this->Session->setFlash('Uno o más productos fueron removidos de tu carro de compras debido a falta de stock.', null, array(), 'danger');
			}
		}

		/**
		 * Camino de migas
		 */
		BreadcrumbComponent::add('Carro de compras');
		$this->set('title', 'Carro de compras');

		$this->set(compact('productos', 'carro'));
	}

	

	public function admin_excel()
	{
		set_time_limit(0);
		$productos			= $this->Producto->find('all', array(
			'fields'	=> array(
				'Producto.id', 'Producto.codigo', 'Producto.isbn',
				'Producto.precio', 'Producto.nombre', 'Producto.talla',
				'Producto.codigo_articulo', 'Producto.codigo_talla',
				'Producto.codigo_colegio', 'Producto.stock', 'Producto.activo'
			),
			'limit' => 3000,
			'offset' => 15000
		));
		$this->set(compact('productos'));
	}

	public function admin_add()
	{
		if ( $this->request->is('post') )
		{
			$this->Producto->create();
			if ( $this->Producto->save($this->request->data) )
			{
				$this->Session->setFlash("Registro agregado correctamente (ID {$this->Producto->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
	}

	public function admin_edit($id = null)
	{
		if ( ! $this->Producto->exists($id) )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		if ( $this->request->is('post') || $this->request->is('put') )
		{
			if ( $this->Producto->save($this->request->data) )
			{
				$this->Session->setFlash("Registro editado correctamente (ID {$this->Producto->id})", null, array(), 'success');
				$this->redirect(array('action' => 'index'));
			}
			else
				$this->Session->setFlash('Error al guardar el registro. Por favor revisa los mensajes de validación.', null, array(), 'danger');
		}
		else
		{
			$this->request->data	= $this->Producto->find('first', array(
				'conditions'	=> array('Producto.id' => $id)
			));
		}
	}

	public function admin_delete($id = null)
	{
		$this->Producto->id = $id;
		if ( ! $this->Producto->exists() )
		{
			$this->Session->setFlash('Registro inválido.', null, array(), 'danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->request->onlyAllow('post', 'delete');
		if ( $this->Producto->delete() )
		{
			$this->Session->setFlash('Registro eliminado correctamente.', null, array(), 'success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Error al eliminar el registro. Por favor intentalo nuevamente.', null, array(), 'danger');
		$this->redirect(array('action' => 'index'));
	}

	/**
	 *	Funcion que permite obtener las cantidad de registros de productos segun su tipo
	 */
	public function admin_masivo($carga = null, $tipo = null)
	{
		// Instancia con el modelo de configuraciones
		$this->Configuracion        = ClassRegistry::init('Configuracion');

		if ( ! empty($carga) && $carga == 'cargar' )
		{
			if ( $tipo == 'productos')
			{
				// Carga masiva de los productos.
				$cargaProducto	=	$this->Producto->ejecutarCargaMasiva('MASIVO_PRODUCTOS');
				// Carga masiva de categoria.
				$cargaCategoria	=	$this->Producto->ejecutarCargaMasiva('MASIVO_CATEGORIAS');

				$this->Session->setFlash(sprintf('El tiempo de carga del registro de los productos fue de %s ', $cargaProducto), null, array(), 'success');
			}
		}

		// Cantidad de productos en catalogo
		$catalogo	= $this->Producto->obtenerCantidadProductoTipo('catalogo', true);
		// Cantidad de productos en hookipa sport
		$hookipa	= $this->Producto->obtenerCantidadProductoTipo('deportes', true);
		// Cantidad de productos en bits & gits
		$bits		= $this->Producto->obtenerCantidadProductoTipo('bits', true);
		// Cantidad de productos en reserva
		$reserva	= $this->Producto->obtenerCantidadProductoTipo('reserva');
		// Cantidad de prodcutos en lista
		$lista		= $this->Producto->obtenerCantidadProductoTipo('lista');
		// Cantidad total de productos
		$total		= $this->Producto->obtenerCantidadProductoTipo();

		$this->set(compact(
            'catalogo',
            'hookipa',
            'bits',
            'reserva',
            'lista',
            'total'
		));
	}
}
