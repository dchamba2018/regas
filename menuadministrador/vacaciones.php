<!DOCTYPE html>
<html lang="en">
<?php 
  date_default_timezone_set('America/Guayaquil');
  setlocale(LC_TIME, 'spanish');  
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseUsuarios.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";

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
    if($usuario['rol']!="ADMINISTRADOR"){
      header('Location: ../index.php');
    }
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
        <div class="container-fluid" id="app">
          <h1 class="h3 mb-2 text-gray-800" id='print'>Solicitudes de vacaciones</h1>
          <p class="mb-4" id='print'>Registro de Vacaciones generados en la plataforma ASIS-DOCENTES!.</p>

          <!-- DataTales Example -->
          <div class="card shadow mb-12">
            <div class="card-header py-12 d-flex flex-row align-items-center justify-content-between">
                SELECCIONE EL ESTADO DE LAS VACACIONES
            </div>
            <div class="row" id="encabezado" style="width: 100%" align="center">
              <p><h2>INSTITUTO SUPERIOR TECNOLÓGICO PRIMERO DE MAYO</h2></p>
              <p><h6>ASIS-DOCENTES</h6></p>
              <p><h6>DOCENTES REGISTRADOS</h6></p>
            </div>
            <div class="card-body">
              <div class="table">
                <div class="table-responsive">
                  <table class="table table-bordered"  cellspacing="0">
                  <thead>
                    <tr class="text-warning bg-primary">
                      <th id="print" style="width: 400px;">
                        <select class="form-control" v-model="docente">
                          <option v-for="doc of docentes" :value='doc.persona'>{{doc.persona}}</option>
                        </select>
                      </th>
                      <th><b>RANGO</th>
                      <th><b>RESPALDO</th>
                      <th id="print" style="width: 200px;">
                        <select class="form-control" v-model="txtestado">
                          <option>REVISION</option>
                          <option>APROBADO</option>
                          <option>NEGADO</option>
                        </select>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="(item, index) of vacaciones" style="font-size: 13px; font-style: bold;" v-if='txtestado==item.estado && item.docente==docente'>
                        <td><b>FECHA SOLICITUD:</b> {{item.fecha}} <br> <b>TIEMPO:</b> {{item.dias}} dias</td>
                        <td style="width: 150px">
                          DESDE: {{item.desde}}<br>
                          HASTA: {{item.hasta}}
                        </td>
                        <td >
                          <a href="#"  class="btn btn-sm btn-primary" title="Guardar" @click='abrirmodal(item.respaldo)'><i class="fa fa-eye" aria-hidden="true" ></i></a>
                        </td >
                        <td align="center" id="print" v-if="item.estado=='REVISION'">
                          <a href="#"  class="btn btn-sm btn-success" title="Aprobar" @click="aprobar(item,'APROBADO')"><i class="fa fa-save" aria-hidden="true" ></i></a>
                          <a href="#"  class="btn btn-sm btn-warning" title="Aprobar" @click="aprobar(item,'NEGADO')"><i class="fa fa-times" aria-hidden="true" ></i></a>
                          <a href="#"  class="btn btn-sm btn-danger" title="Eliminar"  @click="aprobar(item, 'ELIMINAR')"><i class="fa fa-trash" aria-hidden="true" ></i></a>
                        </td>
                        <td v-if="item.estado!='REVISION'"></td>
                     </tr>
                  </tbody>
                </table>
                </div>
              </div>
              <hr>
              FIRMA RESPONSABLE.<br>
              <?php echo $docente['nombres']." ".$docente['apellidos']."<br>
              ".date('Y-m-d H:i:s');?>
              <br>
              <a id='print'  class="btn btn-success btn-sm" href='javascript:window.print()'><i class="fa fa-print"></i> Imprimir</a>
            </div>
          </div>
          <div class="modal fade" id="ModalArchivo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="card-body">
                 <embed :src="txtarchivo" class="form-control" style="height: 680px;" > 
                </div>
                <div class="modal-footer bg-primary">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                </div>
              </form>
              </div>
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
   <script src="../js/vue.js"></script>
  <script src="../js/axios.min.js"></script>
   <script src="../vendor/jquery/jquery.blockUI1.js"></script>
  <script src="../js/bloqueo.js"></script>
  <script src="../js/menu.js"></script>
  <script src="../js/bloqueapantalla.js"></script>
  <script src="../js/sweetalert.min.js"></script>
  <script src="../js/vue.js"></script>
  <script src="../js/axios.min.js"></script>
  <script src="controller/contNotificaciones.js"></script>
  <script src="metodos/metvacaciones.js?id=<?php echo time(); ?>"></script>

</body>

</html>
