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
	 * Seleccion Region - Comuna
	 */
	$('#ContactoComunaId').remoteChained(
	{
		parents			: '#ContactoRegionId',
		url				: $.webroot('comunas/ajax_region'),
		type			: 'POST',
		loading			: '-- Cargando comunas',
		bootstrap		: {
			''		: '-- Selecciona una comuna'
		}
	});
	$('#ContactoRegionId').trigger('change');

	/**
	 * Validaciones
	 */
	var validate		= {};
	$('#ContactoAddForm').validate($.extend({}, validate, $.configValidacion,
	{
		rules			: {
			'data[Contacto][region_id]': {
				required		: true
			},
			'data[Contacto][comuna_id]': {
				required		: true
			},
			'data[Contacto][nombre]': {
				required		: true
			},
			'data[Contacto][email]': {
				required		: true,
				email			: true
			},
			'data[Contacto][mensaje]': {
				required		: true
			}
		},
		messages		: {
			'data[Contacto][region_id]': {
				required		: 'Debes seleccionar una región'
			},
			'data[Contacto][comuna_id]': {
				required		: 'Debes seleccionar una comuna'
			},
			'data[Contacto][nombre]': {
				required		: 'Debes ingresar tu nombre'
			},
			'data[Contacto][email]': {
				required		: 'Debes ingresar tu email',
				email			: 'Debes ingresar un email válido'
			},
			'data[Contacto][mensaje]': {
				required		: 'Debes ingresar el mensaje'
			}
		}
	}));
});

//]]>
