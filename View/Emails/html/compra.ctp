<tr>
	<td bgcolor="#FFFFFF" align="left" height="60">
		<font face="Arial" color="#2C5496" size="+3">
			NOTIFICACIÓN DE COMPRA
		</font>
	</td>
</tr>
<tr>
	<td align="center" height="100" bgcolor="#2C5496">
		<font face="Arial" size="+2" color="#FFFFFF">
			<b>
				Compra realizada con éxito.<br>
				¡Gracias por preferir Hookipa!<br>
				Recuerda que nuestro tiempo de entrega es de 10 días. Te mantendremos informado del estado de tu compra.
			</b>
		</font>
	</td>
</tr>
<tr>
	<td bgcolor="#2C5496"><?= $this->Html->image('emails/producto.jpg', array('fullBase' => true)); ?></td>
</tr>
<tr>
	<td height="15" align="center" bgcolor="#FFFFFF">
		<table width="90%" border="0" cellpadding="0" cellspacing="10">
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Orden de Compra:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= $compra['Compra']['id']; ?></font></td>
			</tr>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>OC Transbank:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= $compra['Compra']['tbk_orden_compra']; ?></font></td>
			</tr>
			<? if ( $compra['Compra']['lista'] || $compra['Compra']['reserva'] ) : ?>
				<tr>
					<td><font face="Arial" color="#555555" size="-1"><b>Código Colegio:</b></font></td>
					<td><font face="Arial" color="#555555" size="-1"><?= h($compra['Colegio']['codigo_colegio']); ?></font></td>
				</tr>
				<tr>
					<td><font face="Arial" color="#555555" size="-1"><b>Nombre Colegio:</b></font></td>
					<td><font face="Arial" color="#555555" size="-1"><?= h($compra['Colegio']['nombre_colegio']); ?></font></td>
				</tr>
			<? endif; ?>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Nombre Comprador:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= sprintf('%s %s %s', $compra['Usuario']['nombre'], $compra['Usuario']['apellido_paterno'], $compra['Usuario']['apellido_materno']); ?></font></td>
			</tr>

			<? if(!empty($compra['Usuario']['celular'])):?>
				<tr>
					<td><font face="Arial" color="#555555" size="-1"><b>Celular Comprador:</b></font></td>
					<td><font face="Arial" color="#555555" size="-1"><?= $compra['Usuario']['celular']; ?></font></td>
				</tr>
			<?endif;?>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Email:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= $compra['Usuario']['email']; ?></font></td>
			</tr>
			<?if($compra['Compra']['retiro_tienda']):?>
				<tr>
					<td><font face="Arial" color="#555555" size="-1"><b>Tienda de Retiro:</b></font></td>
					<td><font face="Arial" color="#555555" size="-1"><?= ucwords(str_replace('-', ' ', $compra['Sucursal']['slug']))?></font></td>
				</tr>
			<?endif;?>
			<? if ( ! empty($compra['Direccion']['id']) ) : ?>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Dirección:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= sprintf('%s %s %s', $compra['Direccion']['calle'], $compra['Direccion']['numero'], $compra['Direccion']['depto']); ?></font></td>
			</tr>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Comuna:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= $compra['Direccion']['Comuna']['nombre']; ?></font></td>
			</tr>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Región:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= $compra['Direccion']['Comuna']['Region']['nombre']; ?></font></td>
			</tr>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Teléfono:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= vsprintf('%d %d%d%d %d%d%d%d', str_split($compra['Direccion']['telefono'])); ?></font></td>
			</tr>
			<? endif; ?>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Código Postal:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= $compra['Direccion']['codigo_postal']; ?></font></td>
			</tr>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Estado de Compra:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= $compra['EstadoCompra']['nombre']; ?></font></td>
			</tr>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Fecha:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= $compra['Compra']['created']; ?></font></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td height="7" align="center" bgcolor="#FFFFFF"><?= $this->Html->image('emails/detalle-compra.jpg', array('fullBase' => true)); ?></td>
</tr>
<tr>
	<td height="8" align="center" bgcolor="#FFFFFF">
		<table width="90%" border="0" cellspacing="5" cellpadding="5">
			<tr>
				<td bgcolor="#2C5496" align="center"><font face="Arial" color="#FFFFFF" size="-1"><b>Colegio</b></font></td>
				<td bgcolor="#2C5496" align="center"><font face="Arial" color="#FFFFFF" size="-1"><b>Código</b></font></td>
				<td bgcolor="#2C5496" align="center"><font face="Arial" color="#FFFFFF" size="-1"><b>Título</b></font></td>
				<td bgcolor="#2C5496" align="center"><font face="Arial" color="#FFFFFF" size="-1"><b>Precio</b></font></td>
				<td bgcolor="#2C5496" align="center"><font face="Arial" color="#FFFFFF" size="-1"><b>Cantidad</b></font></td>
				<td bgcolor="#2C5496" align="center"><font face="Arial" color="#FFFFFF" size="-1"><b>Subtotal</b></font></td>
			</tr>
			<? foreach ( $compra['DetalleCompra'] as $detalle ) : ?>
			<tr>
				<td align="center">
					<?if(!empty($detalle['Producto']['Colegio'])):?>
						<font face="Arial" color="#555555" size="-1"><?= $detalle['Producto']['Colegio']['nombre']; ?></font>
					<?endif;?>
				</td>
				<td align="center"><font face="Arial" color="#555555" size="-1"><?= $detalle['Producto']['codigo']; ?></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= h($detalle['Producto']['articulo']); ?></font></td>
				<td align="right"><font face="Arial" color="#555555" size="-1">$<?= number_format($detalle['precio_unitario'], 0, null, '.'); ?></font></td>
				<td align="center"><font face="Arial" color="#555555" size="-1"><?= $detalle['cantidad']; ?></font></td>
				<td align="right"><font face="Arial" color="#555555" size="-1">$<?= number_format(($detalle['precio_unitario'] * $detalle['cantidad']), 0, null, '.'); ?></font></td>
			</tr>
			<? endforeach; ?>
			<tr>
				<td height="0px" colspan="6" align="center" bgcolor="#2C5496"></td>
			</tr>
			<? if ( ! $compra['Compra']['reserva'] ) : ?>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><font face="Arial" color="#555555" size="-1">Subtotal</font></td>
				<td align="right"><font face="Arial" color="#555555" size="-1">$<?= number_format($compra['Compra']['subtotal'], 0, null, '.'); ?></font></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><font face="Arial" color="#555555" size="-1">Despacho</font></td>
				<td align="right"><font face="Arial" color="#555555" size="-1">$<?= number_format($compra['Compra']['valor_despacho'], 0, null, '.'); ?></font></td>
			</tr>
			<? endif; ?>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><font face="Arial" color="#555555" size="-1">Total</font></td>
				<td align="right"><font face="Arial" color="#555555" size="-1">$<?= number_format($compra['Compra']['total'], 0, null, '.'); ?></font></td>
			</tr>
		</table>
	</td>
</tr>
<? if ( $compra['Compra']['total'] ) : ?>
<tr>
	<td><?= $this->Html->image('emails/detalle-pago.jpg', array('fullBase' => true)); ?></td>
</tr>
<tr>
	<td>
		<table width="90%" border="0" align="center" cellpadding="5" cellspacing="5">
			<tr>
				<td width="33%" bgcolor="#2C5496" align="center"><font face="Arial" color="#FFFFFF" size="-1"><b>Método de pago</b></font></td>
				<td width="34%" bgcolor="#2C5496" align="center"><font face="Arial" color="#FFFFFF" size="-1"><b>Código de autorización</b></font></td>
				<td width="33%" bgcolor="#2C5496" align="center"><font face="Arial" color="#FFFFFF" size="-1"><b>Número de tarjeta</b></font></td>
			</tr>
			<tr>
				<td align="center"><font face="Arial" color="#555555" size="-1">Webpay Transbank</font></td>
				<td align="center"><font face="Arial" color="#555555" size="-1"><?= $compra['Compra']['tbk_codigo_autorizacion']; ?></font></td>
				<td align="center"><font face="Arial" color="#555555" size="-1">**** **** **** <?= $compra['Compra']['tbk_final_numero_tarjeta']; ?></font></td>
			</tr>
			<tr>
				<td bgcolor="#2C5496" align="center"><font face="Arial" color="#FFFFFF" size="-1"><b>Tipo de Pago</b></font></td>
				<td bgcolor="#2C5496" align="center"><font face="Arial" color="#FFFFFF" size="-1"><b>Tipo de Cuotas</b></font></td>
				<td bgcolor="#2C5496" align="center"><font face="Arial" color="#FFFFFF" size="-1"><b>Número Cuotas</b></font></td>
			</tr>
			<tr>
				<td align="center"><font face="Arial" color="#555555" size="-1"><?= $compra['Compra']['tipo_pago']; ?></font></td>
				<td align="center"><font face="Arial" color="#555555" size="-1"><?= $compra['Compra']['tipo_cuota']; ?></font></td>
				<td align="center"><font face="Arial" color="#555555" size="-1"><?= (empty($compra['Compra']['tbk_numero_cuotas']) ? '00' : $compra['Compra']['tbk_numero_cuotas']); ?></font></td>
			</tr>
		</table>
	</td>
</tr>
<? endif; ?>
<tr>
	<td>
		<table width="90%" border="0" align="center" cellpadding="5" cellspacing="5">
			<tr>
				<td colspan="3" align="center">
					<table border="0" cellpadding="0">
						<tr>
							<td>
								<font face="Arial" color="#999999" size="-2"><p><br>
								<br>
								<strong>Hookipa</strong> comprometido en entregar un servicio de calidad ofrece   a sus clientes la posibilidad de cambiar los productos adquiridos en un plazo   de 10 días corridos desde la fecha de emisión de la boleta, siempre y cuando   éstos vengan en el estado original en el cual fueron vendidos. No se   realizarán devoluciones de dinero. <br>
								<br>
								<strong>¿Cómo realizar un cambio?</strong><br>
								Sólo debe dirigirse a cualquiera de nuestras tiendas con el producto y el   original de la BOLETA DE VENTA, escribiendo al reverso de ésta la fecha del   cambio, su nombre completo, dirección, RUT y firma.<br>
								Recuerde que para hacer cambios por Garantía Legal (linkear con sección   correspondiente) usted cuenta con 3 meses desde la emisión del boleta de   compra y de 10 d&amp;ias corridos para cambios por cualquier otro motivo.<br>
								Importante <br>
								Antes de dirigirse a la tienda para realizar un cambio sugerimos consultar   stock y disponibilidad en nuestro fono clientes (02) 2109190. <br>
								<br>
								<strong>¿Cómo realizo un cambio de una compra por Internet?</strong> <br>
								Si requiere cambiar un producto que comprá a través de nuestro Sitio Web,   comuníquese con nosotros al fono clientes (02) 2109190 o enviando un correo a <a href="mailto:contactoweb@hookipa.cl">contactoweb@hookipa.cl</a>.   También puede realizar el cambio en cualquier tienda de <strong>Hookipa</strong>,   presentando la boleta de venta del producto.<br>
								Si quiere anular una compra realizada a través del sitio web, pero el   producto ya fue despachado a su destino, deberá pagar adicionalmente el costo   del retiro (el mismo valor que pagó por el costo de despacho).<br>
								Si rechaza la entrega del producto por una razón ajena a la responsabilidad   de <strong>Hookipa</strong>, el costo del envío no le será devuelto.<br>
								<br>
								En caso de devolución, <strong>Hookipa</strong> se hará cargo del costo de   retiro de los productos en los siguientes casos:<br>
								» Si el producto recibido no corresponde al solicitado por el cliente<br>
								» Si el producto recibido no corresponde a lo publicado en el Sitio Web<br>
								» Si el producto recibido está dañado o tiene algún defecto de impresión o   falla de fábrica.<br>
								Recuerde que sin boleta no se aceptan cambios y no podrá hacer uso de su   garantía legal.<br>
								CONSERVE SU BOLETA. <br>
								<br>
								Ver más sobre Garantía Legal <a href="http://www.hookipa.cl/ayuda">aquí</a> <br>
								Consideraciones Importantes<br>
								Contamos con cobertura a nivel nacional, con tiempos de entrega de 10 días hábiles a la confirmación de su orden de compra. Los valores dependerán de número de productos que usted este comprando <a href="http://www.hookipa.cl/?seccion=ayuda&id=4">aquí</a> <br>
								<br>
								Los despachos se realizan de lunes a viernes. Los sábados, domingos y festivos no se consideran para el plazo de entrega, retomándose día hábil   siguiente. <br>
								Cuando solicite su despacho recuerde que deberá coordinar que alguna persona recepcione el pedido en su domicilio o dirección de despacho, de lo contrario   el pedido deberá ser entregado al día siguiente.<br>
								Recuerde revisar los datos de despachos ingresados en el registro del sitio web, <strong>Hookipa</strong> no se compromete a cumplir los plazos indicados de   despacho si las direcciones entregadas por el cliente son erróneas.<br>
								Revise su pedido al momento de recepcionarlo, cualquier problema con éste deberá comunicarse de inmediato con nuestro Servicio al Cliente.<br>
								CONSERVE SU BOLETA, recuerde que sin boleta no se aceptan cambios y no podrá hacer uso de su garantía legal. <br>
								</p></font>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>
