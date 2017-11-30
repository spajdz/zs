<?= $this->Html->script(array('productos.carro'), array('inline' => false)) ;?>

<div class="contenedor">
	<div class="row cont-pasos">
		<div class="col-xs-4">
			<div class="pasos-carro active primero">
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
			<div class="pasos-carro no-margin">
				<span class="visible-xs">Paso 03</span>
				<h3><span>03</span> Finaliza tu Compra</h3>
			</div>
		</div>
	</div>
	<?= $this->element('alertas'); ?>
	<div class="row" id="no-more-tables">
		<table class="table-striped table-condensed cf">
			<thead class="cf">
				<tr>
					<th class="numeric" class="hidden-xs">Imagen</th>
					<th class="numeric">Nombre</th>
					<th class="numeric">Código</th>
					<th class="numeric">Precio</th>
					<th class="numeric">Cantidad</th>
					<th class="numeric">Subtotal</th>
					<th class="numeric">Eliminar</th>
				</tr>
			</thead>
			<tbody>
				<? foreach ( $productos as $catalogo => $data ) : ?>
				<? foreach ( $data['Productos'] as $producto ) : ?>
				<tr class="js-contenedor-producto">
					<td data-title="Imagen:" class="hidden-xs">
						<?= $this->Html->image($this->App->imagen($producto['Data']['Producto']['sku']), array('class' => 'img-responsive img-carro')); ?>
					</td>
					<td data-title="Nombre:">
						<?= h($producto['Data']['Producto']['nombre']); ?>
					</td>
					<td data-title="Código:" class="isbn"><?= $producto['Data']['Producto']['sku']; ?></td>
					<td data-title="Precio:" class="precio">$<?= number_format($producto['Data']['Producto']['preciofinal_publico'], 0, null, '.'); ?></td>
					
					<td data-title="Cantidad:">
						<?= $this->Form->input(
							'cantidad',
							array(
								'type'				=> 'number',
								'value'				=> $producto['Meta']['Cantidad'],
								'data-previo'		=> $producto['Meta']['Cantidad'],
								'data-id'			=> $producto['Data']['Producto']['id'],
								'class'				=> 'form-control js-input-cantidad-actualizar',
								'div'				=> false,
								'label'				=> false
							)
						); ?>
					</td>
					<td data-title="Subtotal:" class="precio js-producto-subtotal">$<?= number_format(($producto['Data']['Producto']['preciofinal_publico'] * $producto['Meta']['Cantidad']), 0, null, '.'); ?></td>
					<td data-title="Eliminar:">
						<?= $this->Html->link(
							'x', '#',
							array(
								'class'				=> 'equis js-eliminar-producto',
								'data-id'			=> $producto['Data']['Producto']['id'],
								'data-nombre'		=> h($producto['Data']['Producto']['nombre']),
								'data-imagen'		=> "img/{$this->App->imagen($producto['Data']['Producto']['sku'], true)}"
							)
						); ?>
					</td>
				</tr>
				<? endforeach; ?>
				<? endforeach; ?>
			</tbody>
		</table>
		<div class="row">
			<div class="col-sm-8 agregar">
			</div>
			<div class="col-sm-4 total-compra">
				<p>Subtotal: <span class="js-carro-total-dinero">$<?= number_format($carro['Subtotal'], 0, null, '.'); ?></span></p>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8 col-xs-4">
				<a href="javascript:history.back()" class="btn">volver</a>
			</div>
			<div class="col-sm-4 col-xs-8 right">
				<? if ( $productos ) : ?>
					<?= $this->Html->link('vaciar carro', array('controller' => 'productos', 'action' => 'vaciar'), array('class' => 'vaciar js-accion-carro-1')); ?>
					<?= $this->Html->link('Continuar', array('controller' => 'direcciones', 'action' => 'add'), array('class' => 'btn js-accion-carro-1')); ?>
				<? endif; ?>
			</div>
		</div>
	</div>
</div>
