<?php
App::uses('AppModel', 'Model');
class Configuracion extends AppModel
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
	public $belongsTo = array(
		'Administrador' => array(
			'className'				=> 'Administrador',
			'foreignKey'			=> 'administrador_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'counterCache'			=> false,
			'counterScope'			=> array('Asociado.modelo' => 'Administrador')
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
		if ( ! isset($this->data[$this->name]['administrador_id']) )
		{
			$this->data[$this->name]['administrador_id']		= AuthComponent::user('id');
		}
		$this->data[$this->alias]['created']	=  date('Y-m-d H:i:s');
		$this->data[$this->alias]['modified']	=  date('Y-m-d H:i:s');
	}

	public function getProductiva($identificador = null)
	{
		return $this->find('first', array(
			'conditions'		=> array(
				'Configuracion.nombre'		=> $identificador,
				'Configuracion.activo'		=> true
			)
		));
	}

}
