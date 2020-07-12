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
      $iddocente=$_SESSION['iddocente'];
      $mes=$_GET['fecha'];
      $sql = "SELECT justificaciones.id, justificaciones.tipo, fecha, justificaciones.observacion, detalle, motivo, archivo, justificaciones.estado FROM justificaciones, `marcaciones`, docentes 
    WHERE(justificaciones.`idmarcacion`=marcaciones.id AND 
      marcaciones.`iddocente`=docentes.id AND
      concat(YEAR(fecha),'-',MONTH(fecha))='".$mes."' AND 
      docentes.id=".$iddocente." 
    ) order by fecha DESC;"; 
// run SQL statement
$result = mysqli_query($con,$sql);
  break;
    case 'POST':   
          break;
}

// die if SQL statement failed
if (!$result) {
  http_response_code(404);
  die(mysqli_error($con));
}
if ($method == 'GET') {
    if (!$id) echo '[';
    for ($i=0 ; $i<mysqli_num_rows($result) ; $i++) {
      echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
    }
    if (!$id) echo ']';
} elseif ($method == 'POST') {
  echo json_encode($result);
} else {
  echo mysqli_affected_rows($con);
}
$con->close();
?>