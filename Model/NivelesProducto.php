<?php
App::uses('AppModel', 'Model');
class NivelesProducto extends AppModel
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

	/**
	 * ASOCIACIONES
	 */
	public $belongsTo = array(
		'Nivel' => array(
			'className'				=> 'Nivel',
			'foreignKey'			=> 'nivel_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			/*
			'counterCache'			=> array(
				'nivelesproducto_activo_count'			=> array('NivelesProducto.activo' => true),
				'nivelesproducto_inactivo_count'			=> array('NivelesProducto.activo' => false)
			),
			*/
			//'counterScope'			=> array('Asociado.modelo' => 'Nivel')
		),
		'Producto' => array(
			'className'				=> 'Producto',
			'foreignKey'			=> 'producto_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			/*
			'counterCache'			=> array(
				'nivelesproducto_activo_count'			=> array('NivelesProducto.activo' => true),
				'nivelesproducto_inactivo_count'			=> array('NivelesProducto.activo' => false)
			),
			*/
			//'counterScope'			=> array('Asociado.modelo' => 'Producto')
		)
	);

	public function getProductosIdsNivel($nivel_id = null)
	{
		return $this->find('list', array(
			'fields'		=> array('NivelesProducto.id', 'NivelesProducto.producto_id'),
			'conditions'	=> array('NivelesProducto.nivel_id' => $nivel_id)
		));
	}
}
