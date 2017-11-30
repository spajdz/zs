<div class="page-title">
	<h2><span class="fa fa-bullhorn"></span> Novedades</h2>
</div>

<div class="page-content-wrap">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Listado de novedades</h3>
			<div class="btn-group pull-right">
				<?= $this->Html->link('<i class="fa fa-plus"></i> Nueva novedad', array('action' => 'add'), array('class' => 'btn btn-success', 'escape' => false)); ?>
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr class="sort">
							<th><?= $this->Paginator->sort('administrador_id', 'Autor', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('titulo', 'Título', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('activo', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('created', 'Fecha creación', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ( $novedades as $novedad ) : ?>
						<tr>
							<td><?= h($novedad['Administrador']['nombre']); ?></td>
							<td><?= h($novedad['Novedad']['titulo']); ?>&nbsp;</td>
							<td><?= ($novedad['Novedad']['activo'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>'); ?>&nbsp;</td>
							<td><?= h($novedad['Novedad']['created']); ?>&nbsp;</td>
							<td>
								<?= $this->Html->link('<i class="fa fa-edit"></i> Editar', array('action' => 'edit', $novedad['Novedad']['id']), array('class' => 'btn btn-info', 'rel' => 'tooltip', 'title' => 'Editar este registro', 'escape' => false)); ?>
								<? if ( $novedad['Novedad']['activo'] ) : ?>
									<?= $this->Html->link('<i class="fa fa-square-o"></i> Desactivar', array('action' => 'desactivar', $novedad['Novedad']['id']), array('class' => 'btn btn-danger', 'rel' => 'tooltip', 'title' => 'Desactivar este registro', 'escape' => false)); ?>
								<? else : ?>
									<?= $this->Html->link('<i class="fa fa-check-square-o"></i> Activar', array('action' => 'activar', $novedad['Novedad']['id']), array('class' => 'btn btn-primary', 'rel' => 'tooltip', 'title' => 'Activar este registro', 'escape' => false)); ?>
								<? endif; ?>
								<?= $this->Form->postLink('<i class="icon-remove icon-white"></i> Eliminar', array('action' => 'delete', $novedad['Novedad']['id']), array('class' => 'btn btn-mini btn-danger confirmar-eliminacion', 'rel' => 'tooltip', 'title' => 'Eliminar este registro', 'escape' => false)); ?>
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
