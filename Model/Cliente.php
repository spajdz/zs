<?php
App::uses('AppModel', 'Model');
class Cliente extends AppModel
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
              'imagen'    => array(
                  'versions'  => array(
                      array(
                          'prefix'    => 'original',
                          'width'     => 160,
                          'height'    => 100,
                          'crop'      => false
                      ),
                      array(
                          'prefix'    => 'interna',
                          'width'     => 160,
                          'height'    => 100,
                          'crop'      => true
                      ),
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
		'Administrador' => array(
			'className'				=> 'Administrador',
			'foreignKey'			=> 'administrador_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
		)
	);
}
