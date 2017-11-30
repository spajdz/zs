/* jshint bitwise:true, browser:true, eqeqeq:true, forin:true, globalstrict:true, indent:4, jquery:true,
   loopfunc:true, maxerr:3, noarg:true, node:true, noempty:true, onevar: true, quotmark:single,
   strict:true, undef:true, white:false */
/* global webroot, fullwebroot, number_format, NProgress */

/*!
 * Hookipa 2015
 */

//<![CDATA[
'use strict';

/**
 * Aplicacion
 */
jQuery.extend(
{
	/**
	 * Entrega la URL relativa del sitio
	 *
	 * @param			string			ruta				Ruta de la aplicacion a devolver
	 * @param			bool			full				Devuelve la ruta completa de la app o la ruta relativa
	 * @return			string								URL de la aplicacion
	 */
	webroot					: function(ruta, full)
	{
		full	= (typeof(full) !== 'undefined' ? true : false);
		return (full ? fullwebroot : webroot) + ruta;
	},

	/**
	 * Agrega un producto al carro de compras
	 *
	 * @param			string			id					ID CATALOGO del producto a agregar
	 * @param			int				cantidad			Cantidad del item agregado
	 * @param			bool			wipe				Limpiar otros catalogos antes de agregar el producto?
	 * @return			promise								Promise del proceso
	 */
	agregarProducto			: function(id, cantidad, wipe)
	{
		var def			= $.Deferred();

		$.ajax(
		{
			type		: 'POST',
			url			: $.webroot('productos/ajax_agregar'),
			dataType	: 'json',
			data		: {
				data		: {
					Producto	: {
						id				: id,
						cantidad		: cantidad,
						wipe			: wipe
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
	 * Actualiza la cantidad de un producto en el carro de compras
	 *
	 * @param			string			id					ID CATALOGO del producto a actualizar
	 * @param			int				cantidad			Nueva cantidad del item
	 * @return			promise								Promise del proceso
	 */
	actualizarProducto		: function(id, cantidad)
	{
		var def			= $.Deferred();

		$.ajax(
		{
			type		: 'POST',
			url			: $.webroot('productos/ajax_actualizar'),
			dataType	: 'json',
			data		: {
				data		: {
					Producto	: {
						id				: id,
						cantidad		: cantidad
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
	 * Elimina un producto del carro de compras
	 *
	 * @param			string			id					ID CATALOGO del producto a actualizar
	 * @return			promise								Promise del proceso
	 */
	eliminarProducto		: function(id)
	{
		var def			= $.Deferred();

		$.ajax(
		{
			type		: 'POST',
			url			: $.webroot('productos/ajax_eliminar'),
			dataType	: 'json',
			data		: {
				data		: {
					Producto	: {
						id			: id
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
	 * Elimina una reserva y sus productos del carro
	 *
	 * @param			string			id					ID de la reserva a eliminar
	 * @return			promise								Promise del proceso
	 */
	eliminarReserva			: function(id)
	{
		var def			= $.Deferred();

		$.ajax(
		{
			type		: 'POST',
			url			: $.webroot('reservas/ajax_eliminar'),
			dataType	: 'json',
			data		: {
				data		: {
					Reserva		: {
						id			: id
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
	 * Elimina una lista de uniformes y sus productos del carro
	 *
	 * @param			string			id					ID de la reserva a eliminar
	 * @return			promise								Promise del proceso
	 */
	eliminarLista			: function(id)
	{
		var def			= $.Deferred();

		$.ajax(
		{
			type		: 'POST',
			url			: $.webroot('listas/ajax_eliminar'),
			dataType	: 'json',
			data		: {
				data		: {
					Lista		: {
						id			: id
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
	 * Actualiza la informacion del carro en el header, o donde aplique
	 *
	 * @param			int				cantidad			Cantidad de productos
	 * @param			int				total				Total en dinero
	 * @return			void
	 */
	actualizarCarro			: function(cantidad, total)
	{
		$('.js-carro-total-items').text(cantidad);
		$('.js-carro-total-dinero').text('$' + number_format(total, 0, null, '.'));
	},

	/**
	 * Definiciones de animaciones de popups y elementos dinamicos
	 */
	animaciones				: {
		/**
		 * Eventos de fin de animacion
		 */
		animacionEventoFin	: 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',

		/**
		 * Animaciones de acciones de productos (agregar, eliminar, etc)
		 */

		producto			: {
			/**
			 * Animaciones de carro de compras
			 */
			carro				: {
				eliminar			: 'fadeOutLeftBig'
			},

			/**
			 * Animaciones de popup agregar/eliminar
			 */
			popup				: {
				agregar				: {
					animacionFondoEntrada	: 'fadeIn',
					animacionFondoSalida	: 'fadeOut',
					animacionEntrada		: 'bounceInDown',
					animacionSalida			: 'fadeOutUp',
				},
				eliminar			: {
					animacionFondoEntrada	: 'fadeIn',
					animacionFondoSalida	: 'fadeOut',
					animacionEntrada		: 'bounceInDown',
					animacionSalida			: 'fadeOutUp',
				}
			}
		},

		/**
		 * Animaciones popup generico
		 */
		generico			: {
			animacionFondoEntrada	: 'fadeIn',
			animacionFondoSalida	: 'fadeOut',
			animacionEntrada		: 'bounceInDown',
			animacionSalida			: 'fadeOutUp',
		},

		/**
		 * Animaciones de seccion uniformes por colegio
		 */
		lista				: {
			/**
			 * Cuadro para agregar alumno
			 */
			agregar				: {
				animacionEntrada		: 'fadeInLeftBig',
				animacionSalida			: 'fadeOutLeftBig'
			},

			eliminar			: {
				//
			}
		},

		/**
		 * Animaciones de seccion reservas
		 */
		reserva				: {
			/**
			 * Cuadro para agregar alumno
			 */
			agregar				: {
				animacionEntrada		: 'fadeInLeftBig',
				animacionSalida			: 'fadeOutLeftBig'
			},

			eliminar			: {
				//
			}
		}
	},

	/**
	 * Popups de la aplicación
	 */
	popup					: {
		/**
		 * Popups de productos
		 */
		producto			: {

			/**
			 * Agregar al carro
			 */
			agregar				: {
				/**
				 * Abre el popup de agregar producto al carro
				 *
				 * @param			string			imagen				Imagen del producto
				 * @param			string			nombre				Nombre del producto
				 * @param			object			data				Datos del producto (devuelto por la accion .agregarProducto)
				 * @return			void
				 */
				abrir				: function(nombre, imagen, data)
				{
					var $popup			= $('.popup-agregar-producto');

					/**
					 * Escribe los datos del producto
					 */
					$popup.find('.js-nombre-producto').html(nombre);
					$popup.find('.js-imagen-producto').attr('src', $.webroot(imagen));
					$popup.find('.js-total-articulos').text(data.info.Carro.Cantidad);
					$popup.find('.js-multiple').toggle((data.info.Carro.Cantidad > 1 ? true : false));

					/**
					 * Elimina las clases de animacion
					 */
					$popup.removeClass(['hidden', 'animated', $.animaciones.producto.popup.agregar.animacionFondoEntrada, $.animaciones.producto.popup.agregar.animacionFondoSalida].join(' '))
						.find('.agregar-carro').removeClass(['animated', $.animaciones.producto.popup.agregar.animacionEntrada, $.animaciones.producto.popup.agregar.animacionSalida].join(' '));

					/**
					 * Anima la entrada
					 */
					$popup.addClass(['animated', $.animaciones.producto.popup.agregar.animacionFondoEntrada].join(' '))
						.find('.agregar-carro').addClass(['animated', $.animaciones.producto.popup.agregar.animacionEntrada].join(' '));

					/**
					 * Activa el hoykey (ESCAPE) para cerrar el popup
					 */
					$(document).one('keydown.popupProductoAgregar', null, 'esc', $.popup.producto.agregar.cerrar);

					/**
					 * Botones cerrar
					 */
					$popup.one('click.popupProductoAgregar', '.js-cerrar-popup', $.popup.producto.agregar.cerrar);

					/**
					 * Focus al boton de seguir comprando (para evitar que el enter agrege varias veces el mismo producto)
					 */
					$popup.find('.js-focus').focus();
				},

				/**
				 * Cierra el popup de agregar producto al carro
				 *
				 * @param			object			evento				Evento que ejecuta la accion
				 * @return			void
				 */
				cerrar				: function(evento)
				{
					if ( evento )
					{
						evento.preventDefault();
					}
					var $popup			= $('.popup-agregar-producto');

					/**
					 * Elimina las clases de animacion
					 */
					$popup.removeClass(['hidden', 'animated', $.animaciones.producto.popup.agregar.animacionFondoEntrada, $.animaciones.producto.popup.agregar.animacionFondoSalida].join(' '))
						.find('.agregar-carro').removeClass(['animated', $.animaciones.producto.popup.agregar.animacionEntrada, $.animaciones.producto.popup.agregar.animacionSalida].join(' '));

					/**
					 * Anima la salida
					 */
					$popup.addClass(['animated', $.animaciones.producto.popup.agregar.animacionFondoSalida].join(' '))
						.find('.agregar-carro').addClass(['animated', $.animaciones.producto.popup.agregar.animacionSalida].join(' '));

					/**
					 * Oculta el popup al terminar la animación
					 */
					$popup.one($.animaciones.animacionEventoFin, function()
					{
						$popup.addClass('hidden');
					});

					/**
					 * Desactiva el hotkey
					 */
					$(document).off('keydown.popupProductoAgregar');

					/**
					 * Desactiva botones cerrar
					 */
					$popup.off('click.popupProductoAgregar');
				}
			},

			/**
			 * Eliminar del carro
			 */
			eliminar			: {
				/**
				 * Deferred
				 */
				def					: null,

				/**
				 * Abre el popup de eliminar producto del carro
				 *
				 * @param			string			imagen				Imagen del producto
				 * @param			string			nombre				Nombre del producto
				 * @param			object			data				Datos del producto (devuelto por la accion .agregarProducto)
				 * @return			void
				 */
				abrir				: function(nombre, imagen)
				{
					var $popup			= $('.popup-eliminar-producto');
					$.popup.producto.eliminar.def		= $.Deferred();

					/**
					 * Escribe los datos del producto
					 */
					$popup.find('.js-nombre-producto').html(nombre);
					$popup.find('.js-imagen-producto').attr('src', $.webroot(imagen));

					/**
					 * Elimina las clases de animacion
					 */
					$popup.removeClass(['hidden', 'animated', $.animaciones.producto.popup.eliminar.animacionFondoEntrada, $.animaciones.producto.popup.eliminar.animacionFondoSalida].join(' '))
						.find('.eliminar-carro').removeClass(['animated', $.animaciones.producto.popup.eliminar.animacionEntrada, $.animaciones.producto.popup.eliminar.animacionSalida].join(' '));

					/**
					 * Anima la entrada
					 */
					$popup.addClass(['animated', $.animaciones.producto.popup.eliminar.animacionFondoEntrada].join(' '))
						.find('.eliminar-carro').addClass(['animated', $.animaciones.producto.popup.eliminar.animacionEntrada].join(' '));


					/**
					 * Activa el hoykey (ESCAPE) para cerrar el popup
					 */
					$(document).one('keydown.popupProductoEliminar', null, 'esc', $.popup.producto.eliminar.cerrar);

					/**
					 * Botones cerrar
					 */
					$popup.one('click.popupProductoEliminar', '.js-cerrar-popup', $.popup.producto.eliminar.cerrar);

					/**
					 * Activa el boton de confirmacion
					 */
					$popup.one('click.popupProductoEliminar', '.js-confirma-eliminar', function(evento)
					{
						$.popup.producto.eliminar.def.resolve(evento);
						$.popup.producto.eliminar.cerrar(evento);
					});

					/**
					 * Focus al boton de eliminar, para que al apretar enter se elimine el producto
					 */
					$popup.find('.js-focus').focus();

					/**
					 * Devuelve promise
					 */
					return $.popup.producto.eliminar.def.promise();
				},

				/**
				 * Cierra el popup de eliminar producto del carro
				 *
				 * @param			object			evento				Evento que ejecuta la accion
				 * @return			void
				 */
				cerrar				: function(evento)
				{
					if ( evento )
					{
						evento.preventDefault();
					}
					var $popup			= $('.popup-eliminar-producto');

					/**
					 * Rechaza el promise
					 */
					$.popup.producto.eliminar.def.reject();
					$.popup.producto.eliminar.def	= null;

					/**
					 * Elimina las clases de animacion
					 */
					$popup.removeClass(['hidden', 'animated', $.animaciones.producto.popup.eliminar.animacionFondoEntrada, $.animaciones.producto.popup.eliminar.animacionFondoSalida].join(' '))
						.find('.eliminar-carro').removeClass(['animated', $.animaciones.producto.popup.eliminar.animacionEntrada, $.animaciones.producto.popup.eliminar.animacionSalida].join(' '));

					/**
					 * Anima la salida
					 */
					$popup.addClass(['animated', $.animaciones.producto.popup.eliminar.animacionFondoSalida].join(' '))
						.find('.eliminar-carro').addClass(['animated', $.animaciones.producto.popup.eliminar.animacionSalida].join(' '));

					/**
					 * Oculta el popup al terminar la animación
					 */
					$popup.one($.animaciones.animacionEventoFin, function()
					{
						$popup.addClass('hidden');
					});

					/**
					 * Desactiva el hotkey
					 */
					$(document).off('keydown.popupProductoEliminar');

					/**
					 * Desactiva botones cerrar y confirmar
					 */
					$popup.off('click.popupProductoEliminar');
				}
			}
		},

		/**
		 * Popup generico
		 */
		generico			: {
			/**
			 * Deferred
			 */
		   def						: null,

			/**
			 * Abre el popup generico
			 *
			 * @param			object			opciones			Opciones para mostrar el popup
			 * @return			void
			 */
			abrir				: function(opciones)
			{
				var $popup			= $('.popup-generico'), x, accion,
					accionFocus		= null;
					opciones		= $.extend({},
					{
						titulo			: null,
						subtitulo		: '',
						tipo			: 'OK',
						acciones		: [
							{
								text		: 'Cerrar',
								cerrar		: true,
								icon		: null,
								focus		: true
							}
						]
					}, opciones);

				$.popup.generico.def		= $.Deferred();

				/**
				 * Setea el tipo de alerta
				 */
				$popup.find('span.check').toggle(opciones.tipo === 'OK');
				$popup.find('span.del').toggle(opciones.tipo !== 'OK');

				/**
				 * Escribe los datos del producto
				 */
				$popup.find('.js-titulo').html(opciones.titulo);
				$popup.find('.js-subtitulo').html(opciones.subtitulo);

				/**
				 * Escribe los botones de accion
				 */
				$popup.find('.acciones').html('');
				for ( x in opciones.acciones )
				{
					if ( opciones.acciones.hasOwnProperty(x) )
					{
						accion	= $('<a />',
						{
							data		: {
								resolve		: (opciones.acciones[x].resolve || false),
								cerrar		: (opciones.acciones[x].cerrar || false),
								custom		: (opciones.acciones[x].custom || '')
							},
							text		: (opciones.acciones[x].text || ''),
							href		: (opciones.acciones[x].link || '#'),
							class		: 'btn ' + (opciones.acciones[x].class || ''),
							on			: {
								click		: function(evento)
								{
									var $this		= $(this);
									if ( $this.data('resolve') && $.popup.generico.def )
									{
										evento.preventDefault();
										$.popup.generico.def.resolve(evento);
									}
									if ( $this.data('cerrar') )
									{
										evento.preventDefault();
										$.popup.generico.cerrar(evento);
									}
								}
							}
						});
						if ( opciones.acciones[x].icon )
						{
							accion.append(' <i class="fa ' + opciones.acciones[x].icon + '"></i>');
						}
						accion.appendTo($popup.find('.acciones'));
						if ( opciones.acciones[x].focus )
						{
							accionFocus		= accion;
						}
					}
				}

				/**
				 * Elimina las clases de animacion
				 */
				$popup.removeClass(['hidden', 'animated', $.animaciones.generico.animacionFondoEntrada, $.animaciones.generico.animacionFondoSalida].join(' '))
					.find('.generico').removeClass(['animated', $.animaciones.generico.animacionEntrada, $.animaciones.generico.animacionSalida].join(' '));

				/**
				 * Anima la entrada
				 */
				$popup.addClass(['animated', $.animaciones.generico.animacionFondoEntrada].join(' '))
					.find('.generico').addClass(['animated', $.animaciones.generico.animacionEntrada].join(' '));

				/**
				 * Activa el hoykey (ESCAPE) para cerrar el popup
				 */
				$(document).one('keydown.popupGenerico', null, 'esc', $.popup.generico.cerrar);

				/**
				 * Botones cerrar
				 */
				$popup.one('click.popupGenerico', '.js-cerrar-popup', $.popup.generico.cerrar);

				/**
				 * Cancela el cierre programatico
				 */
				$popup.off($.animaciones.animacionEventoFin);

				/**
				 * Focus default
				 */
				if ( accionFocus )
				{
					accionFocus.focus();
				}
				/**
				 * Devuelve promise
				 */
				return $.popup.generico.def.promise();
			},

			/**
			 * Cierra el popup generico
			 *
			 * @param			object			evento				Evento que ejecuta la accion
			 * @return			void
			 */
			cerrar				: function(evento)
			{
				if ( evento )
				{
					evento.preventDefault();
				}
				var $popup			= $('.popup-generico');

				/**
				 * Rechaza el promise
				 */
				if ( $.popup.generico.def )
				{
					$.popup.generico.def.reject();
				}
				$.popup.generico.def	= null;

				/**
				 * Elimina las clases de animacion
				 */
				$popup.removeClass(['hidden', 'animated', $.animaciones.generico.animacionFondoEntrada, $.animaciones.generico.animacionFondoSalida].join(' '))
					.find('.generico').removeClass(['animated', $.animaciones.generico.animacionEntrada, $.animaciones.generico.animacionSalida].join(' '));

				/**
				 * Anima la salida
				 */
				$popup.addClass(['animated', $.animaciones.generico.animacionFondoSalida].join(' '))
					.find('.generico').addClass(['animated', $.animaciones.generico.animacionSalida].join(' '));

				/**
				 * Oculta el popup al terminar la animación
				 */
				$popup.one($.animaciones.animacionEventoFin, function()
				{
					$popup.addClass('hidden');
				});

				/**
				 * Desactiva el hotkey
				 */
				$(document).off('keydown.popupGenerico');

				/**
				 * Desactiva botones cerrar
				 */
				$popup.off('click.popupGenerico');
			}
		}
	},

	/**
	 * Configuración de la validación de formularios
	 */
	configValidacion		: {
		showErrors		: function() { return false; },
		invalidHandler	: function(evento, validador)
		{
			return $.errorValidacion($(validador.errorList[0].element), validador.errorList[0].message);
		},
		submitHandler	: function(form) { if ( ! $(form).valid() ) { return false; } else { form.submit(); } }
	},

	/**
	 * Errores de validacion
	 */
	errorValidacionTimer	: null,
	errorValidacion			: function($item, mensaje, timeout)
	{
		/**
		 * Cierra los mensajes de validacion que esten abiertos
		 */
		clearTimeout($.errorValidacionTimer);
		$('[data-validate]')
			.popover('destroy')
			.removeAttr('data-validate');

		/**
		 * Muestra el mensaje en el elemento con error
		 */
		$item
			.popover('destroy')
			.attr('data-validate', true)
			.popover(
			{
				container		: 'body',
				placement		: 'auto',
				title			: function() { return 'Error de datos'; },
				content			: mensaje,
				trigger			: 'manual'
			})
			.popover('show');

		/**
		 * Activa el timer para cerrar automaticamente el mensaje
		 */
		$.errorValidacionTimer = setTimeout(function() { $item.popover('destroy'); }, timeout || 5000);
		return false;
	}
});

/**
 * jQuery
 */
jQuery(window).load(function()
{
	NProgress.done();
});
jQuery(document).ready(function($)
{

	$("#zoom_01").elevateZoom();

	/**
	 * Barra progreso
	 */
	$(document).ajaxStart(function()
	{
		NProgress.start();
	});
	$(document).ajaxComplete(function()
	{
		NProgress.done();
	});

	/**
	 * Menu principal
	 */
	$('.toggle-menu').jPushMenu({ closeOnClickLink: false });
	$('.dropdown-toggle').dropdown();
	$('ul.nav li.dropdown').hover(function()
	{
		if ( ! $('#menu-lateral.cbp-spmenu-open').size() )
		{
			$(this).find('.dropdown-menu').stop(true, true).show();
			$(this).addClass('open');
		}
	},
	function()
	{
		if ( ! $('#menu-lateral.cbp-spmenu-open').size() )
		{
			$(this).find('.dropdown-menu').stop(true, true).hide();
			$(this).removeClass('open');
		}
	});


	/**
	 * Agregar producto - Global para todo el sitio
	 */
	$('.js-agregar-producto').on('click', function(evento)
	{
		evento.preventDefault();
		var $this			= $(this),
			id				= $this.attr('data-id'),
			nombre			= $this.attr('data-nombre'),
			imagen			= $this.attr('data-imagen'),
			wipe			= ($this.attr('data-wipe') ? 1 : 0),
			cantidad		= parseInt($('#selectCantidad'+id).val(), 10),
			cantidad		= (isNaN(cantidad) || cantidad < 1 ? 1 : cantidad);
		/**
		 * Agrega el producto al carro
		 */
		$.when($.agregarProducto(id, cantidad, wipe)).done(function(data)
		{
			/**
			 * Abre el popup con la informacion del producto
			 */
			$.popup.producto.agregar.abrir(nombre, imagen, data);

			/**
			 * Escribe los datos del carro
			 */
			$.actualizarCarro(data.info.Carro.Cantidad, data.info.Carro.Subtotal);

			/**
			 * Limpia el bit de wipe
			 */
			$this.data('wipe', 0);

		}).fail(function(data)
		{
			var mensajes		= {};
			if ( data && data.error )
			{
				var proceso = 'compra';
				switch ( data.error )
				{
					case 'SIN_STOCK':
					{
						mensajes		= {
							tipo			: 'ERROR',
							titulo			: 'El producto que seleccionaste ya no tiene stock.',
							subtitulo		: 'Te invitamos a recorrer el catálogo y ver otras opciones.'
						};
						break;
					}
					case 'SIN_STOCK_SUFICIENTE':
					{
						var maximo		= (data.stock - data.actual);
						mensajes		= {
							tipo			: 'ERROR',
							titulo			: 'El producto que seleccionaste no tiene suficiente stock.',
							subtitulo		: (
								maximo > 0 ?
								sprintf('Solo puedes agregar un maximo de %d unidades. Por favor intenta nuevamente', maximo) :
								'Ya no puedes agregar mas unidades de este producto.'
							)
						};
						break;
					}
					case 'RESERVA_PENDIENTE':
					{
						mensajes		= {
							tipo			: 'ERROR',
							titulo			: 'Proceso pendiente',
							subtitulo		: 'Tienes un proceso de Reserva de uniformes pendiente.<br>¿Deseas continuar tu reserva o deseas comenzar un nuevo proceso de compra?',
							acciones		: [
								{
									text		: 'Ir a reserva',
									focus		: true,
									link		: $.webroot('reservas')
								},
								{
									text		: 'Nueva compra',
									cerrar		: true,
									class		: 'js-nueva-compra',
									custom		: $this
								}
							]
						};
						break;
					}
					case 'LISTA_PENDIENTE':
					{
						mensajes		= {
							tipo			: 'ERROR',
							titulo			: 'Proceso pendiente',
							subtitulo		: 'Tienes un proceso de selección de Uniformes por colegio pendiente.<br>¿Deseas continuar tu selección de uniformes o deseas comenzar un nuevo proceso de compra?',
							acciones		: [
								{
									text		: 'Ir a Textos por colegio',
									focus		: true,
									link		: $.webroot('listas')
								},
								{
									text		: 'Nueva '+proceso,
									cerrar		: true,
									class		: 'js-nueva-compra',
									custom		: $this
								}
							]
						};
						break;
					}
					case 'LISTA_CATALOGO':
					{
						mensajes		= {
							tipo			: 'ERROR',
							titulo			: 'Proceso pendiente',
							subtitulo		: 'Tienes un proceso de compra.<br>¿Deseas continuar tu compra o deseas comenzar un nuevo proceso de cotización?',
							acciones		: [
								{
									text		: 'Ir a Compra',
									focus		: true,
									link		: $.webroot('catalogo')
								},
								{
									text		: 'Nueva '+proceso,
									cerrar		: true,
									class		: 'js-nueva-compra',
									custom		: $this
								}
							]
						};
						break;
					}
				}
			}
			else
			{
				mensajes		= {
					tipo			: 'ERROR',
					titulo			: 'Se produjo un error al agregar el producto.',
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
	 * Limpiar compras anteriores
	 */
	$('.popup-generico').on('click', '.js-nueva-compra', function(evento)
	{
		evento.preventDefault();
		var $this		= $(this),
			$custom		= $this.data('custom');

		$custom.data('wipe', 1).trigger('click');
	});


	/**
	 * Validaciones backend - mensajes
	 */
	$('.error-message').each(function()
	{
		var $this		= $(this),
			$input		= $this.prev(),
			mensaje		= $this.text();

		$.errorValidacion($input, mensaje);
		$this.remove();
	});


	/**
	 * Validacion buscador de productos
	 */
	var validate		= {};
	$('#ProductoBuscarForm').validate($.extend({}, validate, $.configValidacion,
	{
		rules			: {
			'data[Producto][criterio]': {
				required		: true
			}
		},
		messages		: {
			'data[Producto][criterio]': {
				required		: 'Ingresa tu criterio de búsqueda'
			}
		}
	}));

});

//]]>
