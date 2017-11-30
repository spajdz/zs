<tr>
	<td bgcolor="#FFFFFF" align="left" height="60"><font face="Arial" color="#2C5496"  size="+3">Reserva de textos</font></td>
</tr>
<tr>
	<td align="center" height="100" bgcolor="#2C5496"><font face="Arial" size="+2" color="#FFFFFF"><b>Tu reserva ha sido exitosa<br>Gracias por realizarla en Hookipa</b></font></td>
</tr>
<tr>
	<td><?= $this->Html->image('emails/producto.jpg', array('fullBase' => true)); ?></td>
</tr>
<tr>
	<td height="15" align="center" bgcolor="#FFFFFF">
		<table width="90%" border="0" cellpadding="0" cellspacing="10">
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Fecha:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= $compra['Compra']['created']; ?></font></td>
			</tr>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Código Colegio:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= h($reserva['Reserva']['codigo_colegio']); ?></font></td>
			</tr>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Colegio:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= h($reserva['Reserva']['nombre_colegio']); ?></font></td>
			</tr>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Nivel:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= h($reserva['Reserva']['nivel']); ?></font></td>
			</tr>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Nombre Alumno:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= sprintf('%s %s', $reserva['Reserva']['nombre_alumno'], $reserva['Reserva']['apellido_alumno']); ?></font></td>
			</tr>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Nombre Apoderado:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= sprintf('%s %s %s', $compra['Usuario']['nombre'], $compra['Usuario']['apellido_paterno'], $compra['Usuario']['apellido_materno']); ?></font></td>
			</tr>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Email Apoderado:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= $compra['Usuario']['email']; ?></font></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<font face="Arial" color="#555555" size="+2">
						<b>
							<? if ( $reserva['Reserva']['cantidad'] ) : ?>
							*** ALUMNO RECIBIRÁ PRODUCTOS EN SU SALA ***
							<? else : ?>
							*** APODERADO NO RESERVA, COMPRARÁ EN TIENDA APOQUINDO #6856, LAS CONDES ***
							<? endif; ?>
						</b>
					</font>
				</td>
			</tr>
			<? if ( $reserva['Reserva']['cantidad'] && ! empty($reserva['Reserva']['leyenda']) ) : ?>
			<tr>
				<td colspan="2" align="center">
					<font face="Arial" color="#555555" size="+1">
						<b>
							<?= $reserva['Reserva']['leyenda']; ?>
						</b>
					</font>
				</td>
			</tr>
			<? endif; ?>

			<? if ( $cantidad && ! empty($reserva['Reserva']['nombre_colegio']) && $reserva['Reserva']['nombre_colegio'] !== 'Colegio Antofagasta International School AIS' ) : ?>
			<tr>
				<td colspan="2" align="center">
					<?= $this->Html->image('emails/descuento-reserva.jpg', array('fullBase' => true, 'width' => '85%')); ?>
				</td>
			</tr>
			<? endif; ?>
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
				<td bgcolor="#2C5496" align="center"><font face="Arial" color="#FFFFFF" size="-1"><b>N°</b></font></td>
				<td bgcolor="#2C5496" align="center"><font face="Arial" color="#FFFFFF" size="-1"><b>Código</b></font></td>
				<td bgcolor="#2C5496" align="center"><font face="Arial" color="#FFFFFF" size="-1"><b>Título</b></font></td>
				<td bgcolor="#2C5496" align="center"><font face="Arial" color="#FFFFFF" size="-1"><b>Precio</b></font></td>
				<td bgcolor="#2C5496" align="center"><font face="Arial" color="#FFFFFF" size="-1"><b>Cantidad</b></font></td>
				<td bgcolor="#2C5496" align="center"><font face="Arial" color="#FFFFFF" size="-1"><b>Subtotal</b></font></td>
			</tr>
			<? $x = 0; foreach ( $compra['DetalleCompra'] as $detalle ) : ?>
			<? if ( $detalle['reserva_id'] == $reserva['Reserva']['id'] ) : ?>
			<tr>
				<td align="center"><font face="Arial" color="#555555" size="-1"><?= ++$x; ?></font></td>
				<td align="center"><font face="Arial" color="#555555" size="-1"><?= $detalle['Producto']['codigo']; ?></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= h($detalle['Producto']['articulo']); ?></font></td>
				<td align="right"><font face="Arial" color="#555555" size="-1">$<?= number_format($detalle['precio_unitario'], 0, null, '.'); ?></font></td>
				<td align="center"><font face="Arial" color="#555555" size="-1"><?= $detalle['cantidad']; ?></font></td>
				<td align="right"><font face="Arial" color="#555555" size="-1">$<?= number_format(($detalle['precio_unitario'] * $detalle['cantidad']), 0, null, '.'); ?></font></td>
			</tr>
			<? endif; ?>
			<? endforeach; ?>
			<tr>
				<td height="0px" colspan="7" align="center" bgcolor="#2C5496"></td>
			</tr>
			<tr>
				<td colspan="8" align="right">&nbsp;</td>
			</tr>
			<tr>
				<td><font face="Arial" color="#555555" size="-1">&nbsp;</font></td>
				<td><font face="Arial" color="#555555" size="-1">Cantidad de Productos:</font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= $reserva['Reserva']['cantidad']; ?></font></td>
				<td>&nbsp;</td>
				<td></td>
				<td><font face="Arial" color="#555555" size="-1">Total:</font></td>
				<td align="right"><font face="Arial" color="#555555" size="-1">$<?= number_format($reserva['Reserva']['total'], 0, null, '.'); ?></font></td>
			</tr>
		</table>
		<table width="90%" border="0" cellspacing="5" cellpadding="5">
			<tr>
				<td width="16%" height="50" valign="bottom"><font face="Arial" color="#555555" size="-1">Fecha:</font></td>
				<td width="13%" valign="bottom"><font face="Arial" color="#555555" size="-1"><?= $compra['Compra']['created']; ?></font></td>
				<td width="15%">&nbsp;</td>
				<td width="16%">&nbsp;</td>
				<td width="40%">&nbsp;</td>
			</tr>
			<tr>
				<td><font face="Arial" color="#555555" size="-1">N° DE BOLETA:</font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= sprintf('%d%d', date('YmdHis', strtotime($reserva['Reserva']['created'])), $reserva['Reserva']['id']); ?></font></td>
				<td colspan="2"><font face="Arial" color="#555555" size="-1">POR FAVOR CONSERVAR</font></td>
				<td align="center"><font face="Arial" color="#555555" size="-1">Firma Apoderado<br>CONFIRMO DATOS EN ESTE FORMULARIO</font></td>
			</tr>
		</table>
	</td>
</tr>
