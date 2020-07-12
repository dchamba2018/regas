<?php 
	$iddocente=$_GET['iddocente'];
	$mes=$_GET['mes'];
	echo llenarTabla($iddocente, $mes);

function llenarTabla($iddocente, $mes){
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseMarcaciones.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseHorarios.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseLaborables.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseVacaciones.php";
	$objMarcaciones = new claseMarcaciones();  
	$objHorario = new claseHorarios();  
	$objlab = new claseLaborables();  
	$objvac = new claseVacaciones();  
	$horario=$objHorario->getHorarioDocSel($iddocente);
	$entrada='14:00:00';
	$salida='22:30:00';
	if(isset($horario['id'])){
		$entrada=$horario['entrada'];
		$salida=$horario['salida'];
	}
	$listamarcaciones=$objMarcaciones->getMarcacionesDocenteMes($iddocente, $mes, $entrada, $salida);
	$respuesta="";
	if ( count( $listamarcaciones ) == 0 ) {
		$respuesta.= "<tr><td colspan='6'>No hay Marcaciones</td></tr>";
	} else { 
		foreach ( $listamarcaciones as $item ) {
			if($item['justificada']=="JUSTIFICADA"){
				$respuesta.="<tr style='font-size:12px;'> 
				<td align='center'><b>". $item['fecha']."</td>
				<td align='center'><b></td>
				<td align='center'><b></b></td>
				<td align='center'><b></td>
				<td align='center'><b>". $item['justificada']."</td></tr>";	
			}else if($item['justificada']=="INASISTENCIA"){
				$dia=$objlab->getRegistroNolaborable($item['fecha']);
				$diaV=$objvac->getRegistroVacaciones($iddocente, $item['fecha']);
				if(isset($dia['id'])){
					$respuesta.="<tr style='font-size:12px;'> 
					<td align='center'><b>". $item['fecha']."</td>
					<td align='center'><b></td>
					<td align='center'><b></b></td>
					<td align='center'><b></td>
					<td align='center'><b>". $dia['motivo']."</td></tr>";	
				}else if(isset($diaV['id'])){
					$respuesta.="<tr style='font-size:12px;'> 
					<td align='center'><b>". $item['fecha']."</td>
					<td align='center'><b></td>
					<td align='center'><b></b></td>
					<td align='center'><b></td>
					<td align='center'><b>VACACIONES</td></tr>";		
				}else{
					$respuesta.="<tr style='font-size:12px;'> 
					<td align='center'><b>". $item['fecha']."</td>
					<td align='center'><b>". $item['entrada']."</td>
					<td align='center'><b>".$item['atrazo']."</b></td>
					<td align='center'><b>". $item['salida']."</td>
					<td align='center'><b>". $item['observacion']."</td></tr>";	
				}				
			}else {
				$respuesta.="<tr style='font-size:12px;'> 
				<td align='center'><b>". $item['fecha']."</td>
				<td align='center'><b>". $item['entrada']."</td>
				<td align='center'><b>".$item['atrazo']."</b></td>
				<td align='center'><b>". $item['salida']."</td>
				<td align='center'><b>". $item['observacion']."</td></tr>";	
			}
		} 
		$atrazo=$objMarcaciones->getTotalMarcacionDocente($iddocente,$mes, $entrada);
		$respuesta.="<tr style='font-size:12px;'>
		<td align='right' colspan='2'><b>TOTAL DE ATRAZOS: </b></td>
		<td align='center'><b>". $atrazo."</td>
		<td align='right' colspan='2'></td>
		</tr>";
	}    
	return $respuesta;
}
?>

