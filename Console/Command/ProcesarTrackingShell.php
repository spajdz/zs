<?php
App::uses('Folder', 'Utility');
class ProcesarTrackingShell extends AppShell
{
	public $cliente_nombre		= 'BookandBits';
	public $cliente_id			= '[0-9]+';
	public $uses				= array('Compra', 'Despacho');

	public function main()
	{
		$dir			= new Folder(APP . implode(DS, array('Vendor', 'Chilexpress')));
		$csvs			= $dir->find(sprintf('%s_%s_[0-9]+\.csv$', $this->cliente_nombre, $this->cliente_id), true);

		/**
		 * Procesa los archivos
		 */
		foreach ( $csvs as $csv )
		{
			/**
			 * Abre el archivo para lectura
			 */
			$archivo		= new File($dir->pwd() . DS . $csv);
			if ( ( $gestor = fopen($archivo->path, 'r') ) !== FALSE )
			{
				/**
				 * Lee linea por linea
				 */
				while ( ( $datos = fgetcsv($gestor, 0, '|') ) !== FALSE )
				{
					/**
					 * Si la cuenta de datos es incorrecta o no viene referenciada la OC, saltar registro
					 */
					if ( empty($datos[1]) )
					{
						continue;
					}

					/**
					 * Comprueba si existe la OC
					 */
					$buscar_oc			= preg_match('/[0-9]{5}/', $datos[1], $oc);
					if ( empty($oc) )
					{
						continue;
					}
					$oc					= $oc[0];
					$compra				= $this->Compra->find('first', array(
						'fields'			=> array('Compra.id'),
						'conditions'		=> array('Compra.id' => (int) $oc),
						'callbacks'			=> false
					));

					/**
					 * Si no existe la OC referenciada, saltar registro
					 */
					if ( ! $compra )
					{
						continue;
					}

					/**
					 * Guarda el registro del despacho
					 */
					$data			= array(
						'compra_id'					=> $compra['Compra']['id'],
						'nro_ot'					=> utf8_encode($datos[0]),
						'nro_referencia'			=> utf8_encode($datos[1]),
						'nro_ot_padre'				=> utf8_encode($datos[2]),
						'codigo_evento'				=> utf8_encode($datos[3]),
						'evento'					=> utf8_encode($datos[4]),
						'fecha_completa_evento'		=> utf8_encode($datos[5]),
						'fecha_evento'				=> utf8_encode($datos[6]),
						'hora_evento'				=> utf8_encode($datos[7]),
						'codigo_oficina'			=> utf8_encode($datos[8]),
						'oficina'					=> utf8_encode($datos[9]),
						'destino'					=> utf8_encode($datos[10]),
						'fecha_completa_recepcion'	=> utf8_encode($datos[11]),
						'fecha_recepcion'			=> utf8_encode($datos[12]),
						'hora_recepcion'			=> utf8_encode($datos[13]),
						'ruta_recepcion'			=> utf8_encode($datos[14]),
						'nombre_recepcion'			=> utf8_encode($datos[15]),
						'observacion'				=> utf8_encode($datos[16]),
						'motivo'					=> utf8_encode($datos[17]),
						'nro_tcc'					=> utf8_encode($datos[18]),
						'archivo'					=> $csv
					);
					$this->Despacho->create();
					$despacho		= $this->Despacho->save($data);
					/*
					if ( ! $despacho )
					{
						$this->out(sprintf('OC %d existe, pero despacho no se guardó. Datos:', $compra['Compra']['id']));
						pr($data);
					}
					*/
				}

				/**
				 * Renombra el archivo
				 */
				$archivo->copy(sprintf('%s.bak', $archivo->path));
				$archivo->delete();
			}
		}

		$this->out('OK');
	}

	/**
	 * Retorna los archivos .bak a su nombre original
	 */
	public function restore()
	{
		$dir			= new Folder(APP . implode(DS, array('Vendor', 'Chilexpress')));
		$csvs			= $dir->find(sprintf('%s_%s_[0-9]+\.csv\.bak$', $this->cliente_nombre, $this->cliente_id), true);

		foreach ( $csvs as $bak )
		{
			$nombre			= explode('.', $bak);
			array_pop($nombre);
			$csv			= implode('.', $nombre);
			$archivo		= new File($dir->pwd() . DS . $bak);
			$archivo->copy(sprintf('%s%s%s', $dir->pwd(), DS, $csv));
			$archivo->delete();
		}

		$this->out('OK');
	}
}
