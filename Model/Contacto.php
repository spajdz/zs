<?php
App::uses('AppModel', 'Model');
class Contacto extends AppModel
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
				'required'		=> false,
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
		'nombre' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
		'email' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
		'mensaje' => array(
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
		'Servicio' => array(
			'className'				=> 'Servicio',
			'foreignKey'			=> 'servicio_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'counterCache'			=> false,
			'counterScope'			=> array('Asociado.modelo' => 'Usuario')
		),
		'TipoContacto' => array(
			'className'				=> 'TipoContacto',
			'foreignKey'			=> 'tipo_contacto_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'counterCache'			=> false,
			'counterScope'			=> array('Asociado.modelo' => 'TipoContacto')
		),
		'Usuario' => array(
			'className'				=> 'Usuario',
			'foreignKey'			=> 'usuario_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'counterCache'			=> false,
			'counterScope'			=> array('Asociado.modelo' => 'Usuario')
		)
	);

	/**
	 * CALLBACKS
	 */
	public function afterSave($created, $options = array())
	{
		parent::afterSave($created, $options);

		/**
		 * Envia mail al usuario y al staff
		 */
		if ( $created )
		{
			$contacto		= $this->find('first', array(
				'conditions'		=> array('Contacto.id' => $this->data[$this->name]['id']),
				'contain'			=> array(
					'TipoContacto',
					'Servicio'
				)
			));

			// prx($contacto);
			$evento			= new CakeEvent('Model.Contacto.afterSave', $this, $contacto);
			$this->getEventManager()->dispatch($evento);
		}
	}

	/**
	 * Funcion que permite organizar un arreglo de condiciones, de acuerdo con el filtro
	 * realizado en el index.
	 * @param			Object			$filtros			arreglo con los datos del filtro
	 * @return			object								arreglo con las condiciones necesarias
	 */
	public function condicionesFiltros( $filtros = null )
	{
		$condiciones		= array();
		if ( ! empty($filtros['filtro']) )
		{
			/**  LIBRE */
			if ( ! empty($filtros['filtro']['buscar']) )
			{
				// Se compara primero los parametros de busqueda con los datos del usuario registrado
				$data_usuario		=	$this->Usuario->find('all', array(
					'conditions'	=> array(
						'OR'	=> array(
								'[Usuario].[nombre] + [Usuario].[apellido_paterno] + [Usuario].[apellido_materno] + [Usuario].[email] LIKE' => sprintf('%%%s%%', $filtros['filtro']['buscar'])
							)
					),
				));

				$usuario = array_unique(Hash::extract($data_usuario,'{n}.Usuario.id'));

				if ( ! empty($usuario) )
				{
					array_push($condiciones, array(
						'Contacto.usuario_id'	=> 	$usuario
					));
				}
				else
				{
					array_push($condiciones, array(
						'OR'	=> array(
							'[Contacto].[nombre] + [Contacto].[email] + [Contacto].[asunto] LIKE' => sprintf('%%%s%%', $filtros['filtro']['buscar'])
						)
					));
				}
			}
			if ( ! empty($filtros['filtro']['region']) )
			{
				// Si no hay comuna, se obtiene las comunas de la region
				if ( empty ($filtros['filtro']['comuna']) )
				{
					$data_comuna		=	$this->Comuna->find('all', array(
						'conditions'	=>	array(
							'Comuna.region_id'		=> $filtros['filtro']['region']
						)
					));
					$comuna = array_unique(Hash::extract($data_comuna,'{n}.Comuna.id'));
				}
				else
				{
					$comuna = $filtros['filtro']['comuna'];
				}

				array_push($condiciones, array(
						'Contacto.comuna_id'	=> 	$comuna
					));
			}
		}
		if ( ! empty($condiciones) )
		{
			return $condiciones;
		}
		return false;
	}

	public function beforeSave($options = array())
    {
        parent::beforeSave($options);

        $this->data[$this->alias]['created']    =  date('Y-m-d H:i:s');
        $this->data[$this->alias]['modified']   =  date('Y-m-d H:i:s');
        
        return true;
    }
}
