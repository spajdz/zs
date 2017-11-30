<? if ( $banners ) : ?>
	<div class="row row2">
		<div class="col-md-12 col-xs-12">
			<div id="slider-principal" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<? foreach ( $banners as $index => $banner) : ?>
						<li data-target="#slider-principal" data-slide-to="<?= $index; ?>" class="<?= ($index == 0 ? 'active' : '' ); ?>"></li>
					<? endforeach; ?>
				</ol>
				<div class="carousel-inner" role="listbox">
					<? foreach ( $banners as $index => $banner) : ?>
						<div class="item <?= ($index == 0 ? 'active' : ''); ?>">
							<? if(!empty($banner['Banner']['link'])):?>
								<?=
									$this->Html->link(
										$this->Html->image($banner['Banner']['imagen']['bannerhome']),
										$banner['Banner']['link'],
										array(
											'class'     =>  'img-responsive',
											'target'    =>  (empty($banner['Banner']['enlace_externo'])) ? '_blank' : '',
											'escape'    =>  false
										)
									);
								?>
							<? else : ?>
								<?= $this->Html->image(
									$banner['Banner']['imagen']['bannerhome'],
									array('class' => 'img-responsive')
								) ?>
							<? endif; ?>
						</div>
					<? endforeach; ?>
				</div>
				<? if( count($banners) > 1 ) : ?>
					<a class="left carousel-control hidden-xs" href="#slider-principal" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control hidden-xs" href="#slider-principal" role="button" data-slide="next">
						<span class="glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				<? endif; ?>
			</div>
		</div>
	</div>
<? endif; ?>

<?= $this->element('buscadores/'.$categoria); ?>


<?if($cuadrosHome):?>
	 <div class="banners clearfix">
	 	<? 
	 		$i = 0;
		 	foreach($cuadrosHome as $banner):
				$nombreImagen = ($i<=2) ? 'bannerHorizontalHome' : 'bannerHorizontalHomeInf';$i++; 
				$text = (empty($banner['Banner']['texto'])) ? '' : $banner['Banner']['texto'];
				$classNumber = ($i<=2) ? 4 : 6 ;
				$content = '<div class="col-sm-'.$classNumber.' banner">';
				if(!empty($banner['Banner']['link'])):
					echo $this->Html->link(
						 '<div class="col-sm-4 banner">
		                    <div class="inner" style="background-image:url(\''.Router::url('/img/'.$banner['Banner']['imagen'][$nombreImagen], true).'\');">
		                        <h3>'.$text.'</h3>
		                    </div>
		                </div>',
						$banner['Banner']['link'],
						array(
							'class'     =>  'img-responsive',
							'target'    =>  (empty($banner['Banner']['enlace_externo'])) ? '_blank' : '',
							'escape'    =>  false,
							'onclick'	=> "ga('send', 'event', 'Menú Principal', '".$text."')"
						)
					);
				else:
					echo '<div class="col-sm-'.$classNumber.' banner">
		                    <div class="inner" style="background-image:url(\''.Router::url('/img/'.$banner['Banner']['imagen'][$nombreImagen], true).'\');">
		                        <h3>'.$text.'</h3>
		                    </div>
		                </div>';
				endif;
			endforeach;
		?>
	</div>
<?endif;?>