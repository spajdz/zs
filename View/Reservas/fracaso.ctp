<div class="contenedor">
	<div class="row inicio">
		<div class="col-sm-8 col-sm-offset-2">
		<i class="fa fa-times icon-titulo rojo"></i><h2>Transacción rechazada para la Orden de Compra N° <?= $id; ?></h2>
		<p>Las posibles causas de este rechazo son: </p>
			<ul>
				<li>Error en el ingreso de los datos de su tarjeta de crédito o débito (fecha y/o código de seguridad).</li>
				<li>Su tarjeta de crédito o débito no cuenta con el cupo necesario para cancelar la compra.</li>
				<li>Tarjeta aún no habilitada en el sistema financiero.</li>
			</ul>
			<?= $this->Html->link('Volver a intentar', array('controller' => 'reservas', 'action' => 'resumen'), array('class' => 'btn')); ?>
			<?= $this->Html->link('Ir al inicio', '/', array('class' => 'btn')); ?>
		</div>
	</div>
</div>
