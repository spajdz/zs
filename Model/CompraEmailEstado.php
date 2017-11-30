<?php
App::uses('AppModel', 'Model');
class CompraEmailEstado extends AppModel
{
	/**
	 * CONFIGURACION DB
	 */
	public $displayField	= 'compra_id';
	public $useTable	= 'compra_email_estados';

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
		'compra_id' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
		'entregado' => array(
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
		'Compra' => array(
			'className'				=> 'Compra',
			'foreignKey'			=> 'compra_id',
			'conditions'			=> '',
			'fields'				=> '',
			'order'					=> '',
			'counterCache'			=> false,
			'counterScope'			=> array('Asociado.modelo' => 'Compra')
		)
	);

	/**
	 * CALLBACKS
	 */
	public function beforeSave($options = array())
	{
		parent::beforeSave($options);

		
	}

	public function EnviarCorreoEntrega($compra_emails_estados = null)
	{
	
		$comprasEmailEstados = $this->find(
            'all',
            array(
                'conditions' => array(
                    'CompraEmailEstado.email_entregado' => 0
                )
            )
        );

		$this->Compra        = ClassRegistry::init('Compra');

		foreach ($comprasEmailEstados  as $compraEmailEstados) {
			$compra			= $this->Compra->find('first', array(
				'conditions'		=> array('Compra.id' => $compraEmailEstados['CompraEmailEstado']['compra_id']),
				'contain'			=> array(
					'Usuario',
				)
			));
		
			$evento			= new CakeEvent('Model.CompraEmailEstado.afterSave', $this, $compra);
			$this->getEventManager()->dispatch($evento);

			$this->id = $compraEmailEstados['CompraEmailEstado']['id'];
			$this->saveField('email_entregado', 1);
			
		}

		
	}
}
