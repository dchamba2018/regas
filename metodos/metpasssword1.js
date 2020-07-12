function TiempoActividad(){
    setTimeout("DestruirSesion()", 60000);
}
function DestruirSesion(){
    location.href = "login.php";
}
function actualizarSeguridad(){
  var pass1= $('#txtclave').val();
  var pass2= $('#txtrepclave').val();
  var seguridad=seguridad_clave(pass1);
  if(pass1==""){
    mensaje("Ingrese su nueva contraseña..", "error");
  }else if(pass2==""){
    mensaje("Repita su nueva contraseña..", "error");
  }else if(pass2!=pass1){
    mensaje("Sus contraseñas no coinciden..", "error");
  }else if(pass1.length<8){
    mensaje("Su clave debe contener al menos 8 carácteres","error");
  }else if(pass1.length>16){
    mensaje("Su clave debe contener como máximo 16 carácteres","error");
  }else if(seguridad<70){
    mensaje("El nivel de seguridad es muy bajo! use números, minúsculas y mayúsculas","error");  
  }else{
    bloquear();
    $.get("consultas/actualizarseguridad.php", {pass1:pass1}, function(datos){ 
      if(datos==0){
        mensaje("ACTUALIZADO CON EXITO\nVuelva a Iniciar Sesión", "success");
        DestruirSesion();
      }else  if(datos==2){
        mensaje("Estimado docente usted ya tiene una cuenta activa!", "error");
        setTimeout($.unblockUI,1000); 
      }else{
        alert(datos);
        mensaje("No se pudo cambiar su clave", "error");
        setTimeout($.unblockUI,1000); 
      }
    });
  }
}
function seguridad_clave(clave){
    var nclave= $('#txtpass1').val();
    var repclave= $('#txtpass2').val();
    if(nclave=="" || repclave==""){
        return 0;     
    }else{
       var seguridad = 0;
       if (clave.length!=0){
          if (tiene_numeros(clave) && tiene_letras(clave)){
             seguridad += 25;
          }
          if (tiene_minusculas(clave) && tiene_mayusculas(clave)){
             seguridad += 25;
          }
          if (clave.length >= 4 && clave.length <= 5){
             seguridad += 5;
          }else{
             if (clave.length >= 6 && clave.length <= 8){
                seguridad += 25;
             }else{
                if (clave.length > 8){
                   seguridad += 35;
                }
             }
          }
       }
       return seguridad;
   }
   
}
function tiene_numeros(texto){
    var numeros="0123456789";
   for(i=0; i<texto.length; i++){
      if (numeros.indexOf(texto.charAt(i),0)!=-1){
         return 1;
      }
   }
   return 0;     
}

function tiene_mayusculas(texto){
    var letras_mayusculas="ABCDEFGHYJKLMNÑOPQRSTUVWXYZ";
   for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i),0)!=-1){
         return 1;
      }
   }
   return 0;
}

function tiene_minusculas(texto){
    var letras="abcdefghyjklmnñopqrstuvwxyz";
   for(i=0; i<texto.length; i++){
      if (letras.indexOf(texto.charAt(i),0)!=-1){
         return 1;
      }
   }
   return 0;
}
    
function tiene_letras(texto){
    var letras="abcdefghyjklmnñopqrstuvwxyz";
   texto = texto.toLowerCase();
   for(i=0; i<texto.length; i++){
      if (letras.indexOf(texto.charAt(i),0)!=-1){
         return 1;
      }
   }
   return 0;
}
function mensaje(mensaje, tipo){
  swal({title: "ASIS-DOCENTE!",
      text: mensaje,
      icon: tipo,
    });
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