<?php
include "../../config/conection.php";
session_start();
$con = mysqli_connect($servername, $username, $password,$dbname);
$method = $_SERVER['REQUEST_METHOD'];
if(isset($_SERVER['PATH_INFO'])){
  $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));  
}
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}
$id='';
switch ($method) {
    case 'GET':      
    if(isset($_GET['op'])){
        $sql="SELECT justificaciones.`id`, motivo, fecha, CONCAT(`docentes`.`nombres`, ' ', `docentes`.`apellidos`) AS docente,
      `docentes`.`foto` FROM justificaciones, `docentes`, marcaciones 
      WHERE (`justificaciones`.`idmarcacion`=`marcaciones`.`id` AND `marcaciones`.`iddocente`=`docentes`.id AND justificaciones.`estado`='REVISION') order by fecha Desc;";
    }else{
        $idmarcacion=$_GET['idm'];
        $sql = "SELECT CONCAT(`docentes`.`nombres`, ' ', `docentes`.`apellidos`) AS docente, justificaciones.id, detalle, fecha, justificaciones.observacion, justificaciones.tipo as op, motivo, archivo, marcaciones.entrada, marcaciones.salida, justificaciones.estado, SUBSTRING_INDEX(justificaciones.archivo, '.', -1) AS tipo FROM justificaciones, `marcaciones`, docentes 
        WHERE(justificaciones.`idmarcacion`=marcaciones.id AND marcaciones.`iddocente`=docentes.id AND justificaciones.id=".$idmarcacion.") order by fecha DESC;";    
    }   
    $result = mysqli_query($con,$sql);

        
      break;
    case 'POST':      
      $idjustificacion = $_POST["id"];
      $estado = $_POST["estado"];
      $detalle = $_POST["detalle"];
      $tipo = $_POST["tipo"];
      $observacion = $_POST["observacion"];
      include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/operaciones.php";
      require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseJustificaciones.php";
      require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseMarcaciones.php";
      $objJustificaciones=new claseJustificaciones();
      $result=$objJustificaciones->actualizarEstado($idjustificacion, $estado, $observacion);
      
      if($estado=="JUSTIFICADO"){
        $objmarcaciones=new claseMarcaciones();
        $docente=$objJustificaciones->getDocenteJustificacion($idjustificacion);
        if($tipo=="ATRAZO"){   
          $result=$objmarcaciones->actualizarEntradaAtrazado($docente['id'], $docente['entrada']);
        }else if ($tipo=="ABANDONO"){
          $result=$objmarcaciones->actualizarSalidaAbandono($docente['id'], $docente['salida']);
        }else{
          $result=$objmarcaciones->actualizarEstado($docente['id'], "JUSTIFICADA");
        }
        
      }
      break;
}

// run SQL statement


// die if SQL statement failed
if ($method == 'GET') {
    if (!$id) echo '[';
    for ($i=0 ; $i<mysqli_num_rows($result) ; $i++) {
      echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
    }
    if (!$id) echo ']';
} else if ($method == 'POST') {
  echo json_encode($result);
} else {
  echo mysqli_affected_rows($con);
}
$con->close();
?>