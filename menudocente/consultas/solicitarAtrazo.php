<?php 
	session_start();
	include $_SERVER['DOCUMENT_ROOT'] . '/docentes/config/operaciones.php';
	date_default_timezone_set('America/Guayaquil');
	
	$idmarcacion=$_POST['txtidreg'];
	$motivo=$_POST['txtmotivo'];
	$detalle=$_POST['txtdetalle'];
	$fecha=date("Y-m-d H:i:s");
	$tipoR=$_POST['txttipo'];
	require_once $_SERVER['DOCUMENT_ROOT'] . '/docentes/clases/claseJustificaciones.php';
	$objjust = new claseJustificaciones();
	$respuesta=3;

	$archivo = $_FILES["txtarchivo"]["tmp_name"];	
	$tamanio=array();
	$tamanio = $_FILES["txtarchivo"]["size"];
	$tipo = $_FILES["txtarchivo"]["type"];
	$nombre_archivo = $_FILES["txtarchivo"]["name"];
	if($archivo==""){
		$respuesta = $objjust->insertar($idmarcacion, $motivo, '', $fecha, "REVISION", $detalle, $tipoR);
	}else if($tamanio>6048576){
		$respuesta=2;
	}else if($tipo=="image/jpg" || $tipo=="image/jpeg" || $tipo=="image/png" || $tipo=="image/gif" || $tipo=="application/pdf"){
		$nom_encriptado=md5($_FILES["txtarchivo"]["tmp_name"]).".gif";
		if($tipo=="image/jpg"){
			$nom_encriptado=md5($_FILES["txtarchivo"]["tmp_name"]).".jpg";
		}else if($tipo=="image/jpeg"){
			$nom_encriptado=md5($_FILES["txtarchivo"]["tmp_name"]).".jpeg";
		}else if($tipo=="image/png"){
			$nom_encriptado=md5($_FILES["txtarchivo"]["tmp_name"]).".png";
		}else if($tipo=="application/pdf"){
			$nom_encriptado=md5($_FILES["txtarchivo"]["tmp_name"]).".pdf";
		}		
		$ruta="../archivos/".$nom_encriptado;
		move_uploaded_file($_FILES["txtarchivo"]["tmp_name"], $ruta);		
		//actualizarimagen
		$respuesta = $objjust->insertar($idmarcacion, $motivo, $nom_encriptado, $fecha, "REVISION", $detalle, $tipoR);
	}
	echo $respuesta;
?>