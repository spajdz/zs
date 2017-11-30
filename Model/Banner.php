<?php
App::uses('AppModel', 'Model');
class Banner extends AppModel
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
							'width'		=> 150,
							'height'	=> 150,
							'crop'		=> true
						),
						array(
							'prefix'	=> 'bannerhome',
							'width'		=> 1350,
							'height'	=> 529,
							'crop'		=> true
						),
						array(
							'prefix'	=> 'bannerinterior',
							'width'		=> 1350,
							'height'	=> 350,
							'crop'		=> true
						),
						array(
							'prefix'	=> 'bannerHorizontalHome',
							'width'		=> 448,
							'height'	=> 186,
							'crop'		=> true
						),
						array(
							'prefix'	=> 'bannerHorizontalHomeInf',
							'width'		=> 674,
							'height'	=> 155,
							'crop'		=> true
						),
						array(
							'prefix'	=> 'bannersucursal',
							'width'		=> 444,
							'height'	=> 227,
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
		
		'activo' => array(
			'boolean' => array(
				'rule'			=> array('boolean'),
				'last'			=> true,
			),
		),
		'orden' => array(
			'numeric' => array(
				'rule'			=> array('numeric'),
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
			'counterCache'			=> false,
			'counterScope'			=> array('Asociado.modelo' => 'Administrador')
		),
		'Pagina' => array(
			'className'				=> 'Pagina',
			'foreignKey'			=> 'pagina_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'counterCache'			=> false,
			'counterScope'			=> array('Asociado.modelo' => 'Pagina')
		)
	);

	public function checkDate($a, $b)
	{
		$fecha_inicio        = DateTime::createFromFormat('Y-m-d H:i:s', $this->data['Banner']['fecha_inicio']);
		$fecha_fin           = DateTime::createFromFormat('Y-m-d H:i:s', $this->data['Banner']['fecha_fin']);
		if ( $fecha_inicio != '' || $fecha_inicio != null )
		{
			if ( $fecha_fin != '' || $fecha_fin != null )
			{
				$diff = $fecha_inicio->diff($fecha_fin);
				if ( $fecha_inicio == $fecha_fin || $fecha_inicio > $fecha_fin )
				{
					return false;
				}
			}
		}
		return true;
	}

	public function beforeSave($options = array())
	{
		parent::beforeSave($options);

		/**
		 * Actualiza el usuario que modifica la query
		 */
		if ( ! isset($this->data[$this->alias]['administrador_id']) )
		{
			$this->data[$this->alias]['administrador_id']		= AuthComponent::user('id');
		}
		/**
		 * Orden inicial
		 */
		if ( ! $this->id && ! isset($this->data[$this->alias][$this->primaryKey]) )
		{
			if($this->data[$this->alias]['pagina_id'] == 2){
				$this->data[$this->alias]['orden']					= $this->find('count', array('conditions' => array('pagina_id' => 2))) + 1;
			}else{
				$this->data[$this->alias]['orden']					= $this->find('count', array('conditions' => array('NOT' => array('pagina_id' => 2)))) + 1;
			}
		}

		$this->data[$this->alias]['created']	=  date('Y-m-d H:i:s');
		$this->data[$this->alias]['modified']	=  date('Y-m-d H:i:s');

		return true;
	}

}
