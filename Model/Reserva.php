<?php
App::uses('AppModel', 'Model');
App::uses('String', 'Utility');
class Reserva extends AppModel
{
	/**
	 * CONFIGURACION DB
	 */

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
		'usuario_id' => array(
			'validateForeignKey' => array(
				'rule'			=> array('validateForeignKey'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
		'LVEN' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
		'nivel' => array(
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
	public $belongsTo = array(
		'Usuario' => array(
			'className'				=> 'Usuario',
			'foreignKey'			=> 'usuario_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'counterCache'			=> false,
			'counterScope'			=> array('Asociado.modelo' => 'Usuario')
		)
	);
	public $hasMany = array(
		'DetalleCompra' => array(
			'className'				=> 'DetalleCompra',
			'foreignKey'			=> 'reserva_id',
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


	/**
	 * CALLBACKS
	 */
	public function beforeSave($options = array())
	{
		parent::beforeSave($options);
		/**
		 * Actualiza el usuario que modifica la query
		 */
		if ( ! isset($this->data[$this->name]['usuario_id']) )
		{
			$this->data[$this->name]['usuario_id']		= AuthComponent::user('id');
		}
	}


	/**
	 * Devuelve la lista de instituciones a traves de una busqueda por nombre
	 *
	 * @param			string			$colegio			Nombre o parte del nombre de la institucion a buscar
	 * @return			array								Resultados de la query formateados
	 */
	public function getColegiosReserva($colegio = null)
	{
		/**
		 * Obtiene la query
		 */
		$this->Query		= ClassRegistry::init('Query');
		$query				= $this->Query->getProductiva('RESERVAS_LISTA_INSTITUCIONES');
		if ( ! $query )
		{
			return false;
		}

		/**
		 * Reemplaza el identificador
		 */
		$sql				= String::insert($query['Query']['query'], array(
			'QUERY_NOMBRE_COLEGIO'		=> mb_strtoupper($colegio)
		));
		$resultados			= null;

		/**
		 * Ejecuta las querys
		 */
		try
		{
			$this->usarDsBooks();
			$resultados = $this->query($sql);
			$this->usarDsLocal();
		}
		catch ( PDOException $error )
		{
			// TODO: Informar error de query
		}
		if ( ! $resultados )
		{
			return false;
		}

		/**
		 * Formatea los resultados para ajustarse al autocomplete
		 */
		$colegios		= array();
		foreach ( $resultados as $resultado )
		{
			array_push($colegios, $resultado[0]);
		}

		return $colegios;
	}


	/**
	 * Devuelve la lista de niveles de una institucion dada
	 *
	 * @param			string			$colegio			Codigo del colegio
	 * @return			array								Resultados de la query formateados
	 */
	public function getNiveles($colegio = null)
	{
		if ( ! $colegio )
		{
			return false;
		}

		/**
		 * Obtiene la query
		 */
		$this->Query		= ClassRegistry::init('Query');
		$query				= $this->Query->getProductiva('RESERVAS_LISTA_NIVELES');
		if ( ! $query )
		{
			return false;
		}

		/**
		 * Reemplaza el identificador
		 */
		$sql				= String::insert($query['Query']['query'], array(
			'CODIGO_COLEGIO'		=> $colegio
		));
		$resultados			= null;

		/**
		 * Ejecuta las querys
		 */
		try
		{
			$this->usarDsBooks();
			$resultados = $this->query($sql);
			$this->usarDsLocal();
		}
		catch ( PDOException $error )
		{
			// TODO: Informar error de query
		}
		if ( ! $resultados )
		{
			return false;
		}

		/**
		 * Formatea los resultados para ajustarse al autocomplete
		 */
		$niveles		= array();
		foreach ( $resultados as $resultado )
		{
			array_push($niveles, array(
				//'id'		=> $resultado[0]['codigo'],
				'name'		=> $resultado[0]['nombre']
			));
		}

		return $niveles;
	}


	/**
	 * Devuelve la lista de textos pertenecientes a un colegio y nivel dados
	 *
	 * @param			string			$colegio			Codigo del colegio
	 * @param			string			$nivel				Nombre del nivel
	 * @return			array								Resultados de la query formateados
	 */
	public function getTextos($colegio = null, $nivel = null)
	{
		if ( ! $colegio || ! $nivel )
		{
			return false;
		}

		/**
		 * Obtiene la query
		 */
		$this->Query			= ClassRegistry::init('Query');
		$identidicadorQuery		= 'RESERVAS_LISTA_TEXTOS';

		/**
		 * Cosultamos si el usuario pertenece a algun grupo tarifario,
		 * si endo asi, obtenemos el identificador de la Query relacionado
		 * con el grupo tarificario que pertenece
		*/
		$grupoTarifarioQuery 	= $this->Usuario->getUsuarioGrupoTarifario();
		if ( ! empty($grupoTarifarioQuery) )
		{
			$identidicadorQuery		= $grupoTarifarioQuery;
		}
		$query					= $this->Query->getProductiva($identidicadorQuery);

		if ( ! $query )
		{
			return false;
		}

		/**
		 * Reemplaza el identificador
		 */
		$sql				= String::insert($query['Query']['query'], array(
			'CODIGO_COLEGIO'		=> $colegio,
			'NIVEL'					=> $nivel
		));
		$resultados			= null;

		/**
		 * Ejecuta las querys
		 */
		try
		{
			$this->usarDsBooks();
			$resultados = $this->query($sql);
			$this->usarDsLocal();
		}
		catch ( PDOException $error )
		{
			// TODO: Informar error de query
		}
		if ( ! $resultados )
		{
			return false;
		}

		/**
		 * Formatea el resultado al formato carro
		 */
		$textos			= array();
		foreach ( $resultados as $resultado )
		{
			array_push($textos, array(
				'Producto' => $resultado[0]
			));
		}

		return $textos;
	}
}
