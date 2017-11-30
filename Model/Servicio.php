<?php
App::uses('AppModel', 'Model');
class Servicio extends AppModel
{
	/**
	 * CONFIGURACION DB
	 */
	public $displayField	= 'nombre';
	/**
	 * BEHAVIORS
	 */
	 var $actsAs         = array(
        /**
         * IMAGE UPLOAD
         */
        
        'Image'     => array(
            'fields'    => array(
                'imagen'  => array(
                    'versions'  => array(
                        array(
                            'prefix'    => 'mini',
                            'width'     => 390,
                            'height'    => 202,
                            'crop'      => true
                        ),
                        array(
                            'prefix'    => 'interna',
                            'width'     => 590,
                            'height'    => 260,
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
	);
	/**
	 * ASOCIACIONES
	 */
	public $hasAndBelongsToMany = array(
		'Sucursal' => array(
			'className'				=> 'Sucursal',
			'joinTable'				=> 'servicios_sucursales',
			'foreignKey'			=> 'servicio_id',
			'associationForeignKey'	=> 'sucursal_id',
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
