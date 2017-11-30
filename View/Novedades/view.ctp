<div class="contenedor">
	<div class="row">
		<div class="col-sm-12">
			<?= ( $novedad['Novedad']['imagen_destacada'] != '' && is_file(IMAGES . $novedad['Novedad']['imagen_destacada']['img']) != '' ?
				   $this->Html->image($novedad['Novedad']['imagen_destacada']['img'], array('class' => 'img-responsive')) :
					   $this->Html->image('noImgNoticiaCarrusel.png', array('class' => 'img-responsive'))) ?>
		   <div class="not-principal">
			   <h2><?= $novedad['Novedad']['titulo']?></h2>
				   <?= $novedad['Novedad']['texto']?>
		   </div>
		   <?=
				$this->html->link(
					'Volver',
					'javascript:history.back()',
					array(
						'class' => 'btn',
						'escape' => false
					)
				);
			?>
		</div>
	</div>
</div>
