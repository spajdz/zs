<div class="page-title">
	<h2><span class="fa fa-dollar"></span> Grupos Tarifarios</h2>
</div>

<div class="page-content-wrap">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Listado de grupos tarifarios</h3>
			<div class="btn-group pull-right">
				<?= $this->Html->link('<i class="fa fa-plus"></i> Nuevo grupo tarifario', array('action' => 'add'), array('class' => 'btn btn-success', 'escape' => false)); ?>
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr class="sort">
							<th><?= $this->Paginator->sort('nombre', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('comentario', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('identificador', 'Query', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('activo', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('última modificación', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('administrador_id', 'Modificado por', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ( $grupoTarifarios as $grupoTarifario ) : ?>
						<tr>
							<td><?= h($grupoTarifario['GrupoTarifario']['nombre']); ?>&nbsp;</td>
							<td><?= h($grupoTarifario['GrupoTarifario']['comentario']); ?>&nbsp;</td>
							<td><?= $this->Html->link($grupoTarifario['Query']['identificador'], array('controller' => 'querys', 'action' => 'edit', $grupoTarifario['Query']['id'])); ?></td>
							<td style="text-align: center" ><?= ($grupoTarifario['GrupoTarifario']['activo'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>'); ?>&nbsp;</td>
							<td><?= h($grupoTarifario['Administrador']['nombre']); ?></td>
							<td><?= h($grupoTarifario['Administrador']['nombre']); ?></td>
							<td>
								<?= $this->Html->link('<i class="fa fa-edit"></i> Editar', array('action' => 'edit', $grupoTarifario['GrupoTarifario']['id']), array('class' => 'btn btn-info', 'rel' => 'tooltip', 'title' => 'Editar este registro', 'escape' => false)); ?>
								<? if ( $grupoTarifario['GrupoTarifario']['activo'] ) : ?>
									<?= $this->Html->link('<i class="fa fa-square-o"></i> Desactivar', array('action' => 'desactivar', $grupoTarifario['GrupoTarifario']['id']), array('class' => 'btn btn-danger', 'rel' => 'tooltip', 'title' => 'Desactivar este registro', 'escape' => false)); ?>
								<? else : ?>
									<?= $this->Html->link('<i class="fa fa-check-square-o"></i> Activar', array('action' => 'activar', $grupoTarifario['GrupoTarifario']['id']), array('class' => 'btn btn-primary', 'rel' => 'tooltip', 'title' => 'Activar este registro', 'escape' => false)); ?>
								<? endif; ?>
								<?= $this->Form->postLink('<i class="icon-remove icon-white"></i> Eliminar', array('action' => 'delete', $grupoTarifario['GrupoTarifario']['id']), array('class' => 'btn btn-mini btn-danger confirmar-eliminacion', 'rel' => 'tooltip', 'title' => 'Eliminar este registro', 'escape' => false)); ?>
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
		<?= $this->Paginator->numbers(array('tag' => 'li', 'currentTag' => 'a', 'modulus' => 2, 'currentClass' => 'active', 'separator' => '')); ?>
		<?= $this->Paginator->next('Siguiente »', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'last disabled hidden')); ?>
	</ul>
</div>
