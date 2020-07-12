function cargarReporte(iddocente){
  var mes= $('#txtmes').val();
  bloquear();
  $.get("consultas/llenarTablaReporte.php", {iddocente:iddocente, mes:mes}, function(datos){ 		   	
    $("#tablareporte").html(datos);  
    setTimeout($.unblockUI,2000);
  });
}
