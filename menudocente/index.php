<!DOCTYPE html>
<html lang="en">
<?php 
  date_default_timezone_set('America/Guayaquil');
  setlocale(LC_TIME, 'spanish');  
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseUsuarios.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseHorarios.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseMarcaciones.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseJustificaciones.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseVacaciones.php";
  setlocale(LC_ALL,"es_ES");  
  include "../config/data.dc";
  include "../config/fotos.php";
  session_start();
  $objusuario = new claseUsuarios();  
  if(isset($_SESSION['iddocente'])){
    $iddocente=$_SESSION['iddocente'];
    $usuario=$objusuario->getUsuarioDocente($iddocente);
    $objDocente = new claseDocentes();  
    $docente=$objDocente->getDocente($iddocente);
    $foto= imagensuperiorsublinea($docente['foto']);

    $objMarcacion = new claseMarcaciones();  
    $totalmarcaciones=$objMarcacion->getDiasLaboradosMesDocente($iddocente);
    $totalabandonos=$objMarcacion->getDiasLaboradosMesDocenteAbandono($iddocente);
    $mes=intval(date("m"))."/".date("Y");
    $objHorarios= new claseHorarios();  
    $horario=$objHorarios->getHorarioDocSel($iddocente);
    $atrazos=$objMarcacion->getTotalMarcacionDocente($iddocente,$mes, $horario['entrada']);
    $listaMarcaciones=$objMarcacion->getMarcacionDiariasDocentesSeleccionado($iddocente);
    $objVacaciones= new claseVacaciones();  
    $totalvacaciones=$objVacaciones->getSumaVacacionesDocente($iddocente, date("Y"));

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
</head>

<body id="page-top" onload="TiempoActividad()">
  <!-- Page Wrapper -->
        <!-- End of Topbar -->
        <?php 
        include "menu.dc";
        ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Escritorio</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generar Reporte </a>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Dias laborados en (<?php echo date("M");?>)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"># <?php echo $totalmarcaciones; ?> día(s)</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Atrasos (<?php echo date("M");?>) H:m:s</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $atrazos;?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Vacaciones <?php echo date("Y") ?>
                      </div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                            <i class="fas fa-arrow-right"></i> 
                            <?php echo $totalvacaciones." día(s)"?></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-business-time fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Abandonos</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalabandonos; ?> día(s)</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user-clock fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->

          <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Marcaciones del <?php echo date('D, d    F / Y') ?></h6>
                </div>
                <!-- Card Body -->
                <div class="card-body ">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Foto</th>
                      <th>Estado</th>
                      <th>Entrada</th>
                      <th>Salida</th>
                      <th>Map</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      if(count($listaMarcaciones)>0){
                        foreach ( $listaMarcaciones as $item){
                          $foto="foto.jpg";
                          if($item['foto']!=""){
                            $foto=$item['foto'];
                          }
                          echo "<tr>
                            <td align='center'><a target='_blank' href='../img/fotos/".$foto."'><img class='circle' style='padding: 0; display: block' src='../img/fotos/".$foto."' width='100px'></a></td>";
                            if($item['observacion']=="INASISTENCIA"){
                              echo "
                              <td colspan='4'style='background:#E55648; color:white;'align='center'><h3> Docente no registra asistencia</h3></td>
                              </tr>
                              ";
                            }else if($item['observacion']=="ENTRADA"){
                               echo "
                            <td style='background:#67DE67; color:white;' align='center'><h3>".$item['observacion']."</h3></td>
                            <td align='center'><h3>".$item['entrada']."</h3></td>
                              <td></td>                                  
                              <td align='center'><h1><a title='Ver ubicación en el mapa class='btn btn-primary' target='_blank' href='https://www.google.com/maps/@".$item['lat'].",".$item['longitud'].",20z'>
                              <i class='fas fa-map-marker-alt'></i>
                              </a></h1></td></tr>";
                            }else{
                              echo "
                            <td align='center'><h3>".$item['observacion']."</h3></td>
                            <td style='background:#67DE67; color:white;'align='center'><h3>".$item['entrada']."</h3></td>
                              <td style='background:#6F7EE8; color:white;'align='center'><h3>".$item['salida']."</h3></td>                                  
                              <td align='center'><h1><a title='Ver ubicación en el mapa class='btn btn-primary' target='_blank' href='https://www.google.com/maps/@".$item['lat'].",".$item['longitud'].",20z'>
                              <i class='fas fa-map-marker-alt'></i>
                              </a><h1></td></tr>";
                            }
                          }
                      }else{
                        echo "<tr>
                        <td colspan='6'>
                        No hay Marcaciones
                        </td></tr>";  
                      }
                    ?>                    
                  </tbody>
                </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Content Row -->          
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

  <!-- Logout Modal-->
  <?php 
  include "logout.php";
  ?>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="../js/session.js"></script>


  <script src="../vendor/jquery/jquery.blockUI1.js"></script>
  <script src="../js/bloqueo.js"></script>
  <script src="../js/menu.js"></script>
  <script src="../js/sweetalert.min.js"></script>
</body>
</html>
