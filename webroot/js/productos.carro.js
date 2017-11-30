/* jshint bitwise:true, browser:true, eqeqeq:true, forin:true, globalstrict:true, indent:4, jquery:true,
   loopfunc:true, maxerr:3, noarg:true, node:true, noempty:true, onevar: true, quotmark:single,
   strict:true, undef:true, white:false */
/* global number_format */

/*!
 * Hookipa 2015
 */

//<![CDATA[
'use strict';

/**
 * jQuery
 */
jQuery(document).ready(function($)
{
	/**
	 * Actualizacion cantidad
	 */
	$('.js-input-cantidad-actualizar').numeric().on('change', function()
	{
		var $this			= $(this),
			id				= $this.data('id'),
			cantidad		= parseInt($this.val(), 10),
			previo			= parseInt($this.data('previo'), 10),
			$producto		= $this.parents('.js-contenedor-producto').first(),
			$subtotal		= $producto.find('.js-producto-subtotal').first();

		if ( isNaN(cantidad) )
		{
			$this.val(cantidad = 1);
		}

		if (cantidad < 1)
		{
			$this.val(cantidad = 1);
			return;
		}

		/**
		 * Actualiza la cantidad
		 */
		$.when($.actualizarProducto(id, cantidad)).done(function(data)
		{
			/**
			 * Escribe los datos actualizados a la tabla
			 */
			$this.val(data.info.Producto.Cantidad);
			$this.data('previo', data.info.Producto.Cantidad);
			$subtotal.text('$' + number_format(data.info.Producto.Subtotal, 0, null, '.'));

			/**
			 * Escribe los datos del carro
			 */
			$.actualizarCarro(data.info.Carro.Cantidad, data.info.Carro.Subtotal);
		}).fail(function(data)
		{
			$this.val(previo);

			var mensajes		= {};
			if ( data && data.error )
			{
				switch ( data.error )
				{
					case 'SIN_STOCK':
					{
						mensajes		= {
							tipo			: 'SIN STOCK',
							titulo			: 'El producto que seleccionaste ya no tiene stock.',
							subtitulo		: 'Por favor selecciona alguna alternativa desde nuestro catálogo'
						};
						$producto.find('.js-eliminar-producto').trigger('click');
						break;
					}
					case 'SIN_STOCK_SUFICIENTE':
					{
						mensajes		= {
							tipo			: 'SIN STOCK',
							titulo			: 'El producto que seleccionaste no tiene suficiente stock.',
							subtitulo		: sprintf('Solo puedes agregar un maximo de %d unidades. Por favor intenta nuevamente', data.stock)
						};
						break;
					}
				}
			}
			else
			{
				mensajes		= {
					tipo			: 'ERROR',
					titulo			: 'Se produjo un error al actualizar la cantidad del producto.',
					subtitulo		: 'Por favor intentalo nuevamente.'
				};
			}

			if ( Object.keys(mensajes).length )
			{
				$.popup.generico.abrir(mensajes);
			}
		});
	});


	/**
	 * Eliminar productos del carro
	 */
	$('.js-eliminar-producto').on('click', function(evento)
	{
		evento.preventDefault();
		var $this			= $(this),
			id				= $this.data('id'),
			nombre			= $this.data('nombre'),
			imagen			= $this.data('imagen'),
			$producto		= $this.parents('.js-contenedor-producto').first();

		/**
		 * Muestra el popup de confirmacion
		 */
		$.when($.popup.producto.eliminar.abrir(nombre, imagen)).done(function()
		{
			$.when($.eliminarProducto(id)).done(function(data)
			{
				/**
				 * Elimina el producto de la tabla
				 */
				$producto.addClass(['animated', $.animaciones.producto.carro.eliminar].join(' '));
				$producto.one($.animaciones.animacionEventoFin, function()
				{
					$producto.remove();
				});

				/**
				 * Escribe los datos del carro
				 */
				$.actualizarCarro(data.info.Carro.Cantidad, data.info.Carro.Subtotal);

				/**
				 * Si elimina todos los productos, quita los botones de accion
				 */
				if ( ! data.info.Carro.Cantidad )
				{
					$('.js-accion-carro-1').hide();
				}
			}).fail(function()
			{
				$this.val();
			});
		}).fail(function()
		{
			//
		});
	});
});

//]]>
