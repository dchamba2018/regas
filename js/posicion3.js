function localize(){
 	if (navigator.geolocation){
        navigator.geolocation.getCurrentPosition(mapa,error);
    }else{
        mensaje("Tu navegador no soporta geolocalizacion.","error");
    }
}
function mapa(pos){
/************************ Aqui están las variables que te interesan***********************************/
	var latitud = pos.coords.latitude;
	var longitud = pos.coords.longitude;
	var precision = pos.coords.accuracy;
	var contenedor = document.getElementById("map")
	document.getElementById("txtlatitud").value = latitud;
	document.getElementById("txtlongitud").value = longitud;
	document.getElementById("txtprecision").value = precision;
	var centro = new google.maps.LatLng(latitud,longitud);
	var propiedades ={
        zoom: 17,
        center: centro,
        mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(contenedor, propiedades);
	var marcador = new google.maps.Marker({
        position: centro,
        map: map,
        title: "Tu posicion actual"
    });
    verificarposicion();
}
function error(errorCode){
	if(errorCode.code == 1)
		mensaje("No has permitido buscar tu localizacion","error")
	else if (errorCode.code==2)
		mensaje("Posicion no disponible","error")
	else
		mensaje("Ha ocurrido un error","error")
}
function mensaje(mensaje, tipo){
  swal({title: "ASIS-DOCENTE!",
      text: mensaje,
      icon: tipo,
    });
}
