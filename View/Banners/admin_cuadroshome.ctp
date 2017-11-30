<div class="page-title">
	<h2><span class="fa fa-image"></span> Banners Cuadros Categorias</h2>
</div>

<div class="page-content-wrap">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Listado de banners</h3>
			<div class="btn-group pull-right">
				<?= $this->Html->link('<i class="fa fa-plus"></i> Nuevo banner', array('action' => 'add', 'cuadroshome'), array('class' => 'btn btn-success', 'escape' => false)); ?>
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<?= $this->Form->create('Banner', array('url' => array('action' => 'ajax_reorden'))); ?>
					<table class="table">
						<thead>
							<tr class="sort">
								<th width="5%">Orden</th>
								<th>Imagen</th>
								<th><?= $this->Paginator->sort('nombre', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
								<th><?= $this->Paginator->sort('pagina_id', 'Página', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
								<th><?= $this->Paginator->sort('activo', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
								<th><?= $this->Paginator->sort('administrador_id', 'Última modificación', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody class="js-generico-contenedor-sort">
							<? foreach ( $banners as $banner ) : ?>
							<tr>
								<td class="js-generico-orden">
									<a href="#" class="js-generico-handle-sort"><i class="fa fa-arrows"></i></a>
									<?= $this->Form->hidden(sprintf('Banner.orden.%d', $banner['Banner']['id'])); ?>
									<span><?= h($banner['Banner']['orden']); ?>&nbsp;</span>
								</td>
								<td>
									<? if ( ! empty($banner['Banner']['imagen']) ) : ?>
									<?= $this->Html->image($banner['Banner']['imagen']['mini'], array('class'  => 'img-responsive')); ?>
									<? endif; ?>
								</td>
								<td><?= h($banner['Banner']['nombre']); ?>&nbsp;</td>
								<td><?= h($banner['Pagina']['nombre']); ?>&nbsp;</td>
								<td><?= ($banner['Banner']['activo'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>'); ?>&nbsp;</td>
								<td><?= h($banner['Administrador']['nombre']) ?></td>
								<td>
									<?= $this->Html->link('<i class="fa fa-edit"></i> Editar', array('action' => 'edit', $banner['Banner']['id'], 'cuadroshome'), array('class' => 'btn btn-info', 'rel' => 'tooltip', 'title' => 'Editar este registro', 'escape' => false)); ?>
									<? if ( $banner['Banner']['activo'] ) : ?>
										<?= $this->Html->link('<i class="fa fa-square-o"></i> Desactivar', array('action' => 'desactivar', $banner['Banner']['id']), array('class' => 'btn btn-danger', 'rel' => 'tooltip', 'title' => 'Desactivar este registro', 'escape' => false)); ?>
									<? else : ?>
										<?= $this->Html->link('<i class="fa fa-check-square-o"></i> Activar', array('action' => 'activar', $banner['Banner']['id']), array('class' => 'btn btn-primary', 'rel' => 'tooltip', 'title' => 'Activar este registro', 'escape' => false)); ?>
									<? endif; ?>
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
