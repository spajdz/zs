/* jshint bitwise:true, browser:true, eqeqeq:true, forin:true, globalstrict:true, indent:4, jquery:true,
   loopfunc:true, maxerr:3, noarg:true, node:true, noempty:true, onevar: true, quotmark:single,
   strict:true, undef:true, white:false */
/* global number_format, colegios */

/*!
 * Hookipa 2015
 */

//<![CDATA[
'use strict';

/**
 * Listas
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
			url			: $.webroot('listas/ajax_niveles'),
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
				$('[name="data[Lista][nivel]"]').html($html.html());
			}
		});
	},

	/**
	 * Desactiva un libro de la lista
	 */
	activarTexto		: function(id, lista_id, activar)
	{
		var def			= $.Deferred();

		$.ajax(
		{
			type		: 'POST',
			url			: $.webroot('listas/ajax_activar'),
			dataType	: 'json',
			data		: {
				data		: {
					Lista		: {
						id				: id,
						lista_id		: lista_id,
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
				def.reject(data);
			}
		}).fail(function()
		{
			def.reject();
		});

		return def.promise();
	},

	/**
	 * Des/activa todos los libro de la lista
	 */
	activarTextoTodos	: function(lista_id, activar)
	{
		var def			= $.Deferred();

		$.ajax(
		{
			type		: 'POST',
			url			: $.webroot('listas/ajax_activar_todos'),
			dataType	: 'json',
			data		: {
				data		: {
					Lista		: {
						lista_id		: lista_id,
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
	var $autocomplete		= $('[name="data[Lista][colegio]"]'),
		$nivel_id			= $('[name="data[Lista][nivel_id]"]'),
		$id_colegio			= $('[name="data[Lista][colegio_id]"]');

	/**
	 * Boton agregar alumno
	 */
	$('.js-agregar-alumno').on('click', function(evento)
	{
		evento.preventDefault();
		var $container		= $('.js-lista-nuevo-alumno-container');
		if ( $container.hasClass('hidden') )
		{
			/**
			 * Elimina las clases de animacion
			 */
			$container.removeClass(['hidden', 'animated', $.animaciones.lista.agregar.animacionEntrada, $.animaciones.lista.agregar.animacionSalida].join(' '));

			/**
			 * Anima la entrada
			 */
			$container.addClass(['animated', $.animaciones.lista.agregar.animacionEntrada].join(' '));
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
		$container.removeClass(['animated', $.animaciones.lista.agregar.animacionEntrada, $.animaciones.lista.agregar.animacionSalida].join(' '));

		/**
		 * Anima la entrada
		 */
		$container.addClass(['animated', $.animaciones.lista.agregar.animacionSalida].join(' '));
		$container.one($.animaciones.animacionEventoFin, function()
		{
			$container.addClass('hidden');
		});
	});


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
			*/
			source				: colegios,
			minLength			: (colegios.length < 10 ? 0 : 1),
			autoSelect			: true,
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
				}

				/**
				 * Opcion no existente
				 */
				else
				{
					$this.val('');
					$id_colegio.val('');
				}
			}
		});
	}



	$('.js-nivel').on('change', function()
	{
		var $this           = $(this).find(':selected'),
			idnivel = $this.val();
			console.log(idnivel);
			$nivel_id.val(idnivel);
	});

	/**
	 * Enmascaramiento y restriccion de inputs
	 */
	$('#ListaNombreAlumno, #ListaApellidoAlumno').alphanumeric({ allow: ' .-\'' });


	/**
	 * Validaciones
	 */
	var validate		= {};
	$('#ListaAddForm').validate($.extend({}, validate, $.configValidacion,
	{
		rules			: {
			'data[Lista][nivel]': {
				required		: true
			}
		},
		messages		: {
			'data[Lista][nivel]': {
				required		: 'Debes seleccionar el nivel del alumno'
			}
		}
	}));


	$('#ListaColegioForm').validate($.extend({}, validate, $.configValidacion,
	{
		rules			: {
			'data[Lista][colegio]': {
				required		: true
			}
		},
		messages		: {
			'data[Lista][colegio]': {
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
			$lista		= $this.parents('.alumno-colegio');

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
					 * Elimina el contenedor de lista si ya no existen mas productos
					 */
					if ( ! $lista.find('.js-contenedor-producto').length )
					{
						$lista.addClass(['animated', $.animaciones.producto.carro.eliminar].join(' '));
						$lista.one($.animaciones.animacionEventoFin, function()
						{
							$lista.remove();
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
					$('.js-accion-lista').hide();
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
	 * Elimina alumnos de la lista
	 */
	$('.alumno-colegio .js-eliminar-lista').on('click', function(evento)
	{
		evento.preventDefault();
		var $this			= $(this),
			$lista			= $this.parents('.alumno-colegio'),
			id				= $lista.data('id'),
			popupOpt		= {
				tipo			: 'ERROR',
				titulo			: 'Eliminar lista',
				subtitulo		: '¿Confirmas que deseas eliminar este alumno de tu lista de uniformes?',
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
			$.when($.eliminarLista(id)).done(function(data)
			{
				/**
				 * Elimina la lista de la tabla
				 */
				$lista.addClass(['animated', $.animaciones.producto.carro.eliminar].join(' '));
				$lista.one($.animaciones.animacionEventoFin, function()
				{
					$lista.remove();
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
					$('.js-accion-lista').hide();
				}
			}).fail(function()
			{
				$.popup.generico.abrir(
				{
					tipo			: 'ERROR',
					titulo			: 'Error al eliminar la lista',
					subtitulo		: 'Se produjo un error al eliminar la lista.<br>Por favor intenta nuevamente.'
				});
			});
		}).fail(function()
		{
			//
		});
	});


	/**
	 * Recalcula total producto
	 */
	$('.js-talla-select').on('change', function()
	{
		var $this			= $(this),
			$contenedor		= $this.parents('.js-contenedor-producto').first();

		$contenedor.find('.js-cantidad-select').trigger('change');
	});
	$('.js-cantidad-select').on('change', function()
	{
		var $this			= $(this),
			cantidad		= parseInt($this.val(), 10),
			$contenedor		= $this.parents('.js-contenedor-producto').first(),
			$lista			= $this.parents('.js-contenedor-lista').first(),
			$subtotal		= $lista.find('.js-subtotal-lista'),
			precio			= 0,
			total			= 0;

		precio			= parseInt($contenedor.find('.js-talla-select :selected').data('precio-raw'), 10);
		$contenedor.find('.js-total-libro').html('$' + number_format((precio * cantidad), 0, null, '.'));

		$lista.find('.js-contenedor-producto').each(function()
		{
			total		+= (
				parseInt($(this).find('.js-talla-select :selected').data('precio-raw'), 10) *
				parseInt($(this).find('.js-cantidad-select :selected').val(), 10)
			);
		});

		$subtotal.html('$' + number_format(total, 0, null, '.'));
	}).trigger('change');
});

//]]>
