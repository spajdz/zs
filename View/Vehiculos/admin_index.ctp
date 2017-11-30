<div class="row">
	<div class="col-md-12">
		<div class="page-title">
			<h2><span class="fa fa-list"></span> Vehiculos</h2>
		</div>

		<div class="page-content-wrap">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Listado de Vehiculos</h3>
					<div class="btn-group pull-right">
						<?= $this->Html->link('<i class="fa fa-plus"></i> Nuevo Vehiculo', array('action' => 'add'), array('class' => 'btn btn-success', 'escape' => false)); ?>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr class="sort">
									<? $this->Paginator->options(array('title' => 'Haz click para ordenar por este criterio')); ?>
									<th><?= $this->Paginator->sort('marca'); ?></th>
									<th><?= $this->Paginator->sort('modelo'); ?></th>
									<th><?= $this->Paginator->sort('version'); ?></th>
									<th><?= $this->Paginator->sort('apernadura'); ?></th>
									<th><?= $this->Paginator->sort('aro'); ?></th>
									<th><?= $this->Paginator->sort('ancho'); ?></th>
									<th><?= $this->Paginator->sort('ancho_llanta'); ?></th>
									<th><?= $this->Paginator->sort('perfil'); ?></th>
									<th><?= $this->Paginator->sort('ano', 'Año'); ?></th>
									<th><?= $this->Paginator->sort('puertas'); ?></th>
									<th><?= $this->Paginator->sort('carroceria'); ?></th>
									<th><?= $this->Paginator->sort('traccion'); ?></th>
									<th><?= $this->Paginator->sort('medida_original'); ?></th>
									<th><?= $this->Paginator->sort('indice_carga'); ?></th>
									<th><?= $this->Paginator->sort('velocidad'); ?></th>
								</tr>
								</tr>
							</thead>
							<tbody>
								<? foreach ( $vehiculos as $vehiculo ) : ?>
								<tr>
									<td><?= h($vehiculo['Vehiculo']['marca']); ?>&nbsp;</td>
									<td><?= h($vehiculo['Vehiculo']['modelo']); ?>&nbsp;</td>
									<td><?= h($vehiculo['Vehiculo']['version']); ?>&nbsp;</td>
									<td><?= h($vehiculo['Vehiculo']['apernadura']); ?>&nbsp;</td>
									<td><?= h($vehiculo['Vehiculo']['aro']); ?>&nbsp;</td>
									<td><?= h($vehiculo['Vehiculo']['ancho']); ?>&nbsp;</td>
									<td><?= h($vehiculo['Vehiculo']['ancho_llanta']); ?>&nbsp;</td>
									<td><?= h($vehiculo['Vehiculo']['perfil']); ?>&nbsp;</td>
									<td><?= h($vehiculo['Vehiculo']['ano']); ?>&nbsp;</td>
									<td><?= h($vehiculo['Vehiculo']['puertas']); ?>&nbsp;</td>
									<td><?= h($vehiculo['Vehiculo']['carroceria']); ?>&nbsp;</td>
									<td><?= h($vehiculo['Vehiculo']['traccion']); ?>&nbsp;</td>
									<td><?= h($vehiculo['Vehiculo']['medida_original']); ?>&nbsp;</td>
									<td><?= h($vehiculo['Vehiculo']['indice_carga']); ?>&nbsp;</td>
									<td><?= h($vehiculo['Vehiculo']['velocidad']); ?>&nbsp;</td>
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
