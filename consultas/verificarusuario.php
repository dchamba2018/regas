<?php 
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseMarcaciones.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/ValidadorEc.php";
	date_default_timezone_set('America/Guayaquil');
	$cedula=$_GET['cedula'];
	$objDocente = new claseDocentes();	
	$objMarcaciones = new claseMarcaciones();	
	$docente=$objDocente->getDocenteCedula($cedula);
	$objvalidar = new ValidadorEc();
	if($objvalidar->validarCedula($cedula)){
		if(isset($docente['id'])){
			//verificar registro
			$marcacion=$objMarcaciones->getContarMarcacionDocente($docente['id']);
			if($marcacion==0){
				$objMarcaciones->insertar($docente['id'], date("Y-m-d H:i:s"), "", "", "", "INASISTENCIA", "", "", date("Y-m-d H:i:s"));
			}
			$marcacionentrada=$objMarcaciones->getMarcacionObservacion($docente['id'], date("Y-m-d"), "INASISTENCIA");
			$marcacionsalida=$objMarcaciones->getMarcacionObservacion($docente['id'], date("Y-m-d"), "ENTRADA");
			if(isset($marcacionentrada['id'])){
				$respuesta="0|".$docente['nombres']." ".$docente['apellidos']."|".$docente['id'];
			}else if(isset($marcacionsalida['id'])){
				$respuesta="2|".$docente['nombres']." ".$docente['apellidos']."|".$docente['id'];
			}else{
				$respuesta=3;
			}			
		}else{
			//$respuesta=1;
			$respuesta=1;
			session_start();
			$_SESSION['cedula']=$cedula;
		}
	}else{
		$respuesta=4;
	}
	//0 existe docente
	//1 no existe docente
	//2 disponible
	//3 no ha sido registrada
	echo $respuesta;
?>