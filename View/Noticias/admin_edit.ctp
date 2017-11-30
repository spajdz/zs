<div class="page-title">
	<h2><span class="fa fa-map-marker"></span> Noticias</h2>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Editar Noticia</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<?= $this->Form->create('Noticia', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<table class="table">
					<?= $this->Form->input('id'); ?>

					<tr> 
						<th><?= $this->Form->label('titulo', 'Titulo'); ?></th>
						<td><?= $this->Form->input('titulo', array('maxlength'=>'50')); ?></td>
					</tr>

					<?php if($FotoActual != "") { ?>
						<tr>
							<th><?= $this->Form->label('foto', 'Foto Actual'); ?></th>
							<td><?= $this->Html->image($FotoActual); ?></td>
						</tr>
					<? } ?>
					<tr>
						<th><?= $this->Form->label('imagen', 'Foto'); ?></th>
						<td><?= $this->Form->input('imagen', array('type' => 'file')); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('extracto', 'Descripcion Basica'); ?></th> 
						<td><?= $this->Form->input('extracto', array( 'class' => 'js-summernote2')); ?></td>			 			
					</tr> 	
					<tr>
						<th><?= $this->Form->label('cuerpo', 'Descripción completa'); ?></th>
						<td><?= $this->Form->input('cuerpo', array( 'class' => 'js-summernote')); ?></td>						
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
