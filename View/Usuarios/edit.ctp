<?= $this->Html->script(array(
	'vendor/jquery.maskedinput.min',
	'vendor/jquery.validate.min',
	'vendor/jquery.Rut.min',
	'vendor/jquery.alphanumeric.pack',
	'usuarios.edit'
), array('inline' => false)) ;?>

<div class="contenedor">
	<div class="row">
		<?= $this->element('menu_lateral_usuario'); ?>
		<div class="col-sm-9 contenido">
			<h2>Mis Datos</h2>
			<?= $this->element('alertas'); ?>
			<?= $this->Form->create('Usuario', array('url' => array('action' => 'edit'), 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
				<?= $this->Form->hidden('id'); ?>
				<div class="row pasos">
					<div class="col-sm-12 col-xs-12">
						<h3><span>01</span> Tu Perfil de Usuario es:</h3>
					</div>
					<div class="col-sm-12 col-xs-12 radios">
						<?= $this->Form->input('tipo_usuario_id', array('type' => 'radio', 'class' => '', 'legend' => false, 'label' => true)); ?>
					</div>
				</div>
				<div class="row pasos">
					<div class="col-sm-12">
						<h3><span>02</span> Edita tus datos</h3>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<?= $this->Form->label('nombre', 'Nombre'); ?>
							<?= $this->Form->input('nombre'); ?>
						</div>
					</div>
					<div class="col-sm-6">
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
							<label style="display: block;">Sexo</label>
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
						<h3><span>03</span> Cambia tu contraseña:</h3>
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
	</div>
</div>
