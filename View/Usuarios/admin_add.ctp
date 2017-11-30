 
<div class="page-title">
	<h2><span class="fa fa-list"></span> Usuarios</h2>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Nuevo Usuario</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<?= $this->Form->create('Usuario', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<table class="table">
					<tr>
						<th><?= $this->Form->label('nombre', 'Nombre'); ?></th>
						<td><?= $this->Form->input('nombre'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('apellido_paterno', 'Apellido paterno'); ?></th>
						<td><?= $this->Form->input('apellido_paterno'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('apellido_materno', 'Apellido materno'); ?></th>
						<td><?= $this->Form->input('apellido_materno'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('email', 'Email'); ?></th>
						<td><?= $this->Form->input('email'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('telefono', 'Telefono'); ?></th>
						<td><?= $this->Form->input('telefono'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('clave', 'Clave'); ?></th>
						<td><?= $this->Form->input('clave', array('type' => 'password', 'autocomplete' => 'off', 'value' => '')); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('repetir_clave', 'Repetir clave'); ?></th>
						<td><?= $this->Form->input('repetir_clave', array('type' => 'password', 'autocomplete' => 'off', 'value' => '')); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('fecha_nacimiento', 'Fecha nacimiento'); ?></th>
						<td><?= $this->Form->input('fecha_nacimiento', array('style' => 'width: 20%;display:inline-block;' )); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('genero', 'Género'); ?></th>
						<td><?= $this->Form->input('genero'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('tipo_usuario_id', 'Tipo de usuario'); ?></th>
						<td><?= $this->Form->input('tipo_usuario_id', array('empty' => 'Seleccione')); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('TipoPago', 'Tipos de pago aceptados'); ?></th>
						<td><?= $this->Form->input('TipoPago'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('activo', 'Activo'); ?></th>
						<td><?= $this->Form->input('activo', array('class' => 'icheckbox')); ?></td>
					</tr>
				</table>

				<div class="pull-right">
					<input type="submit" class="btn btn-primary esperar-carga" autocomplete="off" data-loading-text="Espera un momento..." value="Guardar cambios">
					<?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
				</div>
			<?= $this->Form->end(); ?>
		</div>
	</div>
</div>
