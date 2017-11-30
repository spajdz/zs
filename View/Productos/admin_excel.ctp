<?
/* Crea el documento */
$this->PhpExcel->createWorksheet();
//$this->PhpExcel->setDefaultFont('Calibri', 12);

/* Define las cabeceras */
$cabeceras		= array(
	'ID Catálogo', 'Código', 'ISBN', 'Precio', 'Nombre',
	'Talla', 'Código Artículo', 'Código Talla', 'Código Colegio',
	'Stock', 'Activo', 'Imagen'
);
$labels			= array();
$opciones		= array('width' => 'auto', 'filter' => true, 'wrap' => true);
foreach ( $cabeceras as $cabecera )
{
	array_push($labels, array_merge(array('label' => $cabecera), $opciones));
}

$this->PhpExcel->addTableHeader($labels, array('bold' => true));

/* Datos */
foreach ( $productos as $producto )
{
	$this->PhpExcel->addTableRow(array(
		$producto['Producto']['id'],
		$producto['Producto']['codigo'],
		$producto['Producto']['isbn'],
		$producto['Producto']['precio'],
		$producto['Producto']['nombre'],
		$producto['Producto']['talla'],
		$producto['Producto']['codigo_articulo'],
		$producto['Producto']['codigo_talla'],
		$producto['Producto']['codigo_colegio'],
		$producto['Producto']['stock'],
		($producto['Producto']['activo'] ? 'Si' : 'No'),
		$this->Hookipa->imagen($producto['Producto']['codigo'], false)
	));
}

/* Crea el documento */
$this->PhpExcel->addTableFooter();
$fecha			=  date('Y-m-d_H_i');
$this->PhpExcel->output("Reporte_Productos_{$fecha}.xls");
