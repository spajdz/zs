<div class="page-title">
	<h2><span class="fa fa-picture-o"></span> Banners</h2>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Nuevo Banner</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<?= $this->Form->create('Banner', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<table class="table">
					<?if(empty($cuadroshome)):?>
						<tr>
							<th><?= $this->Form->label('pagina_id', 'Página'); ?></th>
							<td>
								<?= $this->Form->input('pagina_id', array('class' => 'form-control select')); ?>
							</td>
						</tr>
					<?endif;?>
					<tr>
						<th><?= $this->Form->label('nombre', 'Nombre'); ?></th>
						<td><?= $this->Form->input('nombre'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('imagen', 'Imagen'); ?></th>
						<td><?= $this->Form->input('imagen', array('type' => 'file', 'class' => '')); ?></td>
					</tr>
					<?if(!empty($cuadroshome)):?>
						<tr>
							<th><?= $this->Form->label('texto', 'Texto de sección'); ?></th>
							<td><?= $this->Form->input('texto'); ?></td>
						</tr>
					<?endif;?>
					<tr>
						<th><?= $this->Form->label('link', 'Link'); ?></th>
						<td><?= $this->Form->input('link', array( 'required' => false)); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('enlace_externo', 'Enlace Externo'); ?></th>
						<td><?= $this->Form->input('enlace_externo', array('class' => 'icheckbox')); ?></td>
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
