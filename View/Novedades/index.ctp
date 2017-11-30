<!-- Div contenedor mayor -->
<div class="contenedor">
	<div class="row">
		<div class="col-sm-3 menu-lateral">
			<h2><i class="fa fa-bullhorn"></i> Últimas novedades</h2>
			<ul>
				<? foreach ( $ultimas_novedades as $ultima_novedad ) : ?>
				<li>
					<?= $this->Html->link(
						sprintf('%s <i class="fa fa-angle-right"></i>', $ultima_novedad['Novedad']['titulo']),
						array('action' => 'view', $ultima_novedad['Novedad']['id']),
						array(
							//'class'		=> ($novedades['Novedad']['slug'] == $actual['Novedad']['slug'] ? 'active' : ''),
							'escape'	=> false
						)
					); ?>
				</li>
				<? endforeach; ?>
			</ul>
		</div>
		<div class="col-sm-9">
			<h2>Novedades</h2>
				<div class="row">
					<? foreach ( $novedades AS $novedad ) :?>
					<div class="col-sm-6 novedad">
						<?=
							$this->Html->link(
								($novedad['Novedad']['imagen'] != '' && is_file(IMAGES . $novedad['Novedad']['imagen']['img']) ? $this->Html->image($novedad['Novedad']['imagen']['img'], array('class'  => 'img-responsive')) : $this->Html->image('nodisponibleNovedad_G.jpg', array('class'  => 'img-responsive'))),
								array('controller' => 'novedades', 'action' => 'view', $novedad['Novedad']['id']),
								array(
									'escape' => false
								)
							);
						?>
						<h4><?= $novedad['Novedad']['titulo']; ?></h4>
						<div class="contenido">
							<?= strip_tags($this->Text->truncate($novedad['Novedad']['texto'], 90)); ?>
						</div>
							<?=
								$this->html->link(
									'Leer más',
									array('controller' => 'novedades', 'action' => 'view', $novedad['Novedad']['id']),
									array(
										'class' => 'btn',
										'escape' => false
									)
								);
							?>
					</div>
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
