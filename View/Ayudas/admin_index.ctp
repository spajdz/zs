<div class="page-title">
	<h2><span class="fa fa-support"></span> Temas de ayuda</h2>
</div>

<div class="page-content-wrap">
	<? $x = 0; foreach ( $temas as $tema ) : ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Categoría: <?= $tema['Tema']['nombre']; ?></h3>
			<? if ( ++$x == 1 ) : ?>
			<div class="btn-group pull-right">
				<?= $this->Html->link('<i class="fa fa-support"></i> Administrar categorías de ayuda', array('controller' => 'temas'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
				<?= $this->Html->link('<i class="fa fa-plus"></i> Nuevo tema de ayuda', array('action' => 'add'), array('class' => 'btn btn-success', 'escape' => false)); ?>
			</div>
			<? endif; ?>
		</div>
		<div class="panel-heading">
			<p class="help-block">Para reordenar, arrastra las filas con el mouse</p>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<?= $this->Form->create('Ayuda', array('url' => array('action' => 'ajax_reorden'))); ?>
					<table class="table">
						<thead>
							<tr class="sort">
								<th width="5%">Orden</th>
								<th width="40%"><?= $this->Paginator->sort('titulo', 'Título', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
								<th><?= $this->Paginator->sort('activo', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
								<th><?= $this->Paginator->sort('administrador_id', 'Última modificación', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody class="js-generico-contenedor-sort">
							<? foreach ( $tema['Ayuda'] as $ayuda ) : ?>
							<tr>
								<td class="js-generico-orden">
									<a href="#" class="js-generico-handle-sort"><i class="fa fa-arrows"></i></a>
									<?= $this->Form->hidden(sprintf('Ayuda.orden.%d', $ayuda['id'])); ?>
									<span><?= h($ayuda['orden']); ?>&nbsp;</span>
								</td>
								<td><?= h($ayuda['titulo']); ?>&nbsp;</td>
								<td><?= ($tema['Tema']['activo'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>'); ?>&nbsp;</td>
								<td><?= h($ayuda['Administrador']['nombre']); ?></td>
								<td>
									<?= $this->Html->link('<i class="fa fa-edit"></i> Editar', array('action' => 'edit', $ayuda['id']), array('class' => 'btn btn-mini btn-info', 'rel' => 'tooltip', 'title' => 'Editar este registro', 'escape' => false)); ?>
									<? if ( $ayuda['activo'] ) : ?>
									<?= $this->Html->link('<i class="fa fa-square-o"></i> Desactivar', array('action' => 'desactivar', $ayuda['id']), array('class' => 'btn btn-danger', 'rel' => 'tooltip', 'title' => 'Desactivar este registro', 'escape' => false)); ?>
									<? else : ?>
									<?= $this->Html->link('<i class="fa fa-check-square-o"></i> Activar', array('action' => 'activar', $ayuda['id']), array('class' => 'btn btn-primary', 'rel' => 'tooltip', 'title' => 'Activar este registro', 'escape' => false)); ?>
									<? endif; ?>
									<? $this->Form->postLink('<i class="fa fa-remove"></i> Eliminar', array('action' => 'delete', $ayuda['id']), array('class' => 'btn btn-mini btn-danger confirmar-eliminacion', 'rel' => 'tooltip', 'title' => 'Eliminar este registro', 'escape' => false)); ?>
								</td>
							</tr>
							<? endforeach; ?>
						</tbody>
					</table>
				<?= $this->Form->end(); ?>
			</div>
		</div>
	</div>
	<? endforeach; ?>
</div>
