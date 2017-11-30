<?php
App::uses('Model', 'Model');
class AppModel extends Model
{
	public $recursive		= -1;
	public $actsAs			= array('Containable');


	/**
	 * Switch datasources
	 */
	public function usarDsLocal()
	{
		$this->useDbConfig		= 'default';
		$this->useTable			= $this->table;
	}
	public function usarDsBooks()
	{
		$this->useDbConfig		= 'books';
		$this->useTable			= false;
	}
	public function usarDsBooksWeb()
	{
		$this->useDbConfig		= 'bookscl';
		$this->useTable			= false;
	}

	/**
	 * VALIDACION -- REPETIR CLAVE
	 */
	function repetirClave($data)
	{
		return ($this->data[$this->name]['clave'] === $this->data[$this->name]['repetir_clave']);
	}


	/**
	 * VALIDACION -- VALIDA RUT CHILENO
	 */
	public function rutChileno($data = array(), $dv = null)
	{
		$rut		= $rutcalc = preg_replace('/[^\da-z]/i', '', current($data));
		if ( ! $dv )
		{
			$dv			= substr($rut, -1);
			$rut		= $rutcalc = substr_replace($rut, '', -1);
		}
		else
			$dv			= $this->data[$this->name][$dv];

		if ( ! $rut || ! is_numeric($rut) || strlen($rut) < 6 || strlen($dv) != 1 )
			return false;

		$suma		= 1;
		for ( $x = 0; $rutcalc != 0; $rutcalc /= 10 )
			$suma	= ($suma + $rutcalc % 10 * (9 - $x++ % 6)) % 11;
		$dvcalc		= chr($suma ? $suma + 47 : 75);

		return (strtolower($dvcalc) == strtolower($dv));
	}


	/**
	 * VALIDACION -- VALIDA QUE UNA LLAVE FORANEA EXISTA EN EL MODELO ASOCIADO
	 */
	public function validateForeignKey($data = array())
	{
		$associations	= array_map(
			create_function('$v', 'return $v["foreignKey"];'),
			$this->belongsTo
		);
		$aliases		= array();
		foreach ( $associations as $model => $foreignKey )
		{
			if ( ! array_key_exists($foreignKey, $aliases) )
				$aliases[$foreignKey] = array();
			array_push($aliases[$foreignKey], $model);
		}
		foreach ( $aliases[key($data)] as $model )
		{
			$count	= $this->{$model}->find('count', array(
				'conditions'	=> array("{$model}.{$this->{$model}->primaryKey}" => current($data)),
				'recursive'		=> -1,
				'callbacks'		=> false
			));
			if ( $count == 1 )
			{
				return true;
			}
		}
		return false;
	}


	/**
	 * Find Cache
	 */
	public function find($type = 'first', $query = array())
	{
		switch ($type) {
            case 'threaded' :
                $results = parent::find('all', $query);

                foreach($results as &$r) {
                    $r['children'] = $this->find('all', array(
                            'conditions' => array('parent_id' => $r[$this->alias][$this->primaryKey])
                    ));
                }
                return $results;

            default:
                return parent::find($type, $query);
        }
		/**
		 * Solicita query con cache activado
		 */
		if ( ! empty($query['cache']) )
		{
			$cacheName		= sprintf('%s.%s', $this->name, $query['cache']);

			return Cache::remember($cacheName, function() use($type, $query)
			{
				return parent::find($type, $query);
			}, 'query');
		}

		return parent::find($type, $query);
	}


	/**
	 * Elimina cache de queries
	 */
	public function deleteCache($model = null, $name = null)
	{
		return Cache::delete(sprintf('%s.%s', $model, $name), 'query');
	}


	/**
	 * Normaliza los campos datetime que vienen sin fecha, seteandolos a hora 00:00:00
	 */
	public function normalizaFechaVacia($data = array(), $fields = array())
	{
		if ( ! $data )
		{
			return false;
		}
		$model		= current(array_keys($data));

		foreach ( $fields as $field )
		{
			if ( ! empty($data[$model][$field]['year']) && empty($data[$model][$field]['hour']) )
			{
				$data[$model][$field]['hour']			= '00';
				$data[$model][$field]['min']			= '00';
				$data[$model][$field]['meridian']		= 'am';
			}
		}

		return $data;
	}

	public function beforeSave($options = array())
	{
		parent::beforeSave($options);

		foreach ( array('created', 'modified') as $campo )
		{
			if ( ! empty($this->data[$this->name][$campo]) )
			{
				$this->data[$this->name][$campo]	= str_replace('-', '', $this->data[$this->name][$campo]);
			}
		}
	}

	/**
	 * Funcion que permite ejecutar las funciones query de carga
	 * @param			object			$proc			Tipo de carga
	 * @return			object							el tiempo de ejecucion sql
	 */
	public function ejecutarCargaMasiva($proc)
	{
		if ( ! empty($proc) )
		{
			/**
			 * Nombre DB
			 */
			$db					= $this->getDatasource()->config['database'];

			/**
			 * Ejecuta el procedimiento de carga masiva
			 */
			$this->usarDsBooks();
			$procedimiento		= $this->query(sprintf('EXEC [$s].[dbo].[%s]', $db, $proc));

			/**
			 * Ejecuta las estadisticas de ejecucion del procedimiento
			 */
			$estadisticas		= $this->query(sprintf('
				SELECT TOP 1 CONVERT(TIME(3), DATEADD(ms, ROUND(last_elapsed_time / 1000.0, 0), 0)) AS tiempo_ejecucion
				FROM sys.dm_exec_procedure_stats
				WHERE OBJECT_NAME(object_id, database_id) = \'%s\'
				ORDER BY last_execution_time DESC
			', $proc));

			// Llamado al dataSource local
			$this->usarDsLocal();
			return $estadisticas[0][0]['tiempo_ejecucion'];
		}
	}

	/**
	 * Devuelve la lista de instituciones a traves de una busqueda por nombre
	 *
	 * @param			string			$colegio			Nombre o parte del nombre de la institucion a buscar
	 * @return			array								Resultados de la query formateados
	 */

	public function getColegios($colegio = null, $general = false)
	{

		$condiciones = array();
		$this->Colegio       = ClassRegistry::init('Colegio');

		//condiciones
		$condiciones['Colegio.nivel_count >'] = 0;
		$condiciones['Colegio.activo'] = true;
		if( !empty($colegio) )
		{
			$condiciones['Colegio.nombre like'] = '%'.$colegio.'%';
		}

		//prx($condiciones);

		$resultados			= $this->Colegio->find('all', array(
			'fields'				=> array('id', 'nombre', 'codigo'),
			'conditions'		=> $condiciones,
			'order'				=> array('Colegio.nombre' => 'DESC')
		));

		//prx($resultados);

		/**
		 * Formatea los resultados para ajustarse al autocomplete
		 */
		$colegios		= array();
		foreach ( $resultados as $resultado )
		{
			array_push($colegios, $resultado['Colegio']);
		}


		return $colegios;



	}



	public function getColegios_old($colegio = null, $general = false)
	{
		/**
		 * Obtiene la query
		 */
		$this->Query		= ClassRegistry::init('Query');
		$query				= $this->Query->getProductiva('LISTAS_LISTA_INSTITUCIONES');
		if ( ! $query )
		{
			return false;
		}
		/**
		 * Reemplaza el identificador
		 */
		$sql				= CakeText::insert($query['Query']['query'], array(
			'QUERY_NOMBRE_COLEGIO'		=> mb_strtoupper($colegio)
		));
		$resultados			= null;
		/**
		 * Ejecuta las querys
		 */
		try
		{
			$this->usarDsBooks();
			$resultados = $this->query($sql);
			$this->usarDsLocal();
		}
		catch ( PDOException $error )
		{
			// TODO: Informar error de query
		}
		if ( ! $resultados )
		{
			return false;
		}

		/**
		 * Formatea los resultados para ajustarse al autocomplete
		 */
		$colegios		= array();
		foreach ( $resultados as $resultado )
		{
			array_push($colegios, $resultado[0]);
		}

		return $colegios;
	}



	/**
	 * Summary
	 * @return			object						Description
	 */
	public function obtenerConfiguraciones( $condition = array(), $field = array() )
	{
		$this->Configuracion	= ClassRegistry::init('Configuracion');
		$configuracion			= $this->Configuracion->find('first', array(
			'conditions'			=> $condition,
			'fields'				=> $field
		));

		return array(
			'configuracion' => $configuracion
		);
	}
}
