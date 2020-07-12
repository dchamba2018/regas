<?php 
	header("Content-Type: text/html; charset=utf-8");
	session_start();
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseUsuarios.php";
	include "../config/data.dc";
	date_default_timezone_set('America/Guayaquil');
	$email=$_GET['email'];
	$clave=$_GET['clave'];
	$objUsuario = new claseUsuarios();	
	$objDocente = new claseDocentes();	
	$usuarioemail=$objUsuario->getUsuarioEmail($email);
	$iddocente=0;
	if(isset($usuarioemail['id'])){
		if($usuarioemail['estado']=="INACTIVO"){
			$respuesta=3;
		}else{
			$usuario=$objUsuario->getUsuarioEmailClave($email, base64_encode($clave));
			if(isset($usuario['id'])){		
				if($usuario['rol']=="ADMINISTRADOR"){
					$_SESSION['iddocente']=$usuario['iddocente'];
					$respuesta=$usuario['iddocente'];	
					$iddocente=$usuario['iddocente'];
				}else{
					$_SESSION['iddocente']=$usuario['iddocente'];
					$respuesta=5;	
					$iddocente=$usuario['iddocente'];
				}				
			}else{
				$respuesta=4;
			}
		}
	}else{
		$docente=$objDocente->getDocenteCedulaEmail($clave,$email);
		if(isset($docente['id'])){
			$_SESSION['cedula']=$clave;
			$_SESSION['email']=$email;
			$_SESSION['iddocente']=$docente['id'];
			$iddocente=$docente['id'];
			$respuesta=1;
		}else{
			$respuesta=0;	
		}
		
	}
	//0 existe docente
	//1 no existe docente
	//2 disponible
	//3 no ha sido registrada

	$resp=array("codigo"=>"".$respuesta, "iddocente"=>"".$iddocente);
	echo json_encode($resp);
?>