<?= $this->Html->script(array(
	'vendor/jquery.validate.min',
	'vendor/jquery.alphanumeric.pack',
	'vendor/bootstrap3-typeahead',
	'reservas.add'
), array('inline' => false)) ;?>
<? if ( ! empty($colegios) ) : ?>
<?= $this->Html->scriptBlock(sprintf('var reserva_colegios = %s;', json_encode($colegios))); ?>
<? endif; ?>

<div class="contenedor">
	<?= $this->element('alertas'); ?>
	<!--
	<div class="alert alert-warning" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>PUEDE RESERVAR PARA TANTOS ALUMNOS NECESITE,</strong> INCLUSO DE DISTINTOS COLEGIOS.
	</div>
	-->

	<!--
	<div class="row agregar-colegio">
		<div class="col-sm-6">
			<h2>Agregar Alumno</h2> <p> Seleccione Colegio y Nivel, automáticamente se agregarán los libros.</p>
		</div>
		<div class="col-sm-6">
			<a href="#" class="btn-fb js-reserva-nuevo-alumno">Agregar Alumno</a>
		</div>
	</div>
	-->

	<? if ( $colegio ) : ?>
	<h2 class="datos">Datos de tu Reserva</h2>
	<div class="row datos-personales2">
		<div class="col-sm-2">
			<?= $this->Html->image($this->Hookipa->imagenColegio($colegio['codigo']), array('class' => 'logoCole img-responsive')); ?>
		</div>
		<div class="col-sm-7">
			<h2><?= h($colegio['nombre']); ?></h2>
			<div class="col-sm-6"><div class="form-group"><p><span>Nombre:</span> <?= h(AuthComponent::user('nombre')); ?></p></div></div>
			<div class="col-sm-6"><div class="form-group"><p><span>Apellido:</span> <?= sprintf('%s %s', h(AuthComponent::user('apellido_paterno')), h(AuthComponent::user('apellido_materno'))); ?></p></div></div>
			<div class="col-sm-6"><div class="form-group"><p><span>Celular:</span> <?= h(AuthComponent::user('celular')); ?></p></div></div>
			<div class="col-sm-6"><div class="form-group"><p><span>Email:</span> <?= h(AuthComponent::user('email')); ?></p></div></div>
		</div>
		<div class="col-sm-3 text-center">
			<?= $this->Html->link(
				'<i class="fa fa-exchange"></i> Cambiar Colegio',
				array('action' => 'cambiar_colegio'),
				array('class' => 'btn', 'escape' => false)
			); ?>
			<a href="#" class="btn js-agregar-alumno"><i class="fa fa-user-plus"></i> Agregar alumno</a>
		</div>
	</div>
	<? endif; ?>

	<? if ( ! $colegio ) : ?>
	<h2 class="datos">Seleccionar colegio</h2>
	<div class="row js-reserva-nuevo-alumno-container js-container">
		<div class="col-sm-12">
			<div class="cabecera-colegio-reserva">
				<?= $this->Form->create('Reserva', array('url' => array('action' => 'colegio'), 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
					<?= $this->Form->label('colegio', 'Selecciona el Colegio donde reservarás'); ?>
					<?= $this->Form->input('colegio', array(
						'type'				=> 'select',
						'empty'				=> '-- Selecciona el colegio',
						'value'				=> ($colegio ? $colegio['lista'] : null),
						'class'				=> 'form-control colegio',
						'placeholder'		=> 'Nombre del Colegio - Comuna',
						'xdata-provide'		=> 'typeahead',
						'xautocomplete'		=> 'off'
					)); ?>
					<?= $this->Form->submit('Seleccionar colegio', array('div' => false, 'class' => 'btn')); ?>
				<?= $this->Form->end(); ?>
			</div>
		</div>
	</div>
	<? endif; ?>

	<? if ( $colegio ) : ?>
	<div class="row js-reserva-nuevo-alumno-container js-container hidden">
		<div class="col-sm-12">
			<div class="cabecera-colegio-reserva">
				<a href="#" class="equis js-cerrar-container">x</a>
				<?= $this->Form->create('Reserva', array('inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>

					<?= $this->Form->label('nombre_alumno', 'Nombre del Alumno'); ?>
					<?= $this->Form->input('nombre_alumno', array('class' => 'form-control nombre primero', 'placeholder' => 'Nombre del Alumno')); ?>
					<?= $this->Form->input('apellido_alumno', array('class' => 'form-control nombre', 'placeholder' => 'Apellido del Alumno')); ?>
					<?= $this->Form->label('nivel', 'Selecciona el nivel del Alumno'); ?>
					<?= $this->Form->input('nivel', array('type' => 'select', 'options' => $niveles, 'empty' => '-- Selecciona el nivel', 'class' => 'form-control nivel')); ?>
					<?= $this->Form->submit('Agregar', array('div' => false, 'class' => 'btn')); ?>
				<?= $this->Form->end(); ?>
			</div>
		</div>
	</div>

	<? foreach ( $reservas as $reserva ) : $reserva_id = $reserva['Reserva']['id']; ?>
	<div class="alumno-colegio" data-id="<?= $reserva_id; ?>">
		<div class="row">
			<div class="col-sm-12">
				<div class="cabecera-colegio resultado">
					<a href="#" class="equis js-eliminar-reserva">x</a>
					<h2><?= sprintf('%s %s', $reserva['Reserva']['nombre_alumno'], $reserva['Reserva']['apellido_alumno']); ?> - <?= h($reserva['Reserva']['nivel']); ?></h2>
					<h3><?= h($reserva['Reserva']['nombre_colegio']); ?></h3>
					<!--<a href="#" class="edit">Editar</a>-->
				</div>
			</div>
		</div>

		<div class="row js-contenedor-reserva" id="no-more-tables">
			<table class="table-striped table-condensed cf">
				<thead class="cf">
					<tr>
						<th class="numeric">Reservar</th>
						<!--<th class="numeric" class="hidden-xs">Imagen</th>-->
						<th class="numeric">Nombre</th>
						<th class="numeric">Código</th>
						<th class="numeric">Modalidad</th>
						<th class="numeric">Precio</th>
						<th class="numeric">Cantidad</th>
						<th class="numeric">Total</th>
						<!--
						<th class="numeric">Eliminar</th>
						-->
					</tr>
				</thead>
				<tbody>
					<? foreach ( $productos['reserva'][$reserva_id]['Productos'] as $producto ) : ?>
					<tr class="js-contenedor-producto">
						<td data-title="Agregar">
							<?= $this->Form->input('seleccionar', array(
								'type'				=> 'checkbox',
								'class'				=> 'checkbox-reserva-libro js-reserva-seleccionar-texto',
								'data-id'			=> $producto['Data']['Producto']['id'],
								'data-reserva_id'	=> $reserva['Reserva']['id'],
								'checked'			=> ($producto['Meta']['Cantidad'] > 0)
							)); ?>
						</td>
						<!--
						<td data-title="Imagen:" class="hidden-xs">
							<? $this->Html->image($this->Hookipa->imagen($producto['Data']['Producto']['codigo']), array('class' => 'img-responsive')); ?>
						</td>
						-->
						<td data-title="Nombre:" class="nombre">
							<? h($producto['Data']['Producto']['articulo']); ?>
							<?= $this->Html->link(
								$producto['Data']['Producto']['articulo'],
								array('controller' => 'productos', 'action' => 'view', $producto['Data']['Producto']['codigo'])
							); ?>
						</td>
						<td data-title="Código:" class="isbn"><?= $producto['Data']['Producto']['codigo']; ?></td>
						<td data-title="Modalidad:">
							<? if ( $producto['Data']['Producto']['arriendo'] ) : ?>
							<span class="label label-warning">Arriendo</span>
							<? else : ?>
							<span class="label label-success">Venta</span>
							<? endif; ?>
						</td>
						<td data-title="Precio:" class="js-precio-libro">$<?= number_format($producto['Meta']['Precio'], 0, null, '.'); ?></td>
						<td data-title="Cantidad:" class="js-cantidad-libro"><?= $producto['Meta']['Cantidad']; ?></td>
						<td data-title="Total:" class="precio js-total-libro">$<?= number_format($producto['Meta']['Subtotal'], 0, null, '.'); ?></td>
						<!--
						<td data-title="Eliminar:">
						<?= $this->Html->link(
							'x', '#',
							array(
								'class'				=> 'equis js-eliminar-producto',
								'data-id'			=> $producto['Data']['Producto']['id'],
								'data-nombre'		=> h($producto['Data']['Producto']['articulo']),
								'data-imagen'		=> "img/{$this->Hookipa->imagen($producto['Data']['Producto']['codigo'], true)}"
							)
						); ?>
						</td>
						-->
					</tr>
					<? endforeach; ?>
				</tbody>
			</table>
			<div class="row padd20">
				<div class="col-sm-8 suma-compra">
					<a href="#" data-reserva_id="<?= $reserva_id; ?>" class="btn btn-xs btn-primary js-reserva-desel-todos"><i class="fa fa-square-o"></i> Deseleccionar todos</a>
					<a href="#" data-reserva_id="<?= $reserva_id; ?>" class="btn btn-xs btn-primary js-reserva-sel-todos"><i class="fa fa-check-square-o"></i> Seleccionar todos</a>
				</div>
				<div class="col-sm-4 total-compra">
					<p>Total reserva: <span class="js-subtotal-reserva">$<?= number_format($productos['reserva'][$reserva_id]['Meta']['Subtotal'], 0, null, '.'); ?></span></p>
				</div>
			</div>
		</div>
	</div>
	<? endforeach; ?>
	<? endif; ?>

	<div class="row">
		<div class="col-sm-8 col-xs-4"></div>
		<div class="col-sm-4 col-xs-8 right">
			<?= $this->Html->link(
				'Resumen reserva',
				array('controller' => 'reservas', 'action' => 'resumen'),
				array('class' => array(
					'btn',
					'todo',
					'js-accion-reserva',
					(empty($reservas) ? 'hidden' : '')
				))
			); ?>
		</div>
	</div>
</div>
