<?php
include "../config/conection.php";
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
switch ($method) {
    case 'GET':      
        $iddocente=$_GET['iddocente'];
        $sql = "SELECT * FROM marcaciones WHERE(iddocente=".$iddocente." and date(entrada)='".date("Y-m-d")."');";  
        $result = mysqli_query($con,$sql);
      break;
    case 'POST':   
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/operaciones.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseMarcaciones.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";
        $objmarcaciones=new claseMarcaciones();
        $objDocente = new claseDocentes();     
      if(isset($_POST['idmarcacion'])){
        $result=$objmarcaciones->actualizarFoto($_POST['idmarcacion'], $_POST['foto']);
      }else{
        include "../mail.php";
        $iddocente = $_POST["iddocente"];
        $observacion = $_POST["observacion"];
        $lat=$_POST["latitud"];
        $long=$_POST["longitud"];
        $precision=$_POST["precision"];
        $ip=getRealIP();
        $foto=$_POST["foto"];
        $idmarcacion=$_POST['idmarca'];
        
        if($observacion=="ENTRADA"){
          $result=$objmarcaciones->actualizarEntrada(date("Y-m-d H:i:s"), $lat, $long, $ip, $observacion, $precision, $foto, $idmarcacion);
        }else{
          $result=$objmarcaciones->actualizarSalida(date("Y-m-d H:i:s"), $lat, $long, $ip, $observacion, $precision, $foto, $idmarcacion);
        }
        //enviar correo
        
        $docente=$objDocente->getDocente($iddocente);
        $marca=$objmarcaciones->getMarcacion($iddocente, date('Y-m-d'));
        $para = $docente['email'];
        $mensaje = crearplantillaEntrada($docente, $marca, $observacion);
        $cabeceras = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $cabeceras .= 'From: admin@ikerany.com';
        $titulo="CONFIRMACION DE ASISTENCIA";
        $enviado = mail($para, $titulo, $mensaje, $cabeceras);     
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