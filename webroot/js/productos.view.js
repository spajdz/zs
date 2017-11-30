/* jshint bitwise:true, browser:true, eqeqeq:true, forin:true, globalstrict:true, indent:4, jquery:true,
   loopfunc:true, maxerr:3, noarg:true, node:true, noempty:true, onevar: true, quotmark:single,
   strict:true, undef:true, white:false */

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
	 * Actualizacion cantidad producto
	 */
	$('.js-input-cantidad').numeric().on('change', function()
	{
		var $this			= $(this),
			cantidad		= parseInt($this.val(), 10),
			$producto		= $this.parents('.js-contenedor-producto').first(),
			$agregar		= $producto.find('.js-agregar-producto').first();

		if ( isNaN(cantidad) )
		{
			$this.val(cantidad = 1);
		}

		$agregar.data('cantidad', cantidad);
	});

	/**
	 * Valorizacion de los productos
	 */
	if ( $('.js-valorizacion').length )
	{
		$('.js-check-valorizacion').on('click', function(evento)
		{
			evento.preventDefault();
			/**
			 * Se obtienen los datos del producto que ha sido valorado
			 */
			var $this			= $(this),
				bloqueado		= ($this.parent().data('bloqueado') == 1 ? true : false),
				valorizacon		= $this.data('estrellas'),
				producto		= $this.data('producto');

			if ( ! bloqueado )
			{
				$.ajax(
				{
					type			: 'POST',
					url				: $.webroot('valoraciones/ajax_valorizacion'),
					dataType		: 'json',
					data			: {
						Valoracion : {
							estrellas:			valorizacon,
							producto_id:		producto
						}
					},
					success			: function(data)
					{
						if ( data.success )
						{
							$this.parent().data('bloqueado', true);
							$this.addClass('current');
						}
					}
				});
			}
		});
	}
});

//]]>
