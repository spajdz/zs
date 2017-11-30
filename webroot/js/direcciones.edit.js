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
	 * Seleccion Region - Comuna
	 */
	$('#DireccionComunaId').remoteChained(
	{
		parents			: '#DireccionRegionId',
		url				: $.webroot('comunas/ajax_region'),
		type			: 'POST',
		loading			: '-- Cargando comunas'
	});


	/**
	 * Enmascaramiento y restriccion de inputs
	 */
	$('#DireccionTelefono').mask('9 999 9999', { placeholder: 'X' });
	$('#DireccionCodigoPostal').mask('9999999', { placeholder: 'X' });


	/**
	 * Validaciones
	 */
	var validate		= {};
	$('#DireccionEditForm').validate($.extend({}, validate, $.configValidacion,
	{
		rules			: {
			'data[Direccion][calle]': {
				required		: true,
			},
			'data[Direccion][numero]': {
				required		: true
			},
			'data[Direccion][region_id]': {
				required		: true
			},
			'data[Direccion][comuna_id]': {
				required		: true
			},
			'data[Direccion][codigo_postal]': {
				required		: true,
				digits			: true,
				rangelength		: [7, 7]
			},
			'data[Direccion][telefono]': {
				required		: true
			}
		},
		messages		: {
			'data[Direccion][calle]': {
				required		: 'Debes ingresar tu calle',
			},
			'data[Direccion][numero]': {
				required		: 'Debes ingresar el número de tu dirección'
			},
			'data[Direccion][region_id]': {
				required		: 'Debes seleccionar una región'
			},
			'data[Direccion][comuna_id]': {
				required		: 'Debes seleccionar una comuna'
			},
			'data[Direccion][codigo_postal]': {
				required		: 'Debes ingresar el código postal',
				digits			: 'El código postal solo pueden ser dígitos',
				rangelength		: 'El código postal solo puede tener 7 dígitos'
			},
			'data[Direccion][telefono]': {
				required		: 'Debes ingresar un celular de contacto'
			}
		}
	}));
});

//]]>
