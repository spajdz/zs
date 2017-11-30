<div class="row">
	<div class="col-md-12">
		<div class="page-title">
			<h2><span class="fa fa-list"></span> Cargas</h2>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Nuevo Carga</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<?= $this->Form->create('Carga', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
						<table class="table">
							<tr>
								<th><?= $this->Form->label('administrador_id', 'Administrador'); ?></th>
								<td><?= $this->Form->input('administrador_id', array('class' => 'form-control select')); ?></td>
							</tr>
							<tr>
								<th><?= $this->Form->label('identificador', 'Identificador'); ?></th>
								<td><?= $this->Form->input('identificador', array('placeholder' => 'Identificador')); ?></td>
							</tr>
							<tr>
								<th><?= $this->Form->label('ejecutando', 'Ejecutando'); ?></th>
								<td><?= $this->Form->input('ejecutando', array('class' => 'icheckbox')); ?></td>
							</tr>
							<tr>
								<th><?= $this->Form->label('error', 'Error'); ?></th>
								<td><?= $this->Form->input('error', array('class' => 'icheckbox')); ?></td>
							</tr>
							<tr>
								<th><?= $this->Form->label('ultimo_mensaje', 'Ultimo mensaje'); ?></th>
								<td><?= $this->Form->input('ultimo_mensaje', array('placeholder' => 'Ultimo mensaje')); ?></td>
							</tr>
							<tr>
								<th><?= $this->Form->label('productos_total', 'Productos total'); ?></th>
								<td><?= $this->Form->input('productos_total', array('placeholder' => 'Productos total')); ?></td>
							</tr>
							<tr>
								<th><?= $this->Form->label('productos_nuevos', 'Productos nuevos'); ?></th>
								<td><?= $this->Form->input('productos_nuevos', array('placeholder' => 'Productos nuevos')); ?></td>
							</tr>
							<tr>
								<th><?= $this->Form->label('productos_modificados', 'Productos modificados'); ?></th>
								<td><?= $this->Form->input('productos_modificados', array('placeholder' => 'Productos modificados')); ?></td>
							</tr>
							<tr>
								<th><?= $this->Form->label('productos_eliminados', 'Productos eliminados'); ?></th>
								<td><?= $this->Form->input('productos_eliminados', array('placeholder' => 'Productos eliminados')); ?></td>
							</tr>
							<tr>
								<th><?= $this->Form->label('manual', 'Manual'); ?></th>
								<td><?= $this->Form->input('manual', array('class' => 'icheckbox')); ?></td>
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
	</div>
</div>
