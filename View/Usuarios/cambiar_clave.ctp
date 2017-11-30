<?= $this->Html->script(array(
	'vendor/jquery.validate.min',
	'usuarios.cambiar_clave'
), array('inline' => false)) ;?>

<div class="contenedor">
	<div class="inicio">
		<?= $this->element('alertas'); ?>
		<i class="fa fa-power-off icon-titulo"></i><h2>CAMBIA TU CONTRASEÑA</h2>
		<p>Ingresa tu nueva contraseña de acceso a Hookipa.</p>
		<?= $this->Form->create('Usuario', array('autocomplete' => 'off', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
			<div class="row">
				<div class="col-sm-4 col-xs-12">
					<div class="form-group">
						<?= $this->Form->label('clave', 'Contraseña:'); ?>
						<?= $this->Form->input('clave', array('type' => 'password')); ?>
					</div>
				</div>
				<div class="col-sm-4 col-xs-12">
					<div class="form-group">
						<?= $this->Form->label('repetir_clave', 'Repetir contraseña:'); ?>
						<?= $this->Form->input('repetir_clave', array('type' => 'password')); ?>
					</div>
				</div>
				<div class="col-sm-4 col-xs-12">
					<?= $this->Form->submit('Cambiar clave', array('class' => 'iniciar', 'div' => false)); ?>
				</div>
			</div>
		<?= $this->Form->end(); ?>
	</div>
</div>
