<!DOCTYPE html>
<html lang="en">
<?php 
  date_default_timezone_set('America/Guayaquil');
  setlocale(LC_TIME, 'spanish');  
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseUsuarios.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseJustificaciones.php";
  setlocale(LC_ALL,"es_ES");  
  include "../config/data.dc";
  include "../config/fotos.php";
  session_start();
  $iddocente=$_SESSION['iddocente'];
  if (isset($_SESSION['iddocente'])) {
    $objusuario = new claseUsuarios();
    $usuario=$objusuario->getUsuarioDocente($iddocente);
    $objDocente = new claseDocentes();  
    $docente=$objDocente->getDocente($iddocente);
    $foto= imagensuperiorsublinea($docente['foto']);
    $objjustificaicones= new claseJustificaciones();  
    $listajustificacionesPendientes=$objjustificaicones->getJustificacionesPendientesMes();
  }else{
    header('Location: ../index.php');
  }
?>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="apple-touch-icon" sizes="76x76" href="../img/favicon.png" />
  <link rel="icon" type="image/png" href="../img/favicon.png" />
  <title><?php echo $titulo; ?></title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../css/css.css" rel="stylesheet">
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <script src="../js/vue.js"></script>
  <script src="../js/axios.min.js"></script>
  <style type="text/css">
    [v-cloak] {
      display: none;
    }
    #encabezado {display:none} 
    @media print {
      #print {display:none;}     
      #encabezado {display:block} 
      #accordionSidebar{display:none}
    }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php 
        include "menu.dc";
        ?>
        <div class="container-fluid" id="appJustificacion" v-cloak>
          <input type="hidden" ref="idmarcacion" value="<?php echo @$_GET['idj'] ?>">
          <input type="hidden" ref="tipo" value="<?php echo @$_GET['tipo'] ?>">
          <input type="hidden" ref="docente" value="<?php echo $docente['nombres']." ".$docente['apellidos'] ?>">
          <div class="row" id="encabezado" style="width: 100%" align="center">
            <p><h2>INSTITUTO SUPERIOR TECNOLÓGICO PRIMERO DE MAYO</h2></p>
            <p><h6>ASIS-DOCENTES</h6></p>
            <hr class="text-primary" style="height: 2px">
          </div>
          <div  v-for="(objJustificacion, index) in justificaciones">                      
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">JUSTIFICACION DE  {{objJustificacion.tipo}}</h1>
            <p class="mb-4" >
            <div class="row">
              <div class="col-lg-6">
                <div class="card mb-4">
                  <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Motivo: {{objJustificacion.motivo}}</h6>  
                  </div>
                  <div class="card-body">
                    <h6 class="text-success"><b>Estado: </b>{{objJustificacion.estado}}</h6>
                    <h6 class="text-default"><b>Fecha de solicitud:</b> {{objJustificacion.fecha}}</h6>
                    <h6 class="text-danger" v-if="objJustificacion.op === 'ATRAZO'"><b>{{objJustificacion.obervacion}}:</b> [{{objJustificacion.entrada}}] </h6>
                    <h6 class="text-danger" v-else="objJustificacion.estado === 'ABANDONO'"><b>{{objJustificacion.observacion}}:</b> {{objJustificacion.salida}} </h6>
                    <hr>
                    <h6 class="text-primary">JUSTIFICACION</h6>                    
                    {{objJustificacion.detalle}} 
                    <hr>
                    <h6 class="text-primary">OBSERVACION: </h6>
                    <p class="text-danger">{{objJustificacion.observacion}}</p>
                    <hr>
                    <h6 class="text-primary">RESPONDER: </h6>
                    <textarea class="form-control" rows="2" aria-label="With textarea" v-model='txtobservacion'></textarea>    
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="card mb-4">
                  <div class="card-header">
                      <h6 class="m-0 font-weight-bold text-primary">Archivo de Justificación</h6>  
                  </div>
                  <div class="card-body">
                    <p v-if="objJustificacion.archivo!=''" >
                      <embed v-bind:src="'../menudocente/archivos/'+objJustificacion.archivo" style="width: 100%; text-align: center;">  
                    </p>
                    <div class="form-group row" v-else>
                        <div class="col-lg-12">
                            <img src="" width="100%" id="output">
                            <input type="file" name="image" @change="getImage" accept="image/*" class="form-control" onchange="Loadfile(event)">
                        </div>
                    </div>
                    <div class="btn-group row" aria-label="Basic example" id="print">
                      <div class="col-12" align="center">
                        <button type="button" @click="ReplicarAsistencia" class="btn btn-success" ><i class="far fa-check-circle"></i> REPLICAR SOLICITUD</button>
                        <a class="btn btn-info" href='resumen.php'>
                          <i class="fas fa-arrow-circle-left"></i> Cancelar</a>     
                      </div>                     
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
      <?php 
      include '../footer.php';
      ?>
    </div>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <?php 
  include "logout.php";
  ?>
  </div>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/sb-admin-2.min.js"></script>
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="../js/session.js"></script>
  <script src="../vendor/jquery/jquery.blockUI1.js"></script>
  <script src="../js/bloqueo.js"></script>
  <script src="../js/bloqueapantalla.js"></script>
  <script src="../js/sweetalert.min.js"></script>
  <script type="text/javascript" src="controller/rechazocontroller2.js"></script>
  <script type="text/javascript">
  var Loadfile=function(event){ // archivo cargado
    var reader = new FileReader();
    reader.onload=function(){
      var output=document.getElementById("output");
      output.src=reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
</script>
</body>

</html>
