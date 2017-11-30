<div class="page-title">
	<h2><span class="fa fa-dollar"></span> Tarifas de despachos</h2>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Editar tarifa</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<?= $this->Form->create('TarifaDespacho', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<table class="table">
					<?= $this->Form->input('id'); ?>
					<!-- Peso 1.5 kg -->
					<tr>
						<th><?= $this->Form->label('nombre', '1.5 Kg'); ?></th>
						<td><?= $this->Form->input('peso150', array('class' => 'control-label', 'required' => true)); ?></td>
					</tr>
					<!-- Peso 3 kg -->
					<tr>
						<th><?= $this->Form->label('descripcion', '3 Kg'); ?></th>
						<td><?= $this->Form->input('peso300', array('class' => 'control-label', 'required' => true)); ?>
					</tr>
					<!-- Peso 6 kg -->
					<tr>
						<th><?= $this->Form->label('fecha_inicio', '6 Kg'); ?></th>
						<td><?= $this->Form->input('peso600', array('class' => 'control-label', 'required' => true)); ?>
					</tr>
					<!-- Peso 10 kg -->
					<tr>
						<th><?= $this->Form->label('fecha_fin', '10 Kg'); ?></th>
						<td><?= $this->Form->input('peso1000', array('class' => 'control-label', 'required' => true)); ?></td>
					</tr>
					<!-- Peso 15 kg -->
					<tr>
						<th><?= $this->Form->label('imagen', '15 Kg'); ?></th>
						<td><?= $this->Form->input('peso1500', array('class' => 'control-label', 'required' => true)); ?></td>
					</tr>
					<!-- Domicilio -->
					<tr>
						<th><?= $this->Form->label('domicilio', 'Domicilio'); ?></th>
						<td><?= $this->Form->input('domicilio', array('class' => 'control-label')); ?></td>
					</tr>
					<!-- observacion domicilio -->
					<tr>
						<th><?= $this->Form->label('observacion_domicilio', 'Observacion domicilio'); ?></th>
						<td><?= $this->Form->input('observacion_domicilio'); ?></td>
					</tr>
					<!-- extrema -->
					<tr>
						<th><?= $this->Form->label('extrema', 'Extrema'); ?></th>
						<td><?= $this->Form->input('extrema', array('class' => 'control-label')); ?></td>
					</tr>
					<!-- observacion extrema -->
					<tr>
						<th><?= $this->Form->label('observacion_extrema', 'Observacion extrema'); ?></th>
						<td><?= $this->Form->input('observacion_extrema'); ?></td>
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
