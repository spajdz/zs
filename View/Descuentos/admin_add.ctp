<div class="page-title">
	<h2><span class="fa fa-dollar"></span> Descuentos</h2>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Nuevo descuento</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<?= $this->Form->create('Descuento', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<table class="table">
					<tr>
						<th><?= $this->Form->label('tipo_descuento_id', 'Tipo descuento'); ?></th>
						<td><?= $this->Form->input('tipo_descuento_id', array('class' => 'form-control select')); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('nombre', 'Nombre'); ?></th>
						<td><?= $this->Form->input('nombre'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('descripcion', 'Descripcion'); ?></th>
						<td><?= $this->Form->input('descripcion'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('codigo_colegio', 'Codigo colegio'); ?></th>
						<td><?= $this->Form->input('codigo_colegio'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('codigo_lista', 'Codigo lista'); ?></th>
						<td><?= $this->Form->input('codigo_lista'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('minimo', 'Minimo'); ?></th>
						<td><?= $this->Form->input('minimo'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('maximo', 'Maximo'); ?></th>
						<td><?= $this->Form->input('maximo'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('porcentaje', 'Porcentaje'); ?></th>
						<td><?= $this->Form->input('porcentaje'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('monto', 'Monto'); ?></th>
						<td><?= $this->Form->input('monto'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('precedencia', 'Precedencia'); ?></th>
						<td><?= $this->Form->input('precedencia'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('acumulable', 'Acumulable'); ?></th>
						<td><?= $this->Form->input('acumulable', array('class' => 'icheckbox')); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('fecha_inicio', 'Fecha inicio'); ?></th>
						<td><?= $this->Form->input('fecha_inicio'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('fecha_fin', 'Fecha fin'); ?></th>
						<td><?= $this->Form->input('fecha_fin'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('via_catalogo', 'Via catalogo'); ?></th>
						<td><?= $this->Form->input('via_catalogo', array('class' => 'icheckbox')); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('via_reserva', 'Via reserva'); ?></th>
						<td><?= $this->Form->input('via_reserva', array('class' => 'icheckbox')); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('via_lista', 'Via lista'); ?></th>
						<td><?= $this->Form->input('via_lista', array('class' => 'icheckbox')); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('activo', 'Activo'); ?></th>
						<td><?= $this->Form->input('activo', array('class' => 'icheckbox')); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('administrador_id', 'Administrador'); ?></th>
						<td><?= $this->Form->input('administrador_id', array('class' => 'form-control select')); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('Compra', 'Compra'); ?></th>
						<td><?= $this->Form->input('Compra'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('Usuario', 'Usuario'); ?></th>
						<td><?= $this->Form->input('Usuario'); ?></td>
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
