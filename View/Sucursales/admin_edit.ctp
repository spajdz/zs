<div class="page-title">
	<h2><span class="fa fa-map-marker"></span> Sucursales</h2>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Editar Sucursal</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<?= $this->Form->create('Sucursal', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<table class="table">
					<?= $this->Form->input('id'); ?>
					<tr> 
						<th><?= $this->Form->label('retiro_sucursal', 'Retiro en tienda'); ?></th>
                        <td><label class="switch">
                            <?= $this->Form->input('retiro_sucursal', array('type' => 'checkbox'));?>
                            <span></span>
                        </label>
                        </td>						
					</tr> 
					<tr>
						<th><?= $this->Form->label('Servicio', 'Servicios'); ?></th>
						<td>					
						<?= $this->Form->input('Servicio', array(
							'data-tipo'		=> 'Servicio',
							'options'		=> $servicios,
							'multiple'		=> true,
							'class'			=> 'form-control selectpicker',
							'title'			=> '-- Selecciona Servicios'
							)
						); ?>
						</td>
					</tr>
					<tr>
						<th><?= $this->Form->label('tipo_sucursal_id', 'Tipo'); ?></th>
						<td><?= $this->Form->input('tipo_sucursal_id'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('nombre', 'Nombre'); ?></th>
						<td><?= $this->Form->input('nombre'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('direccion', 'Dirección'); ?></th>
						<td><?= $this->Form->input('direccion'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('telefono', 'Teléfonos'); ?></th>
						<td><?= $this->Form->input('telefono'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('email', 'Email'); ?></th>
						<td><?= $this->Form->input('email'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('hr_semana', 'Horario Lunes a Viernes'); ?></th>
						<td><?= $this->Form->input('hr_semana'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('hr_sabado', 'Horario Sábado'); ?></th>
						<td><?= $this->Form->input('hr_sabado'); ?></td>
					</tr>
					<tr>
						<th><?= $this->Form->label('hr_domingo', 'Horario Domingo'); ?></th>
						<td><?= $this->Form->input('hr_domingo'); ?></td>
					</tr>

					<tr>
						<th><?= $this->Form->label('url_mapa', 'url google maps'); ?></th>
						<td><?= $this->Form->input('url_mapa'); ?></td>
					</tr>


					<?php if($FotoActual != "") { ?>
						<tr>
							<th><?= $this->Form->label('imagen', 'Foto Actual'); ?></th>
							<td><?= $this->Html->image($FotoActual); ?></td>
						</tr>
					<? } ?>
					<tr>
						<th><?= $this->Form->label('imagen', 'Foto'); ?></th>
						<td><?= $this->Form->input('imagen', array('type' => 'file')); ?></td>
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
