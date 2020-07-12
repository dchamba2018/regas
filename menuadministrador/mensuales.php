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
  include "../config/data.dc";
  include "../config/fotos.php";
  session_start();
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
    $objMarcaciones = new claseMarcaciones();  
    $listaMeses=$objMarcaciones->getListaMeses();
    $mesactual=date("m/Y");
    $listaDocentes=$objDocente->getDocentes("ACTIVO");
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
  <style type="text/css">
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
        <div class="container-fluid">
          <h1 class="h3 mb-2 text-gray-800" id='print'>Reporte Mensual</h1>
          <p class="mb-4" id='print'>Resumen de asistencias registradas durante el mes seleccionado!.</p>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary" id='print'>
                <select class="form-control" id="txtmes">
                  <option value="0">Seleccione un mes</option>
                  <?php 
                  if(count($listaMeses)>0){
                      foreach ( $listaMeses as $item){
                        if($item['meses']==$mesactual || '0'.$item['meses']==$mesactual){
                          echo "<option value='".$item['meses']."' selected>".$item['meses']."</option>";
                        }else{
                          echo "<option value='".$item['meses']."'>".$item['meses']."</option>";
                        }
                      }
                    }
                  ?>
                </select>
              </h6>  
              <div class="dropdown no-arrow" id='print'>
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-users-cog fa-sm fa-fw text-gray-400"></i> Seleccione un docente!
                  </a>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Docentes:</div>
                    <?php 
                      if(count($listaDocentes)>0){
                        foreach ( $listaDocentes as $item){
                          echo "<a class='dropdown-item' href='#' onclick='cargarReporte(".$item['id'].")'>👨‍🏫 ".strtoupper($item['apellidos'])." ". strtoupper($item['nombres'])."</a>";
                        }
                      }
                    ?>
                  </div>
                </div>
            </div>
            <div class="row" id="encabezado" style="width: 100%" align="center">
              <p><h2>INSTITUTO SUPERIOR TECNOLÓGICO PRIMERO DE MAYO</h2></p>
              <p><h6>ASIS-DOCENTES</h6></p>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <div class="row" id="tablaencabezado">
                  
                </div>
                <table class="table table-bordered" id="dataTable"  cellspacing="0">
                  <thead>
                    <tr>
                      <th>Fecha</th>
                      <th>Entrada</th>
                      <th>Atrazos</th>
                      <th>Salida</th>
                      <th>Observación</th>
                    </tr>
                  </thead>
                  <tbody id='tablareporte'>
                     
                  </tbody>
                </table>
              </div>
              <hr>
              FIRMA RESPONSABLE.<br>
              <?php echo $docente['nombres']." ".$docente['apellidos']."<br>
              ".date('Y-m-d H:i:s');?>
              <br>
              <a id='print'  class="btn btn-success btn-sm" href='javascript:window.print()'><i class="fa fa-print"></i> Imprimir</a>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php 
      include '../footer.php';
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
include "logout.php";
 ?>
 
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/sb-admin-2.min.js"></script>
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="../js/session.js"></script>
  <script src="metodos/metmensuales2.js?id=<?php echo time(); ?>"></script>
  <script src="../vendor/jquery/jquery.blockUI1.js"></script>
  <script src="../js/bloqueo.js"></script>
  <script src="../js/bloqueapantalla.js"></script>
<script src="../js/vue.js"></script>
  <script src="../js/axios.min.js"></script>
  <script src="../js/menu.js"></script> 
  <script src="controller/contNotificaciones.js"></script>
  <script src="../js/sweetalert.min.js"></script>
</body>

</html>
