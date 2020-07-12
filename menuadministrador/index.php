<!DOCTYPE html>
<html lang="en">
<?php 
  session_start();
  date_default_timezone_set('America/Guayaquil');

  setlocale(LC_TIME, 'spanish');  
  setlocale (LC_TIME, "es_ES");
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseUsuarios.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseHorarios.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseMarcaciones.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseJustificaciones.php";
  include "../config/data.dc";
  include "../config/fotos.php";
  $objusuario = new claseUsuarios();
  $iddocente=0;
  if(isset($_GET['iddocente'])){
    $iddocente=$_GET['iddocente'];
    $_SESSION['iddocente']=$iddocente;
  }else if(isset($_SESSION['iddocente'])){
    $iddocente=$_SESSION['iddocente'];
  }
  
  $usuario=$objusuario->getUsuarioDocente($iddocente);
  if(isset($usuario['id'])){
    if($usuario['rol']!="ADMINISTRADOR"){
      header('Location: ../index.php');
    }
    $objDocente = new claseDocentes();  
    $docente=$objDocente->getDocente($iddocente);
    $foto= imagensuperiorsublinea($docente['foto']);
    $objMarcacion = new claseMarcaciones();  
    $totalmarcaciones=$objMarcacion->getMarcacionesMes();
    $objHorarios= new claseHorarios();  
    $listaDocentes=$objDocente->getDocentes("ACTIVO");

    $listahorarios=$objHorarios->getHorarios(); 
    $objjustificaicones= new claseJustificaciones();  
    $totaljustificaciones=$objjustificaicones->getJustificacionesMes();
    $listajustificacionesPendientes=$objjustificaicones->getJustificacionesPendientesMes();
    $listaMarcaciones=$objMarcacion->getMarcacionDiariasDocentes();


    $fecha_actual = date("Y-m-d");
    $fecha_actual = date("Y-m-d",strtotime($fecha_actual."- 6 month"));
    $listaarchivos=$objMarcacion->getComprobantesSeisMeses($fecha_actual);
    if ( count( $listaarchivos ) > 0 ) {
      echo "<script type='text/javascript'>"; 
      echo "window.open('../config/comprimirpdf.php', '_blank');"; 
      echo "</script>";
    }
    setlocale(LC_TIME, 'es_ES.UTF-8');
    $miFecha= gmmktime(12,0,0,date('m'),date('d'),date("Y"));
    $fechadia=strftime("%A, %d de %B de %Y", $miFecha);

  }else{
    header('Location: ../index.php');
  }
?>

<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
  
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
  <style type="text/css">
    #encabezado {display:none} 
        @media print {
          #print {display:none;}     
          #encabezado {display:block} 
          #accordionSidebar{display:none}
          #hoja{
            margin-left: 40px;
            margin-right: 30px;
            margin-bottom: 30px;
            margin-top: 30px;
          }
        }
    </style>
</head>

<body id="page-top">
  <!-- Page Wrapper -->
        <!-- End of Topbar -->
        <?php 
        include "menu.dc";
        ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4" >
            <div id="print">
              <h1 class="h3 mb-0 text-gray-800" id="print">Escritorio</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="print"><i class="fas fa-download fa-sm text-white-50" id="print"></i> Generar Reporte</a>
            </div>
            
          </div>

          <!-- Content Row -->
          <div class="row" id="print">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Marcaciones (<?php echo date("M");?>)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"># <?php echo $totalmarcaciones; ?></div>
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
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Docentes (Activos)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"># <?php echo count($listaDocentes) ?></div>
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
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Horarios</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo count($listahorarios) ?>%</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo count($listahorarios) ?>%" aria-valuenow="<?php echo count($listahorarios) ?>" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
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
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Justificaciones</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totaljustificaciones; ?></div>
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

          <div class="row" id="hoja">
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="row" id="encabezado" style="width: 100%" align="center">
                  <br>
                  <img src="../img/escudo.png" width="80px">
                  <p><h2>INSTITUTO SUPERIOR TECNOLÓGICO PRIMERO DE MAYO</h2></p>
                  <p><h6>ASIS-DOCENTES</h6></p><hr>
                </div>
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Marcaciones del <?php echo $fechadia;?></h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Foto</th>
                      <th>Docente</th>
                      <th>Estado</th>
                      <th>Entrada</th>
                      <th>Salida</th>
                      <th>Map</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Foto</th>
                      <th>Docente</th>
                      <th>Estado</th>
                      <th>Entrada</th>
                      <th>Salida</th>                      
                      <th>Map</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php 
                      if(count($listaMarcaciones)>0){
                        foreach ( $listaMarcaciones as $item){
                          $foto=imagensuperiorsublinea($item['foto']);
                          //if($item['foto']!=""){
                          //  $foto=$item['foto'];
                          //}
                          $color="bg-warning";
                          if($item['observacion']=="ENTRADA"){
                            $color="bg-info";
                          }else  if($item['observacion']=="SALIDA"){
                            $color="bg-success";
                          }
                          echo "<tr class='".$color."' style='color:black;'>
                            <td align='center'><a target='_blank' href='".$foto."'><img class='circle' style='padding: 0; display: block' src='".$foto."' width='36px'></a></td>
                            <td>".strtoupper($item['docente'])."</td>";
                            if($item['observacion']=="INASISTENCIA"){
                              echo "
                              <td colspan='4' > Docente no registra asistencia</td>
                              </tr>
                              ";
                            }else if($item['observacion']=="ENTRADA"){
                               echo "
                            <td >".$item['observacion']."</td>
                            <td>".$item['entrada']."</td>
                              <td></td>                                  
                              <td align='center'><a title='Ver ubicación en el mapa class='btn btn-primary' target='_blank' href='https://www.google.com/maps/@".$item['lat'].",".$item['longitud'].",20z'>
                              <i class='fas fa-map-marker-alt'></i>
                              </a></td></tr>";
                            }else{
                              echo "
                            <td>".$item['observacion']."</td>
                            <td >".$item['entrada']."</td>
                              <td >".$item['salida']."</td>                                  
                              <td align='center'><a title='Ver ubicación en el mapa class='btn btn-primary' target='_blank' href='https://www.google.com/maps/@".$item['lat'].",".$item['longitud'].",20z'>
                              <i class='fas fa-map-marker-alt'></i>
                              </a></td></tr>";
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
              <hr>
                <?php echo $docente['nombres']." ".$docente['apellidos']."<br>
                ".date('Y-m-d H:i:s');?>
                <br>
                <a id='print'  class="btn btn-success btn-sm" href='javascript:window.print()'><i class="fa fa-print"></i> Imprimir</a>
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
  <script src="../js/session.js"></script>
  <script src="../vendor/jquery/jquery.blockUI1.js"></script>
  <script src="../js/bloqueo.js"></script>
  <script src="../js/vue.js"></script>
  <script src="../js/axios.min.js"></script>
  <script src="controller/contNotificaciones.js"></script>
  <script src="../js/menu.js"></script>
  <script src="../js/sweetalert.min.js"></script>
  <script>
  //Cuando la página esté cargada completamente
  $(document).ready(function(){
    //Cada 10 segundos (10000 milisegundos) se ejecutará la función refrescar
    setTimeout(refrescar, 60000);
  });
  function refrescar(){
    //Actualiza la página
    location.reload();
  }
</script>
</body>
</html>
