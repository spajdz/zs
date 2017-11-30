<div class="fondo-layer popup-agregar-producto hidden">
	<div class="agregar-carro">
		<a href="#" class="equis js-cerrar-popup">x</a>
		<div class="row">
			<div class="col-sm-3">
				<img src="" class="img-responsive js-imagen-producto">
				<span class="check"><i class="fa fa-check"></i></span>
			</div>
			<div class="col-sm-9">
				<h2 class="js-nombre-producto"></h2>
				<p class="primero">
					Se ha añadido un nuevo artículo a tu carro.<br>
					Ahora tienes <span class="js-total-articulos">1</span> artículo<span class="js-multiple">s</span> en tu carro.
				</p>

				<?= $this->Html->link(
					'Finalizar compra <i class="fa fa-shopping-cart"></i>',
					array('controller' => 'productos', 'action' => 'carro'),
					array('class' => 'btn', 'escape' => false)
				); ?>

				<a href="#" class="btn js-cerrar-popup js-focus">
					Seguir comprando
				</a>
			</div>
		</div>
	</div>
</div>
