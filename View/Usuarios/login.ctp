<?= $this->Html->script(array(
	'vendor/jquery.validate.min',
	'usuarios.login'
), array('inline' => false)) ;?>

<div class="contenedor">
	<div class="inicio">
		<?= $this->element('alertas'); ?>
		<i class="fa fa-power-off icon-titulo"></i><h2>INICIA SESIÓN</h2>
		<p>Completa  tus datos y estaremos en contacto.</p>
		<?= $this->Form->create('Usuario', array('autocomplete' => 'off', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
			<div class="row">
				<div class="col-sm-4 col-xs-12">
					<div class="form-group">
						<?= $this->Form->label('email', 'Email:'); ?>
						<?= $this->Form->input('email'); ?>
					</div>
				</div>
				<div class="col-sm-4 col-xs-12">
					<div class="form-group">
						<?= $this->Form->label('clave', 'Contraseña:'); ?>
						<?= $this->Form->input('clave', array('autocomplete' => 'new-password', 'type' => 'password')); ?>
					</div>
				</div>
				<div class="col-sm-4 col-xs-12">
					<?= $this->Form->submit('Iniciar sesión', array('class' => 'iniciar', 'div' => false)); ?>
					<?= $this->Html->link('¿Olvidaste tu contraseña?', array('controller' => 'usuarios', 'action' => 'recuperar'), array('class' => 'olvido')); ?>
				</div>
			</div>
		<?= $this->Form->end(); ?>
	</div>

	<div class="reg">
		<i class="fa fa-user icon-titulo"></i><h2>¿ERES NUEVO? REGÍSTRATE AQUÍ</h2>
		<div class="row">
			<div class="col-sm-6 col-sm-push-6 col-xs-12">
				<?= $this->Html->link('Regístrate aquí', array('controller' => 'usuarios', 'action' => 'add'), array('class' => 'registrate')); ?>
			</div>
			<div class="col-sm-6 col-sm-pull-6 col-xs-12">
				<p>Al registrarte podrás optar a los siguientes beneficios:</p>
				<ul>
					<li>Promociones exclusivas.</li>
					<li>Actualizaciones de catálogo personalizado.</li>
					<li>Información de interés para toda tu familia.</li>
				</ul>
			</div>
		</div>
	</div>
</div>
