<?php 
	function GuardarActualizarEliminar($sql){
	    include "conection.php";
	    // Create connection
	    $conn = new mysqli($servername, $username, $password, $dbname);
	     // Check connection
	    if ($conn->connect_error) {
	        die("Connection failed: " . $conn->connect_error);
	        $resp="conexion incorrecta";
	    }   
	    if ($conn->query($sql) === TRUE) {
	        $resp="0";
	    } else {
	        $resp="conexion incorrecta";
	    }
	    $conn->close();
	    return $resp;
	}
?>