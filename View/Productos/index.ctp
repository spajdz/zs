<?//= $this->Html->script(array('productos.index'), array('inline' => false)) ;?>
<?= $this->Html->script(array(
	'vendor/jquery.validate.min',
	'vendor/jquery.alphanumeric.pack',
	'vendor/bootstrap3-typeahead',
	'productos.index'
), array('inline' => false)) ;?>
<?= $this->element('buscadores/'.$categoria); ?>

<div class="contenedor catalogos">
	<div class="row">
		<?//= $this->element('menu_lateral'); ?>
		<div class="col-md-12 contenido">
			<div class="filtros catalogo">
				<span>Ordenar por:</span>
				<?= $this->Paginator->sort('precio', 'Precio <i class="fa fa-caret-down"></i><i class="fa fa-caret-up"></i>', array('class' => 'orden', 'escape' => false)); ?>
				<?= $this->Paginator->sort('articulo', 'Nombre <i class="fa fa-caret-down"></i><i class="fa fa-caret-up"></i>', array('class' => 'orden', 'escape' => false)); ?>
				
				<span class="por-pag">Productos por página:</span>
				<? $this->Html->loadConfig('html_links_planos'); ?>
				<select class="form-control js-productos-por-pagina">
					<option value="<?= $this->Paginator->link(null, array('limite' => 10)); ?>" <?= ($limite == 12 ? 'selected="selected"' : ''); ?>>10</option>
					<option value="<?= $this->Paginator->link(null, array('limite' => 20)); ?>" <?= ($limite == 36 ? 'selected="selected"' : ''); ?>>20</option>
					<option value="<?= $this->Paginator->link(null, array('limite' => 30)); ?>" <?= ($limite == 48 ? 'selected="selected"' : ''); ?>>30</option>
					<option value="<?= $this->Paginator->link(null, array('limite' => 40)); ?>" <?= ($limite == 48 ? 'selected="selected"' : ''); ?>>40</option>
				</select>
				<? $this->Html->loadConfig('html_links_normales'); ?>
				<span class="pagn"><?= $this->Paginator->counter(array('format' => '{:page} de {:pages}')); ?></span>
			</div>

			<div class="row">
				<? foreach ( $productos as $producto ) : ?>
					<? $this->set(compact('producto')); ?>
					<?= $this->element('productos/producto'); ?>
				<? endforeach; ?>
			</div>
			<nav class="paginador">
				<ul class="pagination">
					<?= $this->Paginator->prev('« Anterior', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'first disabled hidden')); ?>
					<?= $this->Paginator->numbers(array('tag' => 'li', 'currentTag' => 'a', 'modulus' => 9, 'currentClass' => 'active', 'separator' => '')); ?>
					<?= $this->Paginator->next('Siguiente »', array('tag' => 'li'), null, array('tag' => 'li', 'disabledTag' => 'a', 'class' => 'last disabled hidden')); ?>
				</ul>
			</nav>
		</div>
	</div>
</div>
