<?php
App::uses('AppModel', 'Model');
App::uses('String', 'Utility');
class Categoria extends AppModel
{
	/**
	 * CONFIGURACION DB
	 */
	public $displayField	= 'nombre';

	/**
	 * BEHAVIORS
	 */
	var $actsAs			= array(
		/**
		 * IMAGE UPLOAD
		 */
		/*
		'Image'		=> array(
			'fields'	=> array(
				'imagen'	=> array(
					'versions'	=> array(
						array(
							'prefix'	=> 'mini',
							'width'		=> 100,
							'height'	=> 100,
							'crop'		=> true
						)
					)
				)
			)
		)
		*/
	);

	/**
	 * VALIDACIONES
	 */
	public $validate = array(
		'nombre' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
		'lista_precio' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
	);

	/**
	 * ASOCIACIONES
	 */
	public $hasMany = array(
		'Producto' => array(
			'className'				=> 'Producto',
			'foreignKey'			=> 'categoria_id',
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
	public $belongsTo = array(
		'Parent' => array(
			'className'				=> 'Categoria',
			'foreignKey'			=> 'parent_id'
		)
	);


	/**
	 * Verifica que los slugs pasados via URL sean correctos
	 *
	 * @param			string			$lista				Tipo de catalogo ($this->params['pass'][0])
	 * @param			array			$pass				Slugs pasados al controlador ($this->params['pass'])
	 * @return			array								Datos de la validacion
	 */
	public function verificar($lista = 'catalogo', $pass = array())
	{
		/**
		 * Limpia la lista
		 * @var string
		 */

		if ( ! in_array($lista, array('catalogo', 'deportes', 'bits')) )
		{
			$lista		= 'catalogo';
		}

		/**
		 * Datos a devolver
		 * @var array
		 */
		$data		= array(
			'valido'		=> true,
			'redirect'		=> '',
			'nivel'			=> count($pass),
			'parent_id'		=> null,
			'idclasif'		=> null,
			'categorias'	=> array()
		);

		/**
		 * Si se pasan slugs, se deben validar que existan y que esten
		 * jerarquicamente bien estructuradas
		 */
		if ( count($pass) )
		{
			foreach ( $pass as $nivel => &$slug )
			{
				$query			= array(
					'conditions'		=> array(
						'Categoria.slug'		=> $slug,
						'Categoria.nivel'		=> $nivel,
						"Categoria.{$lista}"	=> true
					),
					'callbacks'			=> false
				);
				if ( isset($pass[($nivel - 1)]) )
				{
					$query['conditions']['Categoria.parent_id']		= $pass[($nivel - 1)]['Categoria']['id'];
				}
				$categoria		= $this->find('first', $query);
				if ( ! $categoria )
				{
					$data['valido']		= false;
					return $data;
				}
				$data['redirect']		= "{$data['redirect']}/{$categoria['Categoria']['slug']}";
				$data['parent_id']		= $categoria['Categoria']['id'];
				$data['idclasif']		= $categoria['Categoria']['idclasif'];
				$slug					= $categoria;
			}
			$data['categorias']		= $pass;
		}
		return $data;
	}


	/**
	 * Trae el arbol completo de categorias, hasta la categorias consultada via URL
	 *
	 * @param			string			$lista				Tipo de catalogo ($this->params['pass'][0])
	 * @param			array			$current			Categorias consultadas via URL (slugs)
	 * @return			array								Arbol completo de categorias, con todos sus hijos hasta el nivel abierto via URL
	 */
	public function arbol($lista = 'catalogo', $current = array())
	{
		$tops			= $this->find('all', array(
			'conditions'		=> array(
				'Categoria.nivel'			=> 0,
				"Categoria.{$lista}"		=> true
			),
			'order'				=> array(
				'Categoria.nombre'			=> 'ASC'
			),
			'callbacks'			=> false
		));
		$ids			= Hash::extract($current, '{n}.Categoria.id');
		$hijos			= array();
		if ( ! empty($ids) )
		{
			$hijos			= $this->find('all', array(
				'conditions'		=> array(
					'Categoria.parent_id'		=> Hash::extract($current, '{n}.Categoria.id'),
					"Categoria.{$lista}"		=> true
				),
				'order'				=> array(
					'Categoria.nombre'			=> 'ASC'
				),
				'callbacks'			=> false
			));
		}

		foreach ( $tops as &$top )
		{
			$top['Categoria']['current']	= (isset($ids[$top['Categoria']['nivel']]) && $ids[$top['Categoria']['nivel']] == $top['Categoria']['id']);
		}
		foreach ( $hijos as &$hijo )
		{
			$hijo['Categoria']['current']	= (isset($ids[$hijo['Categoria']['nivel']]) && $ids[$hijo['Categoria']['nivel']] == $hijo['Categoria']['id']);
		}

		return Hash::nest(array_merge($tops, $hijos), array(
			'idPath'		=> '{n}.Categoria.id',
			'parentPath'	=> '{n}.Categoria.parent_id'
		));
	}


	/**
	 * Devuelve un arreglo plano con todas las categorias del producto, en orden de nivel
	 *
	 * @param			array			$producto			Array con la info del producto (find first)
	 * @return			mixed								Arreglo plano con las categorias del producto
	 */
	public function categoriasProducto($producto = array())
	{
		if ( ! $producto )
		{
			return false;
		}

		$categorias			= array();
		$campos				= array_map(function($val) { return sprintf('IDBTBCLASIF%s', $val); }, range(1, 4));

		foreach ( $campos as $nivel => $campo )
		{
			$categoria		= $this->find('first', array(
				'conditions'		=> array(
					'Categoria.nivel'			=> $nivel,
					'Categoria.idclasif'		=> $producto['Producto'][$campo]
				),
				'callbacks'			=> false
			));
			if ( $categoria )
			{
				$categorias[]		= $categoria;
			}
		}

		return $categorias;
	}


	/**
	 * Devuelve las categorias del menu principal segun la lista
	 *
	 * @param			string			$lista				Lista de uniformes
	 * @return			array								Lista de categorias
	 */
	public function menu($parent_id = 3)
	{
		if ( ! in_array($parent_id, array(1,2,3)) )
		{
			return false;
		}

		return  $this->find('threaded', array(
			'cache'			=> 'menu_categorias',
			'conditions'		=> array(
				"Categoria.parent_id"	=> $parent_id,
				'Categoria.activo'		=> 1,
				'Categoria.menu'		=> 1,
			),
			'fields'			=> array(
				'Categoria.id',
				'Categoria.nombre',
				'Categoria.slug',
				'Categoria.parent_id'
			),
			'order'				=> array(
				'Categoria.nombre'			=> 'ASC'
			),
			'callbacks' 		=> false
		));
	}

	public function beforeSave($options = array())
	{
		parent::beforeSave($options);

		$this->data[$this->alias]['created']	=  date('Y-m-d H:i:s');
		$this->data[$this->alias]['modified']	=  date('Y-m-d H:i:s');
		
		return true;
	}
}
