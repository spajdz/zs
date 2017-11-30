<div class="col-md-3 menu-lateral hidden-xs">
	<h2><i class="fa fa-shopping-bag icon-titulo"></i> <?= $lista['nombre']; ?></h2>
	<ul>
		<? foreach ( $categorias as $categoria ) : ?>
		<li>
			<?= $this->Html->link(
				h($categoria['Categoria']['nombre']) . '<i class="fa fa-angle-right"></i>',
				(
					//empty($categoria['children']) ?
					array('action' => 'index', $categoria['Categoria']['slug'], 'lista' => $lista['slug']) //:
					//'javascript://'
				),
				array(
					'class'		=> (! empty($categoria['Categoria']['current']) ? 'active' : ''),
					'escape'	=> false
				)
			); ?>
			<?= $this->Hookipa->submenuCatalogo($categoria['children'], $lista['slug'], $categoria['Categoria']['slug']); ?>
		</li>
		<? endforeach; ?>
	</ul>
</div>
