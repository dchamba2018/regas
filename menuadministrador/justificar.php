<!DOCTYPE html>
<html lang="en">
<?php 
  date_default_timezone_set('America/Guayaquil');
  setlocale(LC_TIME, 'spanish');  
  session_start();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseUsuarios.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseJustificaciones.php";
  include "../config/data.dc";
  include "../config/fotos.php";
  $iddocente=$_SESSION['iddocente'];
  if (isset($_SESSION['iddocente'])) {
    $objusuario = new claseUsuarios();
    $usuario=$objusuario->getUsuarioDocente($iddocente);
    if($usuario['rol']!="ADMINISTRADOR"){
      header('Location: ../index.php');
    }
    $objDocente = new claseDocentes();  
    $docente=$objDocente->getDocente($iddocente);
    $foto= imagensuperiorsublinea($docente['foto']);
    $objjustificaicones= new claseJustificaciones();  
    $listajustificacionesPendientes=$objjustificaicones->getJustificacionesPendientesMes();
  }else{
    //header('Location: ../index.php');
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
          <input type="hidden" ref="idmarcacion" value="<?php echo @$_GET['idma'] ?>">
          <div class="row" id="encabezado" style="width: 100%" align="center">
            <p><h2>INSTITUTO SUPERIOR TECNOLÓGICO PRIMERO DE MAYO</h2></p>
            <p><h6>ASIS-DOCENTES</h6></p>
            <hr class="text-primary" style="height: 2px">
          </div>
          <div  v-for="(objDocente, index) in docentes">                      
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">JUSTIFICACION DE  {{objDocente.op}}</h1>
            <p class="mb-4" >
            Docente: {{objDocente.docente}}</p>
            <div class="row">
              <div class="col-lg-6">
                <div class="card mb-4">
                  <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Motivo: {{objDocente.motivo}}</h6>  
                  </div>
                  <div class="card-body">
                    <h6 class="text-success"><b>Estado: </b>{{objDocente.estado}}</h6>
                    <h6 class="text-default"><b>Fecha de solicitud:</b> {{objDocente.fecha}}</h6>
                    <h6 class="text-danger" v-if="objDocente.op === 'ATRAZO'"><b>{{objDocente.op}}:</b> [{{objDocente.entrada}}] </h6>
                    <h6 class="text-danger" v-else="objDocente.estado === 'ABANDONO'"><b>{{objDocente.op}}:</b> {{objDocente.salida}} </h6>
                    <hr>
                    <h6 class="text-primary"><b>JUSTIFICACION:</b> {{objDocente.detalle}} </h6>
                    <h6 class="text-primary">OBSERVACION</h6>
                    <textarea class="form-control" rows="3" aria-label="With textarea" v-model='txtobservacion' @keyup="escribir" v-if="objDocente.estado==='REVISION'"></textarea>    
                    <h6 v-else>{{objDocente.observacion}}</h6>
                    <br>
                    <div class="btn-group row" aria-label="Basic example" id="print">
                      <div class="col-12" v-if="objDocente.estado==='REVISION'" align="center">
                        <button type="button" @click="JustificarAsistencia" class="btn btn-success" ><i class="far fa-check-circle"></i> Justificar</button>
                        <button type="button" @click="RechazarAsistencia" class="btn btn-danger" ><i class="far fa-times-circle"></i> Rechazar</button>
                        <a class="btn btn-info" href='justificaciones/'>
                          <i class="fas fa-arrow-circle-left"></i> Cancelar</a>     
                      </div>     
                      <div class="col-12" v-else>
                        <a class="btn btn-success" href='javascript:window.print()'>
                          <i class="fa fa-print"></i> Imprimir</a>
                        <a class="btn btn-info" href='justificaciones/'>
                          <i class="fas fa-arrow-circle-left"></i> Cancelar</a>                           
                      </div>                  
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="card mb-4">
                  <div class="card-header">
                      <h6 class="m-0 font-weight-bold text-primary">Archivo de Justificación</h6>  
                  </div>
                  <div class="card-body" style="max-height: 530px; height: 500px;">
                    <p v-if="objDocente.archivo!=''" >
                      <embed v-bind:src="'../menudocente/archivos/'+objDocente.archivo" style="width: 100%; text-align: center; height: 480px;" >  
                    </p>
                  </div>
                  <div class="card-footer" id="print">
                    <a title="Descargar" class="btn btn-outline-primary" :href="'../menudocente/archivos/'+objDocente.archivo" target="_blank">
                          <i class="fas fa-file-download"></i> Descargar
                        </a>
                  </div>
                </div>
              </div>
              
            </div>
            <br>
             <div class="row" id="encabezado">
              FIRMA DOCENTE.
              <br>
                {{objDocente.docente}}
              <br><br><br><hr>
              FIRMA RESPONSABLE.<br>
                <?php echo $docente['nombres']." ".$docente['apellidos'];?>

              
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
  <script src="../js/vue.js"></script>
  <script src="../js/axios.min.js"></script>
  <script src="../js/menu.js"></script> 
  <script src="controller/contNotificaciones.js"></script>
  <script type="text/javascript" src="controller/justificarDocente5.js?id=<?php echo time(); ?>"></script>
</body>

</html>
