<div class="page-title">
	<h2><span class="fa fa-users"></span> Usuarios</h2>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Información del usuario</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-6">
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th>Nombre</th>
							<td><?= h($usuario['Usuario']['nombre']); ?></td>
						</tr>
						<tr>
							<th>Apellido Paterno</th>
							<td><?= h($usuario['Usuario']['apellido_paterno']); ?></td>
						</tr>
						<tr>
							<th>Apellido Materno</th>
							<td><?= h($usuario['Usuario']['apellido_materno']); ?></td>
						</tr>
						<tr>
							<th>Email</th>
							<td><?= h($usuario['Usuario']['email']); ?></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="col-md-6">
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th>Celular - fono </th>
							<td><?= h($usuario['Usuario']['celular']); ?> - <?= h($usuario['Usuario']['fono']); ?></td>
						</tr>
						<tr>
							<th>Fecha de nacimiento</th>
							<td><?= h($usuario['Usuario']['fecha_nacimiento']); ?></td>
						</tr>
						<tr>
							<th>Tipo de usuario</th>
							<td><?= h($usuario['TipoUsuario']['nombre']); ?></td>
						</tr>
						<tr>
							<th>Fecha de registro</th>
							<td><?= h($usuario['Usuario']['created']); ?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!--
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Actividad en el sitio</h3>
	</div>
	<div class="panel-body">

		<div class="timeline timeline-right">
			<div class="timeline-item timeline-item-right">
				<div class="timeline-item-info">
					06 Oct 2015<br>
					10:00 pm
				</div>
				<div class="timeline-item-icon"><span class="fa fa-dollar"></span></div>
				<div class="timeline-item-content">
					<div class="timeline-body">
						asasd
					</div>
				</div>
			</div>

			<div class="timeline-item timeline-item-right">
				<div class="timeline-item-info">
					<?= $this->Time->format('Y M d', $usuario['Usuario']['created']); ?><br>
					<?= $this->Time->format('h:i a', $usuario['Usuario']['created']); ?>
				</div>
				<div class="timeline-item-icon"><span class="fa fa-user"></span></div>
				<div class="timeline-item-content">
					<div class="timeline-body">
						asdasdasd
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
-->
