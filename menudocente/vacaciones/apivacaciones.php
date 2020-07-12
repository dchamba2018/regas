<?php
include "../../config/conection.php";
session_start();
date_default_timezone_set('America/Guayaquil');
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
    $year=$_GET['year'];
    //$sql = "SELECT * from vacaciones WHERE(iddocente=".$iddocente." AND year(fecha)<=".$year.") order by fecha DESC;"; 
    $sql="SELECT id, desde, hasta, 
      IF(YEAR(desde)=".$year." AND YEAR(hasta)=".$year.", 
        DATEDIFF(hasta, desde)+1, 
        IF(YEAR(desde)=".$year." AND YEAR(hasta)!=".$year.",
          IFNULL(DATEDIFF('".$year."-12-31', desde)+1,0), 
          IFNULL(DATEDIFF(hasta, '".$year."-01-01')+1,0)
        )
      ) AS dias, 
      estado, respaldo FROM vacaciones WHERE(`iddocente`='".$iddocente."' AND (YEAR(desde)=".$year." OR YEAR(hasta)=".$year."));";
    // run SQL statement
    $result = mysqli_query($con,$sql);
    break;
  case 'POST': 
    include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/operaciones.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseVacaciones.php";
    $objVacaciones=new claseVacaciones();
    $idvacacion = $_POST["idvacacion"];
    if($idvacacion==0){
      $desde = $_POST["desde"];
      $hasta = $_POST["hasta"];

      $date1 = new DateTime($desde);
      $date2 = new DateTime($hasta);
      $diff = $date1->diff($date2);
      // will output 2 days
      $dias=$diff->days;
      if($desde>$hasta){
        $result="-1";
      }else{
        $dias=$dias+1;
        $fecha = date("Y-m-d H:i:s");
        $estado="REVISION";
      
        $archivo = $_FILES["file"]["tmp_name"]; 
        $tamanio=array();
        $tamanio = $_FILES["file"]["size"];
        $tipo = $_FILES["file"]["type"];
        $nombre_archivo = $_FILES["file"]["name"];
        if($tamanio>6048576){
          $result="-2";
        }else if($tipo=="image/jpg" || $tipo=="image/jpeg" || $tipo=="image/png" || $tipo=="image/gif" || $tipo=="application/pdf"){
          $nom_encriptado=md5($_FILES["file"]["tmp_name"]).".gif";
          if($tipo=="image/jpg"){
            $nom_encriptado=md5($_FILES["file"]["tmp_name"]).".jpg";
          }else if($tipo=="image/jpeg"){
            $nom_encriptado=md5($_FILES["file"]["tmp_name"]).".jpeg";
          }else if($tipo=="image/png"){
            $nom_encriptado=md5($_FILES["file"]["tmp_name"]).".png";
          }else if($tipo=="application/pdf"){
            $nom_encriptado=md5($_FILES["file"]["tmp_name"]).".pdf";
          }   
          $ruta="../archivos/".$nom_encriptado;
          move_uploaded_file($_FILES["file"]["tmp_name"], $ruta);   
          //actualizarimagen
          $objVacaciones->insertar($iddocente, $desde, $hasta, $dias, $fecha, $estado, $nom_encriptado);
          $result="0";
        }else{
          $result="-3";
        }  
      }
    }else{
      $objVacaciones->eliminar($idvacacion);
      $ruta="../archivos/".$_POST['respaldo'];
      unlink($ruta);
      $result="0";
    }  
    break;    
}
// die if SQL statement failed
if (!$result) {
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