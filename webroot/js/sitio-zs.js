fullwebroot = '/zsmotor2';
$(document).ready(function(){
	$('.js-buscar-productos').click(function(){
		var categoria = $('#ProductoCategoria').val();
		var url,ancho,apernadura,perfil,aro;
		var texto_busqueda = $('#ProductoFiltro').val();

		if(typeof texto_busqueda != 'undefined' && texto_busqueda != null && texto_busqueda != '' ){
			$('#ProductoFiltroForm').submit();
		}else{
			switch(categoria) {
			    case 'neumaticos':

			    	url 	= '/neumaticos';

			    	ancho 	= $('#ProductoAncho').val();
			    	perfil 	= $('#ProductoPerfil').val();
			    	aro 	= $('#ProductoAro').val();

			    	if(typeof ancho != 'undefined' && ancho != null && ancho != '' ){
			    		url += '/' + ancho;
			    		if(typeof perfil != 'undefined' && perfil != null && perfil != '' ){
			    			url += '/' + perfil;
			    			if(typeof aro != 'undefined' && aro != null && aro != '' ){
			    				url += '/' + aro;
			    			}
			    		}
			    	}
			        break;
			    case 'llantas':
			        url 		= '/llantas';

			    	aro 		= $('#ProductoAro').val();
			        apernadura 	= $('#ProductoApernadura').val();

			        if(typeof aro != 'undefined' && aro != null && aro != '' ){
			        	url += '/' + aro;
			        	if(typeof apernadura != 'undefined' && apernadura != null && apernadura != '' ){
			        		url += '/' + apernadura;
			        	}
			        }

			        break;
			    case 'accesorios':
			        alert('accesorios')
			        break;
			    default:
			        alert('sin categoria')
			}
			window.location = fullwebroot + url;
		}
		return false;
	})

	$('#buscador-marca').change(function(){
		var t = $(this).val();
		$.post(webroot + "vehiculos/modelos_marca/" + t, function(t) {
			$('#buscador-modelo').html(t);
	    })

	});

	$('#buscador-modelo').change(function(){
		var t = $(this).val();
		var n = $('#buscador-marca').val();
		$.post(webroot + "vehiculos/versiones_marca_modelo/" + n + '/' + t, function(t) {
			$('#buscador-version').html(t);
	    })

	});

	$('#buscador-version').change(function(){
		var t = $(this).val();
		var n = $('#buscador-marca').val();
		var m = $('#buscador-modelo').val();
		$.post(webroot + "vehiculos/anos_marca_modelo_version/" + n + '/' + m + '/' + t, function(t) {
			$('#buscador-ano').html(t);
	    })
	});

	$('#buscador-ano').change(function(){
		var t = $(this).val();
		var n = $('#buscador-marca').val();
		var m = $('#buscador-modelo').val();
		var o = $('#buscador-version').val();
		var c = $('#buscador-categoria').val();

		$.post(webroot + "vehiculos/anchos_marca_modelo_version_ano/" + c + '/' + n + '/' + m + '/' + o + '/' + t, function(t) {
			$('#buscador-ancho').html(t);
	    })
	});

	$('#buscador-ancho').change(function(){
		var t = $(this).val();
		var n = $('#buscador-marca').val();
		var m = $('#buscador-modelo').val();
		var o = $('#buscador-version').val();
		var p = $('#buscador-ano').val();

		$.post(webroot + "vehiculos/perfiles_marca_modelo_version_ano_ancho/" + n + '/' + m + '/' + o + '/' + p + '/' + t, function(t) {
			$('#buscador-perfil').html(t);
	    })
	});

	$('#buscador-perfil').change(function(){
		var t = $(this).val();
		var n = $('#buscador-marca').val();
		var m = $('#buscador-modelo').val();
		var o = $('#buscador-version').val();
		var p = $('#buscador-ano').val();
		var q = $('#buscador-ancho').val();

		$.post(webroot + "vehiculos/perfiles_marca_modelo_version_ano_ancho/" + n + '/' + m + '/' + o + '/' + p + '/' + q + '/' + t, function(t) {
			$('#buscador-aro').html(t);
	    })
	});
})	