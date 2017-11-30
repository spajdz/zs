<?= $this->Html->script(array(
	'vendor/jquery.chained.remote',
	'vendor/jquery.maskedinput.min',
	'vendor/jquery.validate.min',
	'direcciones.add.js?_201708081621'
), array('inline' => false)) ;?>

<div class="contenedor">
	<div class="row cont-pasos">
		<div class="col-xs-4">
			<div class="pasos-carro ">
			<span class="visible-xs">Paso 01</span>
			<h3><span>01</span> Confirma tu Compra</h3>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="pasos-carro active">
			<span class="visible-xs">Paso 02</span>
			<h3><span>02</span> Ingresa tu Dirección</h3>
			<!-- <h3><span>02</span> Selecciona tu forma de despacho</h3> -->
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
		<div class="row ingreso-direccion">
			<div class="col-sm-12">
				<h2>Tipo de Despacho</h2>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<?= $this->Form->input('retiro_tienda', array('options' => $tiposDespacho));?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row seleccion-tienda" style="display: none;">
			<div class="col-sm-12">
				<h2>Selecciona tienda de retiro</h2>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<?= $this->Form->input('tienda_retiro', array('options' => $sucursales));?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<?= $this->Form->label('observaciones_retiro_tienda', 'Observaciones'); ?>
							<?= $this->Form->input('observaciones_retiro_tienda', array('maxlength' => 'max', 'class' => 'form-control', 'type'=> 'textarea')); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<? if ( ! empty($direcciones) ) : ?>
		<div class="row ingreso-direccion" id="direcciones-js">
			<div class="col-sm-12">
				<h2>Enviamos a tu dirección favorita</h2>
				<div class="row">
					<div class="col-sm-6">
					<div class="form-group">
							<?= $this->Form->input('id', array('type' => 'select', 'options' => $direcciones, 'class' => 'form-control', 'empty' => '-- Selecciona una dirección', 'div' => false, 'label' => false)); ?>
					</div>
				</div>
				</div>
			</div>
			
		</div>
		<? endif; ?>

		<div class="row ingreso-direccion">
			
			<div class="col-sm-12" id="info-direccion-js">
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
					AVISO DESPACHO
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
