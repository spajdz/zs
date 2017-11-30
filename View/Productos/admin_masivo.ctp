<div class="page-title">
	<h2><span class="fa fa-folder-open"></span> Carga masiva Productos</h2>
</div>
<div class="page-content-wrap">
	<? if ( $flash = $this->Session->flash('success') ) : ?>
		<div class="alert alert-success" data-dismiss="alert" role="alert">
			<?= $flash; ?>
		</div>
	<? endif; ?>
	<!-- Realiza carga masiva -->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">
						<p>
							<?= $this->Html->link(
									'Realizar carga masiva',
									array('controller' => 'productos', 'action' => 'masivo', 'cargar', 'productos'),
									array(
										'class' => 'btn btn-primary btn-lg',
										'escape' => false
									)
							); ?>
						</p>
					</h3>
				</div>
			</div>
		</div>
	</div>
	<!-- Estadisticas -->
	<div class="row">
		<!-- Estadisticas de productos -->
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Estadisticas de los productos</h3>
				</div>
				<div class="panel-body">
					<?
						/** Cantidad porcentual */
						$porcentajeCatalogo 	= ($catalogo * 100) / $total;
						$porcentajeHookipa 		= ($hookipa * 100) / $total;
						$porcentajeReserva		= ($reserva * 100) / $total;
						$porcentajeLista 		= ($lista * 100) / $total;
					?>
					<!-- CANTIDAD DE PRODUCTOS POR CATALOGO -->
					<div class="col-md-6">
						<h5>
							<?= sprintf(
									'Cantidad de productos en catalogo | %d (%01.2f%%)',
									$catalogo,
									$porcentajeCatalogo
							); ?>
						</h5>
						<div class="progress">
							<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $catalogo; ?>" aria-valuemin="0" aria-valuemax="<?= $total; ?>" style="width: <?= $porcentajeCatalogo; ?>%"></div>
						</div>
					</div>
					<!-- CANTIDAD DE PRODUCTOS POR HOOKIPA SPORT -->
					<div class="col-md-6">
						<h5>
							<?= sprintf(
									'Cantidad de productos en hookipa sport | %d (%01.2f%%)',
									$hookipa,
									$porcentajeHookipa
							); ?>
						</h5>
						<div class="progress">
							<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?= $hookipa; ?>" aria-valuemin="0" aria-valuemax="<?= $total; ?>" style="width: <?= $porcentajeHookipa; ?>%"></div>
						</div>
					</div>

					<!-- CANTIDAD DE PRODUCTOS POR RESERVA -->
					<div class="col-md-6">
						<h5>
							<?= sprintf(
									'Cantidad de productos en reserva | %d (%01.2f%%)',
									$reserva,
									$porcentajeReserva
							); ?>
						</h5>
						<div class="progress">
							<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?= $reserva; ?>" aria-valuemin="0" aria-valuemax="<?= $total; ?>" style="width: <?= $porcentajeReserva; ?>%"></div>
						</div>
					</div>
					<!-- CANTIDAD DE PRODUCTOS POR LISTA -->
					<div class="col-md-6">
						<h5>
							<?= sprintf(
									'Cantidad de productos en lista | %d (%01.2f%%)',
									$lista,
									$porcentajeLista
							); ?>
						</h5>
						<div class="progress">
							<div class="progress-bar progress-bar-colorful" role="progressbar" aria-valuenow="<?= $lista; ?>" aria-valuemin="0" aria-valuemax="<?= $total; ?>" style="width: <?= $porcentajeLista; ?>%"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Estadisticas de ejecucion de carga masiva
		<div class="col-md-6">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h3 class="panel-title">Estadisticas de ejecución de carga masiva</h3>
				</div>
				<div class="panel-body">

					<div class="panel panel-default">
						<div class="panel-body">
							<div id="morris-line-example" style="height: 300px;"></div>
						</div>
					</div>

				</div>
			</div>
		</div> -->
	</div>
</div>

<!-- ********************* Carga masiva comunas y regiones ****************************** -->
<div class="page-title">
	<h2><span class="fa fa-folder-open"></span> Carga masiva Comunas y regiones</h2>
</div>

<div class="page-content-wrap">
	<? if ( $flash = $this->Session->flash('success') ) : ?>
		<div class="alert alert-success" data-dismiss="alert" role="alert">
			<?= $flash; ?>
		</div>
	<? endif; ?>
	<!-- Realiza carga masiva -->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">
						<p>
							<?= $this->Html->link(
									'Realizar carga masiva',
									array('controller' => 'comunas', 'action' => 'masivo', 'cargar'),
									array(
										'class' => 'btn btn-primary btn-lg',
										'escape' => false
									)
							); ?>
						</p>
					</h3>
				</div>
			</div>
		</div>
	</div>
	<!-- Estadisticas -->
	<div class="row">

	</div>
</div>
