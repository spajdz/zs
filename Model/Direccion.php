<?php
App::uses('AppModel', 'Model');
class Direccion extends AppModel
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
		'comuna_id' => array(
			'validateForeignKey' => array(
				'rule'			=> array('validateForeignKey'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
		'calle' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
		'numero' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
		'codigo_postal' => array(
			'numeric' => array(
				'rule'			=> array('numeric'),
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
		'TipoDireccion' => array(
			'className'				=> 'TipoDireccion',
			'foreignKey'			=> 'tipo_direccion_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'counterCache'			=> true,
		),
		'Usuario' => array(
			'className'				=> 'Usuario',
			'foreignKey'			=> 'usuario_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'counterCache'			=> false,
			'counterScope'			=> array('Asociado.modelo' => 'Usuario')
		),
		'Comuna' => array(
			'className'				=> 'Comuna',
			'foreignKey'			=> 'comuna_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'counterCache'			=> false,
			'counterScope'			=> array('Asociado.modelo' => 'Comuna')
		)
	);
	public $hasMany = array(
		'Compra' => array(
			'className'				=> 'Compra',
			'foreignKey'			=> 'direccion_id',
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
		 * Asigna el usuario
		 */
		$this->data[$this->alias]['usuario_id']			= AuthComponent::user('id');
		$this->data[$this->alias]['modified']			=  date('Y-m-d H:i:s');
		$this->data[$this->alias]['created']			=  date('Y-m-d H:i:s');
		$this->data[$this->alias]['tipo_direccion_id']	=  1;
		
		if ( ! empty($this->data[$this->alias]['calle']) )
		{
			/**
			 * Primero, comprueba si existe una direccion igual (combinacion calle + numero + depto + region + comuna)
			 */
			$previa			= $this->find('first', array(
				'conditions'		=> array(
					'Direccion.calle'			=> $this->data[$this->alias]['calle'],
					'Direccion.numero'			=> $this->data[$this->alias]['numero'],
					'Direccion.depto'			=> $this->data[$this->alias]['depto'],
					'Direccion.comuna_id'		=> $this->data[$this->alias]['comuna_id'],
				)
			));

			/**
			 * Si existe, fuerza actualizacion en vez de creacion de una nueva direccion
			 */
			if ( $previa )
			{
				$data								= $this->data;
				$this->clear();
				$this->data							= $data;
				$this->id							= $previa['Direccion']['id'];
				$this->data[$this->alias]['id']		= $previa['Direccion']['id'];
				unset($this->data[$this->alias]['created']);
			}

			/**
			 * Obtiene el nombre de la comuna seleccionada
			 */
			$comuna			= $this->Comuna->find('first', array(
				'conditions'		=> array('Comuna.id' => $this->data[$this->alias]['comuna_id'])
			));
			if ( ! $comuna )
			{
				return false;
			}

			/**
			 * Asigna el nombre
			 */
			$this->data[$this->alias]['nombre']			= sprintf(
				'%s %s %s, %s',
				$this->data[$this->alias]['calle'],
				$this->data[$this->alias]['numero'],
				$this->data[$this->alias]['depto'],
				$comuna['Comuna']['nombre']
			);
		}

		/**
		 * Normaliza el telefono
		 */
		if ( isset($this->data[$this->alias]['telefono']) )
		{
			$this->data[$this->alias]['telefono']		= preg_replace('/[^\d]/', '', $this->data[$this->alias]['telefono']);
		}

		return true;
	}
}
