<?
$this->PhpExcel->createWorksheet();
//$this->PhpExcel->setDefaultFont('Calibri', 12);

/* Define las cabeceras */
$cabeceras		= array(
	'Tipo Usuario', 'Nombre', 'Apellido Paterno', 'Apellido Materno',
	'Sexo', 'Email', 'Celular', 'Fono', 'Fecha Nacimiento', 'Fecha registro'
);
$labels			= array();
$opciones		= array('width' => 'auto', 'filter' => true, 'wrap' => true);
foreach ( $cabeceras as $cabecera )
{
	array_push($labels, array_merge(array('label' => $cabecera), $opciones));
}
$this->PhpExcel->addTableHeader($labels, array('bold' => true));

/* Datos */
$sexo		= array(
	0 => 'Hombre',
	1 => 'Mujer'
);
foreach ( $usuarios as $usuario )
{
	$this->PhpExcel->addTableRow(array(
		$usuario['TipoUsuario']['nombre'],
		$usuario['Usuario']['nombre'],
		$usuario['Usuario']['apellido_paterno'],
		$usuario['Usuario']['apellido_materno'],
		($usuario['Usuario']['genero'] ? $sexo[$usuario['Usuario']['genero']] : ''),
		$usuario['Usuario']['email'],
		$usuario['Usuario']['celular'],
		$usuario['Usuario']['fono'],
		$usuario['Usuario']['fecha_nacimiento'],
		$usuario['Usuario']['created'],
	));
}

/* Crea el documento */
$this->PhpExcel->addTableFooter();
$fecha			=  date('Y-m-d_H_i');
$this->PhpExcel->output(sprintf('BYB_Reporte_Usuarios_%s.xls', $fecha));
