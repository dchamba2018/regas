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
// run SQL statement

switch ($method) {
  case 'GET':    
    $iddocente=$_SESSION['iddocente'];
    $fecha=$_GET['fecha'];
    $sql = "Select UPPER(concat(apellidos, ' ', nombres)) as docente,
    date(marcaciones.entrada) as fecha,
    time(marcaciones.entrada) as entrada,
    time(marcaciones.salida) as salida,
    marcaciones.observacion,
    marcaciones.id
    from marcaciones, docentes where (marcaciones.iddocente=docentes.id and date(entrada)='".$fecha."') order by apellidos";    
    break;
  case 'POST':
    $idmarcacion = $_POST["id"];
    $observacion = $_POST["observacion"];
    $fecha = @$_POST["fecha"];
    $entrada = @$_POST["entrada"];
    $entrada=$fecha.' '.$entrada;
    $salida = @$_POST["salida"];
    $salida=$fecha.' '.$salida;
    $sql = "Update marcaciones set entrada='$entrada', salida='$salida', observacion='$observacion' where id=$idmarcacion"; 
    break;
}
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