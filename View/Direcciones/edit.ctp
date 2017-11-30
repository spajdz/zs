<?= $this->Html->script(array(
	'vendor/jquery.chained.remote',
	'vendor/jquery.maskedinput.min',
	'vendor/jquery.validate.min',
	'direcciones.edit'
), array('inline' => false)) ;?>

<div class="contenedor">
    <div class="row">
		<?= $this->element('menu_lateral_usuario'); ?>
		<div class="col-sm-9 contenido">
			<?= $this->Form->create('Direccion', array('action' => 'edit', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<?= $this->Form->hidden('id'); ?>

				<div class="row ingreso-direccion">
					<div class="col-sm-12">
						<h2>Editar dirección</h2>
							<?= $this->element('alertas'); ?>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<?= $this->Form->label('calle', 'Calle'); ?>
										<?= $this->Form->input('calle'); ?>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<?= $this->Form->label('numero', 'Número'); ?>
										<?= $this->Form->input('numero'); ?>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<?= $this->Form->label('depto', 'Dpto.'); ?>
										<?= $this->Form->input('depto'); ?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<?= $this->Form->label('region_id', 'Región'); ?>
										<?= $this->Form->input('region_id', array('empty' => '-- Selecciona una región')); ?>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<?= $this->Form->label('comuna_id', 'Comuna'); ?>
										<?= $this->Form->input('comuna_id', array('empty' => '-- Selecciona una comuna')); ?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<?= $this->Form->label('codigo_postal', 'Código postal'); ?>
										<?= $this->Form->input('codigo_postal', array('type' => 'text', 'maxlength' => 7)); ?>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<?= $this->Form->label('telefono', 'Celular'); ?>
										<?= $this->Form->input('telefono'); ?>
									</div>
								</div>
							</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<!--
							<iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d13317.924209543467!2d-70.62762785!3d-33.4367715!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2scl!4v1440106782204" width="100%" height="360" frameborder="0" style="border:0" allowfullscreen></iframe>
							-->
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8 col-xs-4">
					</div>
					<div class="col-sm-4 col-xs-8 right">
						<?= $this->Form->submit('Guardar', array('class' => 'btn', 'div' => false)); ?>
					</div>
				</div>
			<?= $this->Form->end(); ?>
		</div>
	</div>
</div>
