<?php
App::uses('AppModel', 'Model');
class Usuario extends AppModel
{
	/**
	 * CONFIGURACION DB
	 */
	public $displayField	= 'nombre';

	/**
	 * BEHAVIORS
	 */
	var $actsAs			= array(
		 'Image'     => array(
            'fields'    => array(
                'imagen'  => array(
                    'versions'  => array(
                        array(
                            'prefix'    => 'mini',
                            'width'     => 100,
                            'height'    => 100,
                            'crop'      => true
                        ),
                        array(
                            'prefix'    => 'interna',
                            'width'     => 250,
                            'height'    => 250,
                            'crop'      => true
                        ),
                        array(
                            'prefix'    => 'interna',
                            'width'     => 200,
                            'height'    => 105,
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
		'email' => array(
			'email' => array(
				'rule'			=> array('email'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		)
	);

	/**
	 * ASOCIACIONES
	 */
	public $belongsTo = array(
		'TipoUsuario' => array(
			'className'				=> 'TipoUsuario',
			'foreignKey'			=> 'tipo_usuario_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			/*
			'counterCache'			=> array(
				'usuario_activo_count'			=> array('Usuario.activo' => true),
				'usuario_inactivo_count'			=> array('Usuario.activo' => false)
			),
			*/
			//'counterScope'			=> array('Asociado.modelo' => 'TipoUsuario')
		)
	);
	public $hasMany = array(
		'Compra' => array(
			'className'				=> 'Compra',
			'foreignKey'			=> 'usuario_id',
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
		'Direccion' => array(
			'className'				=> 'Direccion',
			'foreignKey'			=> 'usuario_id',
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
		'TipoPago' => array(
			'className'				=> 'TipoPago',
			'joinTable'				=> 'usuarios_tipo_pagos',
			'foreignKey'			=> 'usuario_id',
			'associationForeignKey'	=> 'tipo_pago_id',
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

	/**
	 * CALLBACKS
	 */
	public function beforeSave($options = array())
	{
		if ( isset($this->data[$this->alias]['clave']) )
		{
			if ( trim($this->data[$this->alias]['clave']) == false )
			{
				unset($this->data[$this->alias]['clave'], $this->data[$this->alias]['repetir_clave']);
			}
			else
			{
				$this->data[$this->alias]['clave']	= AuthComponent::password($this->data[$this->alias]['clave']);
			}
		}
		return true;
	}
}
