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
          <h1 class="h3 mb-2 text-gray-800" id='print'>Fechas No Laborables</h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary" id='print'>
                Listado de fechas suspendidas para claseDocentes
              </h6>
            </div>
             <div class="card-body">
              <div class="table-responsive" v-if="nuevo">
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label">Motivo:</label>
                  <div class="col-lg-10">
                      <input v-model="id" type="hidden" class="form-control" placeholder="Motivo">
                      <input v-model="motivo" type="text" class="form-control" placeholder="Motivo">
                  </div>
                </div>
                <hr>
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label">Inicio:</label>
                  <div class="col-lg-4">
                      <input v-model="inicio" type="date" name="inicio" placeholder="Inicio"  class="form-control">
                  </div>
                  <label class="col-lg-2 col-form-label">Fin:</label>
                  <div class="col-lg-4">
                      <input v-model="fin" type="date" name="fin" placeholder="Fin"  class="form-control">
                  </div>
                </div> 
                <div class="form-group row">
                  <div class="col" align="right">
                    <button @click="guardaregistro('update')" class="btn btn-primary">Guardar</button>  
                    <button @click="guardaregistro('delet')" class="btn btn-danger" v-if="id!=0">Eliminar</button>  
                    <button @click="nuevoregistro()" class="btn btn-success">Cancelar</button> 
                  </div>                  
                </div>
              </div>
              <div class="table-responsive" v-else>
                <div class="row">
                  <div class="col-sm-8 col-md-8 col-lg-8">
                     <button @click="nuevoregistro()" class="btn btn-success">Nuevo Registro</button>
                  </div>
                  <div class="col-sm-4 col-md-4 col-lg-4">
                    <select class="form-control" v-model="txtanio" @change="listarJutificaciones">
                      <?php 
                        for($anio=2019; $anio<=date('Y'); $anio++){
                          echo "<option value='".$anio."'>".$anio."</option>";  
                        }
                      ?>
                    </select>
                  </div>
                </div>
               
                
                <hr>
                <table class="table table-bordered" id="dataTable"  cellspacing="0" style="width: 100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Desde</th>
                      <th width="13%" style="text-align: center">Hasta</th>
                      <th>Motivo</th>
                      <th width="24%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(dianolab, index) in laborables">
                      <td style="font-size: 1vw; text-align: center">{{ index +1}}</td>
                      <td style="font-size: 1vw;">{{ dianolab.inicio }}</td>
                      <td style="font-size: 1vw;">{{ dianolab.fin }}</td>
                      <td style="font-size: 1vw; color: #539F02">{{ dianolab.motivo }}</td>
                      <td style="font-size: 1vw; text-align: center">
                        <a title="Editar" class="btn btn-outline-primary" @click="editarregistro(dianolab)" >
                          <i class="fas fa-edit"></i>
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
  <script src="../../js/bloqueo.js"></script>
  <script src="../../js/bloqueapantalla.js"></script>
  <script src="../../js/vue.js"></script>
  <script src="../../js/axios.min.js"></script>
  <script src="../controller/contNotificaciones.js"></script>
  <script src="../../js/sweetalert.min.js"></script>
  <script src="../../js/fechas.js"></script>
  <script src="../../js/menu.js"></script>
  <script type="text/javascript" src="laborablescontroller3.js?id=<?php echo time(); ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
</body>
</html>
