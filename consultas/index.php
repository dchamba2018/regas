<?php 
	$host= $_SERVER["HTTP_HOST"];
	$url= "/docentes/";
	$ir="https://" . $host . "". $url;		
	if($host=="localhost"){
		echo "<SCRIPT>window.location='$url';</SCRIPT>";		
	}else{
		echo "<SCRIPT>window.location='$ir';</SCRIPT>";	
	}
?>