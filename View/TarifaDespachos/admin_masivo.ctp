<div class="page-title">
	<h2><span class="fa fa-dollar"></span> Tarifas de despacho</h2>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Carga masiva</h3>
		<!-- Boton para descargar formato de ejemplo -->
		<div class="btn-group pull-right">
			<?= $this->Html->link(
				'<i class="fa fa-cloud-download"></i> Formato ejemplo CSV',
				'/backend/file/file_tarifa_despachos.csv',
				array('class' => 'btn btn-success',
					  'escape' => false
			)); ?>
		</div>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<?= $this->Form->create('TarifaDespacho', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<table class="table">
					<tr>
						<th><?= $this->Form->label('archivo', 'Archivo (CSV)'); ?></th>
						<td><?= $this->Form->input('archivo', array('type' => 'file', 'class' => '')); ?></td>
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
