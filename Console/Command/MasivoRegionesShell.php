<?php
App::uses('View', 'View');
class MasivoRegionesShell extends AppShell
{
	public $uses			= array('Query');
	public $proc			= 'MASIVO_REGIONES';
	public $db				= null;

	public function main()
	{
		$this->db		= ConnectionManager::getDataSource('default')->config['database'];
		$this->Query->usarDsBooks();

		/**
		 * Ejecuta el procedimiento de carga masiva
		 */
		$this->out(sprintf('Ejecutando procedimiento de carga masiva de regiones y comunas en %s', $this->db));
		$procedimiento		= $this->Query->query(sprintf('EXEC [%s].[dbo].[%s]',$this->db, $this->proc));
		$this->hr();

		/**
		 * Ejecuta las estadisticas de ejecucion del procedimiento
		 */
		$estadisticas		= $this->Query->query(sprintf('
			SELECT TOP 1 CONVERT(TIME(3), DATEADD(ms, ROUND(last_elapsed_time / 1000.0, 0), 0)) AS tiempo_ejecucion
			FROM sys.dm_exec_procedure_stats
			WHERE OBJECT_NAME(object_id, database_id) = \'%s\'
			ORDER BY last_execution_time DESC
		', $this->proc));

		/**
		 * Imprime las estadisticas
		 */
		$this->out(sprintf('%s: %s', str_pad('Tiempo de ejecución', 35), $estadisticas[0][0]['tiempo_ejecucion']));
		$this->hr();
	}
}
