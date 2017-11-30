<div class="page-title">
	<h2><span class="fa fa-list-ol"></span> Productos</h2>
</div>

<div class="page-content-wrap">
	<div class="panel panel-default">
	<div class="panel-body">
		<h3>Filtros</h3>
		<?= $this->Form->create('Producto', array('inputDefaults' => array('label' => false, 'required' => false))); ?>
			<div class="row fila-filtro">
				<div class="col-md-6">
					<label class="control-label">Búsqueda por sku <a href="#" class="btn btn-primary btn-xs btn-limpiar js-limpiar-busqueda-productos" data-tipo="sku">Limpiar</a></label>
					<div class="input-group">
						<span class="input-group-addon"><span class="fa fa-search"></span></span>
						<?= $this->Form->input('sku', array(
							'data-tipo'		=> 'sku',
							'value'			=> (! empty($filtros['filtro']['buscar']) ? $filtros['filtro']['buscar'] : ''),
							'class'			=> 'form-control',
							'placeholder'	=> 'sku'
						)); ?>
					</div>
				</div>
				<div class="col-md-3">
					<label class="control-label">Categoria <a href="#" class="btn btn-primary btn-xs btn-limpiar js-limpiar-busqueda-productos" data-tipo="producto_tipo">Limpiar</a></label>
					<?= $this->Form->input('categoria_id', array(
							'data-tipo'		=> 'categoria_id',
							'selected'		=> (! empty($filtros['filtro']['categoria_id']) ? $filtros['filtro']['categoria_id'] : false),
							'options'		=> $categorias,
							'multiple'		=> true,
							'class'			=> 'form-control selectpicker',
							'title'			=> '-- Selecciona categoria'
						)
					); ?> 
				</div>
				<div class="col-md-3">
					<label class="control-label">Marca <a href="#" class="btn btn-primary btn-xs btn-limpiar js-limpiar-busqueda-productos" data-tipo="marca">Limpiar</a></label>
					<?= $this->Form->input('marca', array(
							'data-tipo'		=> 'marca',
							'selected'		=> (! empty($filtros['filtro']['marca']) ? $filtros['filtro']['marca'] : false),
							'options'		=> $marcas,
							'multiple'		=> true,
							'class'			=> 'form-control selectpicker',
							'title'			=> '-- Selecciona Marca'
						)
					); ?> 
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<label class="control-label">&nbsp;</label>
					<div class="form-group" style="text-align: right;">
						<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
						<?= $this->Html->link('<i class="fa fa-repeat"></i> Limpiar', array('action' => 'index'), array('class' => 'btn btn-danger', 'escape' => false)); ?>
						<?= $this->Html->link('<i class="fa fa-repeat"></i> Historial de Cargas Masivas', array('controller' => 'cargas','action' => 'admin_index'), array('class' => 'btn btn-success', 'escape' => false)); ?>
                        <?= $this->Html->link('<i class="fa fa-repeat"></i> Carga masiva Datos Productos', array('action' => 'admin_cm'), array('class' => 'btn btn-success', 'escape' => false)); ?>
                          <?= $this->Html->link('<i class="fa fa-repeat"></i> Carga masiva Descripciones de Productos', array('action' => 'admin_masiva_descripcion'), array('class' => 'btn btn-success', 'escape' => false)); ?>											
					</div>
				</div>
			</div>
		<?= $this->Form->end(); ?>
	</div>
</div>


	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Listado de productos</h3>
			<div class="btn-group pull-right">
				<?= $this->Html->link('<i class="fa fa-file-excel-o"></i> Exportar', array('action' => 'excel'), array('class' => 'btn btn-success', 'escape' => false)); ?>
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr class="sort">
							<th>Nombre</th>
							<th>SKU</th>
							<th>Activo</th>
							<th>Foto</th>
							<th>Stock</th>
							<th>Marca</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ( $productos as $producto ) : ?>
						<tr>
							<td><?= h($producto['Producto']['nombre']); ?></td>
							<td><?= h($producto['Producto']['sku']); ?></td>
							<td><?= ($producto['Producto']['activo'] ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>'); ?>&nbsp;</td>
							<td><?= $this->Html->image($this->App->imagen($producto['Producto']['sku']), array('class' => 'img-responsive')) ?></td>
							<td><?= h($producto['Producto']['stock']); ?></td>
							<td><?= h($producto['Marca']['nombre']); ?></td>
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
