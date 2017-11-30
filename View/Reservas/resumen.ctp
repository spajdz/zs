<div class="cabecera-colegio resultado">
	<? $this->Html->image($this->Hookipa->imagenColegio($colegio['codigo']), array('class' => 'logoCole img-responsive')); ?>
	<h2>Listado de alumnos relacionados</h2>
	<h3><?= h($colegio['nombre']); ?></h3>
</div>
<div class="row" id="no-more-tables">
	<table class="table-striped table-condensed cf">
		<thead class="cf">
			<tr>
				<th class="numeric">Nro.</th>
				<th class="numeric">Nivel</th>
				<th class="numeric">Nombre Alumno</th>
				<th class="numeric">Apellido Alumno</th>
				<th class="numeric">Solicita productos</th>
				<th class="numeric">Cantidad de productos</th>
				<th class="numeric">Total</th>
			</tr>
		</thead>
		<tbody>
			<? $x = 0; $total = 0; foreach ( $reservas as $reserva ) : ?>
			<? $total += $reserva['Meta']['Subtotal']; ?>
			<tr>
				<td data-title="Nro."><?= ++$x; ?></td>
				<td data-title="Nivel"><?= $reserva['Reserva']['nivel']; ?></td>
				<td data-title="Nombre Alumno"><?= $reserva['Reserva']['nombre_alumno']; ?></td>
				<td data-title="Apellido Alumno"><?= $reserva['Reserva']['apellido_alumno']; ?></td>
				<td data-title="Solicita productos"><?= ($reserva['Meta']['Cantidad'] ? 'Si' : 'No'); ?></td>
				<td data-title="Cantidad de productos"><?= $reserva['Meta']['Cantidad']; ?></td>
				<td data-title="Total">$<?= number_format($reserva['Meta']['Subtotal'], 0, null, '.'); ?></td>
			</tr>
			<? endforeach; ?>
		</tbody>
	</table>
	<div class="row padd20">
		<div class="col-sm-4 suma-compra hidden-xs"></div>
		<div class="col-sm-4 suma-compra hidden-xs"></div>
		<div class="col-sm-4 total-compra">
			<p>Total Reserva: $<?= number_format($total, 0, null, '.'); ?></p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8 col-xs-4">
			<?= $this->Html->link('Volver a la reserva', array('action' => 'add'), array('class' => 'btn')); ?>
		</div>
		<div class="col-sm-4 col-xs-8 right">
			<?= $this->Html->image('logo-webpay.jpg', array('class' => 'logo-webpay')); ?>
			<?= $this->Html->link('Pagar reserva', array('action' => 'pagar'), array('class' => 'btn')); ?>
		</div>
	</div>
</div>
