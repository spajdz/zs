<? $this->Html->script(array('productos.view'), array('inline' => false)) ;?>
<? $this->Html->meta(array('property' => 'og:image', 'content' => $this->Html->url(sprintf('/img/%s', $this->App->imagen($producto['Producto']['sku'])), true)), null, array('inline' => false)); ?>
<?= $this->element('buscadores/'.$categoria); ?>
<div class="contenedor">
	<div class="row">
		<?//= $this->element('menu_lateral'); ?>
		<div class="col-md-9 catalogo-ficha">
			<div class="row js-contenedor-producto">
				<div class="col-md-6">
					<?= $this->Html->image($this->App->imagen($producto['Producto']['sku'], true), array('class' => 'img-responsive','id' => 'zoom_01')); ?>
					<p class="sabana-descripcion">Pasa el mouse por la imagen para hacer zoom</p>
				</div>
				<div class="col-md-6 detalles-ficha js-talla-contenedor">
				
					<h2><?= h($producto['Producto']['nombre']); ?></h2>
					<div class="info">
						<p class="cat"><span class="js-talla-precio">$<?= number_format($producto['Producto']['preciofinal_publico'], 0, null, '.'); ?></span> </p>
					</div>
					<div class="cant-carro">
						<form>
							<? if ( $producto['Producto']['stock'] ) : ?>
								<span class="cantidad">Cantidad</span>
								<?= $this->Form->input('cantidad', array('value' => 1, 'maxlength' => 1, 'class' => 'form-control caja js-input-cantidad', 'div' => false, 'label' => false)); ?>
								<button type="submit" class="btn-agregar js-agregar-producto"
										data-id="<?= $producto['Producto']['id']; ?>"
										data-nombre="<?= h(trim($producto['Producto']['nombre'])); ?>"
										data-imagen="<?= "img/{$this->App->imagen($producto['Producto']['sku'], true)}"; ?>"
										data-cantidad="1">
									Agregar al Carro <i class="fa fa-shopping-cart"></i>
								</button>
							<? else : ?>
								<span class="no-stock">Sin Stock <i class="fa fa-ban"></i></span>
							<? endif; ?>
						</form>
					</div>

					<? if ( ! empty($producto['Producto']['descripcion']) ) : ?>
					<h3 class="title-compartir">Descripción</h3>
					<p><?= h(ucfirst($producto['Producto']['descripcion'])); ?></p>
					<? endif; ?>

					<h3 class="title-compartir">Stock</h3>
					<p>Producto <?= ($producto['Producto']['stock'] > 0 ? 'en stock' : 'sin stock'); ?></p>

					<h3 class="title-compartir">Compartir</h3>
					<div class="compartir clearfix">
						<div class="pull-left">
							<div class="fb-share-button"
								data-href="<?= $this->Html->url(array('controller' => 'productos', 'action' => 'view', $producto['Producto']['sku']), true); ?>"
								data-layout="button">
							</div>
						</div>
						<div class="pull-left" style="margin-left: 10px;">
							<a href="https://twitter.com/share" class="twitter-share-button" data-lang="es">Twittear</a>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
						</div>
					</div>
				</div>
			</div>

			<h2>Comentarios del Producto</h2>
			<div class="comentarios">
				<div class="sdk-facebook">
					<div id="fb-root"></div>
					<script>(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.5&appId=1938664143025395";
					fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>
				</div>
				<div class="fb-comments"
					 data-href="<?= $this->Html->url(array('controller' => 'productos', 'action' => 'view', $producto['Producto']['sku']), true); ?>"
					 data-numposts="4" data-width="100%">
				</div>
			</div>
		</div>
	</div>
</div>
