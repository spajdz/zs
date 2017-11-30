<?php
App::uses('AppModel', 'Model');
class Query extends AppModel
{
	/**
	 * CONFIGURACION DB
	 */
	public $displayField		= 'identificador';

	/**
	 * CONFIGURACION MODELO
	 */
	public $crearRevisiones		= true;

	/**
	 * BEHAVIORS
	 */
	var $actsAs					= array();

	/**
	 * VALIDACIONES
	 */
	public $validate = array(
		'identificador' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
		'version' => array(
			'numeric' => array(
				'rule'			=> array('numeric'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
		'query' => array(
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
		'Administrador' => array(
			'className'				=> 'Administrador',
			'foreignKey'			=> 'administrador_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'counterCache'			=> false,
			'counterScope'			=> array('Asociado.modelo' => 'Administrador')
		)
	);
	public $hasMany = array(
		'Identificador' => array(
			'className'				=> 'Identificador',
			'foreignKey'			=> 'query_id',
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
		if ( ! isset($this->data[$this->name]['administrador_id']) )
		{
			$this->data[$this->name]['administrador_id']		= AuthComponent::user('id');
		}

		/**
		 * Si se esta modificando la query, se crea una revision de ser necesario
		 */
		if ( $this->crearRevisiones && $this->id && isset($this->data[$this->name]['query']) )
		{
			$query			= $this->find('first', array(
				'conditions'		=> array("{$this->name}.id" => $this->id)
			));

			if ( $query[$this->name]['query'] != $this->data[$this->name]['query'] )
			{
				/**
				 * Guarda la nueva query como version productiva
				 */
				$id				= $this->id;
				$data			= $this->data;
				$this->id		= null;
				$this->data		= null;
				$nueva			= array_merge_recursive($data, array(
					$this->name		=> array(
						'identificador'		=> $query[$this->name]['identificador'],
						'version'			=> ($query[$this->name]['version'] + 1),
						'revision'			=> false,
					)
				));
				unset($nueva[$this->name]['id'], $nueva[$this->name]['modified']);

				$nueva[$this->name]['created']		= date('Ymd H:i:s');
				$nueva[$this->name]['modified']		= date('Ymd H:i:s');

				$this->create();
				$this->save($nueva, array(
					'callbacks'		=> false
				));
				$nuevo_id		= $this->id;
				$this->clear();

				/**
				 * Reasigna los identificadores de la query
				 */
				$this->Identificador->updateAll(
					array('Identificador.query_id'	=> $nuevo_id),
					array('Identificador.query_id'	=> $query[$this->name]['id'])
				);

				/**
				 * Query antigua (revision)
				 */
				$this->id		= $id;
				$this->data		= $data;
				$this->data[$this->name]['revision']		= true;
				$this->data[$this->name]['query']			= $query[$this->name]['query'];
				$this->data[$this->name]['comentarios']		= $query[$this->name]['comentarios'];
			}
		}

		return true;
	}


	/**
	 * Restore
	 *
	 * Recupera una query del historial y la pasa a modo productivo
	 */
	public function restore($id = null)
	{
		/**
		 * Sanidad
		 */
		if ( ! empty($id) )
		{
			$this->id = $id;
		}
		$id		= $this->id;
		if ( ! $this->exists() )
		{
			return false;
		}

		/**
		 * Query a recuperar
		 */
		$query			= $this->find('first', array(
			'conditions'		=> array(
				'Query.id'				=> $id
			)
		));

		/**
		 * Query productiva
		 */
		$productiva		= $this->find('first', array(
			'conditions'		=> array(
				'Query.identificador'	=> $query['Query']['identificador'],
				'Query.revision'		=> false
			)
		));
		if ( ! $productiva )
		{
			return false;
		}

		/**
		 * Guarda la nueva query
		 */
		$data			= $query;
		unset(
			$data['Query']['id'],
			$data['Query']['administrador_id'],
			$data['Query']['created'],
			$data['Query']['modified']
		);
		$data['Query']['version']			= ($productiva['Query']['version'] + 1);
		$data['Query']['revision']			= false;
		$data['Query']['comentarios']		= "Se restaura query desde la versión {$query['Query']['version']}";
		$this->clear();
		$this->create();
		if ( $this->save($data) )
		{
			/**
			 * Reasigna los identificadores de la query
			 */
			$this->Identificador->updateAll(
				array('Identificador.query_id'	=> $this->id),
				array('Identificador.query_id'	=> $productiva['Query']['id'])
			);

			/**
			 * Archiva la actual query productiva
			 */
			$this->clear();
			$this->save(array(
				'id'			=> $productiva['Query']['id'],
				'revision'		=> true
			));

			return true;
		}
		return false;
	}

	public function getProductiva($identificador = null)
	{
		return $this->find('first', array(
			'conditions'		=> array(
				'Query.identificador'		=> $identificador,
				'Query.revision'			=> false
			),
			//'cache'				=> $identificador
		));
	}
}
