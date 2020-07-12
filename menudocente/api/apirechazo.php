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
        $idjustificacion=$_GET['idj'];
        $tipo=$_GET['tipo'];
        $sql = "SELECT justificaciones.tipo,
        justificaciones.motivo,
        justificaciones.estado,
        justificaciones.archivo,
        justificaciones.fecha,
        justificaciones.observacion,
        marcaciones.entrada, 
        marcaciones.salida,
        justificaciones.detalle,
        justificaciones.id
        from justificaciones, marcaciones
        where (idmarcacion=".$idjustificacion." and
        marcaciones.id=justificaciones.idmarcacion and justificaciones.tipo='".$tipo."') order by justificaciones.id desc limit 1;";       
        $result = mysqli_query($con,$sql);
      break;
    case 'POST':      
      $idjustificacion = $_POST["id"];
      $estado = 'REVISION';
      $newobservacion = $_POST["newobservacion"];
      $observacion = $_POST["observacion"];
      $docente = $_POST["docente"];
      $observacion=$observacion."<br>".$docente." escribío el ".date('Y-m-d')." a las ".date('H:i')."<br>".$newobservacion;
      include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/operaciones.php";
      require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseJustificaciones.php";
      $objJustificaciones=new claseJustificaciones();
      $archivo = $_FILES["file"]["tmp_name"]; 
      $tamanio=array();
      $tamanio = $_FILES["file"]["size"];
      $tipo = $_FILES["file"]["type"];
      $nombre_archivo = $_FILES["file"]["name"];
      if($archivo==""){
        $respuesta = $objJustificaciones->actualizarEstadoObservacionArchivo($idjustificacion, $estado, $observacion, "");
      }else if($tamanio>6048576){
        $respuesta=2;
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
        $respuesta = $objJustificaciones->actualizarEstadoObservacionArchivo($idjustificacion, $estado, $observacion, $nom_encriptado);
      }
      break;
}

// run SQL statement


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