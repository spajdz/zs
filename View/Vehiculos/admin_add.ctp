<div class="row">
	<div class="col-md-12">
		<div class="page-title">
			<h2><span class="fa fa-list"></span> Vehiculos</h2>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Nuevo Vehiculo</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<?= $this->Form->create('Vehiculo', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
						<table class="table">
							<tr>
								<th><?= $this->Form->label('nombre', 'Nombre'); ?></th>
								<td><?= $this->Form->input('nombre', array('placeholder' => 'Nombre')); ?></td>
							</tr>
							<tr>
								<th><?= $this->Form->label('marca', 'Marca'); ?></th>
								<td><?= $this->Form->input('marca', array('placeholder' => 'Marca')); ?></td>
							</tr>
							<tr>
								<th><?= $this->Form->label('modelo', 'Modelo'); ?></th>
								<td><?= $this->Form->input('modelo', array('placeholder' => 'Modelo')); ?></td>
							</tr>
							<tr>
								<th><?= $this->Form->label('version', 'Version'); ?></th>
								<td><?= $this->Form->input('version', array('placeholder' => 'Version')); ?></td>
							</tr>
							<tr>
								<th><?= $this->Form->label('apernadura', 'Apernadura'); ?></th>
								<td><?= $this->Form->input('apernadura', array('placeholder' => 'Apernadura')); ?></td>
							</tr>
							<tr>
								<th><?= $this->Form->label('aro', 'Aro'); ?></th>
								<td><?= $this->Form->input('aro', array('placeholder' => 'Aro')); ?></td>
							</tr>
							<tr>
								<th><?= $this->Form->label('ancho', 'Ancho'); ?></th>
								<td><?= $this->Form->input('ancho', array('placeholder' => 'Ancho')); ?></td>
							</tr>
							<tr>
								<th><?= $this->Form->label('perfil', 'Perfil'); ?></th>
								<td><?= $this->Form->input('perfil', array('placeholder' => 'Perfil')); ?></td>
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
