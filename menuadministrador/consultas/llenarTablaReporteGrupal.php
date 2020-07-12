<?php 
	$idhorario=$_GET['idhorario'];
	$mes=$_GET['mes'];
	echo llenarTabla($idhorario, $mes);

function llenarTabla($idhorario, $mes){
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseHorarios.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseMarcaciones.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseLaborables.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseVacaciones.php";
	$objHorario = new claseHorarios();  
	$objMarcaiones = new claseMarcaciones(); 
	$objLaborables = new claseLaborables();  
	$objvacaciones = new claseVacaciones();  
	$listahorario=$objHorario->getHorarioMensual($idhorario);
	$horario=$objHorario->getHorario($idhorario);
	$listaDiasMarcadas=$objMarcaiones->getTotalDiasLaborados($mes, "SALIDA");
	$entrada='14:00:00';
	$salida='22:30:00';
	if(isset($horario['id'])){
		$entrada=$horario['entrada'];
		$salida=$horario['salida'];
	}
	$listaInasistencias=$objMarcaiones->getTotalDiasLaborados($mes, "INASISTENCIA");
	$listaJustificadas=$objMarcaiones->getTotalDiasLaborados($mes, "JUSTIFICADA");
	$listaAbandonos=$objMarcaiones->getTotalDiasLaborados($mes, "ENTRADA");
	$totalnolaborables=$objLaborables->getTotalNolaborable($mes);

	$respuesta="";
	if ( count( $listahorario ) == 0 ) {
		$respuesta.= "<tr><td colspan='6'>No hay Registros</td></tr>";
	} else {
		foreach ( $listahorario as $item ) {
			$totallabor=0;
			$respuesta.="<tr style='font-size:10px;'> 
			<td align='center'><b>". $item['cedula']."</td>
			<td><b>".strtoupper($item['docente'])."</td>";
			$dias=0;
			foreach ( $listaDiasMarcadas as $dmarc ) {
				if($dmarc['iddocente']==$item['iddocente']){
					$dias=$dmarc['dias'];
				}
			}
			$totallabor=$totallabor+$dias;

			$respuesta.="<td align='center'><b>". $dias."</td>";
			$atrazos=$objMarcaiones->getTotalMarcacionDocente($item['iddocente'],$mes, $entrada);
			$respuesta.="<td align='center'><b>". $totalnolaborables."</td>";			
			$respuesta.="<td align='center'><b>". $atrazos."</td>";
			$totallabor=$totallabor+$totalnolaborables; 

			$abandonos=0;
			foreach ( $listaAbandonos as $aband ) {
				if($aband['iddocente']==$item['iddocente']){
					$abandonos=$aband['dias'];
				}
			}
			$totallabor=$totallabor+$abandonos;			
			if($abandonos>0){
				$respuesta.="<td align='center'><b>". $abandonos."</td>";	
			}else{
				$respuesta.="<td align='center'><b></td>";
			}
			
			$justificadas=0;
			foreach ( $listaJustificadas as $fjust ) {
				if($fjust['iddocente']==$item['iddocente']){
					$justificadas=$fjust['dias'];
				}
			}
			$totallabor=$totallabor+$justificadas;

			if($justificadas>0){
				$respuesta.="<td align='center' ><b>". $justificadas."</td>";	
			}else{
				$respuesta.="<td align='center'><b></td>";
			}
			
			$injustificadas="0";
			foreach ( $listaInasistencias as $finjust ) {
				if($finjust['iddocente']==$item['iddocente']){
					$injustificadas=$finjust['dias'];
				}
			}
			
			$totalvacaciones=$objvacaciones-> getSumaVacacionesDocenteMes($item['iddocente'], $mes);
			$totalvacaciones1=$objvacaciones-> getSumaVacacionesDocenteDesde($item['iddocente'], $mes);
			$totalvacaciones2=$objvacaciones-> getSumaVacacionesDocenteHasta($item['iddocente'], $mes);
			$totalvacaciones=$totalvacaciones+$totalvacaciones1+$totalvacaciones2;
			$totalvacacionesdiaslaborables=0;

			if($injustificadas>0){				
				if($totalnolaborables>$injustificadas){
					$injustificadas=$totalnolaborables-$injustificadas;	
				}else{
					$injustificadas=$injustificadas-$totalnolaborables;
				}				
				if($injustificadas==0){
					$injustificadas="";
				}
				//analisi de vacaciones
				if($injustificadas<$totalvacaciones){
					$totalvacacionesdiaslaborables=$injustificadas;
					$injustificadas='';
				}else{
					$totalvacacionesdiaslaborables=$totalvacaciones;
					$injustificadas=$injustificadas-$totalvacaciones;
				}
				$respuesta.="<td align='center'><b>".$injustificadas."</td>";
			}else{
				$respuesta.="<td align='center'><b></td>";
			}

			$totallabor=$totallabor+$injustificadas;

			$respuesta.="<td align='center'><b>".$totalvacacionesdiaslaborables."</td>";
			$respuesta.="<td align='center'><b>".$totalvacaciones."</td>";
			$totallabor=$totallabor+$totalvacacionesdiaslaborables;
			$respuesta.="<td align='center'><b>". $totallabor."</td></tr>";
		} 
	}    
	return $respuesta;
}
?>

