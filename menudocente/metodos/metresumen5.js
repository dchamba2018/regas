function cargarReporte(iddocente){
  var mes= $('#txtmes').val();
  bloquear();
  $.get("consultas/llenarTablaReporte.php", {iddocente:iddocente, mes:mes}, function(datos){ 		   	
    $("#tablareporte").html(datos);  
    setTimeout($.unblockUI,2000);
  });
}
function justificarAtrazo(idAtrazo, tipo){
	$('#ModalAtrazo').modal('show');
    document.getElementById("titulomodal").innerHTML="JUSTIFICAR "+tipo+"?";
	document.getElementById("txtidreg").value = idAtrazo;
    document.getElementById("txttipo").value = tipo;
}
function mensaje(mensaje, tipo){
  swal({title: "ASIS-DOCENTE!",
      text: mensaje,
      icon: tipo,
    });
}
function procesarAtrazo(){
	var id= $('#txtidreg').val();
	var motivo= $('#txtmotivo').val();
    var detalle= $('#txtdetalle').val();
    var archivo= $('#txtarchivo').val();
    var tipo=$('#txttipo').val();
    if(motivo=="" || motivo==null){
    	mensaje("Escriba el motivo", "error");
    }else{
    	$('#ModalAtrazo').modal('hide');
        bloquear();
        var parametros = new FormData($("#formulario-envia")[0]);
        $.ajax({
            data: parametros,
            url:"consultas/solicitarAtrazo.php",
            type: "POST",
            contentType: false,
            processData: false,
            beforesend: function(){
            },
            success: function(response){
                response=response.trim();
                if(response==0){
                    mensaje("Solicitud procesada correctamente", "success");
                    location.reload();                
                }else if(response==1){
                    mensaje("No se ha seleccionado un archivo","error");
                    setTimeout($.unblockUI,1000);
                    $('#ModalAtrazo').modal('show'); 
                }else if(response==2){
                    mensaje("Tamaño de archivo no permitido","error");
                    setTimeout($.unblockUI,1000);
                    $('#ModalAtrazo').modal('show'); 
                }else if(response==3){
                    mensaje("Archivo no permitido","error");
                    setTimeout($.unblockUI,1000);
                    $('#ModalAtrazo').modal('show'); 
                }else{
                    mensaje("No se ha generado la justificación","error");
                    setTimeout($.unblockUI,1000);
                    $('#ModalAtrazo').modal('show'); 
                }                
            }
        });
    }
}