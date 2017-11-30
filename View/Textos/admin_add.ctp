<div class="page-title">
	<h2><span class="fa fa-text-width"></span> Textos</h2>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Nuevo texto</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<?= $this->Form->create('Texto', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<table class="table">
					<!-- IDENTIFICADOR -->
					<tr>
						<th><?= $this->Form->label('identificador', 'Identificador'); ?></th>
						<td><?= $this->Form->input('identificador'); ?></td>
					</tr>
					<!-- DESCRIPCION -->
					<tr>
						<th><?= $this->Form->label('descripcion', 'Descripcion'); ?></th>
						<td><?= $this->Form->input('descripcion'); ?></td>
					</tr>
					<!-- Texto -->
					<tr>
						<th><?= $this->Form->label('texto', 'Texto'); ?></th>
						<td><?= $this->Form->input('texto', array('required' => false, 'class' => 'form-control js-summernote')); ?></td>
					</tr>

				</table>
				<!-- Botones -->
				<div class="pull-right">
					<input type="submit" class="btn btn-primary esperar-carga" autocomplete="off" data-loading-text="Espera un momento..." value="Guardar cambios">
					<?= $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
				</div>
			<?= $this->Form->end(); ?>
		</div>
	</div>
</div>
