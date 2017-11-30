<?php
App::uses('AppModel', 'Model');
App::uses('String', 'Utility');
class Lista extends AppModel
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
		'colegio_id' => array(
			'validateForeignKey' => array(
				'rule'			=> array('validateForeignKey'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
		// 'nivel_id' => array(
		// 	'validateForeignKey' => array(
		// 		'rule'			=> array('validateForeignKey'),
		// 		'last'			=> true,
		// 		//'message'		=> 'Mensaje de validación personalizado',
		// 		//'allowEmpty'	=> true,
		// 		//'required'		=> false,
		// 		//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
		// 	),
		// )
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
			/*
			'counterCache'			=> array(
				'lista_activo_count'			=> array('Lista.activo' => true),
				'lista_inactivo_count'			=> array('Lista.activo' => false)
			),
			*/
			//'counterScope'			=> array('Asociado.modelo' => 'Usuario')
		),
		'Colegio' => array(
			'className'				=> 'Colegio',
			'foreignKey'			=> 'colegio_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			/*
			'counterCache'			=> array(
				'lista_activo_count'			=> array('Lista.activo' => true),
				'lista_inactivo_count'			=> array('Lista.activo' => false)
			),
			*/
			//'counterScope'			=> array('Asociado.modelo' => 'Colegio')
		),
		'Nivel' => array(
			'className'				=> 'Nivel',
			'foreignKey'			=> 'nivel_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			/*
			'counterCache'			=> array(
				'lista_activo_count'			=> array('Lista.activo' => true),
				'lista_inactivo_count'			=> array('Lista.activo' => false)
			),
			*/
			//'counterScope'			=> array('Asociado.modelo' => 'Nivel')
		)
	);
	public $hasMany = array(
		'DetalleCompra' => array(
			'className'				=> 'DetalleCompra',
			'foreignKey'			=> 'lista_id',
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
}
