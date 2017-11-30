<div class="page-title">
	<h2><span class="fa fa-list"></span> Categorías de ayuda</h2>
</div>

<div class="page-content-wrap">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Listado de categorías de ayuda</h3>
			<div class="btn-group pull-right">
				<?= $this->Html->link('<i class="fa fa-arrow-left"></i> Volver a temas de ayuda', array('controller' => 'ayudas'), array('class' => 'btn btn-primary', 'escape' => false)); ?>
				<?= $this->Html->link('<i class="fa fa-plus"></i> Nueva categoría', array('action' => 'add'), array('class' => 'btn btn-success', 'escape' => false)); ?>
			</div>
		</div>
		<div class="panel-heading">
			<p class="help-block">Para reordenar, arrastra las filas con el mouse</p>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<?= $this->Form->create('Tema', array('url' => array('action' => 'ajax_reorden'))); ?>
					<table class="table">
						<thead>
							<tr class="sort">
								<th width="5%">Orden</th>
								<th><?= $this->Paginator->sort('nombre', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
								<th><?= $this->Paginator->sort('activo', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody class="js-generico-contenedor-sort">
							<? foreach ( $temas as $tema ) : ?>
							<tr>
								<td class="js-generico-orden">
									<a href="#" class="js-generico-handle-sort"><i class="fa fa-arrows"></i></a>
									<?= $this->Form->hidden(sprintf('Tema.orden.%d', $tema['Tema']['id'])); ?>
									<span><?= h($tema['Tema']['orden']); ?>&nbsp;</span>
								</td>
								<td><?= h($tema['Tema']['nombre']); ?>&nbsp;</td>
								<td><?= ($tema['Tema']['activo'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>'); ?>&nbsp;</td>
								<td>
									<?= $this->Html->link('<i class="fa fa-edit"></i> Editar', array('action' => 'edit', $tema['Tema']['id']), array('class' => 'btn btn-info', 'rel' => 'tooltip', 'title' => 'Editar este registro', 'escape' => false)); ?>
									<? if ( $tema['Tema']['activo'] ) : ?>
									<?= $this->Html->link('<i class="fa fa-square-o"></i> Desactivar', array('action' => 'desactivar', $tema['Tema']['id']), array('class' => 'btn btn-danger', 'rel' => 'tooltip', 'title' => 'Desactivar este registro', 'escape' => false)); ?>
									<? else : ?>
									<?= $this->Html->link('<i class="fa fa-check-square-o"></i> Activar', array('action' => 'activar', $tema['Tema']['id']), array('class' => 'btn btn-primary', 'rel' => 'tooltip', 'title' => 'Activar este registro', 'escape' => false)); ?>
									<? endif; ?>
									<? $this->Form->postLink('<i class="fa fa-remove"></i> Eliminar', array('action' => 'delete', $tema['Tema']['id']), array('class' => 'btn btn-danger confirmar-eliminacion', 'rel' => 'tooltip', 'title' => 'Eliminar este registro', 'escape' => false)); ?>
								</td>
							</tr>
							<? endforeach; ?>
						</tbody>
					</table>
				<?= $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
