
function hacer_click(){
  $('#horarioModal').modal('hide');
  $('#horarioDocentes').modal('hide');
  bloquear();
}
function abrirmodal(id){
  document.getElementById("txtidhorario").value = id;
  bloquear();
  $.get("consultas/llenarTablaDocentes.php", {id:id}, function(datos){ 
    $("#todosdocentes").html(datos);   
    $.get("consultas/llenarTablaDocentesHorario.php", {id:id}, function(datos){ 
      $("#docentesasignados").html(datos);   
      setTimeout($.unblockUI,2000);
      $('#horarioDocentes').modal('show');
    });
  });
}
function quitarDocente(iddocente, idhorarioDocente){
  $('#horarioDocentes').modal('hide');
  bloquear();
  $.get("consultas/quitarDocente.php", {iddocente:iddocente, idhorarioDocente:idhorarioDocente}, function(datos){ 
    var idhorario= $('#txtidhorario').val();
    abrirmodal(idhorario);
    setTimeout($.unblockUI,2000);  
  });
}
function agregarDocente(iddocente, idhorarioDocente){
  $('#horarioDocentes').modal('hide');
  bloquear();
  $.get("consultas/agregarDocente.php", {iddocente:iddocente, idhorarioDocente:idhorarioDocente}, function(datos){ 
    var idhorario= $('#txtidhorario').val();
    abrirmodal(idhorario);
    setTimeout($.unblockUI,2000);  
  });
}