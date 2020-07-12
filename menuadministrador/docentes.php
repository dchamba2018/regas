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
    $objjustificaicones= new claseJustificaciones();  
    $listajustificacionesPendientes=$objjustificaicones->getJustificacionesPendientesMes();
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
          <h1 class="h3 mb-2 text-gray-800" id='print'>Lista Docentes</h1>
          <p class="mb-4" id='print'>Docentes registrados en la plataforma ASIS-DOCENTES!.</p>

          <!-- DataTales Example -->
          <div class="card shadow mb-12">
            <div class="card-header py-12 d-flex flex-row align-items-center justify-content-between">
                <input id="print" type="text" name="" placeholder="ESCRIBA EL NOMBRE O CEDULA DEL DOCENTE" v-model="txtbusqueda" class="form-control" @keyup.enter="cargardocentes">
            </div>
            <div class="row" id="encabezado" style="width: 100%" align="center">
              <p><h2>INSTITUTO SUPERIOR TECNOLÓGICO PRIMERO DE MAYO</h2></p>
              <p><h6>ASIS-DOCENTES</h6></p>
              <p><h6>DOCENTES REGISTRADOS</h6></p>
            </div>
            <div class="card-body">
              <div class="table">
                <div class="table-responsive">
                  <table class="table table-striped"  cellspacing="0">
                  <thead>
                    <tr style="font-size: 12px; font-weight: bold;">
                      <th>Foto</th>
                      <th>Cedula</th>
                      <th>Docente</th>
                      <th>Celular</th>
                      <th>Email</th>
                      <th id="print">
                        <select @change='cargardocentes' v-model="txtestado">
                          <option>ACTIVO</option>
                          <option>INACTIVO</option>
                        </select>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="item of docentes" style="font-size: 13px; font-style: bold;">
                        <th align="center"><img :src="'../img/fotos/'+item.foto" width="36px" onerror="this.src='../img/fotos/foto.jpg'"></th>
                        <td>{{item.cedula}}</td>
                        <td>
                          {{item.persona}}
                          <!--
                          <form>
                            <div class="form-row">
                              <div class="col">
                                <input type="text" class="form-control" v-model="item.nombres" style="text-transform:uppercase;" placeholder="First name">
                              </div>
                              <div class="col">
                                <input type="text" class="form-control" v-model="item.apellidos" style="text-transform:uppercase;" placeholder="Last name">
                              </div>
                            </div>
                          </form>
                        -->
                        </td>
                        <td>
                           <a v-bind:href="'https://api.whatsapp.com/send?phone=+593'+item.celular+'&text=Estimado docente!'" target="_blank"> <i v-if="item.celular!=''" id="print" class="fa fa-comment" aria-hidden="true"></i> {{item.celular}}</a>
                          
                        </td>
                        <td>{{item.email}}</td>
                        <td align="center" id="print">
                          <a href="#"  class="btn btn-sm btn-primary" title="Guardar" v-if="item.estado=='ACTIVO'" @click='actualizar(item)'><i class="fa fa-save" aria-hidden="true" ></i></a>
                          <a href="#"  class="btn btn-sm btn-danger" title="Desactivar" v-if="item.estado=='ACTIVO'" @click='activar(item)'><i class="fa fa-power-off" aria-hidden="true" ></i></a>
                          <a href="#" class="btn btn-sm btn-success"  title="Activar" v-if="item.estado=='INACTIVO'" @click='activar(item)'><i class="fa fa-power-off" aria-hidden="true" ></i></a>
                        </td>
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
  <script src="../js/menu.js"></script> 
  <script src="controller/contNotificaciones.js"></script>
  <script src="metodos/metdocentes.js?id=<?php echo time(); ?>"></script>

</body>

</html>
