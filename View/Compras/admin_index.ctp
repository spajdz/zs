<? $this->Paginator->options(array('url' => array('action' => 'index') + $filtros)); ?>

<div class="page-title">
	<h2><span class="fa fa-list-ol"></span> Listado OC</h2>
</div>
<?= $this->Html->scriptBlock(sprintf("var limites = %s;", json_encode($limites))); ?>
<?= $this->Html->scriptBlock(sprintf("var filtros = %s;", json_encode($filtros))); ?>

<? if ( $flash = $this->Session->flash('danger') ) : ?>
<div class="alert alert-danger" data-dismiss="alert" role="alert">
	<?= $flash; ?>
</div>
<? endif; ?>

<? if ( $flash = $this->Session->flash('sucess') ) : ?>
<div class="alert alert-sucess" data-dismiss="alert" role="alert">
	<?= $flash; ?>
</div>
<? endif; ?>

<div class="panel panel-default">
	<div class="panel-body">
		<h3>Filtros</h3>
		<?= $this->Form->create('Compra', array('inputDefaults' => array('label' => false, 'required' => false))); ?>
			<div class="row fila-filtro">
				<div class="col-md-6">
					<label class="control-label">Búsqueda libre <a href="#" class="btn btn-primary btn-xs btn-limpiar js-limpiar-busqueda" data-tipo="libre">Limpiar</a></label>
					<div class="input-group">
						<span class="input-group-addon"><span class="fa fa-search"></span></span>
						<?= $this->Form->input('libre', array(
							'data-tipo'		=> 'libre',
							'value'			=> (! empty($filtros['filtro']['buscar']) ? $filtros['filtro']['buscar'] : ''),
							'class'			=> 'form-control',
							'placeholder'	=> 'Nombre cliente, Email, Teléfono, N° OC, Valor total'
						)); ?>
					</div>
				</div>
				<div class="col-md-3">
					<label class="control-label">Fecha de compra <a href="#" class="btn btn-primary btn-xs btn-limpiar js-limpiar-busqueda" data-tipo="fecha">Limpiar</a></label>
					<div class="input-group">
						<span class="input-group-addon add-on"><span class="fa fa-calendar"></span></span>
						<?= $this->Form->input('fecha_inicio', array('data-tipo' => 'fecha', 'value' => (! empty($filtros['filtro']['fecha_min']) ? $filtros['filtro']['fecha_min'] : ''), 'class' => 'form-control', 'placeholder' => 'Fecha inicial')); ?>
					</div>
				</div>
				<div class="col-md-3">
					<label class="control-label">&nbsp;</label>
					<div class="input-group">
						<span class="input-group-addon add-on"><span class="fa fa-calendar"></span></span>
						<?= $this->Form->input('fecha_fin', array('data-tipo' => 'fecha', 'value' => (! empty($filtros['filtro']['fecha_max']) ? $filtros['filtro']['fecha_max'] : ''), 'class' => 'form-control', 'placeholder' => 'Fecha fin')); ?>
					</div>
				</div>
			</div>
			<div class="row fila-filtro">
				<div class="col-md-6">
					<label class="control-label">Estado de compra <a href="#" class="btn btn-primary btn-xs btn-limpiar js-limpiar-busqueda" data-tipo="estado">Limpiar</a></label>
					<?= $this->Form->input('estado_compra_id', array(
							'data-tipo'		=> 'estado',
							'selected'		=> (! empty($filtros['filtro']['estado']) ? $filtros['filtro']['estado'] : false),
							'options'		=> $estadoCompras,
							'multiple'		=> true,
							'class'			=> 'form-control selectpicker',
							'title'			=> '-- Selecciona el estado de compra'
						)
					); ?>
				</div>
				<div class="col-md-6">
					<label class="control-label">Periodo de tiempo</label>
					<div class="btn-group btn-group-justified">
						<a href="#" class="btn btn-primary js-data-search" data-tipo="todo">Todos los tiempos</a>
						<a href="#" class="btn btn-primary js-data-search" data-tipo="dia" data-rango="7"> Última semana </a>
						<a href="#" class="btn btn-primary js-data-search" data-tipo="mes" data-rango="1">Último Mes</a>
						<a href="#" class="btn btn-primary js-data-search" data-tipo="mes" data-rango="3">Último trimestre</a>
					</div>
				</div>
			</div>
			<div class="row fila-filtro">
				<div class="col-md-6">
					 <div class="form-group">
						<label class="control-label">Rango de OC <a href="#" class="btn btn-primary btn-xs btn-limpiar js-limpiar-busqueda" data-tipo="oc">Limpiar</a></label>
						<?= $this->Form->input('rango_oc', array('data-tipo' => 'oc', 'disabled' => true, 'value' => null, 'data-min-oc' => $limites['oc_primera'], 'data-max-oc' => $limites['oc_ultima'])); ?>
					</div>
				</div>
				<div class="col-md-6">
					 <div class="form-group">
						<label class="control-label">Rango de monto de venta <a href="#" class="btn btn-primary btn-xs btn-limpiar js-limpiar-busqueda" data-tipo="monto">Limpiar</a></label>
						<?= $this->Form->input('rango_monto', array('data-tipo' => 'monto', 'disabled' => true, 'value' => null, 'data-min-monto' => $limites['monto_minimo'], 'data-max-monto' => $limites['monto_maximo'])); ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6"></div>
				<div class="col-md-6">
					<label class="control-label">&nbsp;</label>
					<div class="form-group" style="text-align: right;">
						<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
						<?= $this->Html->link('<i class="fa fa-file-excel-o"></i> Exportar', array('action' => 'excel') + $filtros, array('class' => 'btn btn-success', 'escape' => false)); ?>
						<?= $this->Html->link('<i class="fa fa-repeat"></i> Limpiar', array('action' => 'index'), array('class' => 'btn btn-danger', 'escape' => false)); ?>
					</div>
				</div>
			</div>
		<?= $this->Form->end(); ?>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr class="sort">
						<th><?= $this->Paginator->sort('id', 'Número OC', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
						<th><?= $this->Paginator->sort('id', 'OC Transbank', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
						<th><?= $this->Paginator->sort('Usuario.nombre', 'Nombre', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
						<th><?= $this->Paginator->sort('Usuario.email', 'E-mail', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
						<th><?= $this->Paginator->sort('total', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
						<th><?= $this->Paginator->sort('estado_compra_id', 'Estado', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
						<th><?= $this->Paginator->sort('created', 'Fecha', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<? foreach ( $compras as $compra ) :
						$sucess = array('1' => 'warning', '2' => 'danger', '3' => 'danger', '4' => 'success', '5' => 'primary');
					?>
						<tr>
							<td><?= $compra['Compra']['id']; ?></td>
							<td><?= $compra['Compra']['tbk_orden_compra']; ?></td>
							<td><?= sprintf('%s %s %s', $compra['Usuario']['nombre'], $compra['Usuario']['apellido_paterno'], $compra['Usuario']['apellido_materno']); ?></td>
							<td><?= h($compra['Usuario']['email']) ?></td>
							<td>$ <?= h(number_format($compra['Compra']['total'],0,',','.')); ?></td>
							<td><span class="label label-<?= $sucess[$compra['EstadoCompra']['id']]; ?>"><?= explode(' ', $compra['EstadoCompra']['nombre'])[0]; ?></span></td>
							<td><?= h($compra['Compra']['created']) ?></td>
							<td>
								<?= $this->Html->link('<i class="fa fa-eye"></i> Ver', array('action' => 'view', $compra['Compra']['id']), array('class' => 'btn btn-mini btn-info', 'rel' => 'tooltip', 'title' => 'Ver este registro', 'escape' => false)); ?>
								<? if ( $compra['EstadoCompra']['id'] == 4 && $compra['Compra']['tbk_tipo_pago'] != 'VD') : ?>
									<?= $this->Html->link('<i class="fa fa-dollar"></i> Anular', array('action' => 'anular', $compra['Compra']['id']), array('class' => 'btn btn-danger', 'escape' => false)); ?>
								<? endif; ?>
							</td>
						</tr>
					<? endforeach; ?>
				</tbody>
			</table>
			<div class="pull-right">
				<ul class="pagination">
					<?= $this->Paginator->prev('« Anterior', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'first disabled hidden')); ?>
					<?= $this->Paginator->numbers(array('tag' => 'li', 'currentTag' => 'a', 'modulus' => 2, 'currentClass' => 'active', 'separator' => '')); ?>
					<?= $this->Paginator->next('Siguiente »', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'last disabled hidden')); ?>
				</ul>
			</div>
		</div>
	</div>
</div>
