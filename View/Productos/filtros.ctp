<?= $this->element('buscadores/'.$categoria); ?>

<div class="contenedor catalogos">
	<div class="row">
		<?//= $this->element('menu_lateral'); ?>
		<div class="col-md-9 contenido">
			<div class="filtros catalogo">
				<span>Ordenar por:</span>
				<?= $this->Paginator->sort('precio', 'Precio <i class="fa fa-caret-down"></i><i class="fa fa-caret-up"></i>', array('class' => 'orden', 'escape' => false)); ?>
				<?= $this->Paginator->sort('articulo', 'Nombre <i class="fa fa-caret-down"></i><i class="fa fa-caret-up"></i>', array('class' => 'orden', 'escape' => false)); ?>
				
				<span class="por-pag">Productos por página:</span>
				<? $this->Html->loadConfig('html_links_planos'); ?>
				<select class="form-control js-productos-por-pagina">
					<option value="<?= $this->Paginator->link(null, array('limite' => 12)); ?>" <?= ($limite == 12 ? 'selected="selected"' : ''); ?>>12</option>
					<option value="<?= $this->Paginator->link(null, array('limite' => 36)); ?>" <?= ($limite == 36 ? 'selected="selected"' : ''); ?>>36</option>
					<option value="<?= $this->Paginator->link(null, array('limite' => 48)); ?>" <?= ($limite == 48 ? 'selected="selected"' : ''); ?>>48</option>
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
