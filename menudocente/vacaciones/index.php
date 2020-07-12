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
          <h1 class="h3 mb-2 text-gray-800" id='print'>Registro Vacaciones</h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary" id='print'>
                Seleccione el año para ver sus días de vacaciones!
              </h6>
              <h6 class="m-0 font-weight-bold text-primary" id='print'>
                <div class="input-group">
                  <input type="number" min='2019' class="form-control" id="txtyear" aria-describedby="inputGroupPrepend2" required v-model="year" @change='listarVacaciones'>
                  <div class="input-group-prepend">
                      <button type="button" @click="listarVacaciones" class="btn btn-success" ><i class="fas fa-search"></i></button>
                  </div>                    
                </div>
              </h6> 
            </div>
            <div class="card-body" v-if="form">
                <div class="form-group row">                  
                  <div class="col-lg-12">
                      <h3>Complete la información!</h3>
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-2 col-form-label">Fecha Desde:</label>
                    <div class="col-lg-4">
                       <input type='date' class="form-control" v-model="desde" />
                    </div>
                    <label class="col-lg-2 col-form-label">Fecha hasta:</label>
                    <div class="col-lg-4">
                       <input type='date' class="form-control" v-model="hasta" />
                    </div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-2 col-form-label">Respaldo:</label>
                    <div class="col-lg-12 text-center" >
                        <img src="" width="50%" id="output">
                        <input type="file" @change="getImage" name="image" accept="application/pdf,image/*" class="form-control" onchange="Loadfile(event)">
                    </div>
                </div> 
                <div class="form-group row">
                  <div class="col" align="right" v-if="botonguardar">
                    <button type="button" @click="registrarVacaciones" class="btn btn-danger" ><i class="fas fa-trash"></i> CANCELAR</button>  
                  </div>
                  <div class="col" v-if="botonguardar">
                    <button type="button" @click="guardarVacaciones" class="btn btn-info" ><i class="fas fa-edit"></i> GUARDAR</button>  
                  </div>                  
              </div> 
              <hr>
            </div>
            <div class="card-body" v-else>
              <div>
                  <button type="button" @click="registrarVacaciones" class="btn btn-success" ><i class="fas fa-edit"></i> REGISTRAR</button>
              </div> 
              <hr>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable"  cellspacing="0" style="width: 100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Desde</th>
                      <th>Hasta</th>
                      <th>Dias</th>
                      <th>Estado</th>
                      <th>Archivo</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(vacacion, index) in vacaciones">
                      <td style="font-size: 1vw; text-align: center">{{ index +1}}</td>
                      <td style="font-size: 1vw;">{{ vacacion.desde }}</td>
                      <td style="font-size: 1vw;">{{ vacacion.hasta }}</td>
                      <td style="font-size: 1vw;"><b>{{vacacion.dias}} </b></td>
                      <td style="font-size: 1vw;"><b>{{vacacion.estado}} </b></td>
                      <td style="font-size: 1vw; text-align: center">
                         <a title="Ver Archivo" :href="'../archivos/'+vacacion.respaldo" target="_blank">
                          <i class="fas fa-file-download" style="font-size: 20px"></i>
                        </a>
                      </td>
                      <td style="font-size: 1vw;" align="center">
                        <div v-if="vacacion.estado=='REVISION'">
                          <a title="ELIMINAR" style="color: red" type="button" @click="eliminarVacacion(vacacion)">
                            <i class="fas fa-trash" style="font-size: 20px"></i>
                          </a>  
                        </div>
                        
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              {{total}} dias de vacaciones
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
  <script src="../../js/fechas.js"></script>
  <script src="../../js/menu.js"></script> 
  <script type="text/javascript" src="vacacionescontroller3.js?id=<?php echo time(); ?>"></script>
  <script type="text/javascript">
    var Loadfile=function(event){ // archivo cargado
      var reader = new FileReader();
      reader.onload=function(){
        var output=document.getElementById("output");
        output.src=reader.result;
      };
      if(event.target.files[0].type != "application/pdf"){
        reader.readAsDataURL(event.target.files[0]);
      }      
    };    
  </script>
</body>
</html>
