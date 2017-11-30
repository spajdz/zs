<div class="contenedor">
    <div class="row">
		<?= $this->element('menu_lateral_usuario'); ?>
		<div class="col-sm-9 contenido">
			<h2>Mis Compras</h2>

			<div class="row" id="no-more-tables">
				<table class="table-striped table-condensed cf">
					<thead class="cf">
						<tr>
							<th>Número OC</th>
							<th>Dirección</th>
							<th>Subtotal</th>
							<th>Valor despacho</th>
							<th>Total</th>
							<th>Estado</th>
							<th>Fecha</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ( $compras as $compra ) : ?>
						<tr>
							<td><?= h($compra['Compra']['id']) ?></td>
							<? if ( ! empty($compra['Direccion']['calle']) ) : ?>
							<td><?= sprintf('%s %s %s', $compra['Direccion']['calle'], $compra['Direccion']['numero'], $compra['Direccion']['depto']); ?></td>
							<? else : ?>
							<td>N/A</td>
							<? endif; ?>
							<td>$<?= number_format($compra['Compra']['subtotal'], 0, ',', '.'); ?></td>
							<td>$<?= number_format($compra['Compra']['valor_despacho'], 0, ',', '.'); ?></td>
							<td>$<?= number_format($compra['Compra']['total'], 0, ',', '.'); ?></td>
							<td><?= h($compra['EstadoCompra']['nombre']); ?></td>
							<td><?= h($compra['Compra']['created']) ?></td>
							<td>
								<?= $this->Html->link('Ver', array('action' => 'view', $compra['Compra']['id']), array('class' => 'btn btn-xs btn-info', 'escape' => false, 'style' => 'padding: 5px 15px;')); ?>
							</td>
						</tr>
						<? endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
