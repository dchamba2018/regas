<?php 
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseMarcaciones.php";
  	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";
  	$objmarcacion=new claseMarcaciones();
  	$objDocente = new claseDocentes();  
    $listaDocentes=$objDocente->getDocentes("ACTIVO");
    $objmarcacion->consultaMarcacion($listaDocentes);
    
	$host= $_SERVER["HTTP_HOST"];
	$url= "/docentes/marcaciones/";
	$ir="https://" . $host . "". $url;		
	if($host=="localhost"){
		echo "<SCRIPT>window.location='$url';</SCRIPT>";		
	}else{
		echo "<SCRIPT>window.location='$ir';</SCRIPT>";	
	}
	//gethostbyaddr($_SERVER['REMOTE_ADDR']);
?>