<?php 
	$idhorario=$_GET['id'];
	echo llenarTabla($idhorario);

function llenarTabla($idhorario){
	session_start();;        
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";

	$objDocente = new claseDocentes();  
	$listadocentes=$objDocente->getDocenteTienenHorario($idhorario);
	$respuesta="";
	if ( count( $listadocentes ) == 0 ) {
		$respuesta.= "<tr><td colspan='3'>No hay docentes asignados</td></tr>";
	} else { 
		$i=1;
		foreach ( $listadocentes as $item ) {
			$respuesta.="<tr style='font-size:12px;'> 
			<td align='center'>
			<b><a  title='Quitar Docente' href='#' onclick='quitarDocente(".$item['id'].", ".$idhorario.")' 
			style='color:red;'><i class='fas fa-arrow-left'></i></a></b>
			</td>	
			<td><b>".strtoupper($item['nombres'])." ". strtoupper($item['apellidos'])."</td>
			<td><b>". $i."</td>
			";
			$respuesta.="</tr>";
			$i++;
		} 
	}    
	return $respuesta;
}
?>

