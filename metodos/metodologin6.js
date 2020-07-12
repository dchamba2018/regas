function TiempoActividad(){
    setTimeout("DestruirSesion()", 60000);
}
function DestruirSesion(){
    location.href = "index.php";
}
function ingresar(){
    var email= $('#txtemail').val();
    var clave= $('#txtclave').val();
    if(email=="" || email==" " || email==null){
        mensaje("Escriba su email", "error");
    }else if(clave=="" || clave==" " || clave==null){
    	mensaje("Escriba su clave", "error");
  	}else{
	    bloquear();
	    $.get("consultas/verificarusuariosistema.php", {email:email, clave:clave}, function(data){  
           let user = JSON.parse(data);
           datos=user.codigo;
          if(datos==0){
	          mensaje('Los datos ingresados no corresponden a ningun docente', 'error');
	          setTimeout($.unblockUI,1000);
          }else if(datos==1){
            clave=base64EncodeUnicode(clave);
            mensaje('Estimado docente a continuación proceda a registrar su clave personal!', 'error');
            location.href = "password.php?cedula="+clave;
          }else if(datos==3){
            mensaje('Estimado docente su cuenta se encuentra bloqueada contacte al administrador!', 'error');
            setTimeout($.unblockUI,1000);  
          }else if(datos==4){
            mensaje('Sus Datos de acceso son incorrectos!', 'error');
            setTimeout($.unblockUI,1000);  
          }else if(datos==2){
            mensaje('BIENVENIDO ADMINISTRADOR!', 'success');
            location.href = "menuadministrador/";
            setTimeout($.unblockUI,1000);  
          }else if(datos==5){
            mensaje('BIENVENIDO DOCENTE!', 'success');
            location.href = "activate.php?iddocente="+user.iddocente;
            setTimeout($.unblockUI,1000);  
          }else if(datos==10){
            mensaje('BIENVENIDO ADMINISTRADOR!', 'success');
            location.href = "menuadministrador/index.php?iddocente="+datos;
            setTimeout($.unblockUI,1000);  
	        }else {
            console.log(datos);
	          setTimeout($.unblockUI,1000);  
	          mensaje("Se ha producido un error!","error");
	        }
	    });
	}
}
function base64EncodeUnicode(str) {
    // First we escape the string using encodeURIComponent to get the UTF-8 encoding of the characters, 
    // then we convert the percent encodings into raw bytes, and finally feed it to btoa() function.
    utf8Bytes = encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, function(match, p1) {
            return String.fromCharCode('0x' + p1);
    });

    return btoa(utf8Bytes);
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