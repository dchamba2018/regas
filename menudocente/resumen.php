<!DOCTYPE html>
<html lang="en">
<?php 
  date_default_timezone_set('America/Guayaquil');
  setlocale(LC_TIME, 'spanish');  
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseMarcaciones.php";
   require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseUsuarios.php";
  setlocale(LC_ALL,"es_ES");  
  include "../config/data.dc";
  include "../config/fotos.php";
  session_start();
  $iddocente=$_SESSION['iddocente'];
  if (isset($_SESSION['iddocente'])) {
    $objDocente = new claseDocentes();  
    $docente=$objDocente->getDocente($iddocente);
    $foto= imagensuperiorsublinea($docente['foto']);
    $objMarcaciones = new claseMarcaciones();  
    $listaMeses=$objMarcaciones->getListaMeses();
    $mesactual=date("m/Y");
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
</head>
<body id="page-top" onload="cargarReporte(<?php echo $iddocente ?>)">
  <div id="wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php 
        include "menu.dc";
        ?>
        <div class="container-fluid">
          <h1 class="h3 mb-2 text-gray-800" id='print'>Reporte Mensual</h1>
         
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary" id='print'>
                <select class="form-control" id="txtmes" onclick="cargarReporte(<?php echo $iddocente; ?>)">
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
            </div>
             <div class="card-body">
              <div class="table">
                <table class="table table-bordered" id="dataTable"  cellspacing="0">
                  <thead>
                    <tr>
                      <th>Capture</th>
                      <th>Fecha</th>
                      <th>Entrada</th>
                      <th>Atrasos</th>
                      <th>Salida</th>
                      <th>Observación</th>
                      <th>Mapa</th>
                    </tr>
                  </thead>
                  <tbody id='tablareporte'>
                     
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
      <div class="modal fade" id="ModalAtrazo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="titulomodal"></h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <form name="formulario-envia" id="formulario-envia" enctype="multipart/form-data" method="post">
            <div class="modal-body">          
              <div class="form-group row">
                  <label class="col-lg-2 col-form-label">Motivo:</label>
                  <div class="col-lg-10">
                      <input type="hidden"  class="form-control" id="txtidreg" name="txtidreg">
                      <input type="hidden"  class="form-control" id="txttipo" name="txttipo">
                      <input type="text"  class="form-control" id="txtmotivo" name="txtmotivo">
                  </div>
              </div>
              <div class="form-group row">
                  <label class="col-lg-2 col-form-label">Detalle:</label>
                  <div class="col-lg-10">
                     <textarea class="form-control" rows="4" aria-label="With textarea" id="txtdetalle" name="txtdetalle"></textarea>
                  </div>
              </div>
              <div class="form-group row">
                  <label class="col-lg-2 col-form-label">Respaldo:</label>
                  <div class="col-lg-12">
                      <input type="file" title="Acta defunción" class="form-control" id='txtarchivo' name="txtarchivo">
                  </div>
              </div>    
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="button" onclick="procesarAtrazo()">Justificar</button>
            </div>
          </form>
          </div>
        </div>
      </div>
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
  <script src="metodos/metresumen5.js"></script>
  <script src="../vendor/jquery/jquery.blockUI1.js"></script>
  <script src="../js/bloqueo.js"></script>
  <script src="../js/bloqueapantalla.js"></script>
  <script src="../js/sweetalert.min.js"></script>
</body>


</html>
