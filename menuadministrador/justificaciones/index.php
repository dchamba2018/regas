<!DOCTYPE html>
<html lang="en">
<?php 
  date_default_timezone_set('America/Guayaquil');
  setlocale(LC_TIME, 'spanish');  
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseMarcaciones.php";
   require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseUsuarios.php";
   require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseJustificaciones.php";
  setlocale(LC_ALL,"es_ES");  
  include "../../config/data.dc";
  include "../../config/fotos.php";
  session_start();
  $iddocente=$_SESSION['iddocente'];
  if (isset($_SESSION['iddocente'])) {
    $objDocente = new claseDocentes();  
    $docente=$objDocente->getDocente($iddocente);
    $foto= imagensuperiorsublinea($docente['foto']);
    $objMarcaciones = new claseMarcaciones();  
    $listaMeses=$objMarcaciones->getListaMeses();
    $objjustificaicones= new claseJustificaciones(); 
    $listajustificacionesPendientes=$objjustificaicones->getJustificacionesPendientesMes();
    $mesactual=date("m/Y");
    $ruta="../";
  }else{
    header('Location: ../../index.php');
  }
?>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="apple-touch-icon" sizes="76x76" href="../../img/favicon.png" />
  <link rel="icon" type="image/png" href="../../img/favicon.png" />
  <title><?php echo $titulo; ?></title>
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../../css/css.css" rel="stylesheet">
  <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
 
  <style type="text/css">
    [v-cloak] {
      display: none;
    }
  </style>
</head>
<body id="page-top">
  <div id="wrapper" >
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php 
        include "../menu.dc";
        ?>
        <div class="container-fluid" id="appJustificaciones" v-cloak>
          <h1 class="h3 mb-2 text-gray-800" id='print'>Reporte Mensual</h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary" id='print'>
                Justificaciones Realizadas
              </h6>
              <h6 class="m-0 font-weight-bold text-primary" id='print'>
                <select id="select" class="form-control" @change="onChange()">
                  <option selected disabled value="0">Seleccionar...</option>
                  <option v-for="estado in estados" v-bind:value="estado.value">{{ estado.text }}</option>
                </select>
              </h6> 
            </div>
             <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable"  cellspacing="0" style="width: 100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th  width="25%">Docente</th>
                      <th width="13%" style="text-align: center">Fecha</th>
                      <th>Justificar</th>
                      <th>Estado</th>
                      <th  width="13%"  >Observacion</th>
                      <th width="14%">Respaldo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(justificacion, index) in justificaciones">
                      <td style="font-size: 1vw; text-align: center">{{ index +1}}</td>
                      <td style="font-size: 1vw;">{{ justificacion.docente }}</td>
                      <td style="font-size: 1vw;">{{ justificacion.fecha }}</td>
                      <td style="font-size: 1vw; color: #539F02">{{ justificacion.tipo }}</td>
                      <td style="font-size: 1vw;">{{ justificacion.estado }}</td>
                      <td style="font-size: 1vw;">{{ justificacion.observacion }}</td>
                      <td style="font-size: 1vw; text-align: center">
                         <a title="Ver Archivo" class="btn btn-outline-primary" :href="'../../menudocente/archivos/'+justificacion.archivo" target="_blank">
                          <i class="fas fa-file-download"></i>
                        </a>
                        <a title="Justificar" class="btn btn-outline-success" :href="'../justificar.php?idma='+justificacion.id" v-if="justificacion.estado==='REVISION'">
                          <i class="fas fa-hand-point-left"></i>
                        </a>
                        <a title="Ver Solicitud" class="btn btn-outline-warning" :href="'../justificar.php?idma='+justificacion.id" v-else>
                          <i class="fas fa-hand-point-right"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- Footer -->
      <?php 
      include '../../footer.php';
      ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<?php 
include "../logout.php";
 ?>
 
  <script src="../../vendor/jquery/jquery.min.js"></script>
  <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../../js/sb-admin-2.min.js"></script>
  <script src="../../vendor/chart.js/Chart.min.js"></script>
  <script src="../../js/session.js"></script>
  <script src="../../vendor/jquery/jquery.blockUI1.js"></script>
  <script src="../../js/vue.js"></script>
  <script src="../../js/axios.min.js"></script>
  <script src="../../js/menu.js"></script> 
  <script src="../controller/contNotificaciones.js"></script>
  <script src="../../js/bloqueo.js"></script>
  <script src="../../js/bloqueapantalla.js"></script>
  <script src="../../js/sweetalert.min.js"></script>
  <script type="text/javascript" src="justificacionescontroller1.js"></script>
</body>
</html>
