<?php
  include "../../config/conection.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . '/docentes/clases/claseDocentes.php';
  include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/operaciones.php";
  date_default_timezone_set('America/Guayaquil');

  $objDocentes=new claseDocentes();
  $id=''; 
  $method = $_SERVER['REQUEST_METHOD'];
  if(isset($_SERVER['PATH_INFO'])){
    $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));  
  }
  switch ($method) {
    case 'GET':      
      $result=$objDocentes->getDocentesApi($_GET['dato'], $_GET['estado']);
    break;
  case 'POST':  
    $iddocente=$_POST['iddocente'];
    if(isset($_POST['op'])){
      $nombres=$_POST['nombres'];
      $apellidos=$_POST['apellidos'];
      $result=$objDocentes->actualizarDocenteApi($iddocente,  $nombres, $apellidos);
    }else{
      $estado=$_POST['estado'];
      //actualizamos estado cupo
      $result=$objDocentes->actualizarEstadoDocente($iddocente,  $estado);
    }
    
    $codigo=$result;
    $detalle="Actualizado Correctamente!";
    $result=array("codigo"=>$result, "detalle"=>$detalle);
    break;
}

// die if SQL statement failed
if ($method == 'GET') {
    if (!$id) echo '[';
    for ($i=0 ; $i<mysqli_num_rows($result); $i++) {
      echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
    }
    if (!$id) echo ']';
} else if ($method == 'POST') {
  echo json_encode($result);
} else {
}
?>