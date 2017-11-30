<div class="contenedor">
    <div class="row">
		<?= $this->element('menu_lateral_usuario'); ?>
		<div class="col-sm-9 contenido">
			<h2>Mis Compras - Detalle OC <?= $compra['Compra']['id']; ?></h2>

			<div class="row">
				<div class="col-sm-12 datos-facturacion">
					<h3 style="width: 100%;">Información de facturación y despacho</h3>
					<p><span>Nombre:</span> <?= sprintf('%s %s %s', $compra['Usuario']['nombre'], $compra['Usuario']['apellido_paterno'], $compra['Usuario']['apellido_materno']); ?></p>
					<p><span>Email:</span> <a href="mailto:<?= $compra['Usuario']['email']; ?>"><?= $compra['Usuario']['email']; ?></a></p>
					<? if ( ! empty($compra['Direccion']['id']) ) : ?>
					<p><span>Dirección:</span> <?= sprintf('%s %s %s', $compra['Direccion']['calle'], $compra['Direccion']['numero'], $compra['Direccion']['depto']); ?></p>
					<p><span>Comuna:</span> <?= $compra['Direccion']['Comuna']['nombre']; ?></p>
					<p><span>Región:</span> <?= $compra['Direccion']['Comuna']['Region']['nombre']; ?></p>
					<p><span>Teléfono:</span> <?= vsprintf('%d %d%d%d %d%d%d%d', str_split($compra['Direccion']['telefono'])); ?></p>
					<p><span>Código Postal:</span> <?= $compra['Direccion']['codigo_postal']; ?></p>
					<? endif; ?>
					<p><span>Fecha:</span> <?= $compra['Compra']['created']; ?></p>
				</div>
				<div class="col-sm-12 datos-facturacion">
					<h3 style="width: 100%;">Información del pago</h3>
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

			<div class="datos-facturacion">
				<h3 style="width: 100%;">Detalle de la compra</h3>
				<div class="row" id="no-more-tables">
					<table class="table-striped table-condensed cf" style="width: 100%; margin: 0;">
						<thead class="cf">
							<tr>
								<th class="numeric" class="hidden-xs">Imagen</th>
								<th class="numeric">Nombre</th>
								<th class="numeric">Código</th>
								<th class="numeric">Modalidad</th>
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
										$this->Html->image($this->Hookipa->imagen($detalle['Producto']['codigo']), array('class' => 'img-responsive')),
										array('action' => 'view', $detalle['Producto']['codigo']),
										array('escape' => false)
									); ?>
								</td>
								<td data-title="Nombre:">
									<?= $this->Html->link(
										$detalle['Producto']['articulo'],
										array('controller' => 'productos', 'action' => 'view', $detalle['Producto']['codigo'])
									); ?>
								</td>
								<td data-title="Código:" class="isbn"><?= $detalle['Producto']['codigo']; ?></td>
								<td data-title="Modalidad:">
									<? if ( $detalle['arriendo'] ) : ?>
									<span class="label label-warning">Arriendo</span>
									<? else : ?>
									<span class="label label-success">Venta</span>
									<? endif; ?>
								</td>
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

			<? if ( $compra['Despacho'] ) : ?>
			<div class="datos-facturacion">
				<h3 style="width: 100%;">Información de Despacho</h3>
				<div class="row" id="no-more-tables">
					<table class="table-striped table-condensed cf" style="width: 100%; margin: 0;">
						<thead>
							<th>Nro OT</th>
							<th>Evento</th>
							<th>Fecha</th>
							<!--
							<th>Oficina</th>
							<th>Destino</th>
							-->
							<th>Observación</th>
							<!--
							<th>Nro TCC</th>
							-->
						</thead>
						<tbody>
							<? foreach ( $compra['Despacho'] as $despacho ) : ?>
							<tr>
								<td><?= $despacho['nro_ot']; ?></td>
								<td><?= $despacho['evento']; ?></td>
								<td><?= $despacho['fecha_completa_evento']; ?></td>
								<!--
								<td><?= $despacho['oficina']; ?></td>
								<td><?= $despacho['destino']; ?></td>
								-->
								<td><?= $despacho['observacion']; ?></td>
								<!--
								<td><?= $despacho['nro_tcc']; ?></td>
								-->
							</tr>
							<? endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<? endif; ?>
		</div>
	</div>
</div>
