<?php
include "../config/conection.php";
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
        $cedula=$_GET['cedula'];
        require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/ValidadorEc.php";
        $objvalidar = new ValidadorEc();
        if($objvalidar->validarCedula($cedula)){
          $sql = "SELECT * FROM docentes WHERE(cedula='".$cedula."');";       
          $result = mysqli_query($con,$sql);
        }else{
          $method="RETURN";
          $result = array(
              "error" => "cedula incorrecta"
          );
        }        
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

if($method == 'RETURN'){
  echo json_encode($result);
}else if ($method == 'GET') {
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