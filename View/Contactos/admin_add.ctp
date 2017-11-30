<div class="page-title">
	<h2><span class="fa fa-envelope"></span> Contactos</h2>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Nuevo contacto</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<?= $this->Form->create('Contacto', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<table class="table">
					<tr>
						<th><?= $this->Form->label('usuario_id', 'Usuario'); ?></th>
						<td><?= $this->Form->input('usuario_id', array('class' => 'form-control select')); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('comuna_id', 'Comuna'); ?></th>
						<td><?= $this->Form->input('comuna_id', array('class' => 'form-control select')); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('nombre', 'Nombre'); ?></th>
						<td><?= $this->Form->input('nombre'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('email', 'Email'); ?></th>
						<td><?= $this->Form->input('email'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('LVEN', 'LVEN'); ?></th>
						<td><?= $this->Form->input('LVEN'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('asunto', 'Asunto'); ?></th>
						<td><?= $this->Form->input('asunto'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('mensaje', 'Mensaje'); ?></th>
						<td><?= $this->Form->input('mensaje'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('respondido', 'Respondido'); ?></th>
						<td><?= $this->Form->input('respondido', array('class' => 'icheckbox')); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('administrador_id', 'Administrador'); ?></th>
						<td><?= $this->Form->input('administrador_id', array('class' => 'form-control select')); ?></td>
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
