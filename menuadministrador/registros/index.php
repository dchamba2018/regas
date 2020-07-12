<!DOCTYPE html>
<html lang="en">
<?php 
  date_default_timezone_set('America/Guayaquil');
  setlocale(LC_TIME, 'spanish');  
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";
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
          <h1 class="h3 mb-2 text-gray-800" id='print'>Registros diarios</h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary" id='print'>
                Seleccione la fecha actual
              </h6>
              <h6 class="m-0 font-weight-bold text-primary" id='print'>
                <div class="input-group">
                  <input type="date" class="form-control" id="txtfecha" placeholder="<?php echo date("Y-m-d") ?>" aria-describedby="inputGroupPrepend2" @change="listarRegistros" required v-model="fecha">
                  <div class="input-group-prepend">
                      <button type="button" @click="listarRegistros" class="btn btn-success" ><i class="fas fa-search"></i></button>
                  </div>                    
                </div>
              </h6> 
            </div>
             <div class="card-body">
              <div class="table-responsive" v-if="!editar">
                <table class="table table-bordered" id="dataTable"  cellspacing="0" style="width: 100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th  width="35%">Docente</th>
                      <th  width="15%">Fecha</th>
                      <th width="13%" style="text-align: center">Entrada</th>
                      <th>Salida</th>
                      <th  width="13%">Observacion</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(reg, index) in registros" style="color: black;" :class="devuelvecolor(reg)">
                      <td style=" text-align: center">{{ index +1}}</td>
                      <td style="">{{ reg.docente }}</td>
                      <td style="">{{ reg.fecha }}</td>
                      <td >{{ reg.entrada }}</td>
                      <td >{{ reg.salida }}</td>
                      <td >{{ reg.observacion }}</td>
                      <td style=" text-align: center">
                        <button type="button" @click="editarRegistro(reg)" class="btn btn-success btn-sm" ><i class="fas fa-edit"></i></button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="table-responsive" v-else>
                <form action="" class="text-center">
                  <div class="modal-body">
                    <div class="form-group row">
                      <label class="col-2 col-form-label">Docente:</label>
                      <div class="col-10">
                          <input v-model="docente" type="text" class="form-control" placeholder="Nombre" readonly>
                      </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                      <label class="col-lg-2 col-form-label">Entrada:</label>
                      <div class="col-lg-2">
                          <input v-model="entrada" type="time"  class="form-control">
                      </div>
                      <label class="col-lg-2 col-form-label">Salida:</label>
                      <div class="col-lg-2">
                          <input v-model="salida" type="time"  class="form-control">
                      </div>
                      <div class="col-lg-4">
                        <select class="form-control" id="txtobservacion" name="txtobservacion" v-model="observacion">
                        <option value="INASISTENCIA">INASISTENCIA</option>
                        <option value="ENTRADA">ENTRADA</option>
                        <option value="SALIDA">SALIDA</option>
                        <option value="JUSTIFICADA">JUSTIFICADA</option>
                      </select>
                      </div>
                      
                    </div> 
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cancelarRegistro()">Cancelar</button>
                    <input @click="guardarRegistro" class="btn btn-success" type="button" value="Guardar" class="btn btn-success" >
                  </div>
                </form>
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
  <script src="../../js/bloqueo.js"></script>
  <script src="../../js/bloqueapantalla.js"></script>
  <script src="../../js/sweetalert.min.js"></script>
<script src="../../js/vue.js"></script>
  <script src="../../js/axios.min.js"></script>
  <script src="../../js/menu.js"></script> 
  <script src="../controller/contNotificaciones.js"></script>
  <script type="text/javascript" src="registros4.js?id=<?php echo time(); ?>"></script>
</body>
</html>
