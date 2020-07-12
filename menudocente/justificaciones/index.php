<!DOCTYPE html>
<html lang="en">
<?php 
  date_default_timezone_set('America/Guayaquil');
  setlocale(LC_TIME, 'spanish');  
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseMarcaciones.php";
   require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseUsuarios.php";
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
  <script src="../../js/vue.js"></script>
  <script src="../../js/axios.min.js"></script>
    
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
            </div>
             <div class="card-body">
              <div class="table-responsive">
                <div class="row">
                  <div class="col-sm-3 col-md-3 col-lg-3 col-xs-12">
                    <input size="16" type="month" step="1" @change="listarJutificaciones" class="form-control" v-model="fechas" >
                  </div>
                </div>
                
              </div>
              <hr>
              <div class="table-responsive">
                <table class="table table-striped" id="dataTable"  cellspacing="0" style="width: 100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Fecha</th>
                      <th>Motivo</th>
                      <th>Estado</th>
                      <th>Respaldo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(justificacion, index) in justificaciones" :class="devuelvecolor(justificacion)">
                      <td style="text-align: center">{{ index +1}}</td>
                      <td >{{ justificacion.fecha }}</td>
                      <td >{{ justificacion.motivo }}
                        <p v-if="justificacion.estado==='NEGADO'"><br>
                          <b>DETALLE: </b>{{justificacion.observacion}}</p>
                      </td>
                      <td ><b>{{justificacion.tipo}} =></b> {{ justificacion.estado }}</td>
                      <td style="text-align: center">
                         <a title="Ver Archivo" :href="'../archivos/'+justificacion.archivo" target="_blank">
                          <i class="fas fa-file-download" style="font-size: 20px"></i>
                        </a>
                      </td>
                    </tr>
                    <tr v-if="justificaciones.length==0">
                      <td colspan="5">Seleccione el mes de busqueda para revisar las justificaciones!</td>
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
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="../../js/sb-admin-2.min.js"></script>
  <script src="../../vendor/chart.js/Chart.min.js"></script>
  <script src="../../js/session.js"></script>
  <script src="../../vendor/jquery/jquery.blockUI1.js"></script>
  <script src="../../js/bloqueo.js"></script>
  <script src="../../js/bloqueapantalla.js"></script>
  <script src="../../js/sweetalert.min.js"></script>
  <script src="../../js/fechas.js?id=<?php echo time(); ?>"></script>

  <script src="../../js/menu.js"></script>
  <script type="text/javascript" src="justificacionescontroller.js?id=<?php echo time(); ?>"></script>
  
</body>
</html>
