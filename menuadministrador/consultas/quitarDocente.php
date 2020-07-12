<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseHorariosDocentes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/operaciones.php";
$iddocente=$_GET['iddocente'];
$idhorarioDocente=$_GET['idhorarioDocente'];
$objHorarioDocente = new claseHorariosDocentes();	
$resp=$objHorarioDocente->actualizar($idhorarioDocente, $iddocente);
echo $resp;
?>