<div class="page-title">
	<h2><span class="fa fa-envelope"></span> Contactos</h2>
</div>

<div class="page-content-wrap">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row filtro-contacto">
				<h3>Filtros</h3>
				<?= $this->Form->create('Contacto', array('inputDefaults' => array('label' => false, 'required' => false))); ?>
					<div class="row">
						<div class="row fila-filtro ">
							<!-- Buscador libre (Nombre, apellidos, eail, celular, fono) -->
							<div class="col-md-6">
								<label class="control-label">Búsqueda libre <a href="#" class="btn btn-primary btn-xs btn-limpiar js-limpiar-busqueda" data-tipo="libre">Limpiar</a></label>
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-search"></span></span>
									<?= $this->Form->input('libre', array(
										'data-tipo'		=> 'libre',
										'value'			=> (! empty($filtros['filtro']['buscar']) ? $filtros['filtro']['buscar'] : ''),
										'class'			=> 'form-control',
										'placeholder'	=> 'Nombre, Email, Teléfono'
									)); ?>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<?= $this->Form->label('region_id', 'Región'); ?>
									<?= $this->Form->input('region_id', array(
											'selected'		=> (! empty($filtros['filtro']['region']) ? $filtros['filtro']['region'] : false),
											'class' => 'selectpicker',
											'empty' => '-- Selecciona una región'
										)); ?>
								</div>
							</div>
							<div class="col-md-3">
								<label class="control-label">Comuna</label>
								<?= $this->Form->input('comuna_id', array(
										'selected'		=> (! empty($filtros['filtro']['comuna']) ? $filtros['filtro']['comuna'] : false),
										'class'			=> 'form-control',
										'title'			=> '-- Selecciona una comuna'
									)
								); ?>
							</div>

						</div>
						<div class="col-md-6 pull-right">
							<label class="control-label">&nbsp;</label>
							<div class="form-group" style="text-align: right;">
								<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
								<!-- Boton limpiar -->
								<?= $this->Html->link('<i class="fa fa-repeat"></i> Limpiar', array('action' => 'index'), array('class' => 'btn btn-danger', 'escape' => false)); ?>
							</div>
						</div>
					</div>
				<?= $this->Form->end(); ?>
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr class="sort">
							<th><?= $this->Paginator->sort('created', 'Registro', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('nombre', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('email', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('comuna_id', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('mensaje', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('respondido', null, array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th><?= $this->Paginator->sort('administrador_id', 'Respondido por', array('title' => 'Haz click para ordernar por este criterio')); ?></th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ( $contactos as $contacto ) : ?>
						<tr>
							<td><?= h($contacto['Contacto']['created']); ?></td>
							<? if ( ! empty($contacto['Usuario']['id']) ) : ?>
							<td><?= sprintf('%s %s %s', $contacto['Usuario']['nombre'], $contacto['Usuario']['apellido_paterno'], $contacto['Usuario']['apellido_materno']); ?></td>
							<td><?= h($contacto['Usuario']['email']); ?></td>
							<? else : ?>
							<td><?= h($contacto['Contacto']['nombre']); ?></td>
							<td><?= h($contacto['Contacto']['email']); ?>&nbsp;</td>
							<? endif; ?>
							<td><?= sprintf('%s, %s', $contacto['Comuna']['nombre'], $contacto['Comuna']['Region']['nombre']); ?></td>
							<td><?= $this->Text->truncate($contacto['Contacto']['mensaje'], 15); ?>&nbsp;</td>
							<td><?= ($contacto['Contacto']['respondido'] ? 'Si' : 'No'); ?>&nbsp;</td>
							<td><?= h($contacto['Administrador']['nombre']); ?>&nbsp;</td>
							<td>
								<?= $this->Html->link('<i class="fa fa-edit"></i> Ver', array('action' => 'edit', $contacto['Contacto']['id']), array('class' => 'btn btn-mini btn-info', 'rel' => 'tooltip', 'title' => 'Editar este registro', 'escape' => false)); ?>
								<? $this->Form->postLink('<i class="fa fa-remove"></i> Eliminar', array('action' => 'delete', $contacto['Contacto']['id']), array('class' => 'btn btn-mini btn-danger confirmar-eliminacion', 'rel' => 'tooltip', 'title' => 'Eliminar este registro', 'escape' => false)); ?>
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
