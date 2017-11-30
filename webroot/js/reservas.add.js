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
 * Reservas
 */
jQuery.extend(
{
	/**
	 * Obtiene los niveles dada una seleccion de colegio y los actualiza
	 * al elemento select correspondiente
	 *
	 * @param			string			colegio				Código del colegio
	 * @return			void
	 */
	getNiveles			: function(colegio)
	{
		$.ajax(
		{
			type		: 'POST',
			url			: $.webroot('reservas/ajax_niveles'),
			dataType	: 'json',
			data		: { query: colegio },
			success		: function(data)
			{
				var $html = $('<select />'), x;
				$html.append($('<option />',
				{
					value	: '',
					html	: '-- Selecciona el nivel'
				}));
				for ( x in data )
				{
					if ( data.hasOwnProperty(x) )
					{
						$html.append($('<option />',
						{
							value	: data[x].name,
							html	: data[x].name
						}));
					}
				}
				$('[name="data[Reserva][nivel]"]').html($html.html());
			}
		});
	},

	/**
	 * Desactiva un libro de la reserva
	 */
	activarTexto		: function(id, reserva_id, activar)
	{
		var def			= $.Deferred();

		$.ajax(
		{
			type		: 'POST',
			url			: $.webroot('reservas/ajax_activar'),
			dataType	: 'json',
			data		: {
				data		: {
					Reserva		: {
						id				: id,
						reserva_id		: reserva_id,
						activar			: activar
					}
				}
			}
		}).done(function(data)
		{
			if ( data.success )
			{
				def.resolve(data);
			}
			else
			{
				def.reject();
			}
		}).fail(function()
		{
			def.reject();
		});

		return def.promise();
	},

	/**
	 * Des/activa todos los libro de la reserva
	 */
	activarTextoTodos	: function(reserva_id, activar)
	{
		var def			= $.Deferred();

		$.ajax(
		{
			type		: 'POST',
			url			: $.webroot('reservas/ajax_activar_todos'),
			dataType	: 'json',
			data		: {
				data		: {
					Reserva		: {
						reserva_id		: reserva_id,
						activar			: activar
					}
				}
			}
		}).done(function(data)
		{
			if ( data.success )
			{
				def.resolve(data);
			}
			else
			{
				def.reject();
			}
		}).fail(function()
		{
			def.reject();
		});

		return def.promise();
	}
});

/**
 * jQuery
 */
jQuery(document).ready(function($)
{
	/**
	 * Input autocomplete y codigo colegio
	 */
	/*
	var $autocomplete		= $('[name="data[Reserva][nombre_colegio]"]'),
		$codigo				= $('[name="data[Reserva][LVEN]"]');
	*/


	/**
	 * Limpieza inicial
	 */
	/*
	$autocomplete.val('');
	$codigo.val('');
	*/


	/**
	 * Boton agregar alumno
	 */
	$('.js-agregar-alumno').on('click', function(evento)
	{
		evento.preventDefault();
		var $container		= $('.js-reserva-nuevo-alumno-container');
		if ( $container.hasClass('hidden') )
		{
			/**
			 * Elimina las clases de animacion
			 */
			$container.removeClass(['hidden', 'animated', $.animaciones.reserva.agregar.animacionEntrada, $.animaciones.reserva.agregar.animacionSalida].join(' '));

			/**
			 * Anima la entrada
			 */
			$container.addClass(['animated', $.animaciones.reserva.agregar.animacionEntrada].join(' '));
		}
	});


	/**
	 * Cerrar cuadro de agregar alumnos
	 */
	$('.js-cerrar-container').on('click', function(evento)
	{
		evento.preventDefault();
		var $this			= $(this),
			$container		= $this.parents('.js-container').first();

		/**
		 * Elimina las clases de animacion
		 */
		$container.removeClass(['animated', $.animaciones.reserva.agregar.animacionEntrada, $.animaciones.reserva.agregar.animacionSalida].join(' '));

		/**
		 * Anima la entrada
		 */
		$container.addClass(['animated', $.animaciones.reserva.agregar.animacionSalida].join(' '));
		$container.one($.animaciones.animacionEventoFin, function()
		{
			$container.addClass('hidden');
		});
	});


	/**
	 * Autocomplete del nombre del colegio
	 */
	/*
	$autocomplete.typeahead(
	{
		/*
		source				: function(query, process)
		{
			$.ajax(
			{
				type		: 'POST',
				url			: $.webroot('reservas/ajax_colegios'),
				dataType	: 'json',
				data		: { query: query },
				success		: process
			});
		},
		*
		source				: reserva_colegios,
		minLength			: (reserva_colegios.length < 10 ? 0 : 1),
		autoSelect			: false,
		showHintOnFocus		: true
	});
	*/


	/**
	 * Actualiza el codigo del colegio o elimina el colegio
	 * si no corresponde a una opcion del autoselector
	 */
	/*
	$autocomplete.on('change blur', function()
	{
		var $this			= $(this),
			current			= $this.typeahead('getActive');

		if ( typeof(current) !== 'undefined' )
		{
			/**
			 * Seleccion de opcion
			 *
			if ( current.name === $this.val() )
			{
				$codigo.val(current.id);
				$.getNiveles(current.id);
			}

			/**
			 * Opcion no existente
			 *
			else
			{
				$this.val('');
				$codigo.val('');
			}
		}
	});
	*/


	/**
	 * Enmascaramiento y restriccion de inputs
	 */
	$('#ReservaNombreAlumno, #ReservaApellidoAlumno').alphanumeric({ allow: ' .-\'' });


	/**
	 * Validaciones
	 */
	var validate		= {};
	$('#ReservaAddForm').validate($.extend({}, validate, $.configValidacion,
	{
		rules			: {
			'data[Reserva][nombre_alumno]': {
				required		: true
			},
			'data[Reserva][apellido_alumno]': {
				required		: true
			},
			'data[Reserva][nivel]': {
				required		: true
			}
		},
		messages		: {
			'data[Reserva][nombre_alumno]': {
				required		: 'Debes ingresar el nombre del alumno'
			},
			'data[Reserva][apellido_alumno]': {
				required		: 'Debes ingresar el apellido del alumno'
			},
			'data[Reserva][nivel]': {
				required		: 'Debes seleccionar el nivel del alumno'
			}
		}
	}));


	$('#ReservaColegioForm').validate($.extend({}, validate, $.configValidacion,
	{
		rules			: {
			'data[Reserva][colegio]': {
				required		: true
			}
		},
		messages		: {
			'data[Reserva][colegio]': {
				required		: 'Debes seleccionar un colegio'
			}
		}
	}));


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
			$producto		= $this.parents('.js-contenedor-producto').first(),
			$reserva		= $this.parents('.alumno-colegio');

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

					/**
					 * Elimina el contenedor de reserva si ya no existen mas productos
					 */
					if ( ! $reserva.find('.js-contenedor-producto').length )
					{
						$reserva.addClass(['animated', $.animaciones.producto.carro.eliminar].join(' '));
						$reserva.one($.animaciones.animacionEventoFin, function()
						{
							$reserva.remove();
						});
					}
				});

				/**
				 * Escribe los datos del carro
				 */
				$.actualizarCarro(data.carro.Cantidad, data.carro.Total);

				/**
				 * Si elimina todos los productos, quita los botones de accion
				 */
				if ( ! data.carro.Cantidad )
				{
					$('.js-accion-reserva').hide();
				}
			}).fail(function()
			{
				//
			});
		}).fail(function()
		{
			//
		});
	});


	/**
	 * Elimina alumnos de la reserva
	 */
	$('.alumno-colegio .js-eliminar-reserva').on('click', function(evento)
	{
		evento.preventDefault();
		var $this			= $(this),
			$reserva		= $this.parents('.alumno-colegio'),
			id				= $reserva.data('id'),
			popupOpt		= {
				tipo			: 'ERROR',
				titulo			: 'Eliminar reserva',
				subtitulo		: '¿Confirmas que deseas eliminar este alumno de tu reserva de textos?',
				acciones		: [
					{
						text		: 'Confirmar',
						cerrar		: true,
						resolve		: true,
						icon		: 'fa-trash-o',
						focus		: true
					},
					{
						text		: 'Cancelar',
						cerrar		: true
					}
				]
			};

		$.when($.popup.generico.abrir(popupOpt)).done(function()
		{
			$.when($.eliminarReserva(id)).done(function(data)
			{
				/**
				 * Elimina la reserva de la tabla
				 */
				$reserva.addClass(['animated', $.animaciones.producto.carro.eliminar].join(' '));
				$reserva.one($.animaciones.animacionEventoFin, function()
				{
					$reserva.remove();
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
					$('.js-accion-reserva').hide();
				}
			}).fail(function()
			{
				$.popup.generico.abrir(
				{
					tipo			: 'ERROR',
					titulo			: 'Error al eliminar la reserva',
					subtitulo		: 'Se produjo un error al eliminar la reserva.<br>Por favor intenta nuevamente.'
				});
			});
		}).fail(function()
		{
			//
		});
	});


	/**
	 * Activa o desactiva un texto de la reserva
	 */
	$('.js-reserva-seleccionar-texto').on('change', function()
	{
		var $this			= $(this),
			activar			= ($this.is(':checked') ? 1 : 0),
			id				= $this.data('id'),
			reserva_id		= $this.data('reserva_id'),
			$producto		= $this.parents('.js-contenedor-producto').first(),
			$reserva		= $this.parents('.js-contenedor-reserva').first();

		/**
		 * Solicita la desactivacion del texto
		 */
		$.when($.activarTexto(id, reserva_id, activar)).done(function(data)
		{
			/**
			 * Actualiza la cantidad
			 */
			$producto.find('.js-cantidad-libro').text((activar ? 1 : 0));

			/**
			 * Actualiza el total del producto
			 */
			$producto.find('.js-total-libro').text('$' + number_format(data.info.Producto.Subtotal, 0, null, '.'));

			/**
			 * Actualiza el subtotal de la reserva
			 */
			$reserva.find('.js-subtotal-reserva').text('$' + number_format(data.info.Catalogo.Subtotal, 0, null, '.'));

			/**
			 * Escribe los datos del carro
			 */
			$.actualizarCarro(data.info.Carro.Cantidad, data.info.Carro.Subtotal);
		}).fail(function()
		{
			/**
			 * Retorna el estado del checkbox a su estado anterior
			 */
			$this.prop('checked', ! activar);
		});
	});


	/**
	 * De/Seleccionar todos
	 */
	$('.js-reserva-sel-todos, .js-reserva-desel-todos').on('click', function(evento)
	{
		evento.preventDefault();
		var $this				= $(this),
			reserva_id			= $this.data('reserva_id'),
			activar				= $this.hasClass('js-reserva-sel-todos'),
			$reserva			= $this.parents('.js-contenedor-reserva').first(),
			$productos			= $reserva.find('.js-contenedor-producto'),
			$checks				= $reserva.find('.js-reserva-seleccionar-texto');

		/**
		 * Solicita la desactivacion del texto
		 */
		$.when($.activarTextoTodos(reserva_id, activar)).done(function(data)
		{
			/**
			 * Actualiza los checks
			 */
			$checks.prop('checked', activar);

			/**
			 * Actualiza los datos de los productos
			 */
			$productos.each(function()
			{
				$(this).find('.js-cantidad-libro').text((activar ? 1 : 0));
				$(this).find('.js-total-libro').text((activar ? $(this).find('.js-precio-libro').text() : '$0'));
			});

			/**
			 * Actualiza el subtotal de la reserva
			 */
			$reserva.find('.js-subtotal-reserva').text('$' + number_format(data.info.Catalogo.Subtotal, 0, null, '.'));

			/**
			 * Escribe los datos del carro
			 */
			$.actualizarCarro(data.info.Carro.Cantidad, data.info.Carro.Subtotal);
		}).fail(function()
		{
			//
		});
	});

});

//]]>
