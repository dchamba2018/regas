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
    $sql = "select concat( docentes.apellidos,' ',docentes.nombres) as docentes,
    SUM(vacaciones.dias) AS dias
    from docentes, vacaciones where(
        docentes.id=vacaciones.iddocente and
        year(vacaciones.hasta)=".$_GET['anio']." and 
        vacaciones.estado='APROBADO' and
        docentes.estado='ACTIVO'
    ) 
    GROUP BY docentes.id ORDER BY docentes.apellidos"; 
  // run SQL statement
    $result = mysqli_query($con,$sql);
    break;  
  case 'POST': 
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