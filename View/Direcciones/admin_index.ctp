<div class="page-title">
	<h2><span class="fa fa-list"></span> Direcciones</h2>
</div>

<div class="page-content-wrap">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Listado de Direcciones</h3>
			<div class="btn-group pull-right">
				<?= $this->Html->link('<i class="fa fa-plus"></i> Nueva Direccion', array('action' => 'add'), array('class' => 'btn btn-success', 'escape' => false)); ?>
				<?= $this->Html->link('<i class="fa fa-file-excel-o"></i> Exportar a Excel', array('action' => 'exportar'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table datatable">
					<thead>
						<tr class="sort">
							<th><?= $this->Paginator->sort('tipo_direccion_id', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('usuario_id', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('comuna_id', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('calle', null, array('title' => 'Haz click para ordenar por este criterio')); ?></th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $direcciones as $direccion ) : ?>
						<tr>
							<td><?= $this->Html->link($direccion['TipoDireccion']['nombre'], array('controller' => 'tipo_direcciones', 'action' => 'edit', $direccion['TipoDireccion']['id'])); ?></td>
							<td><?= $this->Html->link($direccion['Usuario']['nombre'], array('controller' => 'usuarios', 'action' => 'edit', $direccion['Usuario']['id'])); ?></td>
							<td><?= $this->Html->link($direccion['Comuna']['nombre'], array('controller' => 'comunas', 'action' => 'edit', $direccion['Comuna']['id'])); ?></td>
							<td><?= h($direccion['Direccion']['calle']); ?>&nbsp;</td>
							<td>
								<?= $this->Html->link('<i class="fa fa-edit"></i> Editar', array('action' => 'edit', $direccion['Direccion']['id']), array('class' => 'btn btn-xs btn-info', 'rel' => 'tooltip', 'title' => 'Editar este registro', 'escape' => false)); ?>
								<?= $this->Form->postLink('<i class="fa fa-remove"></i> Eliminar', array('action' => 'delete', $direccion['Direccion']['id']), array('class' => 'btn btn-xs btn-danger confirmar-eliminacion', 'rel' => 'tooltip', 'title' => 'Eliminar este registro', 'escape' => false)); ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


