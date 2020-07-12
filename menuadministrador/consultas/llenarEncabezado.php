<?php 
	$iddocente=$_GET['iddocente'];
	$mes=$_GET['mes'];
	echo llenarTabla($iddocente, $mes);

function llenarTabla($iddocente,$mes){
	session_start();;        
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseHorarios.php";
	$objDocente = new claseDocentes();  
	$objHorario = new claseHorarios();  
	$docente=$objDocente->getDocente($iddocente);
	$horario=$objHorario->getHorarioDocSel($iddocente);
	$respuesta="";
	if ( isset($docente['id'])) {
		$respuesta.="
		<div class=col-xl-12 col-lg-12>
			<div class='card shadow mb-4'>
		        <div class='card-header py-3'>
		          <h6 class='m-0 font-weight-bold text-primary'>DATOS DEL DOCENTE</h6>
		        </div>
		        <div class='card-body'>
		        	<b>NOMBRES:</b> ".strtoupper($docente['nombres'])." ".strtoupper($docente['apellidos'])."
		        	<br>
		        	<b>CEDULA:</b> ".$docente['cedula']."<br>
		        	<b>MES:</b> ".$mes."<br>
		        	<b>HORARIO:</b> ".@$horario['nombre']." - DE ".@$horario['entrada']." A ".@$horario['salida']."
		        </div>
	     	</div>
	    </div>";
	}    
	return $respuesta;
}
?>

