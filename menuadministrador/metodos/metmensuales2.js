function cargarReporte(iddocente){
  var mes= $('#txtmes').val();
  bloquear();
  $.get("consultas/llenarEncabezado.php", {iddocente:iddocente, mes:mes}, function(head){ 
    	$.get("consultas/llenarTablaReporte.php", {iddocente:iddocente, mes:mes}, function(datos){ 
		    $("#tablaencabezado").html(head);   
		    $("#tablareporte").html(datos);  
		    setTimeout($.unblockUI,2000);
	  	});
  });
}
