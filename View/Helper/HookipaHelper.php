<?php
App::uses('AppHelper', 'View/Helper');

class HookipaHelper extends AppHelper
{
	public $helpers			= array('Html', 'Session');
	public $activeClass		= 'active';
	public $ulClass			= 'sub-menu';

	public function submenuCatalogo($categorias, $slug, $url = '')
	{
		if ( empty($categorias) )
		{
			return false;
		}

		$html			= '';

		if ( ! empty($categorias) )
		{
			$html		.= '<ul class="' . $this->ulClass . '">';
			foreach ( $categorias as $categoria )
			{
				$html		.= '<li>';
				$html		.= $this->Html->link(
					h($categoria['Categoria']['nombre']) . '<i class="fa fa-angle-right"></i>',
					(
						//empty($categoria['children']) ?
						array('action' => 'index', 'lista' => $slug) + array_merge(explode('/', $url), array($categoria['Categoria']['slug']))// :
						//'javascript://'
					),
					array(
						'class'			=> ($categoria['Categoria']['current'] ? $this->activeClass : ''),
						'escape'		=> false
					)
				);

				if ( ! empty($categoria['children']) )
				{
					$html		.= $this->submenuCatalogo($categoria['children'], $slug, "{$url}/{$categoria['Categoria']['slug']}");
				}
				$html		.= '</li>';
			}
			$html		.= '</ul>';
		}

		return $html;
	}

	public function grillaLista($valor1 = null, $valor2 = null)
	{
		$vista			= ($this->Session->check('Catalogo.Preferencias.vista') ? $this->Session->read('Catalogo.Preferencias.vista') : 'grilla');
		return ($vista === 'grilla' ? $valor1 : $valor2);
	}

	public function imagen($codigo = null, $grande = false)
	{
		$size		= ($grande ? 'G' : 'P');
		$path		= IMAGES . implode(DS, array('Producto', sprintf('%s.jpg', $codigo)));
		if ( is_file($path) )
		{
			return sprintf('Producto/%s.jpg', $codigo);
		}

		return sprintf('nodisponible_%s.jpg', $size);
	}

	public function imagenColegio($koen = null)
	{
		$path		= IMAGES . implode(DS, array('Colegio', sprintf('%s.jpg', $koen)));
		if ( is_file($path) )
		{
			return sprintf('Colegio/%s.jpg', $koen);
		}

		return 'Colegio/nodisponible.jpg';
	}

	public function sizeSelect($producto = array())
	{
		/**
		 * El contenedor para el select debe tener la clase
		 * js-talla-contenedor para que se haga la actualización
		 * del data-id del boton para agregar al carrito
		 */
		if ( ! is_array($producto) || empty($producto) )
		{
			return false;
		}
		$productos		= array();
		array_push($productos, $producto['Producto']);
		foreach ( $producto['ProductoHijo'] as $productoHijo )
		{
			if ( ! empty($productoHijo['talla']) )
			{
				array_push($productos, $productoHijo);
			}
		}
		$productos		= Hash::sort($productos, '{n}.codigo_talla', 'ASC');

		$html = '<select name="data[Producto][talla]" class="form-control talla js-talla-select">';

		foreach ( $productos as $producto )
		{
			$html .= vsprintf('
				<option value="%d" data-id="%d" data-talla="%s"
					data-precio="$%s" data-stock="%d" data-isbn="%s"
					data-nombre="%s" data-descripcion="%s">
					%s
				</option>
			', array(
				h($producto['id']),
				h($producto['id']),
				h($producto['talla']),
				number_format($producto['precio'], 0, null, '.'),
				h($producto['stock']),
				h($producto['isbn']),
				h($producto['articulo']),
				h($producto['descripcion']),
				h($producto['talla'])
			));
		}

		$html .= '</select>';

		return $html;
	}

	public function colegiosImagen($colegios = array()){

		$html = '<table> <tr><td>Codigo</td><td>Colegio</td></tr>';

		foreach ( $colegios as $colegio)
		{
			if(filesize('img/Colegio/'.$colegio['Colegio']['codigo'].'.jpg') == filesize('img/Colegio/nodisponible.jpg')){
				$html .= '<tr><td>'.$colegio['Colegio']['codigo'].'</td><td>'.$colegio['Colegio']['nombre'].'</td></tr>';
			}

		}
		$html .= '</table> ';
		return ($html );
	}

	public function productosImagen($productos = array()){

		$html = '<table> <tr><td>ID</td><td>Producto</td></tr>';


		foreach ( $productos as $producto)
		{
			
			if(!is_file('img/Producto/'.$producto['Producto']['codigo'].'.jpg') ){
				$html .= '<tr><td>'.$producto['Producto']['id'].'</td><td>'.$producto['Producto']['nombre'].'</td></tr>';
			}

		}
		$html .= '</table> ';
		return ($html );
	}
}
