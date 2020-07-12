<?php 
	$idhorario=$_GET['idhorario'];
	$mes=$_GET['mes'];
	echo llenarTabla($idhorario, $mes);

function llenarTabla($idhorario,$mes){
	session_start();
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseHorarios.php";
	$objHorario = new claseHorarios();  
	$horario=$objHorario->getHorario($idhorario);
	$respuesta="";
	if ( isset($horario['id'])) {
		$respuesta.="
		<div class=col-xl-12 col-lg-12>
			<div class='card shadow mb-4'>
		        <div class='card-header py-3'>
		          <h6 class='m-0 font-weight-bold text-primary'>REGISTRO DE ASISTENCIA</h6>
		        </div>
		        <div class='card-body'>
		        	<b>JORNADA:</b> ".strtoupper($horario['nombre'])."
		        	<br>
		        	<b>MES:</b> ".$mes."<br>
		        	<b>HORARIO:</b> DE ".@$horario['entrada']." A ".@$horario['salida']."<hr>
		        </div>
	     	</div>
	    </div>";
	}    
	return $respuesta;
}
?>

