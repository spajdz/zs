<?php
App::uses('View', 'View');
App::uses('CakeEventManager', 'Event');
class ProcesarEntregaDespachoCompraShell extends AppShell
{
	public $uses			= array('Query', 'Compra');

	public function main()
	{
		/**
		 * Obtiene la query
		 */
		$query				= $this->Query->getProductiva('LISTA_OC_ENTREGA_DESPACHO');
		$sql				= $query['Query']['query'];
		$resultados			= null;
		$this->Query->usarDsBooks();
		$resultados = $this->Query->query($sql);
		$this->Compra->usarDsLocal();
		if ( ! empty($resultados) )
		{
			foreach ( $resultados as $compra )
			{
				$info_compra		= $this->Compra->find('first', array(
					'conditions'		=> array('Compra.id' => $compra[0]['OC']),
					'fields'			=> array(
						'Compra.id',
						'Compra.total',
						'Compra.subtotal',
						'Compra.valor_despacho',
						'Usuario.email',
						'Usuario.nombre',
						'Usuario.apellido_paterno',
						'Usuario.apellido_materno'
					),
					'contain'			=> array(
						'Usuario',
						'DetalleCompra'		=> array(
							'Producto' 			=> array(
								'fields'			=> array(
									'Producto.id',
									'Producto.isbn',
									'Producto.nombre',
									'Producto.descripcion',
									'Producto.idioma',
									'Producto.editorial'
								)
							)
						)
					)
				));
				$this->Compra->id = $info_compra['Compra']['id'];
				$this->Compra->saveField('estado_compra_despacho_id', 2);
				$this->Compra->EnviarCorreoEntregaDespacho($info_compra);
			}
		}
	}
}
