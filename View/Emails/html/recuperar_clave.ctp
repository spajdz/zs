<tr>
	<td bgcolor="#fff" align="left" height="60"><font face="Arial" color="#2C5496" size="+3">Recuperar Contraseña</font></td>
</tr>
<tr>
	<td align="center" height="100" bgcolor="#2C5496"><font face="Arial" size="+2" color="#FFFFFF">¿Olvidaste tu contraseña?<br>Leer ayuda a la memoria.</font></td>
</tr>
<tr bgcolor="#2C5496">
	<td><?= $this->Html->image('emails/llave.jpg', array('fullBase' => true)); ?></td>
</tr>
<tr>
	<td height="30" align="center" bgcolor="#2C5496"><font face="Arial" color="#FFFFFF">Entra aquí y recupera tu contraseña ahora.</font></td>
</tr>
<tr>
	<td height="100px" bgcolor="#2C5496">
		<?= $this->Html->link(
			$this->Html->image('emails/recuperar.jpg', array('fullBase' => true)),
			array('controller' => 'usuarios', 'action' => 'recuperar', $usuario['Usuario']['codigo'], 'full_base' => true),
			array('escape' => false)
		); ?>
	</td>
</tr>
