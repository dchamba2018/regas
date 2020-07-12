<?php 
session_start();
date_default_timezone_set('America/Guayaquil');
require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseUsuarios.php";
include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/operaciones.php";
include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/data.dc";
include "../mail.php";

$iddocente=$_SESSION['iddocente'];
$estado="ACTIVO";
$email=$_SESSION['email'];
$password=$_GET['pass1'];
$rol="DOCENTE";
if($_SESSION['cedula']=="1900506609"){
	$rol="ADMINISTRADOR";
}
$ip=getRealIP();
$objusuarios=new claseUsuarios();
$usuario=$objusuarios->getUsuarioDocente($iddocente);
$respuesta=1;
if(isset($usuario['id'])){
	$respuesta=2;
}else{
	$password=base64_encode($password);
	$respuesta=$objusuarios->insertar($iddocente, $estado, $email, $password, $rol);
	$para = $email;
	$mensaje = crearplantillaClave($email, base64_decode($password));
	$cabeceras = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$cabeceras .= 'From: admin@ikerany.com';
	$titulo="CAMBIO DE CLAVE";
	$enviado = mail($para, $titulo, $mensaje, $cabeceras); 	
	$respuesta=$enviado;	
	$respuesta=0;
}
echo $respuesta;

?>