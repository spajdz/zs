<div class="page-content-wrap">
	<!-- Variable que contiene los estados registrados de las OC -->
	<?= $this->Html->scriptBlock(sprintf("var estados 			= %s;", json_encode($estados_compra))); ?>
	<!-- Variable que conteien la cantidad de registros de OC por estados en un intervalo de tiempo-->
	<?= $this->Html->scriptBlock(sprintf("var cantidad_estados 	= %s;", json_encode($cantidad_estado))); ?>
	<!-- Variable que contiene el valor total por tipo de OC en un intervalo de tiempo -->
	<?= $this->Html->scriptBlock(sprintf("var valores_oc		= %s;", json_encode($valores_oc))); ?>

	<div class="row">
 
		<div class="col-md-4">

			<!-- Widget de total de ventas -->
			<div class="widget widget-default widget-carousel">
				<div class="owl-carousel" id="owl-example">
					<!-- Total| de compras todos los tiempos -->
					<div>
						<div class="widget-title">Total ventas</div>
						<div class="widget-subtitle"></div>
						<div class="widget-int">$<?= number_format(existe($widgets['total_valor_compra'], 'int'),0,',','.') ?></div>
						<div class="widget-subtitle"><?= existe($widgets['total_compras'], 'int') ?> ventas</div>
					</div>
					<!-- Total de compras del mes actual -->
					<div>
						<div class="widget-title">Total ventas del mes</div>
						<div class="widget-subtitle">Actual</div>
						<div class="widget-int">$<?= number_format(existe($widgets['valor_compra_mes_actual'], 'int'),0,',','.') ?></div>
						<div class="widget-subtitle"><?= $widgets['total_compras_mes_actual'] ?> ventas</div>
					</div>
					<!-- Total de compras del mes anterior -->
					<div>
						<div class="widget-title">Total ventas del mes</div>
						<div class="widget-subtitle"><?= ucfirst(__d('cake', date('F',mktime(0, 0, 0, date("m")-1,date("d"),date("Y"))))) ?></div>
						<div class="widget-int">$<?= number_format(existe($widgets['valor_compra_mes_anterior'], 'int'),0,',','.') ?></div>
						<div class="widget-subtitle"><?= existe($widgets['total_compras_mes_anterior'], 'int') ?> ventas</div>
					</div>
				</div>
			</div>

		</div>
		
	</div>



	<div class="row">
		<!-- Diagramas de comparacion (valores OC - tiempo)
		Este Diagrama compra la el monto total de registros de tipos de OC -->
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title-box">
						<h3>Total Ventas</h3>
						<span>Total ventas de los últimos 4 meses</span>
					</div>
				</div>
				<div class="panel-body padding-0">
					<div class="chart-holder" id="dashboard-line-2" style="height: 400px;"></div>
				</div>
			</div>
		</div>
		<!-- Diagramas de comparacion (Estado - tiempo)
		Este Diagrama compra la cantidad de registros de OC por estado -->
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title-box">
						<h3>Estados de Ventas</h3>
						<span>Estados de venta de los últimos 4 meses</span>
					</div>
				</div>
				<div class="panel-body padding-0">
					<div class="chart-holder" id="dashboard-line-1" style="height: 400px;"></div>
				</div>
			</div>
		</div>
	</div>



	<div class="row">
		<!-- Tabla que muestra los detalles de los ultimos 4 registros de OC -->
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title-box">
						<h3>Ventas</h3>
						<span>Ultimos 10 estados de compra</span>
					</div>
				</div> 
				<div class="panel-body panel-body-table">
					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th width="10%" class="text-center">Estado</th>
									<th width="10%" class="text-center">Nro. venta</th>
									<th width="35%" class="text-center">Cliente</th>
									<th width="10%" class="text-center">Subtotal</th>
									<th width="10%" class="text-center">Costo Envío</th>
									<th width="10%" class="text-center">Total</th>
									<th width="15%" class="text-center">Fecha</th>
									<th ></th>
								</tr>
							</thead>
							<tbody>
								<?php if(count($datos_compras)>1){
									//prx($datos_compras);
								?>	
								
								<? foreach ( $datos_compras as $compra ) :
									$sucess = array('1' => 'warning', '2' => 'danger', '3' => 'danger', '4' => 'success', '5' => 'primary', '6' => 'warning');
								?>
									<tr>
										<td class="text-center"><span class="label label-<?= $sucess[$compra['EstadoCompra']['id']]; ?>"><?= explode(' ', $compra['EstadoCompra']['nombre'])[0]; ?></span></td>

										<td><?= h($compra['Compra']['id']) ?></td>

										<td>
											<?= $this->Html->link(sprintf('%s %s (%s)', $compra['Usuario']['nombre'], $compra['Usuario']['apellido_paterno'], $compra['Usuario']['email']), array('controller' => 'usuarios', 'action' => 'edit', $compra['Usuario']['id']), array('title' => 'Ver info de cliente', 'escape' => false)); ?>
										</td>

										<td class="text-right">$<?= h(number_format($compra['Compra']['subtotal'],0,',','.')); ?></td>

										<td class="text-right">
											<?php
												if( empty($compra['Compra']['total_despacho']) || $compra['Compra']['total_despacho'] == 0) {
													echo "Sin costo";
												}
												else {
													echo "$" . number_format($compra['Compra']['total_despacho'],0,',','.');
												}
											?>
										</td>

										<td class="text-right">$<?= h(number_format($compra['Compra']['total'],0,',','.')); ?></td>

										<td><?= h(date("d-m-Y H:s:i", strtotime($compra['Compra']['created']))); ?></td>

										<td>
											<?= $this->Html->link('<i class="fa fa-eye"></i> Ver', array('action' => 'view', $compra['Compra']['id']), array('class' => 'btn btn-xs btn-info', 'rel' => 'tooltip', 'title' => 'Ver detalle de venta', 'escape' => false)); ?>
										</td>

									</tr>
								<? endforeach; 
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(".owl-carousel").owlCarousel({mouseDrag: false, touchDrag: true, slideSpeed: 300, paginationSpeed: 400, singleItem: true, navigation: false,autoPlay: true});
</script>