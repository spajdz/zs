<div class="col-md-3 col-xs-6 foto js-talla-contenedor">
	<div class="caja-gris">
		<?= $this->Html->link(
				$this->Html->image($this->App->imagen($producto['Producto']['sku']), array('class' => 'img-responsive')),
				 array('controller' => 'productos', 'action' => 'view', $categoria, 'marca' => $producto['Marca']['slug'], 'slug' => $producto['Producto']['slug']),
				array('class' => 'contenedor-imagen', 'escape' => false)
		); ?>
	
		<p><?=$producto['Producto']['nombre'];?></p>
		<p class="isbn">SKU: <span style="font-size: inherit; font-weight: inherit;" class="js-talla-isbn"><?= $producto['Producto']['sku']; ?></span></p>
		
		<div class="precio-full">
			<? $oferta = ($esMayorista) ? $producto['Producto']['oferta_mayorista'] : $producto['Producto']['oferta_publico'];?>
			<? $oferta_palabra = ($esMayorista) ? 'REMATE ' : 'OFERTA '?>
			<? $oferta_dcto = ($esMayorista) ? $producto['Producto']['dcto_mayorista'] : $producto['Producto']['dcto_publico']?>

			<? if($oferta): ?>
				<div><?= $oferta_palabra . $oferta_dcto?> % </div>
			<? endif;?>
			<p class="precio">
				<span class="js-talla-precio">$ <?= number_format(($esMayorista) ? $producto['Producto']['preciofinal_mayorista'] : $producto['Producto']['preciofinal_publico'], 0, null, '.'); ?></span>
			</p>
			<? $precio = $producto['Producto']['precio_publico'];?>
			<? $preciofinal = $producto['Producto']['preciofinal_publico'];?>

			<?if($esMayorista):?>
				<? $precio = $producto['Producto']['precio_mayorista'];?>
				<? $preciofinal = $producto['Producto']['preciofinal_mayorista'];?>
			<?endif;?>

			<?if($precio != $preciofinal):?>
				<p class="precio">
					<span class="js-talla-precio"><span class="precio-normal"> NORMAL: </span> $ <?= number_format($precio, 0, null, '.'); ?></span>
				</p>
			<?endif;?>
		</div>

		<? 
			$n = 100;
			if($esMayorista){
				$n = 1000;
			}
		?>

		<select id="selectCantidad<?= $producto['Producto']['id']; ?>" class="form-control">
		<? for($i=1;$i<=$n;$i++): ?>
		    <? $mod = $i % 4; ?>
		    <?if($producto['Producto']['categoria_id'] != 1 || ($producto['Producto']['categoria_id'] == 1 && $mod==0) ):?>
		       <option value="<?=$i;?>"><?= $i;?></option>
			<?endif?> 
		<? endfor;
		?> 
		</select>

		<?= $this->Html->link(
			'Agregar al carro <i class="fa fa-shopping-cart"></i>',
			'#',
			array(
				'class'				=> 'js-producto-stock js-talla-stock agregar js-agregar-producto',
				'data-id'			=> $producto['Producto']['id'],
				'data-nombre'		=> h($producto['Producto']['nombre']),
				'data-imagen'		=> "img/{$this->App->imagen($producto['Producto']['sku'], true)}",
				'data-cantidad'		=> 1,
				'escape'			=> false
			)
		); ?>

		<?if($producto['Producto']['stock'] <= 0):?>
			<span class="js-producto-nostock no-stock js-talla-nostock">Sin Stock <i class="fa fa-ban"></i></span>
		<?endif;?>
	</div>
</div>