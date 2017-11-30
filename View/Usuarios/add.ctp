<?= $this->Html->script(array(
	'vendor/jquery.maskedinput.min',
	'vendor/jquery.validate.min',
	'vendor/jquery.Rut.min',
	'vendor/jquery.alphanumeric.pack',
	'usuarios.add'
), array('inline' => false)) ;?>

<div class="contenedor registro">
	<?= $this->element('alertas'); ?>
	<i class="fa fa-user icon-titulo"></i><h2>¿ERES NUEVO? REGÍSTRATE AQUÍ</h2>

	<!--
	<p>Regístrate vía Facebook o llena el formulario a continuación.</p>
	<div class="row registro-fb">
		<div class="col-sm-6">
			<h2>Más rápido, más fácil.</h2>
		</div>
		<div class="col-sm-6">
			<a href="#" class="btn-fb"><i class="fa fa-facebook-official"></i> Login con Facebook</a>
		</div>
	</div>
	-->

	<?= $this->Form->create('Usuario', array('inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
		<div class="row pasos">
			<div class="col-sm-4 col-xs-12">
				<h3><span>01</span> Selecciona una alternativa</h3>
			</div>
			<div class="col-sm-8 col-xs-12 radios">
				<?= $this->Form->input('tipo_usuario_id', array('type' => 'radio', 'class' => '', 'legend' => false, 'label' => true)); ?>
			</div>
		</div>

		<div class="row pasos">
			<div class="col-sm-12">
				<h3><span>02</span> Ingresa tus datos</h3>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<?= $this->Form->label('nombre', 'Nombre'); ?>
					<?= $this->Form->input('nombre'); ?>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<?= $this->Form->label('apellido_paterno', 'Apellido Paterno'); ?>
					<?= $this->Form->input('apellido_paterno'); ?>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<?= $this->Form->label('apellido_materno', 'Apellido Materno'); ?>
					<?= $this->Form->input('apellido_materno'); ?>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group radios">
					<label>Sexo</label>
					<?= $this->Form->input('genero', array('type' => 'radio', 'class' => '', 'legend' => false, 'label' => array('class' => 'sex'), 'options' => array('Masculino', 'Femenino'))); ?>
				</div>
			</div>
			<!--<div class="col-sm-4"><div class="form-group"><label>RUT</label> <input type="text" class="form-control rut"><input type="text" class="form-control dv"></div></div>-->
			<div class="col-sm-4">
				<div class="form-group fecha">
					<?= $this->Form->label('fecha_nacimiento', 'Fecha de Nacimiento'); ?>
					<?= $this->Form->input('fecha_nacimiento', array('dateFormat' => 'DMY', 'separator' => false, 'empty' => true, 'minYear' => date('Y') - 100, 'maxYear' => date('Y') - 18)); ?>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<?= $this->Form->label('email', 'Email'); ?>
					<?= $this->Form->input('email'); ?>
				</div>
			</div>
			<div class="col-sm-4 ">
				<div class="form-group">
					<?= $this->Form->label('repetir_email', 'Confirma tu Email'); ?>
					<?= $this->Form->input('repetir_email'); ?>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<?= $this->Form->label('celular', 'Celular'); ?>
					<?= $this->Form->input('celular', array('type' => 'text', 'maxlength' => 10)); ?>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<?= $this->Form->label('fono', 'Fono'); ?>
					<?= $this->Form->input('fono', array('type' => 'text', 'maxlength' => 10)); ?>
				</div>
			</div>
		</div>
		<div class="row pasos">
			<div class="col-sm-12">
				<h3><span>03</span> Elige una contraseña</h3>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<?= $this->Form->label('clave', 'Ingresa una contraseña'); ?>
					<?= $this->Form->input('clave', array('type' => 'password', 'autocomplete' => 'off', 'value' => '')); ?>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<?= $this->Form->label('repetir_clave', 'Confirma tu contraseña'); ?>
					<?= $this->Form->input('repetir_clave', array('type' => 'password', 'autocomplete' => 'off', 'value' => '')); ?>
				</div>
			</div>
			<div class="col-sm-12">
				<?= $this->Form->submit('Enviar registro', array('class' => 'form-control btn-celeste')); ?>
			</div>
		</div>
	<?= $this->Form->end(); ?>
</div>
