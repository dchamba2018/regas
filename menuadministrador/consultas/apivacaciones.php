<?php
  include "../../config/conection.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . '/docentes/clases/claseVacaciones.php';
  include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/operaciones.php";
  date_default_timezone_set('America/Guayaquil');

  $objVacaciones=new claseVacaciones();
  $id=''; 
  $method = $_SERVER['REQUEST_METHOD'];
  if(isset($_SERVER['PATH_INFO'])){
    $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));  
  }
  switch ($method) {
    case 'GET':      
      $result=$objVacaciones->getVacacionesApi();
    break;
  case 'POST':  
    $idvacacion=$_POST['idvacacion'];    
    if(isset($_POST['op'])&& $_POST['op']=='ELIMINAR'){      
      $result=$objVacaciones->eliminar($idvacacion);
    }else{
      $estado=$_POST['op'];
      $result=$objVacaciones->actualizarEstado($idvacacion, $estado);
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