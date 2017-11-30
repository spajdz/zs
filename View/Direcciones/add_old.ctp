<?= $this->Html->script(array(
	'vendor/jquery.chained.remote',
	'vendor/jquery.maskedinput.min',
	'vendor/jquery.validate.min',
	'direcciones.add'
), array('inline' => false)) ;?>

<div class="contenedor">
	<div class="row cont-pasos">
		<div class="col-xs-4">
			<div class="pasos-carro ">
			<span class="visible-xs">Paso 01</span>
			<? if ( $lista ) : ?>
			<h3><span>01</span> Selecciona tus Listas</h3>
			<? else : ?>
			<h3><span>01</span> Confirma tu Compra</h3>
			<? endif; ?>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="pasos-carro active">
			<span class="visible-xs">Paso 02</span>
			<h3><span>02</span> Ingresa tu Dirección</h3>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="pasos-carro no-margin">
			<span class="visible-xs">Paso 03</span>
			<h3><span>03</span> Finaliza tu Compra</h3>
			</div>
		</div>
	</div>

	<?= $this->element('alertas'); ?>

	<?= $this->Form->create('Direccion', array('inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>

		<? if ( ! empty($direcciones) ) : ?>
		<div class="row direccion">
			<div class="col-sm-6">
				<h2>Enviamos a tu dirección favorita</h2>
			</div>
			<div class="col-sm-6">
				<?= $this->Form->input('id', array('type' => 'select', 'options' => $direcciones, 'class' => 'form-control', 'empty' => '-- Selecciona una dirección', 'div' => false, 'label' => false)); ?>
			</div>
		</div>
		<? endif; ?>

		<div class="row ingreso-direccion">
			<div class="col-sm-12">
				<h2>Ingresa Tu Dirección</h2>
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
								<p class="help-block">Si quieres conocer tu código postal, <a href="http://www.correos.cl/SitePages/codigo_postal/codigo_postal.aspx" target="_blank">haz click aquí</a></p>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<?= $this->Form->label('telefono', 'Celular'); ?>
								<?= $this->Form->input('telefono'); ?>
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<?= $this->Form->label('observaciones', 'Indicación / referencia'); ?>
								<?= $this->Form->input('observaciones', array('maxlength' => 'max')); ?>
							</div>
						</div>
					</div>
				<div class="col-sm-12 total-compra">
					<p>Valor Despacho: <span class="js-valor-despacho">$0</span>
						<span class="js-observacion direccion-add-observacion"></span>
					</p>
					<span class="texto-despacho-compra">El tiempo aproximado de entrega es de 7 días.</span>
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
				<?= $this->Html->link('volver', array('controller' => 'productos', 'action' => 'carro'), array('class' => 'btn')); ?>
			</div>
			<div class="col-sm-4 col-xs-8 right">
				<?= $this->Form->submit('Continuar', array('class' => 'btn', 'div' => false)); ?>
			</div>
		</div>
	<?= $this->Form->end(); ?>
</div>
