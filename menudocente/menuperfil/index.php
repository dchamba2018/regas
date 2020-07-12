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
          <h3 class="h5 mb-2 text-gray-800" id='print'><?php echo $docente['nombres']." ".$docente['apellidos'] ?></h3>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary" id='print'>
                Verifique su información!
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive mt-1">
                <div class="form-group row">
                  <div class="col-sm-6 inline">
                    <input ref="iddocente" value="<?php echo $docente['id'] ?>" style='display:none;'></input>
                    <label for="txtcedula">Cedula: </label>
                    <input type="text" class="form-control form-control-user" name="txtcedula" placeholder="Cedula" v-model="docente[0].cedula" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="txtnombre">Nombres: </label>
                    <input type="text" class="form-control form-control-user" name="txtnombres" placeholder="Nombres"  v-model="docente[0].nombres">
                  </div>
                  <div class="col-sm-6">
                    <label for="txtapellidos">Apellidos: </label>
                    <input type="text" class="form-control form-control-user" id="txtapellidos" placeholder="Apellidos" v-model="docente[0].apellidos">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6">
                    <label for="txtemail">Email: </label>
                    <input type="email" class="form-control form-control-user" name="txtemail" placeholder="Dirección Email" v-model="docente[0].email">
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="txttelefono">Telefono: </label>
                    <input type="text" class="form-control form-control-user" name="txttelefono" placeholder="Telefono" v-model="docente[0].celular">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0 col-lg-3">
                    <input type="file" name="" style='color: red;' accept="image/*" 
                    @change="onFileSelected"
                    onchange="Loadfile(event)">
                    <label class="col-lg-12 col-form-label">Seleccione Su Imagen de Perfil!:</label>
                    <div align="center">
                        <img id="output"  style="max-height:100%; height:100%; max-width: 100%; width: 100%" v-bind:src="'../../img/fotos/'+docente[0].foto"/>
                    </div>
                  </div>  
                </div>
                <div class="form-group row">
                  <div class="col-sm-4 mb-3 mb-sm-0 col-lg-3">
                     <button @click='guardar' class="btn btn-primary">Actualizar</button>
                     <a href="../" class="btn btn-danger">Atras</a>
                  </div>
                  <div class="col-sm-8 mb-3 mb-sm-0 col-lg-3">
                  </div>
                    
                </div>
                       
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
  <script src="../../js/menu.js"></script>
  <script src="../../js/axios.min.js"></script>
  <script type="text/javascript" src="perfilcontroller.js?id=<?php echo time(); ?>"></script>
  
</body>
</html>
