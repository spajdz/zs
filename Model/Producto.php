<?php
App::uses('AppModel', 'Model');
class Producto extends AppModel
{
	/**
	 * CONFIGURACION DB
	 */
	public $displayField	= 'nombre';

	/**
	 * BEHAVIORS
	 */
	var $actsAs			= array(
		'Image'     => array(
            'fields'    => array(
                'foto'  => array(
                    'versions'  => array(
                        array(
                            'prefix'    => 'mini',
                            'width'     => 100,
                            'height'    => 100,
                            'crop'      => true
                        ),
                        array(
                            'prefix'    => 'interna',
                            'width'     => 248,
                            'height'    => 248,
                            'crop'      => true
                        )
                    ) 
                )
            )
        )
	);

	/**
	 * VALIDACIONES
	 */
	public $validate = array(
		'sku' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
			),
		),
		'nombre' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
			),
		),
		'slug' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
			),
		),
		'stock' => array(
			'numeric' => array(
				'rule'			=> array('numeric'),
				'last'			=> true,
			),
		),
		'fecha_modificacion' => array(
			'date' => array(
				'rule'			=> array('date'),
				'last'			=> true,
			),
		),
		'hora_modificacion' => array(
			'time' => array(
				'rule'			=> array('time'),
				'last'			=> true,
			),
		),
	);

	/**
	 * ASOCIACIONES
	 */
	public $belongsTo = array(
		'Categoria' => array(
			'className'				=> 'Categoria',
			'foreignKey'			=> 'categoria_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
		),
		'Marca' => array(
			'className'				=> 'Marca',
			'foreignKey'			=> 'marca_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
		)
	);
	public $hasMany = array(
		'DetalleCompra' => array(
			'className'				=> 'DetalleCompra',
			'foreignKey'			=> 'producto_id',
			'dependent'				=> false,
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'limit'					=> '',
			'offset'				=> '',
			'exclusive'				=> '',
			'finderQuery'			=> '',
			'counterQuery'			=> ''
		)
	);

	public function condicionesFiltros($filtros = null)
	{
		$condiciones		= array();

		$condiciones['Producto.precio_publico >'] = 10;
		
		if (!SessionComponent::check('Auth.Administrador'))
		{
			$condiciones['Producto.activo'] = '1';
		}

		if (!empty($filtros)){ 
			if((Router::getParam('prefix', true))=='admin'){
				if(!empty( $filtros['filtro']['buscar'])){
					$condiciones['Producto.sku like'] = '%'.$filtros['filtro']['buscar'].'%';
				}
				if(!empty( $filtros['filtro']['categoria_id'])){
					if( in_array(3, $filtros['filtro']['categoria_id'])){
						$condiciones['NOT']['Producto.categoria_id'] =array(1,2) ;
					}else{
						$condiciones['Producto.categoria_id '] =$filtros['filtro']['categoria_id'] ;
					}
				} 

				if(!empty( $filtros['filtro']['marca'])){
					$condiciones['Producto.marca_id'] = $filtros['filtro']['marca'];
				}
					
				if(! empty($filtros['sort'])){
					if($filtros['sort']=='activo'){
						if($filtros['direction']=='desc'){
							$condiciones['Producto.activo'] = '1';
						}else{
							$condiciones['Producto.activo'] = '0';
						}
					}
				}
			}else{
				$condiciones['Marca.activo'] = 1; 
				if(!empty($filtros['tipo'])){
					$condiciones['Producto.categoria_id !='] = array(1,2);
				}
				if(!empty( $filtros['ProductoMarcaId'])){
					$condiciones['Producto.marca_id'] = $filtros['ProductoMarcaId'];
				}
				if(!empty( $filtros['ProductoId'])){
					$condiciones['Producto.id'] = $filtros['ProductoId'];
				}
				if(!empty( $filtros['MarcaId'])){
					$condiciones['Producto.marca_id'] = $filtros['MarcaId'];
					unset($condiciones['Producto.categoria_id']);
				}
				if(!empty( $filtros['texto'])){
					$filtros['texto'] = trim($filtros['texto']);	
					$condiciones['OR']['Producto.nombre like'] = '%'.str_replace(' ', '%', $filtros['texto']) .'%';
					$condiciones['OR']['Producto.descripcion like'] = '%'.str_replace(' ', '%', $filtros['texto']) .'%';
					$condiciones['OR']['Producto.sku like'] = '%'.str_replace(' ', '%', $filtros['texto']) .'%';  
				}
				if(!empty( $filtros['filtro'])){
					$condiciones['OR']['Producto.nombre like'] = '%'.$filtros['filtro'].'%';
					$condiciones['OR']['Producto.descripcion like'] = '%'.$filtros['filtro'].'%';
				}
			}
		}
 
		if ( ! empty($condiciones) )
		{
			return $condiciones;
		} 
		return false;
	}

	public function anchos($tipo)
	{
		return $this->find('list', array(
			'cache'			=> 'anchos_productos',
			'fields'			=> array(
				'Producto.ancho',
				'Producto.ancho'
			),
			'conditions' => array(
				'Producto.categoria_id' => $tipo,
				'Producto.ancho !=' => ''
			),
			'group' => array('Producto.ancho'),
			'callbacks' 		=> false
		));
	}
}
