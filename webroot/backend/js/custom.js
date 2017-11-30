/* jshint bitwise:true, browser:true, eqeqeq:true, forin:true, globalstrict:true, indent:4, jquery:true,
   loopfunc:true, maxerr:3, noarg:true, node:true, noempty:true, onevar: true, quotmark:single,
   strict:true, undef:true, white:false */
/* global FB, webroot, fullwebroot */

/*!
 * Hookipa | Backend
 */

//<![CDATA[
'use strict';

/**
 * jQuery
 */
jQuery(document).ready(function($)
{
	$('.js-query-ver-query').on('click', function(evento)
	{
		evento.preventDefault();
		var $this			= $(this),
			$tr				= $this.parents('tr').first(),
			$extracto		= $tr.find('.extracto'),
			$query			= $tr.find('.query');

		$extracto.hide();
		$query.show();
	});

	/* LOCK SCREEN */
    $('.lockscreen-box .lsb-access').on('click',function()
	{
		$(this).parent('.lockscreen-box').addClass('active').find('input').focus();
		return false;
	});

    $('.lockscreen-box .user_signin').on('click',function()
	{
		$('.sign-in').show();
		$(this).remove();
		$('.user').hide().find('img').attr('src', webroot + 'backend/assets/images/users/no-image.jpg');
		$('.user').show();
		return false;
	});
    /* END LOCK SCREEN */

	/**
	 * Ordenamiento de tablas generico
	 */
	if ( $('.js-generico-contenedor-sort').length )
	{
		$('.js-generico-contenedor-sort').sortable(
		{
			axis			: 'y',
			cursor			: 'move',
			helper			: function(e, tr)
			{
				var $originals	= tr.children(),
					$helper		= tr.clone();

				$helper.children().each(function(index)
				{
					$(this).width($originals.eq(index).width());
				});
				return $helper;
			},
			stop			: function(e, ui)
			{
				$('td.js-generico-orden', ui.item.parent()).each(function(i)
				{
					var $this		= $(this);
					$this.find('input').val(i + 1);
					$this.find('span').text(i + 1);
				});

				var $form		= ui.item.parents('form').first();
				$.post($form.attr('action'), $form.serialize());
			}
		}).disableSelection();
	}


	$('.js-generico-handle-sort').on('click', function(evento)
	{
		evento.preventDefault();
	});



	/**
	 * Editor de ayudas
	 */
	if ( $('.js-summernote').length )
	{
		$('.js-summernote').summernote(
		{
			height		: 300,
			focus		: true,
			toolbar		: [
				['style', ['bold', 'italic', 'underline', 'clear']],
				['insert', ['link', 'picture']]
			]
		});
	}
	if ( $('.js-summernote2').length )
	{
		$('.js-summernote2').summernote(
		{
			height		: 300,
			focus		: true,
			toolbar		: [
				['style', ['bold', 'italic', 'underline', 'clear']],
				['insert', ['link', 'picture']]
			]
		});
	}

	/**
	 * Funcion que permite obtener en formato YYYY-MM-DD una fecha determinada
	 * @param			{Object}			fecha			Fecha que se desea obtener
	 * @returns			{Object}			fecha			Fecha en formato YYYY-MM-DD
	 */
	function obtenerFecha(fecha)
	{
		return fecha.getFullYear() + '-' + (fecha.getMonth() + 1) + '-' + fecha.getDate();
	}

	/**
	 * Idioma español datepicker
	 */
	!function(a)
	{
		a.fn.datepicker.dates.es = {
			days			: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			daysShort		: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
			daysMin			: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
			months			: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthsShort		: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
			today			: 'Hoy',
			clear			: 'Borrar',
			weekStart		: 1,
			format			: 'dd/mm/yyyy'
		}
	}(jQuery);

	/**
	 * Buscador de OC - Datepicker rango fechas
	 */
	var $buscador_fecha_inicio		= $('#CompraFechaInicio'),
		$buscador_fecha_fin			= $('#CompraFechaFin');

	if ( $buscador_fecha_inicio.length )
	{
		$buscador_fecha_inicio.datepicker(
		{
			language	: 'es',
			format		: 'yyyy-mm-dd'
		}).on('changeDate', function(data)
		{
			$buscador_fecha_fin.datepicker('setStartDate', data.date);
		});

		$buscador_fecha_fin.datepicker(
		{
			language	: 'es',
			format		: 'yyyy-mm-dd'
		}).on('changeDate', function(data)
		{
			$buscador_fecha_inicio.datepicker('setEndDate', data.date);
		});
	}

	/**
	 * Buscador de OC - Rango de fecha predeterminada
	 */
	$('.js-data-search').on('click', function(evento)
	{
		evento.preventDefault();

		var $this			= $(this),
			tipo			= $this.data('tipo'),
			rango			= $this.data('rango'),
			fecha_inicio	= new Date();

		/**
		 * Limpia las fechas
		 */
		if ( tipo == 'todo' )
		{
			$buscador_fecha_inicio.datepicker('update', '');
			$buscador_fecha_fin.datepicker('update', '');
		}
		else
		{
			var method = {
				dia		: ['setDate', 'getDate'],
				mes		: ['setMonth', 'getMonth'],
				ano		: ['setYear', 'getFullYear']
			};

			/**
			* Calcula la fecha
			*/
			fecha_inicio[method[tipo][0]](fecha_inicio[method[tipo][1]]() - rango);
			$buscador_fecha_inicio.datepicker('setDate', obtenerFecha(fecha_inicio));
			$buscador_fecha_fin.datepicker('setDate', obtenerFecha(new Date));
		}
	});

	/**
	 * Buscador de OC - Rango OC
	 */
	var $slider_oc		= $('#CompraRangoOc');
	if ( $slider_oc.length )
	{
		var minOC		= $slider_oc.data('min-oc'),
			maxOC		= $slider_oc.data('max-oc');

		$slider_oc.ionRangeSlider(
		{
			type				: 'double',
			grid				: true,
			min					: minOC,
			max					: maxOC,
			//from				: minOC,
			//to				: maxOC,
			prettify_separator	: '.',
			force_edges: false,
			prefix				: 'OT ',
			onChange			: function(data)
			{
				$(data.input).attr('disabled', false);
			}
		});

		if ( typeof(filtros) === 'object' && typeof(filtros.filtro) === 'object' && typeof(filtros.filtro.oc_min) !== 'undefined' )
		{
			$slider_oc.data('ionRangeSlider').update(
			{
				from		: parseInt(filtros.filtro.oc_min, 10),
				to			: parseInt(filtros.filtro.oc_max, 10)
			});
			$slider_oc.attr('disabled', false);
		}
	}

	/**
	 * Buscador de OC - Rango Monto
	 */
	var $slider_monto		= $('#CompraRangoMonto');
	if ( $slider_monto.length )
	{
		var minMonto		= $slider_monto.data('min-monto'),
			maxMonto		= $slider_monto.data('max-monto');

		$slider_monto.ionRangeSlider(
		{
			type				: 'double',
			grid				: true,
			min					: minMonto,
			max					: maxMonto,
			//from				: minMonto,
			//to					: maxMonto,
			prettify_separator	: '.',
			prefix				: '$',
			onChange			: function(data)
			{
				$(data.input).attr('disabled', false);
			}
		});

		if ( typeof(filtros) === 'object' && typeof(filtros.filtro) === 'object' && typeof(filtros.filtro.monto_min) !== 'undefined' )
		{
			$slider_monto.data('ionRangeSlider').update(
			{
				from		: parseInt(filtros.filtro.monto_min, 10),
				to			: parseInt(filtros.filtro.monto_max, 10)
			});
			$slider_monto.attr('disabled', false);
		}
	}

	/**
	 * Select estados
	 */
	if ( $('.selectpicker').length )
	{
		$('.selectpicker').selectpicker();
	}


	/**
	 * Limpia filtros
	 */
	$('.js-limpiar-busqueda').on('click', function(evento)
	{
		evento.preventDefault();
		var $this			= $(this),
			tipo			= $this.data('tipo'),
			$input			= $('[data-tipo="' + tipo + '"]').not(this);

		if ( tipo === 'libre' )
		{
			$input.val('');
		}
		if ( tipo === 'fecha' )
		{
			$input.datepicker('update', '').datepicker('clearDates');
		}
		if ( tipo === 'estado' )
		{
			$input.selectpicker('deselectAll');
		}
		if ( tipo === 'oc' || tipo === 'monto' )
		{
			$input.data('ionRangeSlider').reset();
			$input.prop('disabled', true);
		}
	});


	/**
	 * Input autocomplete y codigo usuario
	 */
	var $autocomplete		= $('[name="data[GrupoTarifario][usuario]"]');

	if ( $autocomplete.length )
	{
		/**
		* Limpieza inicial
		*/
		$autocomplete.val('');
	   /**
		* Autocomplete del nombre del usuario
		* Muestra
		* 			nombre
		* 			apellido materno
		* 			apellido paterno
		* 			email
		* 			telefono
		*/
		$autocomplete.typeahead(
		{
			/**
			 * Se obtiene el listado de los usuarios, filtrados el parametro enviado al controlador
			 */
			source					: function(query, process)
			{
				$.ajax(
				{
					type			: 'POST',
					url				: webroot + 'admin/grupo_tarifarios/ajax_usuariosTarifarios',
					dataType		: 'json',
					data			: { query: query },
					success			: process
				});
			},
			minLength				: 1,
			delay					: 200,
			autoSelect				: false,
			showHintOnFocus			: true,
			displayText				: function(item)
			{
				return item.Usuario.nombre_completo;
			}
		});

		/**
		 * Actualiza el codigo del usuario o elimina el usuario
		 * si no corresponde a una opcion del autoselector
		 */
		$autocomplete.on('change blur', function()
		{
			var $this			= $(this),
				current			= $this.typeahead('getActive');

			if ( typeof(current) !== 'undefined' )
			{
				if ( current.Usuario.nombre_completo === $this.val() )
				{
					// Se verifica que el id del usuario que se ingresa, no exita o este ingresado
					if ( ! $('.tabla-usuarios tbody tr[data-usuario_id="' + current.Usuario.id + '"]').length )
					{
						/**
						 * Se arma el arreglo que contiene los datos que se ingresan a la tabla
						 * de usuarios seleccionados
						 */
						var datos		= [
							current.TipoUsuario.nombre,
							current.Usuario.nombre,
							current.Usuario.email,
							current.Usuario.celular,
						];
						var html		= $.map(datos, function(texto)
						{
							return $('<td />', { text: texto });
						});

						/**
						 * Agregamos al primer td, un input type: hidde, el cual
						 * contendra el id del usuario que se selecciona
						 */
						html[0].append($('<input />',
						{
							type	: 'hidden',
							name	: 'data[Usuario][][usuario_id]',
							value	: current.Usuario.id
						}));

						/**
						 * Se agrega como ultimo td, el boton de accion, que permite eliminar el usuarios
						 * selecionado
						 */
						html.push('<td><a href="#" class="btn btn-danger js-elimina-usuario"><span class="fa fa-times"></span></td>');

						/**
						 * Se ingresan los datos del usuario en la tabla de usuarios seleccionados
						 */
						$('.tabla-usuarios tbody').append(
							$('<tr />', { 'data-usuario_id' :  current.Usuario.id }).append(html)
						);
					}
				}
				$this.val('').focus();
			}
		});

		/**
		 * Escucha que permite eliminar un item (usuario seleccionado) de la tabla de usuarios
		 */
		$('.tabla-usuarios tbody').on('click', '.js-elimina-usuario', function(evento)
		{
			evento.preventDefault();
			$(this).parents('tr').first().remove();
		});
	}
	
   if ( typeof(valores_oc) !== 'undefined' )
   {
        Morris.Line({
         element: 'dashboard-line-2',
         data: valores_oc,
         xkey: 'y',
         ykeys: ['total_compra'],
         labels: ['Ventas'],
         resize: false,
         lineColors: ['#848484','#FF8000', 'blue'],
		 parseTime: true,
		 preUnits: '$'
       });
   }

	if ( typeof(cantidad_estados) !== 'undefined' )
    {
        Morris.Line({
        element: 'dashboard-line-1',
        data: cantidad_estados,
        xkey: 'y',
        ykeys: ['1', '2', '3', '4', '5'],
        labels: $.map(estados.estados, function(el) { return el }),
        resize: true,
        hideHover: false,
        gridTextSize: '10px',
        lineColors: ['#FF8000', '#B64645', '#8A0808', '#95B75D', '#848484'],
        gridLineColor: '#E5E5E5',
		 parseTime: true
        });
    }


	/**
	 * Description
	 * @type {Object}
	 */
	$('.js-check-ventas-perfil').click(function(){
		checkboxPerfil('ventas');
	});

	$('.js-check-paginas-perfil').click(function(){
		checkboxPerfil('paginas');
	});

	$('.js-check-modulos-perfil').click(function(){
		checkboxPerfil('modulos');
	});

	/**
	 * Check utilizados en los filtros del index ce convenio marco,
	 */
	if ( $('.filtos-convenio-js').length )
	{
		$('.check-pendiente-js').click(function(){
			$(".check-finalizada-js").removeAttr("checked");
		});

		$('.check-finalizada-js').click(function(){
			$(".check-pendiente-js").removeAttr("checked");
		});

		/**
		* Buscador de OC - Datepicker rango fechas
		*/
	   var $buscador_fecha_inicio		= $('#ConvenioFechaInicio'),
		   $buscador_fecha_fin			= $('#ConvenioFechaFin');

	   if ( $buscador_fecha_inicio.length )
	   {
		   $buscador_fecha_inicio.datepicker(
		   {
			   language	: 'es',
			   format		: 'yyyy-mm-dd'
		   }).on('changeDate', function(data)
		   {
			   $buscador_fecha_fin.datepicker('setStartDate', data.date);
		   });

		   $buscador_fecha_fin.datepicker(
		   {
			   language	: 'es',
			   format		: 'yyyy-mm-dd'
		   }).on('changeDate', function(data)
		   {
			   $buscador_fecha_inicio.datepicker('setEndDate', data.date);
		   });
	   }
	}

	if ( $('.filtro-contacto').length )
	{
		/**
		* Seleccion Region - Comuna
		*/
	   $('#ContactoComunaId').remoteChained(
	   {
		   parents			: '#ContactoRegionId',
		   url				: webroot  + 'comunas/ajax_region',
		   type				: 'POST',
		   loading			: '-- Cargando comunas',
		   bootstrap		: {
			   ''				: '-- Selecciona una comuna'
		   }
	   });
	   $('#ContactoRegionId').trigger('change');
	}


});

	/**
	   * Funcion que permite chequear o no los difertenes modulo asignados a un modulo padre
	   * @type {modulo}
	   */
   function checkboxPerfil( modulo )
   {
       if($(".js-check-"+modulo+"-perfil").is(":checked"))
		{
			$(".ck-"+modulo+"-perfil").prop("checked", "checked");
			$(".check-"+modulo).show('slow');
		}
		else
		{
			$(".ck-"+modulo+"-perfil").removeAttr("checked");
			$(".check-"+modulo).hide('slow');
		}
   }

   function MarcarcategoriasTodas(){
		if ($("#marcar-categorias-todas").is(':checked')) {
			$(".accordion-categorias").find("input[type=checkbox]").prop('checked', true);
		}
		else {
			$(".accordion-categorias").find("input[type=checkbox]").prop('checked', false);
		}
	}

	function MarcarcategoriasPorCategoriaPadre(id) {
		if ($("#marcar-categorias-" + id).is(':checked')){
			$("#categorias-hijas-" + id).find("input[type=checkbox]").prop('checked', true);
		}
		else {
			$("#categorias-hijas-" + id).find("input[type=checkbox]").prop('checked', false);
		}
	}

//]]>
