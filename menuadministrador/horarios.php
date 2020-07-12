<!DOCTYPE html>
<html lang="en">
<?php 
  date_default_timezone_set('America/Guayaquil');
  setlocale(LC_TIME, 'spanish');  
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseHorarios.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseUsuarios.php";
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
    $objHorarios= new claseHorarios();  
    $listahorarios=$objHorarios->getHorarios();    
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
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <?php 
        include "menu.dc";
        ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Horarios</h1>
          <p class="mb-4">A continuación podra verificar los horarios disponibles y asignados a los docentes.</p>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Horarios</h6>  
              <div class="dropdown no-arrow">
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Opciones:</div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#horarioModal">Agregar Horario</a>
                  </div>
                </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Nombre</th>
                      <th>Hora Entrada</th>
                      <th>Hora Salida</th>
                      <th align="center"><i class="fas fa-cogs"></i></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Item</th>
                      <th>Nombre</th>
                      <th>Hora Entrada</th>
                      <th>Hora Salida</th>
                      <th align="center"><i class="fas fa-cogs"></i></th>
                    </tr>
                  </tfoot>
                  <tbody>
                     <?php 
                      if(count($listahorarios)>0){
                        $it=1;
                        foreach ( $listahorarios as $item){
                          echo "<tr>
                            <td align='center'>".$it."</td>
                            <td>".strtoupper($item['nombre'])."</td>
                            <td style='background:#E55648; color:white;' align='center'>".$item['entrada']."</td>
                            <td style='background:#67DE67; color:white;' align='center'>".$item['salida']."</td>
                            <td align='center'> 
                            <a href='#' onclick='abrirmodal(".$item['id'].")' class='btn btn-success btn-circle' title='Asignar Docentes'>
                              <i class='fas fa-users-cog'></i>
                            </a></td>
                            </tr>";
                            $it++;
                        }
                      }else{
                        echo "<tr>
                        <td colspan='5'>
                        No hay Horarios Registrados
                        </td></tr>";  
                      }
                    ?> 
                  </tbody>
                </table>
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
 <div class="modal fade" id="horarioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Nuevo Horario?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="consultas/guardarHorario.php" method="post">
        <div class="modal-body">          
          <div class="form-group row">
              <label class="col-lg-2 col-form-label">Nombre:</label>
              <div class="col-lg-10">
                  <input type="text"  class="form-control" id="txtnombre" name="txtnombre">
              </div>
          </div>
          <hr>
          <div class="form-group row">
              <label class="col-lg-2 col-form-label">Entrada:</label>
              <div class="col-lg-4">
                  <input type="time"  class="form-control" id="txtentrada" name='txtentrada'>
              </div>
              <label class="col-lg-2 col-form-label">Salida:</label>
              <div class="col-lg-4">
                  <input type="time"  class="form-control" id="txtsalida" name='txtsalida'>
              </div>
          </div>    
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <input type="submit" class="btn btn-primary" onclick="hacer_click()" value="Guardar" id="btnSend">
        </div>
      </form>
      </div>
    </div>
  </div>

   <div class="modal fade" id="horarioDocentes" tabindex="-1" role="dialog" aria-labelledby="exampleLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Asignar Docentes</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">          
          <div class="form-group row">
            <div class="col-lg-6">
              <div class="table-responsive">
                <input type="hidden"  class="form-control" value="0" id="txtidhorario" name="txtidhorario">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Todos los Docentes</th>
                      <th align="center"><i class="fas fa-cogs"></i></th>
                    </tr>
                  </thead>
                  <tbody id="todosdocentes">
                     
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="table-responsive">
                <input type="hidden"  class="form-control" value="0" id="txtidhorario" name="txtidhorario">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th align="center"><i class="fas fa-cogs"></i></th>
                      <th>Docente Seleccionados</th> 
                      <th>#</th>                     
                    </tr>
                  </thead>
                  <tbody id='docentesasignados'>                     
                  </tbody>
                </table>
              </div>
            </div>
          </div>    
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>          
        </div>
      </div>
    </div>
  </div>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/sb-admin-2.min.js"></script>
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="../js/demo/datatables-demo.js"></script>
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="../js/session.js"></script>
  <script src="metodos/methorarios.js"></script>
  <script src="../vendor/jquery/jquery.blockUI1.js"></script>
  <script src="../js/vue.js"></script>
  <script src="../js/axios.min.js"></script>
  <script src="../js/menu.js"></script> 
  <script src="controller/contNotificaciones.js"></script>
  <script src="../js/bloqueo.js"></script>
  <script src="../js/bloqueapantalla.js"></script>
  <script src="../js/sweetalert.min.js"></script>
</body>

</html>
