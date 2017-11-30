<?= $this->Html->script(array('productos.carro'), array('inline' => false)) ;?>

<div class="contenedor">
	<div class="row cont-pasos">
		<div class="col-xs-4">
			<div class="pasos-carro">
				<span class="visible-xs">Paso 01</span>
				<h3><span>01</span> Confirma tu Compra</h3>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="pasos-carro">
				<span class="visible-xs">Paso 02</span>
				<h3><span>02</span> Ingresa tu Dirección</h3>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="pasos-carro no-margin active">
				<span class="visible-xs">Paso 03</span>
				<h3><span>03</span> Finaliza tu Compra</h3>
			</div>
		</div>
	</div>
	<h2 class="datos">Datos de la Orden de Compra N° <?= $compra['Compra']['id']; ?></h2>
	<div class="row datos-personales">
		<div class="col-sm-6"><div class="form-group"><p><span>Nombre:</span> <?= sprintf('%s %s %s', $compra['Usuario']['nombre'], $compra['Usuario']['apellido_paterno'], $compra['Usuario']['apellido_materno']); ?></p></div></div>
		<div class="col-sm-6"><div class="form-group"><p><span>Email:</span> <?= $compra['Usuario']['email']; ?></p></div></div>
		<? if ( ! empty($compra['Direccion']['id']) ) : ?>
		<div class="col-sm-6"><div class="form-group"><p><span>Dirección:</span> <?= sprintf('%s %s %s', $compra['Direccion']['calle'], $compra['Direccion']['numero'], $compra['Direccion']['depto']); ?></p></div></div>
		<div class="col-sm-6"><div class="form-group"><p><span>Comuna:</span> <?= $compra['Direccion']['Comuna']['nombre']; ?></p></div></div>
		<div class="col-sm-6"><div class="form-group"><p><span>Región:</span> <?= $compra['Direccion']['Comuna']['Region']['nombre']; ?></p></div></div>
		<div class="col-sm-6"><div class="form-group"><p><span>Teléfono:</span> <?= vsprintf('%d %d%d%d %d%d%d%d', str_split($compra['Direccion']['telefono'])); ?></p></div></div>
		<div class="col-sm-6"><div class="form-group"><p><span>Código Postal:</span> <?= $compra['Direccion']['codigo_postal']; ?></p></div></div>
		<? endif; ?>
		<div class="col-sm-6"><div class="form-group"><p><span>Estado de Compra:</span> <?= $compra['EstadoCompra']['nombre']; ?></p></div></div>
		<div class="col-sm-6"><div class="form-group"><p><span>Fecha:</span> <?= $compra['Compra']['created']; ?></p></div></div>
	</div>

	<div class="row" id="no-more-tables">
		<table class="table-striped table-condensed cf">
			<thead class="cf">
				<tr>
					<th class="numeric" class="hidden-xs">Imagen</th>
					<th class="numeric">Nombre</th>
					<th class="numeric">SKU</th>
					<th class="numeric">Precio</th>
					<th class="numeric">Cantidad</th>
					<th class="numeric">Subtotal</th>
				</tr>
			</thead>
			<tbody>
				<? foreach ( $compra['DetalleCompra'] as $detalle ) : ?>
				<tr class="js-contenedor-producto">
					<td data-title="Imagen:" class="hidden-xs">
						<?= $this->Html->link(
							$this->Html->image($this->App->imagen($detalle['Producto']['sku']), array('class' => 'img-responsive img-carro')),
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
					<td data-title="Precio:" class="precio">$ <?= number_format($detalle['precio_unitario'], 0, null, '.'); ?></td>
					
					<td data-title="Cantidad:"><?= $detalle['cantidad']; ?></td>
					<td data-title="Subtotal:" class="precio js-producto-subtotal">$ <?= number_format(($detalle['precio_unitario'] * $detalle['cantidad']), 0, null, '.'); ?></td>
				</tr>
				<? endforeach; ?>
			</tbody>
		</table>
		<div class="row padd20">
			<div class="col-sm-4 suma-compra">
				<p>Subtotal : $<?= number_format($compra['Compra']['subtotal'], 0, null, '.'); ?></p>
			</div>
			<div class="col-sm-4 suma-compra">
				<p>Despacho: $<?= number_format($compra['Compra']['valor_despacho'], 0, null, '.'); ?></p>
			</div>
			<div class="col-sm-4 total-compra">
				<p>Total compra: $<?= number_format($compra['Compra']['total'], 0, null, '.'); ?></p>
			</div>
		</div>
		<div class="row padd20">
			<div class="col-sm-8 col-xs-12">
				<?= $this->Html->link('volver', array('controller' => 'direcciones', 'action' => 'add'), array('class' => 'btn')); ?>
			</div>
			<div class="col-sm-4 col-xs-12 right">
				<?= $this->Html->image('logo-webpay.jpg', array('class' => 'logo-webpay')); ?>
				<?= $this->Html->link('Pagar', array('controller' => 'compras', 'action' => 'webpay'), array('class' => 'btn')); ?>
			</div>
		</div>
	</div>
</div>
