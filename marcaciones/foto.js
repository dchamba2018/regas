function tieneSoporteUserMedia() {
    return !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia)
}
function _getUserMedia() {
    return (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);
}
var videoTracks;
function iniciar(){
	var $video = document.getElementById("video"),
	$canvas = document.getElementById("canvas"),
	$estado = document.getElementById("estado");
	if (tieneSoporteUserMedia()) {
	    _getUserMedia(
	        {video: true},
	        function (stream) {
	            $video.srcObject = stream;
				//$video.src = window.URL.createObjectURL(stream);
				videoTracks = stream.getVideoTracks();
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
function capturar(){
	var $resultado=false;
	var $video = document.getElementById("video"),
	$canvas = document.getElementById("canvas"),
	$estado = document.getElementById("estado");
	$foto="";
	$video.pause();
	//Obtener contexto del canvas y dibujar sobre él
	var contexto = $canvas.getContext("2d");
	$canvas.width = $video.videoWidth;
	$canvas.height = $video.videoHeight;
	contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

	document.getElementById('video').style.display ='none';
	document.getElementById('canvas').style.display ='';


	var foto = $canvas.toDataURL(); //Esta es la foto, en base 64
	$estado.innerHTML = "Enviando foto. Por favor, espera...";
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "../consultas/guardar_foto.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(encodeURIComponent(foto)); //Codificar y enviar
	
	$video.src="";	
	videoTracks.forEach(function(track) {track.stop()});
	return xhr;
}
