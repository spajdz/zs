<div class="page-title">
	<h2><span class="fa fa-list-ol"></span> Compras</h2>
</div>

<div class="page-content-wrap">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Detalle OC <?= $compra['Compra']['id']; ?></h3>
			<div class="btn-group pull-right">
				<? if ( $compra['Compra']['estado_compra_id'] == 4 && $compra['Compra']['tbk_tipo_pago'] != 'VD') : ?>
				<?= $this->Html->link('<i class="fa fa-dollar"></i> Anular compra', array('action' => 'anular', $compra['Compra']['id']), array('class' => 'btn btn-danger', 'escape' => false)); ?>
				<? endif; ?>
			</div>
		</div>
		<div class="panel-body">
			<div class="contenedor">
				<div class="row">
					<div class="col-sm-6 datos-facturacion">
						<h3 class="form-group">Información de facturación y despacho</h3>
						<p><span>Nombre:</span> <?= sprintf('%s %s %s', $compra['Usuario']['nombre'], $compra['Usuario']['apellido_paterno'], $compra['Usuario']['apellido_materno']); ?></p>
						<? if(!empty($compra['Usuario']['celular'])):?>
						<p><span>Celular:</span> <?= $compra['Usuario']['celular']; ?></p>
						<?endif;?>
						<p><span>Email:</span> <a href="mailto:<?= $compra['Usuario']['email']; ?>"><?= $compra['Usuario']['email']; ?></a></p>
						<?if(!empty($compra['Compra']['retiro_tienda'])):?>
							<p><span>Tienda de Retiro:</span> <?= ucfirst(str_replace('-', ' ', $compra['Sucursal']['slug'])) ?></p>
						<?endif;?>  
						<?if(!empty($compra['Compra']['observacion_retiro'])):?>
							<p><span>Observación de Retiro:</span> <?= $compra['Compra']['observacion_retiro'] ?></p>
						<?endif;?>  
						<? if ( ! empty($compra['Direccion']['id']) ) : ?>
						<p><span>Dirección:</span> <?= sprintf('%s %s %s', $compra['Direccion']['calle'], $compra['Direccion']['numero'], $compra['Direccion']['depto']); ?></p>
						<p><span>Comuna:</span> <?= $compra['Direccion']['Comuna']['nombre']; ?></p>
						<p><span>Región:</span> <?= $compra['Direccion']['Comuna']['Region']['nombre']; ?></p>
						<p><span>Teléfono:</span> <?= vsprintf('%d %d%d%d %d%d%d%d', str_split($compra['Direccion']['telefono'])); ?></p>
						<p><span>Código Postal:</span> <?= $compra['Direccion']['codigo_postal']; ?></p>
						<? endif; ?>
						<p><span>Fecha:</span> <?= $compra['Compra']['created']; ?></p>
						<? if ( ! empty($compra['Direccion']['observaciones']) ) : ?>
							<p><span>Referencia: </span> <?= $compra['Direccion']['observaciones']; ?></p>
						<? endif; ?>
					</div>
					<div class="col-sm-6 datos-facturacion">
						<h3 class="form-group">Información del pago</h3>
						<p><span>OC Transbank:</span> <?= $compra['Compra']['tbk_orden_compra']; ?></p>
						<p><span>Estado de Compra:</span> <?= $compra['EstadoCompra']['nombre']; ?></p>
						<? if ( ! empty($compra['Compra']['tbk_codigo_autorizacion']) ) : ?>
						<p><span>Código de autorización:</span> <?= $compra['Compra']['tbk_codigo_autorizacion']; ?></p>
						<p><span>Fecha:</span> <?= $compra['Compra']['tbk_fecha_transaccion']; ?> <?= $compra['Compra']['tbk_hora_transaccion']; ?></p>
						<p><span>Número de tarjeta:</span> **** **** **** <?= $compra['Compra']['tbk_final_numero_tarjeta']; ?></p>
						<p><span>Tipo de Pago:</span> <?= $compra['Compra']['tipo_pago']; ?></p>
						<p><span>Tipo de Cuotas:</span> <?= $compra['Compra']['tipo_cuota']; ?></p>
						<p><span>Número Cuotas:</span> <?= (empty($compra['Compra']['tbk_numero_cuotas']) ? '00' : $compra['Compra']['tbk_numero_cuotas']); ?></p>
						<? endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Detalle Productos</h3>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-condensed cf">
				<thead class="cf">
					<tr>
						<th class="numeric" class="hidden-xs">Imagen</th>
						<th class="numeric">Nombre</th>
						<th class="numeric">Código</th>
						<th class="numeric">Precio</th>
						<th class="numeric">Cantidad</th>
						<th class="numeric">Subtotal</th>
					</tr>
				</thead>
				<tbody>
					<? foreach ( $compra['DetalleCompra'] as $detalle ) : ?>
					<tr>
						<td data-title="Imagen:" class="hidden-xs">
							<?= $this->Html->link(
								$this->Html->image($this->App->imagen($detalle['Producto']['sku']), array('class' => 'img-responsive')),
								array('action' => 'view', $detalle['Producto']['sku']),
								array('escape' => false)
							); ?>
						</td>
						<td data-title="Nombre:">
							<?= $this->Html->link(
								$detalle['Producto']['nombre'],
								array('controller' => 'productos', 'action' => 'view', $detalle['Producto']['sku'])
							); ?>
						</td>
						<td data-title="Código:" class="isbn"><?= $detalle['Producto']['sku']; ?></td>
						<td data-title="Precio:" class="precio">$<?= number_format($detalle['precio_unitario'], 0, null, '.'); ?></td>
						<td data-title="Cantidad:"><?= $detalle['cantidad']; ?></td>
						<td data-title="Subtotal:" class="precio js-producto-subtotal">$<?= number_format(($detalle['precio_unitario'] * $detalle['cantidad']), 0, null, '.'); ?></td>
					</tr>
					<? endforeach; ?>
				</tbody>
				<tfoot style="text-align: right;">
					<tr>
						<th colspan="6" style="text-align: right;">Subtotal:</th>
						<td>$<?= number_format($compra['Compra']['subtotal'], 0, null, '.'); ?></td>
					</tr>
					<tr>
						<th colspan="6" style="text-align: right;">Valor despacho:</th>
						<td>$<?= number_format($compra['Compra']['valor_despacho'], 0, null, '.'); ?></td>
					</tr>
					<tr>
						<th colspan="6" style="text-align: right;">Total:</th>
						<td>$<?= number_format($compra['Compra']['total'], 0, null, '.'); ?></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
