<?php
App::uses('AppModel', 'Model');
class Tema extends AppModel
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
	);

	/**
	 * ASOCIACIONES
	 */
	public $hasMany = array(
		'Ayuda' => array(
			'className'				=> 'Ayuda',
			'foreignKey'			=> 'tema_id',
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
		 * Orden inicial
		 */
		if ( ! $this->id && ! isset($this->data[$this->alias][$this->primaryKey]) )
		{
			$this->data['Tema']['orden']		= $this->find('count') + 1;
		}

		/**
		 * Slug
		 */
		if ( ! empty($this->data[$this->alias]['nombre']) )
		{
			$this->data[$this->alias]['slug']		= Inflector::slug(mb_strtolower($this->data[$this->alias]['nombre']), '-');
		}

		return true;
	}
}
