<?php 
$nombre=$_POST['txtnombre'];
$entrada=$_POST['txtentrada'];
$salida=$_POST['txtsalida'];
require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseHorarios.php";
include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/operaciones.php";
$objHorario = new claseHorarios();	
if($nombre=="" || $nombre==" " || $entrada=="" || $salida==""){
	
}else{
	$objHorario->insertar($nombre, $entrada, $salida);
}

header('Location:../horarios.php');
?>