<?
	// Instancia de la libreria PhpExcel
	$this->PhpExcel->createWorksheet();

	/** Definicion de la cabeceras*/
	$cabeceras		= array(
		'Número OC', 'Nombre', 'E-mail', 'Total', 'Estado', 'Fecha'
	);
	$labels			= array();
	$opciones		= array('width' => 'auto', 'filter' => true, 'wrap' => true);
	foreach ( $cabeceras as $cabecera )
	{
		array_push($labels, array_merge(array('label' => $cabecera), $opciones));
	}
	$this->PhpExcel->addTableHeader($labels, array('bold' => true));

	/** DATOS */
	foreach ( $compras AS $compra )
	{
		$this->PhpExcel->addTableRow(array(
			$compra['Compra']['id'],
			sprintf('%s %s %s', $compra['Usuario']['nombre'], $compra['Usuario']['apellido_paterno'], $compra['Usuario']['apellido_materno']),
			$compra['Usuario']['email'],
			$compra['Compra']['total'],
			explode(' ', $compra['EstadoCompra']['nombre'])[0],
			$compra['Compra']['created']
		));
	}

	/* Crea el documento */
		$this->PhpExcel->addTableFooter();
		$fecha			=  date('Y-m-d_H_i');
		$this->PhpExcel->output(sprintf('Listado_OC_%s.xls', $fecha));

?>
