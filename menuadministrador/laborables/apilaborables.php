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
$iddocente=$_SESSION['iddocente'];
switch ($method) {
  case 'GET':      
    $sql = "SELECT * from nolaborables where(year(inicio)=".$_GET['anio'].") order by inicio DESC;"; 
  // run SQL statement
    $result = mysqli_query($con,$sql);
    break;  
  case 'POST': 
    $idlab = $_POST["id"];
    $inicio = $_POST["inicio"];
    $fin = $_POST["fin"];
    $motivo = $_POST["motivo"];
    include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/operaciones.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseLaborables.php";
    $objLaborables=new claseLaborables();
    if($idlab == "0"){
      $result=$objLaborables->insertar($idlab, $inicio, $fin, $motivo);
    }else{
      $op = $_POST["op"];
      if($op=="update"){
        $result=$objLaborables->actualizar($idlab, $inicio, $fin, $motivo);
      }else{
        $result=$objLaborables->eliminar($idlab);
      }      
    }      
    break;
}

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