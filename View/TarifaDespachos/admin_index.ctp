<div class="page-title">
	<h2><span class="fa fa-dollar"></span> Tarifas de despachos</h2>
</div>

<div class="page-content-wrap">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Listado tarifas</h3>
			<!-- Boton para direccionar a carga masiva -->
			<div class="btn-group pull-right">
				<?= $this->Html->link('<i class="fa fa-plus"></i> Realizar carga masiva', array('action' => 'masivo'), array('class' => 'btn btn-success', 'escape' => false)); ?>
			</div>
		</div>
		<div class="panel-body">
			<?= $this->Form->create('TarifaDespacho', array('inputDefaults' => array('label' => false))); ?>
			<div class="row">
				<div class="col-md-1 pull-right">
					<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
				</div>
				<div class="col-md-4 pull-right">
					<?= $this->Form->input('region_id', array('enpty' => 'Seleccionar Región', 'class' => 'form-control select', 'selected' => (! empty($filtros['filtro']['region']) ? $filtros['filtro']['region'] : '' ) ) ); ?>
				</div>
			</div>
			<? $this->Form->end(); ?>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr class="sort">
							<th><?= $this->Paginator->sort('Comuna.region_id', 'Región', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('Comuna.nombre', 'Comuna', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('peso150', '1.5 Kg', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('peso300', '3 Kg', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('peso600', '6 Kg', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('peso1000', '10 Kg', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('peso1500', '15 Kg', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<? foreach( $tarifas AS $tarifa ) : ?>
							<tr>
								<td><?= h($tarifa['Comuna']['Region']['nombre']) ?></td>
								<td><?= h($tarifa['Comuna']['nombre']) ?></td>
								<td>$ <?= h(number_format($tarifa['TarifaDespacho']['peso150'],0,',','.')) ?></td>
								<td>$ <?= h(number_format($tarifa['TarifaDespacho']['peso300'],0,',','.')) ?></td>
								<td>$ <?= h(number_format($tarifa['TarifaDespacho']['peso600'],0,',','.')) ?></td>
								<td>$ <?= h(number_format($tarifa['TarifaDespacho']['peso1000'],0,',','.')) ?></td>
								<td>$ <?= h(number_format($tarifa['TarifaDespacho']['peso1500'],0,',','.')) ?></td>
								<td><?= $this->Html->link('<i class="fa fa-edit"></i> Editar', array('action' => 'edit', $tarifa['TarifaDespacho']['id']), array('class' => 'btn btn-info', 'rel' => 'tooltip', 'title' => 'Editar este registro', 'escape' => false)); ?></td>
							</tr>
						<? endforeach;?>
					</tbody>
				</table>
				<!-- Paginadores -->
				<div class="pull-right">
					<ul class="pagination">
						<?= $this->Paginator->prev('« Anterior', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'first disabled hidden')); ?>
						<?= $this->Paginator->numbers(array('tag' => 'li', 'currentTag' => 'a', 'modulus' => 8, 'currentClass' => 'active', 'separator' => '')); ?>
						<?= $this->Paginator->next('Siguiente »', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'last disabled hidden')); ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
