<div class="page-title">
	<h2><span class="fa fa-text-width"></span> Textos</h2>
</div>
<div class="page-content-wrap">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Listado de textos</h3>
			<div class="btn-group pull-right">
				<?= $this->Html->link('<i class="fa fa-plus"></i> Nuevo texto', array('action' => 'add'), array('class' => 'btn btn-success', 'escape' => false)); ?>
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr class="sort">
							<th><?= $this->Paginator->sort('administrador_id', 'Autor', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('identificador', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('descripción', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('activo', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ( $textos as $texto ) : ?>
						<tr>
							<td><?= h($texto['Administrador']['nombre']); ?>&nbsp;</td>
							<td><?= h($texto['Texto']['identificador']); ?>&nbsp;</td>
							<td><?= h($texto['Texto']['descripcion']); ?>&nbsp;</td>
							<td><?= ($texto['Texto']['activo'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>'); ?>&nbsp;</td>
							<td>
								<!-- Boton Editar -->
								<?= $this->Html->link(
										'<i class="fa fa-edit"></i> Editar',
										// Accion del link
										array('action'	=>	'edit', $texto['Texto']['id']),
										// Propiedades de link
										array(
											'class'	=>	'btn btn-info',
											'rel' => 'tooltip',
											'title' => 'Editar este registro',
											'escape' => false
										)
								);?>
								<!-- Botones Activar/Desactivar -->
								<? if ( $texto['Texto']['activo'] ) : ?>
									<?= $this->Html->link(
											'<i class="fa fa-square-o"></i> Desactivar',
											// Accion del link
											array('action' => 'desactivar', $texto['Texto']['id']),
											// Propiedades del link
											array(
												  'class' => 'btn btn-danger',
												  'rel' => 'tooltip',
												  'title' => 'Desactivar este registro',
												  'escape' => false
											)
									); ?>
								<? else : ?>
									<?= $this->Html->link(
											'<i class="fa fa-check-square-o"></i> Activar',
											// Accion del link
											array('action' => 'activar', $texto['Texto']['id']),
											// Propiedades del link
											array(
												  'class' => 'btn btn-primary',
												  'rel' => 'tooltip',
												  'title' => 'Activar este registro',
												  'escape' => false
											)
									); ?>
								<? endif; ?>
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
