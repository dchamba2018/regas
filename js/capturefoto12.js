/*
    Tomar una fotografía y guardarla en un archivo
    @date 2017-11-22
    @author parzibyte
    @web parzibyte.me/blog
*/
function diaSemana(){
var fecha = new Date();
var dias = ["D", "L", "M", "X", "J", "V", "S"];
var mes = fecha.getMonth()+1; //obteniendo mes
var dia = $('#txtfecha').val();
var ano = fecha.getFullYear(); //obteniendo año
if(dia<10)
  dia='0'+dia; //agrega cero si el menor de 10
if(mes<10)
  mes='0'+mes //agrega cero si el menor de 10
var fec = mes+"/"+dia+"/"+ano;
var day = new Date(fec).getDay();
return dias[day];
}
function tieneSoporteUserMedia() {
    return !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia)
}
function _getUserMedia() {
    return (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);
}

function iniciar(){
	// Declaramos elementos del DOM

	var $video = document.getElementById("video"),
	$canvas = document.getElementById("canvas"),
	$boton = document.getElementById("btnentrada"),
	$boton1 = document.getElementById("btnsalida"),
	$estado = document.getElementById("estado");
	if (tieneSoporteUserMedia()) {
	    _getUserMedia(
	        {video: true},
	        function (stream) {
	            console.log("Permiso concedido");
	            $video.srcObject = stream;
				//$video.src = window.URL.createObjectURL(stream);
				$video.play();			
	        }, function (error) {
	            console.log("Permiso denegado o error: ", error);
	            $estado.innerHTML = "No se puede acceder a la cámara, o no diste permiso.";
	        });
	} else {
	    alert("Lo siento. Tu navegador no soporta esta característica");
	    $estado.innerHTML = "Parece que tu navegador no soporta esta característica. Intenta actualizarlo.";
	}
}
function capturar(observacion){
	if(diaSemana()=="D" || diaSemana()=="S"){
		mensaje("Estimado Usuario hoy no es día laborable!", "error");
	}else{
		bloquear();
		var $video = document.getElementById("video"),
		$canvas = document.getElementById("canvas"),
		$boton = document.getElementById("btnentrada"),
		$boton1 = document.getElementById("btnsalida"),
		$estado = document.getElementById("estado");
		$foto="";
		$video.pause();
		//Obtener contexto del canvas y dibujar sobre él
		var contexto = $canvas.getContext("2d");
		$canvas.width = $video.videoWidth;
		$canvas.height = $video.videoHeight;
		contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

		var foto = $canvas.toDataURL(); //Esta es la foto, en base 64
		$estado.innerHTML = "Enviando foto. Por favor, espera...";
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "./consultas/guardar_foto.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send(encodeURIComponent(foto)); //Codificar y enviar

		xhr.onreadystatechange = function() {
		    if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
		        console.log("La foto fue enviada correctamente");
		        console.log(xhr);
		        document.getElementById("txtfoto").value = xhr.responseText;
		        $foto=xhr.responseText;
		        registrarEntrada(observacion);
		        //$estado.innerHTML = "Foto guardada con éxito. Puedes verla <a target='_blank' href='./" + xhr.responseText + "'> aquí</a>";
		    }
		}
		//Reanudar reproducción
		$video.play();	
	}
		
}
