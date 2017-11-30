<?php
App::uses('AppModel', 'Model');
class TipoContacto extends AppModel
{
	/**
	 * CONFIGURACION DB
	 */
	public $displayField	= 'nombre';

	/**
	 * VALIDACIONES
	 */
	public $validate = array(
		'nombre' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
			),
		)
	);

	/**
	 * ASOCIACIONES
	 */
	public $hasMany = array(
		'Contacto' => array(
			'className'				=> 'Contacto',
			'foreignKey'			=> 'tipo_contacto_id',
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
}
