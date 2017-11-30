<?php
App::uses('AppModel', 'Model');
class Comuna extends AppModel
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
		'region_id' => array(
			'validateForeignKey' => array(
				'rule'			=> array('validateForeignKey'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
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
		'KOCM' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
		'KOCI' => array(
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
		'Region' => array(
			'className'				=> 'Region',
			'foreignKey'			=> 'region_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'counterCache'			=> false,
			'counterScope'			=> array('Asociado.modelo' => 'Region')
		)
	);
	public $hasMany = array(
		'Direccion' => array(
			'className'				=> 'Direccion',
			'foreignKey'			=> 'comuna_id',
			'dependent'				=> false,
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'limit'					=> '',
			'offset'				=> '',
			'exclusive'				=> '',
			'finderQuery'			=> '',
			'counterQuery'			=> ''
		),
		'Postal' => array(
			'className'				=> 'Postal',
			'foreignKey'			=> 'comuna_id',
			'dependent'				=> false,
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'limit'					=> '',
			'offset'				=> '',
			'exclusive'				=> '',
			'finderQuery'			=> '',
			'counterQuery'			=> ''
		),
		'Contacto' => array(
			'className'				=> 'Contacto',
			'foreignKey'			=> 'comuna_id',
			'dependent'				=> false,
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'limit'					=> '',
			'offset'				=> '',
			'exclusive'				=> '',
			'finderQuery'			=> '',
			'counterQuery'			=> ''
		),
		'TarifaDespacho' => array(
			'className'				=> 'TarifaDespacho',
			'foreignKey'			=> 'comuna_id',
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
	 * Funcion que permite obtener datos de la comuna dependiendo el KOCM y KOCI
	 * respectivamente
	 * @param			object			$KOCM			Atributo relacionado a la comuna
	 * @param			object			$KOCI			Atributo relacionado a la region
	 * @return			object							Datos de la comuna
	 */
	public function obtenerComuna($KOCI = null, $KOCM = null)
	{
		if ( ! $KOCI || ! $KOCM )
		{
			return false;
		}

		$comuna		= $this->find('first', array(
			'conditions'		=> array(
				'Comuna.KOCI'		=> $KOCI,
				'Comuna.KOCM'		=> $KOCM
			)
		));

		if ( $comuna )
		{
			return $comuna;
		}
		else
		{
			return $this->registrarComuna($KOCM, $KOCI);
		}
	}

	/**
	 * Funcion que permite registrar una comuna, cuando esta no exita al
	 * momento de realizar la carga masiva de tarifas.
	 * Este registro es obtenido al consultar la informacion de la comuna
	 * del DSBOOKS
	 * @param			object			$KOCM			Atributo relacionado con la Comuna
	 * @param			object			$KOCI			Atributo relacionado con la region
	 * @return			object							Arreglo del registro que se almaceno / false
	 */
	public function registrarComuna($KOCI = null, $KOCM = null)
	{
		if ( ! $KOCI || ! $KOCM )
		{
			return false;
		}

		// Llamado al dataSource de Books
		$this->usarDsBooks();
		$data		= array();
		/** Remeplazmos el caracter especial Ñ por ¥ */
		$KOCM		= str_replace('Ñ', '¥', $KOCM);
		/** Obtenemos la informacion de la comuna del DSBOOKS */
		$comunaDsBooks		= $this->query(sprintf("
			SELECT
				[KOCI],
				[KOCM],
				[NOKOCM] AS nombre
			FROM
				[BOOKSDB].[dbo].[TABCM]
			WHERE
				KOCI 		= '%s'
				AND KOCM	= '%s'
		",  $KOCM, $KOCI));

		// Llamado al dataSource local
		$this->usarDsLocal();
		if ( ! empty($comunaDsBooks[0]) )
		{
			/** Se arma el arreglo con la informacion obtenida de la comuna */
			$data		= array(
				'Comuna'			=>	array(
					'region_id'					=>	(int) $comunaDsBooks[0][0]['KOCI'],
					'nombre'					=>	$comunaDsBooks[0][0]['nombre'],
					'KOCM'						=>	$comunaDsBooks[0][0]['KOCM'],
					'KOCI'						=>	$comunaDsBooks[0][0]['KOCI']
				)
			);
			return $this->save($data);
		}
		return false;
	}

	public function beforeFind($query = array())
	{
		if ( empty($query['conditions']) )
		{
			$query['conditions']	= array();
		}
		$query['conditions']['Comuna.activo'] = true;
		return $query;
	}
}
