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
require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseMarcaciones.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseHorarios.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseLaborables.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseJustificaciones.php";
$objlab = new claseLaborables(); 
$objMarcaciones = new claseMarcaciones(); 
$objHorario = new claseHorarios(); 
$objJustificaciones = new claseJustificaciones();  
$entrada='14:00:00';
$salida='22:30:00';
if(isset($horario['id'])){
  $entrada=$horario['entrada'];
  $salida=$horario['salida'];
}  
switch ($method) {
    case 'GET':      
        $mes=$_GET['mes'];
        $method="RETURN";
        $result=array();
        $listamarcaciones=$objMarcaciones->getMarcacionesDocenteMesDesc($_SESSION['iddocente'], $mes, $entrada, $salida);
        $fechaseleccionada = explode("/", $mes);
        $aux = date('Y-m-d', strtotime("{$mes} + 1 month"));
        $ultimodia = date('d', strtotime("{$aux} - 1 day"));
        if($fechaseleccionada[0]==date("m")){
          $ultimodia=date("d");
        }

        for ($i=$ultimodia*1; $i>0; $i--) { 
          $regitro=true;
          //primera columna
          $caption="../../img/fotos/foto.png";
          //segunda columna
          $fecha=date("Y-m")."-".$i;
          if($i<10){
            $fecha=date("Y-m")."-0".$i;
          }
          
          $dia=get_nombre_dia($fecha);
          //tercera columna          
          $marcacionentrada="";
          //COLUMNA ATRAZO
          $atraso="";
          $salida="";
          $observacion="";
          $latitud="";
          $longitud="";
          $idmarcacion="";
          $justificacion="";
          $idjustificacion="";
          $justificacionatrazo="";
          $idjustificacionatrazo="";
          $precision="";
          if($dia=="Domingo" || $dia=="Sabado"){
            $regitro=false;
          }else{
            foreach ( $listamarcaciones as $item ) {
              //buscara foto
              if($fecha==$item['fecha']){
                if($item['foto']!=""){
                  $caption="../../img/fotos/".$item['foto'];  
                  if(!file_exists($caption)){
                    $caption="../../img/fotos/foto.png";
                  }
                }
                $marcacionentrada=$item['entrada'];
                $atraso=$item['atrazo'];
                $salida=$item['salida'];
                $observacion=$item['observacion'];
                $dialaborable=$objlab->getRegistroNolaborable($item['fecha']);
                if(isset($dialaborable['id'])){
                  $observacion=$dialaborable['motivo'];
                }               
                $latitud=$item["lat"];
                $longitud=$item['longitud'];
                $precision=$item['precision1'];
                $idmarcacion=$item['id'];
                if($observacion=="ATRAZO"){                  
                  $justif=$objJustificaciones->getJustificacionesMarcacionTipo($idmarcacion, "ATRAZO");
                  if(isset($justif['id'])){
                    $justificacionatrazo=$justif['estado'];
                    $idjustificacionatrazo=$justif['id'];
                  }
                }else{
                  $justif=$objJustificaciones->getJustificacionesMarcacionTipo($idmarcacion, "ATRAZO");
                  if(isset($justif['id'])){
                    $justificacionatrazo=$justif['estado'];
                    $idjustificacionatrazo=$justif['id'];
                  }
                  $justif=$objJustificaciones->getJustificacionesMarcacionTipo($idmarcacion, $observacion);
                  if(isset($justif['id'])){
                    $justificacion=$justif['estado'];
                    $idjustificacion=$justif['id'];
                  }
                  
                }                

              }
            }  
          }
          if($observacion==""){
            $observacion="INASISTENCIA";
          } 
          

          //llenamos el array con los datos del mes
          if($regitro){
            $result[] = array(
              "caption"=>$caption, 
              "dia"=>$fecha,
              "entrada"=>$marcacionentrada,
              "atraso"=>$atraso,
              "salida"=>$salida, 
              "observacion"=>$observacion,
              "latitud"=>$latitud,
              "longitug"=>$longitud,
              "idmarcacion"=>$idmarcacion,
              "justificacionatrazo"=>$justificacionatrazo,
              "idjustificacionatrazo"=>$idjustificacionatrazo,
              "justificacion"=>$justificacion,
              "idjustificacion"=>$idjustificacion,
              "precision"=>$precision
            );
          }          
        }
      break;
    case 'POST':      
      break;
}

// die if SQL statement failed
if (!$result) {
  http_response_code(404);
  die(mysqli_error($con));
}
if($method == 'RETURN'){
  echo json_encode($result);
}else if ($method == 'GET') {
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
function get_nombre_dia($fecha){
  $fechats = strtotime($fecha); //pasamos a timestamp
  switch (date('w', $fechats)){
      case 0: return "Domingo"; break;
      case 1: return "Lunes"; break;
      case 2: return "Martes"; break;
      case 3: return "Miercoles"; break;
      case 4: return "Jueves"; break;
      case 5: return "Viernes"; break;
      case 6: return "Sabado"; break;
  }
}
?>