function bloquear(){
  $.blockUI({
      css:{
          border:'none',
          padding:'15px',
          backgroundColor:'#000',
          '-webkit-border-radius':'10px',
          '-moz-border-radius':'10px',
          opacity:.5,
          color:'#fff'
      }
  });  
}
function mostrarMensaje(){
  $("#cardtexto").html("<h6>Cedula Incorrecta!</h6>");   
  document.getElementById('alerta').style.display ='';
}
function TiempoActividad(){
    setTimeout("DestruirSesion()", 600000);
}
function DestruirSesion(){
    location.href = "index.php";
}
function guardarDocente(){
  var nombres= $('#txtnombres').val();
  var apellidos= $('#txtapellidos').val();
  var email= $('#txtemail').val();
  var telefono= $('#txttelefono').val();
  var cedula= $('#txtcedula').val();
  if(nombres=="" || nombres==" " || nombres==null){
    mensaje("Escriba sus nombres", "error");
  }else if(apellidos=="" || apellidos==" " || apellidos==null){
    mensaje("Escriba sus apellidos", "error");
  }else if(email=="" || email==" " || email==null){
    mensaje("Escriba su email", "error");
  }else if(validarEmail(email)==false){
    mensaje("Dirección de email incorrecto", "error");
  }else{
    bloquear();
    $.get("consultas/guardardocente.php", {nombres:nombres, apellidos:apellidos, email:email, telefono:telefono, cedula:cedula}, function(datos){  
        datos=datos.trim();
        if(datos==0){
          setTimeout($.unblockUI,1000);  
          setTimeout(mensaje("Se ha registrado con exito Verifique su información en su correo!", "success"),3000);
          window.location="index.php?cedula="+cedula;
        }else if(datos==2){
          setTimeout($.unblockUI,1000);  
          mensaje("La dirección de correo ya esta registrada!","error");
        }else{
          setTimeout($.unblockUI,1000);  
          console.log(datos);
          mensaje("Se ha producido un error!","error");
        }        
    });    
  }
}
function mensaje(mensaje, tipo){
  swal({title: "ASIS-DOCENTE!",
      text: mensaje,
      icon: tipo,
    });
}
function validarEmail(valor) {
  if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(valor)){
   return true;
  } else {
   return false;
  }
}