function TiempoActividad(){
    setTimeout("DestruirSesion()", 6000000);
}
function DestruirSesion(){
    location.href = "../index.php";
}