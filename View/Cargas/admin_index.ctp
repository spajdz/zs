<div class="row">
	<div class="col-md-12">
		<div class="page-title">
			<h2><span class="fa fa-list"></span> Cargas</h2>
		</div>

		<div class="page-content-wrap">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Listado de Cargas</h3>
					<div class="btn-group pull-right">
						<?= $this->Html->link('<i class="fa fa-plus"></i> Nuevo Carga', array('action' => 'add'), array('class' => 'btn btn-success', 'escape' => false)); ?>
						<?= $this->Html->link('<i class="fa fa-file-excel-o"></i> Exportar a Excel', array('action' => 'exportar'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr class="sort">
									<? $this->Paginator->options(array('title' => 'Haz click para ordenar por este criterio')); ?>
									<th><?= $this->Paginator->sort('identificador'); ?></th>
									<th><?= $this->Paginator->sort('ejecutando'); ?></th>
									<th><?= $this->Paginator->sort('error'); ?></th>
									<th><?= $this->Paginator->sort('ultimo_mensaje'); ?></th>
									<th><?= $this->Paginator->sort('productos_total', 'Total Productos'); ?></th>
									<th><?= $this->Paginator->sort('productos_nuevos', 'Total Productos Nuevos'); ?></th>
									<th><?= $this->Paginator->sort('productos_modificados', 'Total Productos Modificados'); ?></th>
								</tr>
							</thead>
							<tbody>
								<? foreach ( $cargas as $carga ) : ?>
								<tr>
									<td><?= h($carga['Carga']['identificador']); ?>&nbsp;</td>
									<td><?= ($carga['Carga']['ejecutando'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>'); ?>&nbsp;</td>
									<td><?= ($carga['Carga']['error'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>'); ?>&nbsp;</td>
									<td><?= h($carga['Carga']['ultimo_mensaje']); ?>&nbsp;</td>
									<td><?= h($carga['Carga']['productos_total']); ?>&nbsp;</td>
									<td><?= h($carga['Carga']['productos_nuevos']); ?>&nbsp;</td>
									<td><?= h($carga['Carga']['productos_modificados']); ?>&nbsp;</td>
									
								</tr>
								<? endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="pull-right">
			<ul class="pagination">
				<?= $this->Paginator->prev('« Anterior', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'first disabled hidden')); ?>
				<?= $this->Paginator->numbers(array('tag' => 'li', 'currentTag' => 'a', 'modulus' => 2, 'currentClass' => 'active', 'separator' => '')); ?>
				<?= $this->Paginator->next('Siguiente »', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'last disabled hidden')); ?>
			</ul>
		</div>
	</div>
</div>
