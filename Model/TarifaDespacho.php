<?php
App::uses('AppModel', 'Model');
class TarifaDespacho extends AppModel
{
	/**
	 * CONFIGURACION DB
	 */
	var $extrema				= false;
	var $observacion_extrema	= null;

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
		'KOCI' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
		'KOCM' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
				//'message'		=> 'Mensaje de validación personalizado',
				//'allowEmpty'	=> true,
				//'required'		=> false,
				//'on'			=> 'update', // Solo valida en operaciones de 'create' o 'update'
			),
		),
		'domicilio' => array(
			'boolean' => array(
				'rule'			=> array('boolean'),
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


	/**
	 * Devuelve el valor del despacho segun comuna y peso del carro
	 * TODO: Calcular el valor adicional segun informe Chilexpress.
	 *
	 * @param			array			$comuna_id			ID de la comuna a consultar su valor
	 * @param			array			$peso				Peso total en gramos del carro
	 * @return			int									Valor del despacho
	 */
	public function calcular($comuna_id = null, $peso = 0)
	{
		$total				= 0;
		$maximo				= 'peso1500';
		$rangos				= array(
			'peso1500'			=> 15000,
			'peso1000'			=> 10000,
			'peso600'			=> 6000,
			'peso300'			=> 3000,
			'peso150'			=> 1500
		);
		if ( ! $peso )
		{
			$peso			= 0;
		}

		/**
		 * Busca si existen tarifas disponibles para la comuna especificada
		 */
		$tarifa			= $this->find('first', array(
			'conditions'		=> array('TarifaDespacho.comuna_id' => $comuna_id)
		));

		/**
		 * Si encuentra una tarifa, determina que pesaje corresponde.
		 */
		if ( $tarifa )
		{
			/**
			 * Datos de comuna extrema
			 */
			$this->extrema					= $tarifa['TarifaDespacho']['extrema'];
			$this->observacion_extrema		= $tarifa['TarifaDespacho']['observacion_extrema'];

			$tarifaPeso				= $maximo;
			$adicional				= 0;

			/**
			 * Si el peso excede el máximo, se le cobra la tarifa por peso completo
			 * y se le agrega el valor por kilo adicional
			 */
			if ( $peso > $rangos[$maximo] )
			{
				$calcular		= ($peso - $rangos[$maximo]) / 1000;
				$adicional		= ceil((int) $tarifa['TarifaDespacho']['adicional'] * $calcular);
			}

			/**
			 * Si el peso no excede el máximo, se cobra la tarifa segun el rango de peso
			 */
			else
			{
				foreach ( $rangos as $key => $max )
				{
					if ( $peso <= $max )
					{
						$tarifaPeso		= $key;
					}
				}
			}
			return ($tarifa['TarifaDespacho'][$tarifaPeso] + $adicional);
		}

		/**
		 * Si no encuentra una tarifa, asume despacho gratuito
		 */
		return $total;
	}
}
