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
$estado=$_GET['estado'];
$sql = "SELECT CONCAT(`docentes`.`nombres`, ' ', `docentes`.`apellidos`) AS docente, justificaciones.id, fecha, motivo, archivo, justificaciones.estado, justificaciones.observacion, justificaciones.tipo FROM justificaciones, `marcaciones`, docentes 
WHERE(justificaciones.`idmarcacion`=marcaciones.id AND marcaciones.`iddocente`=docentes.id and justificaciones.estado='".$estado."') order by fecha DESC;"; 
// run SQL statement
$result = mysqli_query($con,$sql);

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