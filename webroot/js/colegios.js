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
	 * Input autocomplete y codigo colegio
	 */
	var $autocomplete		= $('[name="data[Colegio][colegio]"]'),
		$id_colegio			= $('[name="data[Colegio][id_colegio]"]');
		//

	/**
	 * Autocomplete
	 */
	if ( $autocomplete.length )
	{
		/**
		 * Limpieza inicial
		 */
		$autocomplete.val('');
		$id_colegio.val('');


		/**
		 * Autocomplete del nombre del colegio
		 */
		$autocomplete.typeahead(
		{
			source				: colegios,
			minLength			: (colegios.length < 10 ? 0 : 1),
			autoSelect			: false,
			showHintOnFocus		: true,
			displayText			: function(item)
			{
				return item.Colegio.nombre;
			}
		});

		/**
		 * Actualiza el codigo del colegio o elimina el colegio
		 * si no corresponde a una opcion del autoselector
		 */
		$autocomplete.on('change blur', function()
		{

			$('.colegio-caja').fadeIn();
			var $this			= $(this),
				current			= $this.typeahead('getActive');

			if ( typeof(current) !== 'undefined' )
			{
				/**
				 * Seleccion de opcion
				 */
				if ( current.Colegio.nombre === $this.val() )
				{
					$id_colegio.val(current.Colegio.id);

					$('.colegio-caja').fadeIn();
					$('.colegio-caja').filter("[data-id!='" + current.Colegio.id + "']").fadeOut();
				}

				/**
				 * Opcion no existente
				 */
				else
				{
					$this.val('');
					$id_colegio.val('');
					$('.colegio-caja').fadeIn();
				}
			}
		});
	}
});

//]]>
