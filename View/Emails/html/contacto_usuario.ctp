<tr>
	<td bgcolor="#FFFFFF" align="left" height="60"><font face="Arial" color="#2C5496"  size="+3">Contacto</font></td>
</tr>
<tr>
	<td align="center" height="100" bgcolor="#2C5496"><font face="Arial" size="+2" color="#FFFFFF">Has enviado un formulario de contacto a Hookipa con la siguiente información:</font></td>
</tr>
<tr>
	<td bgcolor="#2C5496"><?= $this->Html->image('emails/lapiz.jpg', array('fullBase' => true)); ?></td>
</tr>
<tr>
	<td height="30" align="center" bgcolor="#FFFFFF">
		<table width="90%" border="0" cellpadding="0" cellspacing="10">
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Fecha:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= $contacto['Contacto']['created']; ?></font></td>
			</tr>
			<? if ( ! empty($contacto['Usuario']['id']) ) : ?>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Nombre:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= sprintf('%s %s %s', $contacto['Usuario']['nombre'], $contacto['Usuario']['apellido_paterno'], $contacto['Usuario']['apellido_materno']); ?></font></td>
			</tr>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Email:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= h($contacto['Usuario']['email']); ?></font></td>
			</tr>
			<? else : ?>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Nombre:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= h($contacto['Contacto']['nombre']); ?></font></td>
			</tr>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Email:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= h($contacto['Contacto']['email']); ?></font></td>
			</tr>
			<? endif; ?>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Comuna:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= h($contacto['Comuna']['nombre']); ?></font></td>
			</tr>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Región:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= h($contacto['Comuna']['Region']['nombre']); ?></font></td>
			</tr>
			<? if ( ! empty($contacto['Contacto']['asunto']) ) : ?>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Asunto:</b></font></td>
				<td><font face="Arial" color="#555555" size="-1"><?= h($contacto['Contacto']['asunto']); ?></font></td>
			</tr>
			<? endif; ?>
			<tr>
				<td><font face="Arial" color="#555555" size="-1"><b>Comentario:</b></font></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2">
					<font face="Arial" color="#555555" size="-1">
						<p><?= h($contacto['Contacto']['mensaje']); ?></p>
					</font>
				</td>
			</tr>
		</table>
	</td>
</tr>
