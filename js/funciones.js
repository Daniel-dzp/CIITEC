var ventDialogo = 0;

function frame(url, nombre, ancho, color)
{
	if(typeof ancho=='undefined') ancho='medium';
	dialogo=$.dialog({
		title: nombre,
		content: 'url:'+url,
		type: (typeof color=="undefined") ? 'dark':color,
		columnClass: ancho,
		onContentReady:function(){},
		onClose:function(){}
	});

	ventDialogo = dialogo;
}

function frameEditar(url, nombre, id, ancho, color, no_pagina)
{
	if(typeof ancho=='undefined') ancho='medium';
	dialogo=$.dialog({
		title: nombre,
		content: 'url:'+url+"?id="+id+'&pagina='+no_pagina,
		type: (typeof color=="undefined") ? 'dark':color,
		columnClass: ancho,
		onContentReady:function(){},
		onClose:function(){}
	});

	ventDialogo = dialogo;
}

function accion2(formulario)
{
	datosFormulario = $('#'+formulario).serialize();
	
	$.ajax({
		url: "accionesBD.php",
		type: "post",
		data: datosFormulario,
		before: function () {
			$("#"+formulario).html("Procesando, espere por favor...");
		},
		success: function(result){
			$("#idTabla").html(result);
			dialogo.close();
		    $.dialog({
			    title: 'Mensaje',
			    content: 'Operacion hecha correctamente'
			});
		}
	});
}