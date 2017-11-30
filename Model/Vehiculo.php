<?php
App::uses('AppModel', 'Model');
class Vehiculo extends AppModel
{
	/**
	 * CONFIGURACION DB
	 */
	public $displayField	= 'marca';

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
		'marca' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
			),
		),
		'modelo' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
			),
		),
		'version' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
			),
		),
		'aro' => array(
			'notBlank' => array(
				'rule'			=> array('notBlank'),
				'last'			=> true,
			),
		),
	);

	public function marcas()
	{
		return $this->find('list', array(
			'cache'			=> 'menu_marcas',
			'fields'			=> array(
				'Vehiculo.marca',
				'Vehiculo.marca'
			),
			'group' => array('Vehiculo.marca'),
			'callbacks' 		=> false
		));
	}

	public function modelosByMarca($nombre_marca = null)
	{
		return $this->find('list', array(
			'cache'			=> 'modelos_marca',
			'fields'			=> array(
				'Vehiculo.modelo',
				'Vehiculo.modelo'
			),
			'conditions'	=>  array(
				'Vehiculo.marca' => $nombre_marca
			),
			'group' => array('Vehiculo.modelo'),
			'callbacks' 		=> false
		));
	}

	public function versionesByMarcaModelo($nombre_marca = null, $nombre_modelo = null)
	{
		return $this->find('list', array(
			'cache'			=> 'versiones_marca_modelo',
			'fields'			=> array(
				'Vehiculo.version',
				'Vehiculo.version'
			),
			'conditions'	=>  array(
				'Vehiculo.marca' => $nombre_marca,
				'Vehiculo.modelo' => $nombre_modelo
			),
			'group' => array('Vehiculo.version'),
			'callbacks' 		=> false
		));
	}
	public function anosByMarcaModeloVersion($nombre_marca = null, $nombre_modelo = null, $nombre_version = null)
	{
		return $this->find('list', array(
			'cache'			=> 'anos_marca_modelo_version',
			'fields'			=> array(
				'Vehiculo.ano',
				'Vehiculo.ano'
			),
			'conditions'	=>  array(
				'Vehiculo.marca' => $nombre_marca,
				'Vehiculo.modelo' => $nombre_modelo,
				'Vehiculo.version' => $nombre_version
			),
			'group' => array('Vehiculo.ano'),
			'callbacks' 		=> false
		));
	}
	public function anchosByMarcaModeloVersionAno($tipo = null, $nombre_marca = null, $nombre_modelo = null, $nombre_version = null, $ano = null){
		$campo = ($tipo == 'neumaticos') ? 'ancho' : 'ancho_llanta';
		return $this->find('list', array(
			'cache'			=> 'anchos_marca_modelo_version_ano',
			'fields'			=> array(
				sprintf('Vehiculo.%s', $campo),
				sprintf('Vehiculo.%s', $campo)
			),
			'conditions'	=>  array(
				'Vehiculo.marca' => $nombre_marca,
				'Vehiculo.modelo' => $nombre_modelo,
				'Vehiculo.version' => $nombre_version,
				'Vehiculo.ano' => $ano
			),
			'group' => array(sprintf('Vehiculo.%s', $campo)),
			'callbacks' 		=> false
		));
	}

	public function perfilesByMarcaModeloVersionAnoAncho( $nombre_marca = null, $nombre_modelo = null, $nombre_version = null, $ano = null, $ancho = null){
		return $this->find('list', array(
			'cache'			=> 'perfiles_marca_modelo_version_ano_ancho',
			'fields'			=> array(
				'Vehiculo.perfil',
				'Vehiculo.perfil'
			),
			'conditions'	=>  array(
				'Vehiculo.marca' => $nombre_marca,
				'Vehiculo.modelo' => $nombre_modelo,
				'Vehiculo.version' => $nombre_version,
				'Vehiculo.ano' => $ano,
				'Vehiculo.ancho' => $ancho
			),
			'group' => array('Vehiculo.perfil'),
			'callbacks' 		=> false
		));
	}

	public function arosByMarcaModeloVersionAnoAnchoPerfil( $nombre_marca = null, $nombre_modelo = null, $nombre_version = null, $ano = null, $ancho = null, $perfil = null){
		return $this->find('list', array(
			'cache'			=> 'aros_marca_modelo_version_ano_ancho_perfil',
			'fields'			=> array(
				'Vehiculo.aro',
				'Vehiculo.aro'
			),
			'conditions'	=>  array(
				'Vehiculo.marca' => $nombre_marca,
				'Vehiculo.modelo' => $nombre_modelo,
				'Vehiculo.version' => $nombre_version,
				'Vehiculo.ano' => $ano,
				'Vehiculo.ancho' => $ancho,
				'Vehiculo.perfil' => $perfil
			),
			'group' => array('Vehiculo.aro'),
			'callbacks' 		=> false
		));
	}

	
}
