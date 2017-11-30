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
	 * Validaciones
	 */
	var validate		= {};
	$('#UsuarioCambiarClaveForm').validate($.extend({}, validate, $.configValidacion,
	{
		rules			: {
			'data[Usuario][clave]': {
				required		: true
			},
			'data[Usuario][repetir_clave]': {
				required		: true,
				equalTo			: '#UsuarioClave'
			}
		},
		messages		: {
			'data[Usuario][clave]': {
				required		: 'Debes ingresar tu nueva contraseña'
			},
			'data[Usuario][repetir_clave]': {
				required		: 'Debes repetir tu contraseña',
				equalTo			: 'Las contraseñas ingresadas no son iguales.'
			}
		}
	}));
});

//]]>
