<?php 
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/operaciones.php";

$nombres=$_GET['nombres'];
$apellidos=$_GET['apellidos'];
$cedula=$_GET['cedula'];
$celular=$_GET['telefono'];
$email=$_GET['email'];
$clave="";
$estado="ACTIVO";
$foto="foto.png";
$idapk="";

$objDocente = new claseDocentes();	
$docente=$objDocente->getDocenteEmail($email);

if(isset($docente['id'])){
	$respuesta=2;
}else{
	$respuesta=$objDocente->insertar($nombres, $apellidos, $cedula, $celular, $email, $clave, $estado, $foto, $idapk);	
}
$docente=$objDocente->getDocenteCedula($cedula);
	$para = $docente['email'];
	include "../mail.php";
	$mensaje = crearplantilla($docente);
	$cabeceras = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$cabeceras .= 'From: admin@ikerany.com';
	$titulo="REGISTRO DOCENTE";
	$enviado = mail($para, $titulo, $mensaje, $cabeceras); 
echo $respuesta;
?>