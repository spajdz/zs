<div class="contenedor">
	<div class="row">
		<div class="visible-xs">
			<select class="form-control selectHelp" onchange="location = this.options[this.selectedIndex].value;">
				<option value="">Seleccione Ayuda</option>
				<? foreach ( $temas as $tema ) : ?>
				<option
					value="<?= $this->Html->url(array('action' => 'index', $tema['Tema']['slug'])); ?>"
					<?= ($tema['Tema']['slug'] == $actual['Tema']['slug'] ? ' selected="selected"' : ''); ?>>
					<?= h($tema['Tema']['nombre']); ?>
				</option>
				<? endforeach; ?>
			</select>
		</div>
		<div class="col-sm-3 menu-lateral ayuda hidden-xs">
			<h2><i class="fa fa-life-ring icon-titulo"></i> Ayuda</h2>
			<ul>
				<? foreach ( $temas as $tema ) : ?>
				<li>
					<?= $this->Html->link(
						sprintf('%s <i class="fa fa-angle-right"></i>', $tema['Tema']['nombre']),
						array('action' => 'index', $tema['Tema']['slug']),
						array(
							'class'		=> ($tema['Tema']['slug'] == $actual['Tema']['slug'] ? 'active' : ''),
							'escape'	=> false
						)
					); ?>
				</li>
				<? endforeach; ?>
			</ul>
		</div>
		<div class="col-sm-9 contenido">
			<? foreach ( $ayudas as $ayuda ) : ?>
			<h2><?= h($ayuda['Ayuda']['titulo']); ?></h2>
			<?= $ayuda['Ayuda']['contenido']; ?>
			<? endforeach; ?>
		</div>
	</div>
</div>
