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
    $iddocente=$_GET['iddocente'];
    $sql="SELECT * FROM docentes WHERE(`id`=".$iddocente.");";
    // run SQL statement
    $result = mysqli_query($con,$sql);
    break;
  case 'POST': 
    include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/operaciones.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";
    $objDocente=new claseDocentes();
    $iddocente = $_POST["iddocente"];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $celular = $_POST['celular'];
    $email = $_POST['email'];
    if(isset($_FOTO['file'])){
      $objDocente->actualizarDocenteVue($iddocente, $nombres, $apellidos, $celular, $email);
      $result="0";
    }else{
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
        $ruta="../../img/fotos/".$nom_encriptado;
        move_uploaded_file($_FILES["file"]["tmp_name"], $ruta);   
        //actualizarimagen
        $rutaeliminar="../../img/fotos/".$_POST['fotoanterior'];
        if($_POST['fotoanterior']!='foto.png'){
          unlink($rutaeliminar);
        }
        $objDocente->actualizarDocenteVueFoto($iddocente, $nombres, $apellidos, $celular, $email, $nom_encriptado);
        $result="0";
      }else{
        $result="-3";
      }
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