<footer>
	<div class="row">
		<div class="col-md-8 col-xs-12">
			<div class="col-md-6 col-xs-12">
				<?= $this->Html->image('logo-zs-motors.png'); ?>
			</div>
			<div class="col-md-6 col-xs-12">
				<ul>
					<li>
						<?= $this->Html->link(
							'Por qué elegirnos',
							array('controller' => 'pages', 'action' => 'display', 'porque'),
							array('escape' => false, 'style' => 'float: none;')
						); ?>
					</li>
					<li>
						<?= $this->Html->link(
							'Catálogo',
							array('controller' => 'productos', 'action' => 'index', 'lista' => 'catalogo'),
							array('escape' => false, 'style' => 'float: none;')
						); ?>
					</li>
					<li>
						<?= $this->Html->link(
							'Nuestras Sucursales',
							array('controller' => 'sucursales'),
							array('escape' => false, 'style' => 'float: none;')
						); ?>
					</li>
					<li>
						<?= $this->Html->link(
							'Nuestros Colegios',
							array('controller' => 'colegios'),
							array('escape' => false, 'style' => 'float: none;')
						); ?>
					</li>
					<li>
						<?= $this->Html->link(
							'Contáctanos ahora',
							array('controller' => 'contactos', 'action' => 'add'),
							array('escape' => false, 'style' => 'float: none;')
						); ?>
					</li>
				</ul>
			</div>
		</div>
		<div class="col-md-4 col-xs-12">
			<div class="row">
				<div class="col-md-12 col-xs-12 footer-2a">
					<h3>Contáctanos</h3>
					<p><?= $this->Html->link('servicioalcliente@zsmotor.cl', array('controller' => 'contactos', 'action' => 'add')); ?></p>
				</div>
				<div class="col-md-12 col-xs-12 footer-2b">
					<h3>Call - Center <a href="tel:+56222109100" class="fono"> +56 2 2210 9100</a></h3>
					<p>
						Horario de atención de llamados:<br/>
						Lunes a viernes de 9:00 a 19:00 hrs.
					</p>
				</div>
			</div>
		</div>
	</div>
</footer>
