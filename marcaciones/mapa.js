
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
	document.getElementById("txtlongi").value = longitud;
	document.getElementById("txtprecision").value = precision;
	var centro = new google.maps.LatLng(latitud,longitud);
	var propiedades ={
        zoom: 18,
        center: centro,
        mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(contenedor, propiedades);
	var geocoder = new google.maps.Geocoder;
	var infowindow = new google.maps.InfoWindow;
	geocodeLatLng(geocoder, map, infowindow, latitud, longitud);
}
function geocodeLatLng(geocoder, map, infowindow, latitud, longitud) {
  var latlng = {lat: latitud, lng: longitud};
  geocoder.geocode({'location': latlng}, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      if (results[0]) {
        var marker = new google.maps.Marker({
          position: latlng,
          map: map
        });
        marker.setIcon('avatarh.png');
        var i=1;	
        content = "Ubicación: " + results[i].formatted_address + "<br />" +
                      "Tipo: " + results[i].types + "<br />" +
                      "Latitud: " + results[i].geometry.location.lat() + "<br />" +
                      "Longitud: " + results[i].geometry.location.lng();
        infowindow.setContent(content);
        infowindow.open(map, marker);
        $("#direccion").html("<h6>"+results[1].formatted_address+"</h6>");	
      } else {
        window.alert('No results found');
      }
    } else {
      window.alert('Geocoder failed due to: ' + status);
    }
  });
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
