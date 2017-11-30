<div class="page-title">
	<h2><span class="fa fa-list"></span> Direcciones</h2>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Nuevo direccion</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<?= $this->Form->create('Direccion', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<table class="table">
					<tr>
						<th><?= $this->Form->label('usuario_id', 'Usuario'); ?></th>
						<td><?= $this->Form->input('usuario_id', array('class' => 'form-control select')); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('KOCI', 'KOCI'); ?></th>
						<td><?= $this->Form->input('KOCI'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('KOCM', 'KOCM'); ?></th>
						<td><?= $this->Form->input('KOCM'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('nombre', 'Nombre'); ?></th>
						<td><?= $this->Form->input('nombre'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('calle', 'Calle'); ?></th>
						<td><?= $this->Form->input('calle'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('numero', 'Numero'); ?></th>
						<td><?= $this->Form->input('numero'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('depto', 'Depto'); ?></th>
						<td><?= $this->Form->input('depto'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('codigo_postal', 'Codigo postal'); ?></th>
						<td><?= $this->Form->input('codigo_postal'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('telefono', 'Telefono'); ?></th>
						<td><?= $this->Form->input('telefono'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('observaciones', 'Observaciones'); ?></th>
						<td><?= $this->Form->input('observaciones'); ?></td>
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
