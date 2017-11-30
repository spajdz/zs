<div class="page-title">
	<h2><span class="fa fa-database"></span> Querys SQL</h2>
</div>

<div class="page-content-wrap">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Listado de querys</h3>
			<!--
			<div class="btn-group pull-right">
				<?= $this->Html->link('<i class="fa fa-plus"></i> Nueva query', array('action' => 'add'), array('class' => 'btn btn-success', 'escape' => false)); ?>
			</div>
			-->
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr class="sort">
							<th><?= $this->Paginator->sort('administrador_id', 'Autor', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('identificador', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th width="30%"><?= $this->Paginator->sort('descripcion', 'Descripción', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('version', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('created', 'Última modificación', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ( $querys as $query ) : ?>
						<tr>
							<td><?= h($query['Administrador']['nombre']); ?></td>
							<td><?= h($query['Query']['identificador']); ?>&nbsp;</td>
							<td><?= h($query['Query']['descripcion']); ?>&nbsp;</td>
							<td><?= h($query['Query']['version']); ?>&nbsp;</td>
							<td><?= h($query['Query']['created']); ?>&nbsp;</td>
							<td>
								<?= $this->Html->link('<i class="fa fa-edit"></i> Editar', array('action' => 'edit', $query['Query']['id']), array('class' => 'btn btn-mini btn-info', 'rel' => 'tooltip', 'title' => 'Editar este registro', 'escape' => false)); ?>
								<?= $this->Html->link('<i class="fa fa-remove"></i> Borrar Cache', array('action' => 'eliminarCache', $query['Query']['id']), array('class' => 'btn btn-mini btn-danger', 'rel' => 'tooltip', 'title' => 'Eliminar cache', 'escape' => false)); ?>
								<? $this->Form->postLink('<i class="fa fa-remove"></i> Eliminar', array('action' => 'delete', $query['Query']['id']), array('class' => 'btn btn-mini btn-danger confirmar-eliminacion', 'rel' => 'tooltip', 'title' => 'Eliminar este registro', 'escape' => false)); ?>
							</td>
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
		<?= $this->Paginator->numbers(array('tag' => 'li', 'currentTag' => 'a', 'modulus' => 8, 'currentClass' => 'active', 'separator' => '')); ?>
		<?= $this->Paginator->next('Siguiente »', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'last disabled hidden')); ?>
	</ul>
</div>
