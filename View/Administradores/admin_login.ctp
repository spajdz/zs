<div class="login-box animated fadeInDown">
	<div class="login-logo"></div>
	<div class="login-body">
		<div class="login-title"><strong>Bienvenido</strong><p>Para iniciar debe identificarse.</p></div>
		<?= $this->Form->create('Administrador', array('class' => 'form-horizontal', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
			<div class="form-group">
				<div class="col-md-12">
					<?= $this->Form->input('email', array('placeholder' => 'Email')); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<?= $this->Form->input('clave', array('type' => 'password', 'placeholder' => 'Contraseña')); ?>
				</div>
			</div>
			<?= $this->element('admin_alertas'); ?>
			<div class="form-group">
				<div class="col-md-6">
					<a href="#" class="btn btn-link btn-block">¿Olvidó su contraseña?</a>
				</div>
				<div class="col-md-6">
					<button class="btn btn-info btn-block">Entrar</button>
				</div>
			</div>
		<?= $this->Form->end(); ?>
	</div>
	<div class="login-footer">
		<div class="pull-left">
			&copy; 2017 Hookipa
		</div>
	</div>
</div>
