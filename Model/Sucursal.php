<?php
App::uses('AppModel', 'Model');
class Sucursal extends AppModel
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
		
		'Image'		=> array(
			'fields'	=> array(
				'imagen'	=> array(
					'versions'	=> array(
						array(
							'prefix'	=> 'mini',
							'width'		=> 390,
							'height'	=> 203,
							'crop'		=> true
						),
						array(
							'prefix'	=> 'interna',
							'width'		=> 790,
							'height'	=> 412,
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
		'nombre' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
			),
		),
	);
	/**
	 * ASOCIACIONES
	 */
	public $belongsTo = array(
		'TipoSucursal' => array(
			'className'				=> 'TipoSucursal',
			'foreignKey'			=> 'tipo_sucursal_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'counterCache'			=> true,
			//'counterScope'			=> array('Asociado.modelo' => 'Producto')
		)
	);
	public $hasMany = array(
		'Encargado' => array(
			'className'				=> 'Encargado',
			'foreignKey'			=> 'sucursal_id',
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
		'Sucursal' => array(
			'className'				=> 'Sucursal',
			'foreignKey'			=> 'sucursal_id',
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
	public $hasAndBelongsToMany = array(
		'Servicio' => array(

			'className'				=> 'Servicio',
			'joinTable'				=> 'servicios_sucursales',
			'foreignKey'			=> 'sucursal_id',
			'associationForeignKey'	=> 'servicio_id',
			'unique'				=> true,
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'limit'					=> '',
			'offset'				=> '',
			'finderQuery'			=> '',
			'deleteQuery'			=> '',
			'insertQuery'			=> '' 
		)
	);	

	public function beforeSave($options = array())
	{
		parent::beforeSave($options);

		$this->data[$this->alias]['created']	=  date('Y-m-d H:i:s');
		$this->data[$this->alias]['modified']	=  date('Y-m-d H:i:s');
		
		return true;
	}
}
