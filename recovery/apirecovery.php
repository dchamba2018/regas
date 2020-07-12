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
      if(isset($_GET['clave'])){
        include "../mail.php";
        $clave=base64_decode($_GET['clave']);
        $correo=$_GET['correo'];
        $mensaje = crearplantillaContraseña($clave, $correo);
        $cabeceras = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $cabeceras .= 'From: admin@ikerany.com';
        $titulo="RECUPERACION DE CLAVE";
        $enviado = mail($correo, $titulo, $mensaje, $cabeceras);  
        $result="0";        
      }else{
        $correo=$_GET['correo'];
        $cedula=$_GET['cedula'];
        $sql = "SELECT PASSWORD as clave FROM `usuarios`, `docentes` WHERE(cedula='".$cedula."' AND usuarios.`email`='".$correo."')";   
        $result = mysqli_query($con,$sql);
      }
      break;
    case 'POST':      
      break;
}
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