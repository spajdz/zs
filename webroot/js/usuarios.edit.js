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
	 * Enmascaramiento y restriccion de inputs
	 */
	$('#UsuarioNombre, #UsuarioApellidoPaterno, #UsuarioApellidoMaterno').alphanumeric({ allow: ' ' });
	$('#UsuarioCelular').mask('9 999 9999', { placeholder: 'X' });
	$('#UsuarioFono').mask('9 999 9999', { placeholder: 'X' });
	/*
	$('#UsuarioRut')
		.mask('99.999.99?9', { placeholder: 'X' })
		.on(
		{
			focus		: function()
			{
				$(this).mask('99.999.99?9');
			},
			blur		: function()
			{
				var $this		= $(this);
				setTimeout(function()
				{
					var val		= $this.val().replace(/[^\d]+/g, '');

					if ( val.length == 7 )
					{
						$this.mask('9.999.999', { placeholder: 'X' });
					}
				}, 200);
			}
		});

	$.mask.definitions['~']		= '[0-9kK]';
	$('#UsuarioDv').mask("~");
	*/


	/**
	 * Validaciones
	 */
	var validate		= {};
	/*
	$.validator.addMethod('rut', function(value, element)
	{
		return this.optional(element) || $.Rut.validar(value + $('#UsuarioDv').val());
	});
	$('#UsuarioRut').Rut({ validation: false, format_on: 'keyup', digito_verificador: '#UsuarioDv' });
	*/
	$('#UsuarioEditForm').validate($.extend({}, validate, $.configValidacion,
	{
		rules			: {
			'data[Usuario][tipo_usuario_id]': {
				required		: true
			},
			'data[Usuario][nombre]': {
				required		: true
			},
			'data[Usuario][apellido_paterno]': {
				required		: true
			},
			'data[Usuario][celular]': {
				required		: true
			},
			'data[Usuario][email]': {
				required		: true,
				email			: true
			},
			'data[Usuario][clave]': {
				required		: false
			},
			'data[Usuario][repetir_clave]': {
				required		: false,
				equalTo			: '#UsuarioClave'
			}
		},
		messages		: {
			'data[Usuario][tipo_usuario_id]': {
				required		: 'Debes seleccionar tu tipo de usuario'
			},
			'data[Usuario][nombre]': {
				required		: 'Debes ingresar tu nombre'
			},
			'data[Usuario][apellido_paterno]': {
				required		: 'Debes ingresar tu apellido paterno'
			},
			'data[Usuario][celular]': {
				required		: 'Debes ingresar tu celular'
			},
			'data[Usuario][email]': {
				required		: 'Debes ingresar tu email',
				email			: 'Debes ingresar un email válido'
			},
			'data[Usuario][clave]': {
				required		: 'Debes ingresar tu contraseña'
			},
			'data[Usuario][repetir_clave]': {
				required		: 'Debes repetir tu contraseña',
				equalTo			: 'Las contraseñas ingresadas no concuerdan'
			}
		}
	}));
});

//]]>
