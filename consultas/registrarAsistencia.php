<?php 
session_start();
date_default_timezone_set('America/Guayaquil');
require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseMarcaciones.php";
include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/operaciones.php";
include "../mail.php";

$iddocente=$_GET['iddocente'];
$lat=$_GET['latitud'];
$long=$_GET['longitud'];
$precision=$_GET['presicion'];
$fechahora=date("Y-m-d H:i:s");
$ip=getRealIP();
$observacion=$_GET['observacion'];	
$foto=$_GET['foto'];
$marcacion=new claseMarcaciones();
if(get_nombre_dia()=="Domingo" || get_nombre_dia()=="Sabado"){
	$respuesta="1";
}else{
	if($observacion=='ENTRADA'){
		$respuesta=$marcacion->actualizarEntrada($iddocente, $fechahora, $lat, $long, $ip, $observacion, $precision, $foto, date('Y-m-d'));		
	}else{
		$respuesta=$marcacion->actualizarSalida($iddocente, $fechahora, $lat, $long, $ip, $observacion, $precision, $foto, date('Y-m-d'));
	}
	$objDocente = new claseDocentes();	
	$docente=$objDocente->getDocente($iddocente);
	$marca=$marcacion->getMarcacion($iddocente, date('Y-m-d'));
	$para = $docente['email'];
	$mensaje = crearplantillaEntrada($docente, $marca, $observacion);
	$cabeceras = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$cabeceras .= 'From: admin@ikerany.com';
	$titulo="CONFIRMACION DE ASISTENCIA";
	$enviado = mail($para, $titulo, $mensaje, $cabeceras); 	
}

echo $respuesta;
function get_nombre_dia(){
   $fechats = strtotime(date("Y-m-d")); //pasamos a timestamp
	//el parametro w en la funcion date indica que queremos el dia de la semana
	//lo devuelve en numero 0 domingo, 1 lunes,....
	switch (date('w', $fechats)){
	    case 0: return "Domingo"; break;
	    case 1: return "Lunes"; break;
	    case 2: return "Martes"; break;
	    case 3: return "Miercoles"; break;
	    case 4: return "Jueves"; break;
	    case 5: return "Viernes"; break;
	    case 6: return "Sabado"; break;
	}
}
?>