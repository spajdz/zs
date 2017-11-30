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
	$('#UsuarioRecuperarForm').validate($.extend({}, validate, $.configValidacion,
	{
		rules			: {
			'data[Usuario][email]': {
				required		: true,
				email			: true
			}
		},
		messages		: {
			'data[Usuario][email]': {
				required		: 'Debes ingresar tu email',
				email			: 'Debes ingresar un email válido'
			}
		}
	}));
});

//]]>
