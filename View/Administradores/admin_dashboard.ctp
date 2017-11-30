<? $this->Html->script('/backend/js/demo_dashboard', array('inline' => false)); ?>
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-3">
			<div class="widget widget-default widget-item-icon">
				<div class="widget-item-left">
					<span class="fa fa-dollar"></span>
				</div>

				<div class="widget-data">
					<div class="widget-int num-count">$755.985.347</div>
					<div class="widget-title">Ventas del mes</div>
					<div class="widget-subtitle"><i class="fa fa-thumbs-o-up"></i> $655.985.347 </div>
				</div>
				<div class="widget-controls"></div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="widget widget-default widget-item-icon">
				<div class="widget-item-left">
					<span class="fa fa-shopping-cart"></span>
				</div>
				<div class="widget-data">
					<div class="widget-int num-count">42.245</div>
					<div class="widget-title">Transacciones</div>
					<div class="widget-subtitle">
						<i class="fa fa-thumbs-o-up"></i> 42.240
						<i class="fa fa-thumbs-o-down" style="margin-left:30px;"></i> 5
					</div>
				</div>
				<div class="widget-controls"></div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="widget widget-default widget-item-icon">
				<div class="widget-item-left">
					<span class="fa fa-check-square-o"></span>
				</div>
				<div class="widget-data">
					<div class="widget-int num-count">4.245</div>
					<div class="widget-title">Reservas Totales</div>
					<div class="widget-subtitle">
						<i class="fa fa-thumbs-o-up"></i> 4.240
						<i class="fa fa-thumbs-o-down" style="margin-left:30px;"></i> 5
					</div>
				</div>
				<div class="widget-controls"></div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="widget widget-default widget-item-icon">
				<div class="widget-item-left">
					<span class="fa fa-truck fa-flip-horizontal"></span>
				</div>
				<div class="widget-data">
					<div class="widget-int num-count">42.245</div>
					<div class="widget-title">Despachos</div>
					<div class="widget-subtitle">
						<i class="fa fa-thumbs-o-up"></i> 42.240
						<i class="fa fa-thumbs-o-down" style="margin-left:30px;"></i> 5
					</div>
				</div>
				<div class="widget-controls"></div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title-box">
						<h3>Ventas</h3>
						<span>Intención de Compra</span>
					</div>
					<ul class="panel-controls" style="margin-top: 2px;">
						<li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
						<li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
					</ul>
				</div>
				<div class="panel-body padding-0">
					<div class="chart-holder" id="dashboard-line-1" style="height: 400px;"></div>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title-box">
						<h3>Transacciones</h3>
						<span>Estado de las últimas Transacciones</span>
					</div>
					<ul class="panel-controls" style="margin-top: 2px;">
						<li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
						<li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
					</ul>
				</div>
				<div class="panel-body panel-body-table">
					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th width="20%">Estado</th>
									<th width="20%">OC</th>
									<th width="60%">Nombre</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><span class="label label-danger">En Carro</span></td>
									<td><strong><a href="detalle-oc.php">26500</a></strong><span class="peq">$23.990</span></td>
									<td><strong>Juan Pérez Pérez</strong><span class="peq">01/07/2015 13:52:52</span></td>
								</tr>
								<tr>
									<td><span class="label label-warning">Pendiente</span></td>
									<td><strong><a href="detalle-oc.php">26499</a></strong><span class="peq">$189.990</span></td>
									<td><strong>Máximiliano Buenaventura González</strong><span class="peq">01/07/2015 11:52:52</span></td>
								</tr>
								<tr>
									<td><span class="label label-success">Pagado</span></td>
									<td><strong><a href="detalle-oc.php">26499</a></strong><span class="peq">$189.990</span></td>
									<td><strong>Máximiliano Buenaventura</strong><span class="peq">01/07/2015 11:52:52</span></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title-box">
						<h3>Users Activity</h3>
						<span>Users vs returning</span>
					</div>
					<ul class="panel-controls" style="margin-top: 2px;">
						<li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
						<li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
								<li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Remove</a></li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="panel-body padding-0">
					<div class="chart-holder" id="dashboard-bar-1" style="height: 200px;"></div>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title-box">
						<h3>Ordenes de Compra</h3>
						<span>Estados OC último mes</span>
					</div>
					<ul class="panel-controls" style="margin-top: 2px;">
						<li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
						<li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
					</ul>
				</div>
				<div class="panel-body padding-0">
					<div class="chart-holder" id="dashboard-donut-1" style="height: 200px;"></div>
				</div>
			</div>
		</div>
	</div>
</div>
