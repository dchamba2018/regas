function registrarEntrada(observacion){
  var hora=devuelveHora();
  var iddocente= $('#txtiddocente').val();
  var latitud= $('#txtlatitud').val();
  var longitud= $('#txtlongitud').val();
  var presicion= $('#txtprecision').val();
  var foto= $('#txtfoto').val();
  if(observacion=='SALIDA' && hora<2230){
    res=confirm("ESTA INTENTANDO REGISTRAR SU SALIDA ANTES DEL HORARIO?");
    if(res){
      $.get("consultas/registrarAsistencia.php", {foto:foto, observacion:observacion, iddocente:iddocente, latitud:latitud,longitud:longitud, presicion:presicion}, function(datos){  
        datos=datos.trim();
        if(datos==0){
          document.getElementById('btnentrada').style.display ='none';
          document.getElementById('btnsalida').style.display ='none';
          mensaje("Registro Exitoso");
          TiempoActividadrapida();
        }else if(datos==1){
          mensaje("Estimado Usuario, hoy no es dia laborable!");          
          TiempoActividadrapida();
        }else{
          mensaje("A ocurrido un error!");          
          TiempoActividadrapida();
        }
        setTimeout($.unblockUI,2000);  
        });
    }else{
      location.href = "index.php";
    }
  }else{
    if(latitud==""){
      mensaje("Para usar el sistema debe habilitar su ubicación!", "error");
    }else{
      $.get("consultas/registrarAsistencia.php", {foto:foto, observacion:observacion, iddocente:iddocente, latitud:latitud,longitud:longitud, presicion:presicion}, function(datos){  
          datos=datos.trim();
          if(datos==0){
            document.getElementById('btnentrada').style.display ='none';
            document.getElementById('btnsalida').style.display ='none';
            mensaje("Registro Exitoso");
            TiempoActividadrapida();
          }else if(datos==1){
            mensaje("Estimado Usuario, hoy no es dia laborable!");          
            TiempoActividadrapida();
          }else{
            mensaje("A ocurrido un error!");          
            TiempoActividadrapida();
          }
          setTimeout($.unblockUI,2000);  
      });
    } 
  }
}
function validarCedula(){
  var cedula= $('#txtcedula').val();
  var latitud= $('#txtlatitud').val();
  if(latitud==""){
    mensaje("Para usar el sistema debe habilitar su ubicación!", "error");

  }else if(cedula==""){
    mensaje("Ingrese su cedula!", "error");
  }else if(cedula.length>10){
    document.getElementById('txtcedula').focus();
    mensaje("Cedula incorrecta","error");
  }else{
      bloquear();
      $.get("consultas/verificarusuario.php", {cedula:cedula}, function(datos){  
        datos=datos.trim();
        res = datos.split("|");  
        if(res[0]==0){
            iniciar();
            document.getElementById('btnvalidar').style.display ='none';
            document.getElementById('btnentrada').style.display ='';
            document.getElementById('txtcedula').style.display ='none';
            document.getElementById('txtdocente').style.display ='';
            document.getElementById("txtdocente").value = "USUARIO: "+res[1];
            document.getElementById("txtiddocente").value = res[2];
            TiempoActividad();
        }else if(res[0]==2){
            iniciar();
            document.getElementById('btnvalidar').style.display ='none';
            document.getElementById('btnsalida').style.display ='';
            document.getElementById('txtcedula').style.display ='none';
            document.getElementById('txtdocente').style.display ='';
            document.getElementById("txtdocente").value = "USUARIO: "+res[1];
            document.getElementById("txtiddocente").value = res[2];
            TiempoActividad();
        }else if(res[0]==1){
          mensaje("Docente No registrado","error");
          window.location="register.php?cedula="+cedula;
        }else if(res[0]==4){
          mensaje("Número de cedula incorrecto","error");
        }else{
          mensaje("Usted ya ha cumplido su registro diario","success");
        }
    });
    setTimeout($.unblockUI,2000);  
  }
}
function inicio(){
  verificarHorario();
  localize();
  startTime();
} 
function verificarposicion(){
  var latitud= $('#txtlatitud').val();
  var longitud= $('#txtlongitud').val();
  if(latitud==""){
    mensaje("Para usar el sistema debe habilitar su ubicación!", "error");
  }else{
    $.get("clases/distancias.php", {latitud:latitud, longitud:longitud}, function(datos){  
        datos=datos.trim();
        if(datos==0){
          mensaje("Ubicación no permitida!");  
          window.location="blank/"; 
        }
    });
  } 
}
function startTime() {
    var today = new Date();
    var hr = today.getHours();
    var min = today.getMinutes();
    var sec = today.getSeconds();
    //Add a zero in front of numbers<10
    min = checkTime(min);
    sec = checkTime(sec);
    document.getElementById("clock").innerHTML = hr + " : " + min + " : " + sec;
    var time = setTimeout(function(){ startTime() }, 500);    
}
function verificarHorario(){
  var hora=devuelveHora();
  if(hora>=1330 && hora<=2359){

  }else{
    mensaje("Horario no habilitado para su registro, solo puede usar desde las 13:30 hasta las 23:59","success");
    window.location="blank/";
  }
}
function devuelveHora() {
    var today = new Date();
    var hr = today.getHours();
    var min = today.getMinutes();
    min = checkTime(min);
    return hr+""+min;
}
function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
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
    setTimeout("DestruirSesion()", 30000);
}
function TiempoActividadrapida(){
    setTimeout("DestruirSesion()", 10000);
}
function DestruirSesion(){
    location.href = "index.php";
}