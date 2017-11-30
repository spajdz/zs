<?php
App::uses('AppModel', 'Model');
class Novedad extends AppModel
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

		'Image'		=> array(
			'fields'	=> array(
				'imagen_destacada'	=> array(
					'versions'	=> array(
						array(
							'prefix'	=> 'img',
							'width'		=> 1000,
							'height'	=> 390,
							'crop'		=> false
						),
						array(
							'prefix'	=> 'mini',
							'width'		=> 50,
							'height'	=> 50,
							'crop'		=> true
						)
					)
				),
				'imagen'	=> array(
					'versions'	=> array(
						array(
							'prefix'	=> 'img',
							'width'		=> 320,
							'height'	=> 273,
							'crop'		=> false
						),
						array(
							'prefix'	=> 'mini',
							'width'		=> 50,
							'height'	=> 50,
							'crop'		=> true
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
		'titulo' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
		'texto' => array(
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

	public function beforeSave($options = array())
	{
		parent::beforeSave($options);
		/**
		 * Actualiza el usuario que modifica el texto
		 */
		if ( ! isset($this->data[$this->alias]['administrador_id']) )
		{
			$this->data[$this->alias]['administrador_id']		= AuthComponent::user('id');
		}
		return true;
	}
}
