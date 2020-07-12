<?php 
	$iddocente=$_GET['iddocente'];
	$mes=$_GET['mes'];
	echo llenarTabla($iddocente, $mes);

function llenarTabla($iddocente, $mes){
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseMarcaciones.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseHorarios.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseJustificaciones.php";
	$objMarcaciones = new claseMarcaciones();  
	$objHorario = new claseHorarios();  
	$objJustificaciones = new claseJustificaciones();  
	$horario=$objHorario->getHorarioDocSel($iddocente);
	$entrada='14:00:00';
	$salida='22:30:00';
	if(isset($horario['id'])){
		$entrada=$horario['entrada'];
		$salida=$horario['salida'];
	}
	$listamarcaciones=$objMarcaciones->getMarcacionesDocenteMesDesc($iddocente, $mes, $entrada, $salida);
	$respuesta="";
	if ( count( $listamarcaciones ) == 0 ) {
		$respuesta.= "<tr><td colspan='6'>No hay Marcaciones</td></tr>";
	} else { 
		foreach ( $listamarcaciones as $item ) {
			$foto="foto.jpg";
			$map=true;
          	if($item['foto']!=""){
            	$foto=$item['foto'];
          	}	
          	$urlimagen = $_SERVER['DOCUMENT_ROOT']."/docentes/img/fotos/".$foto;
          	if(file_exists($urlimagen)){          		
          	}else{
          		$foto="foto.jpg";
          	}
          	$respuesta.="<tr style='font-size:12px;'> 
			<td align='center'><a target='_blank' href='../img/fotos/".$foto."'><img class='circle' style='padding: 0; display: block' src='../img/fotos/".$foto."' width='36px'></a></td>
			<td align='center'><b>". $item['fecha']."</td>";
			if($item['justificada']=="JUSTIFICADA"){
				$respuesta.="<td align='center'><b></b></td>";
			}else{
				$respuesta.="<td align='center'><b>". $item['entrada']."</td>";
			}
			if($item['atrazo']==""){
				$respuesta.="<td align='center'><b>".$item['atrazo']."</b></td>";
			}else if($item['justificada']=="JUSTIFICADA"){
				$respuesta.="<td align='center'><b></b></td>";	
			}else{
				$tipo="ATRAZO";
				$justif=$objJustificaciones->getJustificacionesMarcacionTipo($item['id'], $tipo);
				if(isset($justif['id'])){
					if($justif['estado']=='REVISION'){
						$respuesta.="<td align='center' class='text-success' title='Solicitud en proceso'><b>".$item['atrazo']."</b></td>";
					}else if($justif['estado']=='NEGADO'){
						$respuesta.="<td align='center' title='Solicitud rechazada'><b>
						<a title='Solicitud rechazada..' class='btn btn-outline-danger btn-sm' href='rechazo.php?idj=".$item['id']."&tipo=".$tipo."'>
						<i class='far fa-times-circle'></i>
						".$item['atrazo']."</a></b>
						</td>";	
					}else{
						$tipo="\"".$tipo."\"";
						$respuesta.="<td align='center'>
						<a title='Justificar Atrazo' class='btn btn-outline-primary btn-sm' href='#' onclick='justificarAtrazo(".$item['id'].",".$tipo.")'>
						<i class='far fa-check-circle'></i><b>".$item['atrazo']."</b></a>
						</td>";
					}
				}else{
					$tipo="\"".$tipo."\"";
					$respuesta.="<td align='center'>
					<a title='Justificar Atrazo' class='btn btn-outline-primary btn-sm' href='#' onclick='justificarAtrazo(".$item['id'].",".$tipo.")'>
					<i class='far fa-check-circle'></i><b>".$item['atrazo']."</b></a>
					</td>";
				}
			}			
			if($item['justificada']=="JUSTIFICADA"){
				$respuesta.="<td align='center'><b></b></td>";
			}else{
				$respuesta.="<td align='center'><b>". $item['salida']."</td>";
			}			
			if($item['observacion']=="ABANDONO"){
				if($item['justificada']=="JUSTIFICADA"){
					$respuesta.="<td align='center'><b>".$item['justificada']."</b></td>";
					$map=false;
				}else{
					$tipo="ABANDONO";
					$justif=$objJustificaciones->getJustificacionesMarcacionTipo($item['id'], $tipo);
					if(isset($justif['id'])){
						if($justif['estado']=='REVISION'){
							$respuesta.="<td align='center' class='text-success' title='tramite en proceso'><b>".$item['observacion']."</b></td>";
						}else if($justif['estado']=='NEGADO'){
							$respuesta.="<td align='center' class='text-danger' title='tramite rechazado'><b>".$item['observacion']."</b></td>";	
							$respuesta.="<td align='center' title='Solicitud rechazada'><b>
							<a title='Solicitud rechazada..' class='btn btn-outline-danger btn-sm' href='rechazo.php?idj=".$item['id']."&tipo=".$tipo."'><b>".$item['observacion']."</b></a></b>
							</td>";	
						}else{
							if($item['justificada']=="JUSTIFICADA"){
								$respuesta.="<td align='center'><b>".$item['justificada']."</b></td>";
							}else{
								$tipo="\"".$tipo."\"";
								$respuesta.="<td align='center'><b>
								<a title='Justificar Abandono' class='btn btn-outline-primary btn-sm' href='#' onclick='justificarAtrazo(".$item['id'].",".$tipo.")'>
								<b>".$item['observacion']."</b></a>
								</td>";
							}
												
						}
					}else{
						$tipo="\"".$tipo."\"";
						$respuesta.="<td align='center'><b>
						<a title='Justificar Abandono' class='btn btn-outline-primary btn-sm' href='#' onclick='justificarAtrazo(".$item['id'].",".$tipo.")'>
						<b>".$item['observacion']."</b></a>
						</td>";
					}
				}
			}else if($item['observacion']=="INASISTENCIA"){
				require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseLaborables.php";
				$objlab = new claseLaborables();  
				require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseVacaciones.php";
				$objvac = new claseVacaciones();  
				$dia=$objlab->getRegistroNolaborable($item['fecha']);
				$diaV=$objvac->getRegistroVacaciones($iddocente, $item['fecha']);

				if(isset($dia['id'])){
					$respuesta.="<td align='center'>".$dia['motivo']."</a>
					</td>";
					$map=false;					
				}else if(isset($diaV['id'])){
					$respuesta.="<td align='center'>VACACIONES</a>
					</td>";
					$map=false;					
				}else{
					$tipo="INASISTENCIA";				
					$justif=$objJustificaciones->getJustificacionesMarcacionTipo($item['id'], $tipo);
					if(isset($justif['id'])){
						if($justif['estado']=='REVISION' ){
							$respuesta.="<td align='center' class='text-success' title='tramite en proceso'><b>".$item['observacion']."</b></td>";
						}else if($justif['estado']=='NEGADO'){
							$respuesta.="<td align='center' title='Solicitud rechazada'><b>
							<a title='Solicitud rechazada..' class='btn btn-outline-danger btn-sm' href='rechazo.php?idj=".$item['id']."&tipo=".$tipo."'><b>".$item['observacion']."</b></a></b>
							</td>";	
						}else{
							$respuesta.="<td align='center'><b>".$item['observacion']."</b></td>";						
						}
					}else{	
						$tipo="\"".$tipo."\"";				
						$respuesta.="<td align='center'><b>
						<a title='Justificar Inasitencia' class='btn btn-outline-danger btn-sm' href='#' onclick='justificarAtrazo(".$item['id'].",".$tipo.")'>
						<b>".$item['observacion']."</b></a>
						</td>";
					}



				}
			}else{
				$respuesta.="<td align='center'><b>".$item['observacion']."</td>";
			}
			if($map==false){
				$respuesta.="<td align='center'></td>";
			}else{
				$respuesta.="
				<td align='center'><a title='Ver ubicación en el mapa class='btn btn-primary' target='_blank' href='https://www.google.com/maps/@".$item['lat'].",".$item['longitud'].",20z'>
                              <i class='fas fa-map-marker-alt'></i>
                              </a></td></tr>";
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

