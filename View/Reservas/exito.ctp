<div class="contenedor">
	<div class="row">
		<div class="inicio">
			<i class="fa fa-check icon-titulo"></i><h2>COMPRA FINALIZADA CON ÉXITO</h2>
			<p>Te enviamos un correo con el siguiente detalle.</p>
		</div>
		<div class="row inicio">
			<div class="col-sm-12 exito">
				Hola <?= $compra['Usuario']['nombre']; ?>, gracias por preferirnos.
				Si tienes alguna pregunta sobre la <h3>Orden de Compra N° <?= $compra['Compra']['id']; ?></h3>,
				por favor <?= $this->Html->link('contáctenos', array('controller' => 'contactos', 'action' => 'add')); ?>
			</div>
			<div class="col-sm-6 datos-facturacion">
				<h3 class="form-group">Información de facturación y despacho</h3>
				<p><span>Nombre:</span> <?= sprintf('%s %s %s', $compra['Usuario']['nombre'], $compra['Usuario']['apellido_paterno'], $compra['Usuario']['apellido_materno']); ?></p>
				<p><span>Email:</span> <?= $compra['Usuario']['email']; ?></p>
				<? if ( ! empty($compra['Direccion']['id']) ) : ?>
				<p><span>Dirección:</span> <?= sprintf('%s %s %s', $compra['Direccion']['calle'], $compra['Direccion']['numero'], $compra['Direccion']['depto']); ?></p>
				<p><span>Comuna:</span> <?= $compra['Direccion']['Comuna']['nombre']; ?></p>
				<p><span>Región:</span> <?= $compra['Direccion']['Comuna']['Region']['nombre']; ?></p>
				<p><span>Teléfono:</span> <?= vsprintf('%d %d%d%d %d%d%d%d', str_split($compra['Direccion']['telefono'])); ?></p>
				<p><span>Código Postal:</span> <?= $compra['Direccion']['codigo_postal']; ?></p>
				<? endif; ?>
				<p><span>Estado de Compra:</span> <?= $compra['EstadoCompra']['nombre']; ?></p>
				<p><span>Fecha:</span> <?= $compra['Compra']['created']; ?></p>
			</div>
			<div class="col-sm-6 datos-facturacion">
				<h3 class="form-group">Información del pago</h3>
				<? if ( $compra['Compra']['total'] ) : ?>
				<p><span>Método de pago:</span> Webpay Transbank</p>
				<p><span>Moneda de pago:</span> Pesos Chilenos (CLP)</p>
				<p><span>Tipo de Transacción:</span> Venta</p>
				<? else : ?>
				<p><span>Tipo de Transacción:</span> Reserva</p>
				<? endif; ?>
				<p><span>Nombre comercio:</span> Hookipa S.A.</p>
				<p><span>URL comercio:</span> <?= Router::url('/', true); ?></p>
				<p><span>Resultado transacción:</span> <span class="label label-success">Aprobada</span></p>
				<p><span>Orden de compra N°:</span> <?= $compra['Compra']['id']; ?></p>
				<? if ( $compra['Compra']['total'] ) : ?>
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

	<? if ( ! empty($reservas[0]['Reserva']['nombre_colegio']) && $reservas[0]['Reserva']['nombre_colegio'] !== 'Colegio Antofagasta International School AIS' ) : ?>
	<div class="row descuento center" style="text-align: center;">
		<?= $this->Html->image('emails/descuento-reserva.jpg', array('style' => 'margin: 0 auto;')); ?>
	</div>
	<? endif; ?>

	<div class="row" id="no-more-tables">
		<h2>Detalles de la Reserva</h2>

		<? foreach ( $reservas as $reserva ) : ?>
		<table class="table-striped table-condensed cf">
			<thead class="cf">
				<tr>
					<th class="numeric" class="hidden-xs">Imagen</th>
					<th class="numeric">Nombre</th>
					<th class="numeric">Código</th>
					<th class="numeric">Precio</th>
					<th class="numeric">Cantidad</th>
					<th class="numeric">Subtotal</th>
				</tr>
				<tr colspan="7">
					<div class="cabecera-colegio resultado">
						<? $this->Html->image('colegio.jpg', array('class' => 'logoCole img-responsive')); ?>
						<a href="#" class="equis js-eliminar-reserva">x</a>
						<h2><?= sprintf('%s %s', $reserva['Reserva']['nombre_alumno'], $reserva['Reserva']['apellido_alumno']); ?> - <?= h($reserva['Reserva']['nivel']); ?></h2>
						<h3><?= h($reserva['Reserva']['nombre_colegio']); ?></h3>
						<!--
						<h2>
							<? if ( $reserva['Reserva']['reserva'] ) : ?>
							*** ALUMNO RECIBIRÁ PRODUCTOS EN SU SALA ***
							<? else : ?>
							*** APODERADO NO RESERVA, COMPRARÁ EN TIENDA APOQUINDO #6856, LAS CONDES ***
							<? endif; ?>
						</h2>
						-->
						<!--<a href="#" class="edit">Editar</a>-->
					</div>
				</tr>
			</thead>
			<tbody>
				<? foreach ( $compra['DetalleCompra'] as $detalle ) : ?>
				<? if ( $detalle['reserva_id'] == $reserva['Reserva']['id'] ) : ?>
				<tr>
					<td data-title="Imagen:" class="hidden-xs">
						<?= $this->Html->image($this->Hookipa->imagen($detalle['Producto']['codigo']), array('class' => 'img-responsive')); ?>
					</td>
					<td data-title="Nombre:">
						<?= h($detalle['Producto']['articulo']); ?>
					</td>
					<td data-title="Código:" class="isbn"><?= $detalle['Producto']['codigo']; ?></td>
					<td data-title="Precio:" class="precio">$<?= number_format($detalle['precio_unitario'], 0, null, '.'); ?></td>
					<td data-title="Cantidad:"><?= $detalle['cantidad']; ?></td>
					<td data-title="Subtotal:" class="precio js-producto-subtotal">$<?= number_format(($detalle['precio_unitario'] * $detalle['cantidad']), 0, null, '.'); ?></td>
				</tr>
				<? endif; ?>
				<? endforeach; ?>
			</tbody>
		</table>
		<? endforeach; ?>

		<div class="row">
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
		<div class="row">
			<div class="col-sm-8 col-xs-4"></div>
			<div class="col-sm-4 col-xs-8 right">
				<?= $this->Html->link('Volver al inicio', '/', array('class' => 'btn')); ?>
			</div>
		</div>
	</div>

    <div class="legal">
		<h5>Despacho de productos</h5>
		<p>Los despachos se realizan de Arica a Punta Arenas, con tiempos de entrega de 7 días. Los costos de despacho varian dependiendo de la cantidad de productos y la ciudad de destino. Puede ver detalles de valores y tiempos de despacho en la seccion Ayuda - Información de Despacho. </p>
		<p>Condiciones generales de la venta</p>
		<p>Hookipa comprometido en entregar un servicio de calidad ofrece a sus clientes la posibilidad de cambiar los productos adquiridos en un plazo de 10 días corridos desde la fecha de emisión de la boleta, siempre y cuando éstos vengan en el estado original en el cual fueron vendidos. No se realizarán devoluciones de dinero.</p>

		<h5>¿Cómo realizar un cambio?</h5>
		<p>Debe dirigirse a cualquiera de nuestras tiendas con el producto y el original de la BOLETA DE VENTA, escribiendo al reverso de ésta la fecha del cambio, su nombre completo, dirección, RUT y firma.</p>
		<p>Recuerde que para hacer cambios por Garantía Legal, usted cuenta con 3 meses desde la emisión de la boleta de compra y además de 10 días corridos para cambios por cualquier otro motivo.</p>

		<h5>Importante</h5>
		<p>Antes de dirigirse a la tienda para realizar un cambio, sugerimos consultar stock y disponibilidad en nuestro fono clientes (02) 2109190.</p>
		<p>¿Cómo realizo un cambio de una compra por Internet?</p>
		<p>Si requiere cambiar un producto que compró a través de nuestro Sitio Web, comuníquese con nosotros al fono clientes (02) 2109190 o enviando un correo a contacto@hookipa.cl. También puede realizar el cambio en cualquier tienda de Hookipa, presentando la boleta de venta del producto.</p>
		<p>Si quiere anular una compra realizada a través del sitio web, pero el producto ya fue despachado a su destino, deberá pagar adicionalmente el costo del retiro (el mismo valor que pagó por el costo de despacho).</p>
		<p>Si rechaza la entrega del producto por una razón ajena a la responsabilidad de Hookipa, el costo del envío no le será devuelto.</p>
		<p>En caso de devolución, Hookipa se hará cargo del costo de retiro de los productos en los siguientes casos:</p>

		<ul>
			<li>Si el producto recibido no corresponde al solicitado por el cliente.</li>
			<li>Si el producto recibido no corresponde a lo publicado en el Sitio Web</li>
			<li>Si el producto recibido está dańado o tiene algún defecto de impresión o falla de fábrica.</li>
		</ul>
		<p>Recuerde que sin boleta no se aceptan cambios y no podrá hacer uso de su garantía legal.</p>

		<h5>CONSERVE SU BOLETA.</h5>
	</div>
</div>
