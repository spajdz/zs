<?= $this->Html->script(array(
	'vendor/jquery.chained.remote',
	'vendor/jquery.maskedinput.min',
	'vendor/jquery.validate.min',
	'contactos.add'
), array('inline' => false)) ;?>

<div class="contenedor">
	<?= $this->element('alertas'); ?>

	<div class="text-center nuestras">
		<h2 class="bg-lineas"><span class="bg-blanco">Contáctanos ahora</span></h2>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3330.6042728033494!2d-70.5614276852808!3d-33.40748698078623!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662cec259cf05df%3A0x1231ab5f46c3188b!2sApoquindo+Ote.+6862%2C+Las+Condes%2C+Regi%C3%B3n+Metropolitana%2C+Chile!5e0!3m2!1sen!2sus!4v1487858807130" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<div class="row">
				<div class="col-sm-12">
					<h2>Casa Matriz</h2>
					<p>Dirección: Av. Apoquindo 6862 - Las Condes</p>
					<p>Teléfono: +56 2 2210 9100</p>
					<p>Empoqil: contactoweb@hookipa.cl</p>
				</div>
			</div>
		</div>

		<div class="col-sm-8">
			<h2>Contáctenos</h2>
			<?= $this->Form->create('Contacto', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
            <div class="row">
                <div class="col-sm-12">
                    <?= $this->Form->label('asunto', 'Asunto'); ?>
                    <?= $this->Form->input('asunto'); ?>
                </div>
                <div class="col-sm-12">
                    <?= $this->Form->label('nombre', 'Nombre'); ?>
                    <?= $this->Form->input('nombre', array(
                        'value'			=> (! empty($usuario) ? sprintf('%s %s %s', $usuario['nombre'], $usuario['apellido_paterno'], $usuario['apellido_materno']) : null),
                        'disabled'		=> (! empty($usuario) ? true : false)
                    )); ?>
                </div>
                <div class="col-sm-6">
                    <?= $this->Form->label('region_id', 'Región'); ?>
                    <?= $this->Form->input('region_id', array('class' => 'form-control select', 'empty' => '-- Selecciona una región')); ?>
                </div>
                <div class="col-sm-6">
                    <?= $this->Form->label('comuna_id', 'Comuna'); ?>
                    <?= $this->Form->input('comuna_id', array('class' => 'form-control select')); ?>
                </div>
                <div class="col-sm-12">
                    <?= $this->Form->label('email', 'Email'); ?>
                        <?= $this->Form->input('email', array(
                            'value'			=> (! empty($usuario) ? $usuario['email'] : null),
                            'disabled'		=> (! empty($usuario) ? true : false)
                        )); ?>
                </div>
                <div class="col-sm-12">
                    <?= $this->Form->label('mensaje', 'Mensaje'); ?>
                    <?= $this->Form->input('mensaje'); ?>
                </div>
            </div>
            <div class="pull-right">
                <input type="submit" class="btn btn-primary esperar-carga" autocomplete="off" data-loading-text="Espera un momento..." value="Enviar">
            </div>
			<?= $this->Form->end(); ?>
		</div>
	</div>
</div>
