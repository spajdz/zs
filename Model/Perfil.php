<?php
App::uses('AppModel', 'Model');
class Perfil extends AppModel
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
			'isUnique' => array(
				'rule'			=> array('isUnique'),
				'last'			=> true,
				'message'		=> 'El nombre del perfil ya esta asignado. Intente con otro nombre',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			)
		),
		'administrador' => array(
			'boolean' => array(
				'rule'			=> array('boolean'),
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
		'Administrador' => array(
			'className'				=> 'Administrador',
			'foreignKey'			=> 'perfil_id',
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


	public function beforeSave($options = array())
	{
		parent::beforeSave($options);
		/** Se arma un arreglo con los permiso del perfil */
		$permisos = array();
		foreach ( $this->data[$this->alias] AS $campo => $valor)
		{
			if ( $campo != 'nombre' && $campo != 'modified')
			{
				$permisos[$campo] = $valor;
			}
		}
		$this->data[$this->alias]['permisos'] = json_encode($permisos);
		return true;
	}
}
