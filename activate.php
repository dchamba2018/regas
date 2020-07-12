<?php 
date_default_timezone_set('America/Guayaquil');
setlocale(LC_ALL,"es_ES");  
session_start();
if(isset($_GET['iddocente'])){
	$iddocente=$_GET['iddocente'];
	$_SESSION['iddocente']=$iddocente;
	$url= "/docentes/menudocente/";
	$host= @$_SERVER["HTTP_HOST"];
	$ir="https://" . $host . "". $url;    
	if($host=="localhost"){
		echo "<SCRIPT>window.location='$url';</SCRIPT>";    
	}else{
		echo "<SCRIPT>window.location='$ir';</SCRIPT>"; 
	}
}else{
	echo "<SCRIPT>window.location='login.php';</SCRIPT>";    
}
     
?>