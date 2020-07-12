function cargarReporte(idhorario){
  var mes= $('#txtmes').val();
  bloquear();
  $.get("consultas/llenarEncabezadoGrupal.php", {idhorario:idhorario, mes:mes}, function(head){ 
    	$.get("consultas/llenarTablaReporteGrupal.php", {idhorario:idhorario, mes:mes}, function(datos){ 
        $("#tablaencabezado").html(head);   
		    $("#tablareporte").html(datos);  
		    setTimeout($.unblockUI,2000);
	  	});
  });
}
