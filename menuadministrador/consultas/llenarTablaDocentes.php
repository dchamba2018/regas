<?php 
	$idhorario=$_GET['id'];
	echo llenarTabla($idhorario);

function llenarTabla($idhorario){
	session_start();;        
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";

	$objDocente = new claseDocentes();  
	$listadocentes=$objDocente->getDocenteNoTienenHorario();
	$respuesta="";
	if ( count( $listadocentes ) == 0 ) {
		$respuesta.= "<tr><td colspan='3'>No hay docentes asignados</td></tr>";
	} else { 
		$i=1;
		foreach ( $listadocentes as $item ) {
			$respuesta.="<tr style='font-size:12px;'> 
			<td><b>". $i."</td>
			<td><b>". strtoupper($item['nombres'])." ". strtoupper($item['apellidos'])."</td>
			<td align='center'>
				<b><a  title='Agregar Docente' href='#' onclick='agregarDocente(".$item['id'].", ".$idhorario.")' 
			style='color:green;'><i class='fas fa-arrow-right'></i></a></b>
			</td>	
			</td>";
			$respuesta.="</tr>";
			$i++;
		} 
	}    
	return $respuesta;
}
?>

