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
          <h1 class="h3 mb-2 text-gray-800" id='print' v-if='panelregistro'>Reporte Mensual</h1>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" v-if='panelregistro'>
              <div>
              Seleccione  el mes y se cargara el reporte mensual de asistencias-->
              </div>
              <div>
                  <select class="form-control" v-model="itemseleccionado" @change="onChange()">
                  <option  v-for="(itemFecha, index) in fechas" v-bind:value="itemFecha.value">{{itemFecha.texto}}</option>
                </select>
              </div>            
            </div>
            <div class="card-header alert alert-primary col-lg-12 col-form-alert text-center" role="alert" align="text-center" v-else>
                    <h4><b>Justificación de {{justificacion[0].titulosel}} del {{justificacion[0].fechasel}}</b></h4>
            </div>
             <div class="card-body">
              <div class="table-responsive" v-if="panelregistro">
                <table class="table table-bordered" id="dataTable"  cellspacing="0" style="width: 100%">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Fecha</th>
                      <th>H.Entrada</th>
                      <th>Atrasos</th>
                      <th>H.Salida</th>
                      <th>Observación</th>
                      <th>Ubicación</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr style="color: white;text-align: center;" v-for="(itemregistro, index) in registros" 
                    :class="['bg', itemregistro.observacion==='INASISTENCIA'? 'bg-danger':
                    itemregistro.observacion==='ABANDONO'? 'bg-warning':'bg-primary']">

                      <td style="font-size: 1vw; " align="center">
                        <div v-if="itemregistro.caption!='../../img/fotos/foto.png'">
                          <a href="#" @click='abrirModal(itemregistro.caption)' data-toggle="modal" data-target="#create" title="Vista Previa">
                          <img  class='img-fluid img-thumbnail' style='padding: 0; display: block' v-bind:src="itemregistro.caption" width='48px'> 
                          </a>  
                        </div>
                        <div v-else>
                          <img  class='img-fluid img-thumbnail' style='padding: 0; display: block' v-bind:src="itemregistro.caption" width='48px'> 
                        </div>
                      </td>

                      <td style="font-size: 1vw;">{{ itemregistro.dia }}</td>
                      <td style="font-size: 1vw;">{{ itemregistro.entrada }}</td>
                      <td style="font-size: 1vw;">
                        <div v-if="itemregistro.atraso==''"></div>
                        <div class="d-flex justify-content-between align-items-center" 
                        v-else>
                          <div>
                            {{itemregistro.atraso }}  
                          </div>                          
                          <div v-if="itemregistro.justificacionatrazo===''">
                            <button class="btn btn-primary btn-sm btn-outline"  title="Justificar Atrazo" @click="abrir_cerrar_Justificacion(false, 'ATRAZO', index)"> 
                            <i class="fas fa-hand-point-up"></i>
                            </button>    
                          </div>
                          <div v-else-if="itemregistro.justificacionatrazo==='REVISION'">
                            <span class="badge badge-warning">En revisión</span>
                          </div>
                          <div v-else-if="itemregistro.justificacionatrazo==='JUSTIFICADO'">
                            <span class="badge badge-success">Justificado</span>
                          </div>
                          <div v-else>
                             <button type="button" class="btn btn-danger btn-sm btn-outline" title="Replicar Solicitud" @click="abrirRechazo(itemregistro)">
                                 <span class="badge badge-light">Negado</span><i class="fas fa-hand-point-up"></i>
                              </button>
                        </div>
                      </td>
                      <td style="font-size: 1vw; text-align: center">
                          <p v-if="itemregistro.observacion=='SALIDA'">
                            {{itemregistro.salida}}  
                          </p>                          
                      </td>
                      <td style="font-size: 1vw; text-align: center" >
                         <div v-if="itemregistro.observacion=='INASISTENCIA'" class="d-flex justify-content-between align-items-center">
                           {{itemregistro.observacion}}
                            <div v-if="itemregistro.justificacion===''">
                              <button class="btn btn-primary btn-sm btn-outline"  title="Justificar Atrazo" @click="abrir_cerrar_Justificacion(false, 'INASISTENCIA', index)"> 
                              <i class="fas fa-hand-point-up"></i>
                              </button>    
                            </div>
                            <div v-else-if="itemregistro.justificacion==='REVISION'">
                              <span class="badge badge-warning">En revisión</span>
                            </div>
                            <div v-else-if="itemregistro.justificacion==='JUSTIFICADO'">
                              <span class="badge badge-success">Justificado</span>
                            </div>
                            <div v-else-if="itemregistro.justificacion==='NEGADO'">
                               <button type="button" class="btn btn-danger btn-sm btn-outline" title="Replicar Solicitud" @click="abrirRechazo(itemregistro)">
                                   <span class="badge badge-light">Negado</span><i class="fas fa-hand-point-up"></i>
                                </button>
                            </div>
                         </div>
                         <div v-else-if="itemregistro.observacion=='ABANDONO'" class="d-flex justify-content-between align-items-center">
                            {{itemregistro.observacion}} 
                            <div v-if="itemregistro.justificacion===''">
                              <button class="btn btn-primary btn-sm btn-outline"  title="Justificar Atrazo" @click="abrir_cerrar_Justificacion(false, 'ABANDONO', index)"> 
                              <i class="fas fa-hand-point-up"></i>
                              </button>    
                            </div>
                            <div v-else-if="itemregistro.justificacion==='REVISION'">
                              <span class="badge badge-warning">En revisión</span>
                            </div>
                            <div v-else-if="itemregistro.justificacion==='JUSTIFICADO'">
                              <span class="badge badge-success">Justificado</span>
                            </div>
                            <div v-else-if="itemregistro.justificacion==='NEGADO'">
                               <button type="button" class="btn btn-danger btn-sm btn-outline" title="Replicar Solicitud" @click="abrirRechazo(itemregistro)">
                                   <span class="badge badge-light">Negado</span><i class="fas fa-hand-point-up"></i>
                                </button>
                            </div>
                         </div>
                         <p v-else>
                           {{itemregistro.observacion}}
                         </p>                         
                      </td>
                      <td style="font-size: 1vw; text-align: center;">
                        <p v-if="itemregistro.observacion=='INASISTENCIA'">
                          
                        </p>
                        <div class="d-flex justify-content-between align-items-center"
                         v-else-if="itemregistro.observacion=='SALIDA'">
                          <a title="Ver Ubicación" @click='crearMapa(itemregistro)' style="color: white;" >
                            <img class='circle' style='padding: 0; display: block' src="../../img/fotos/blank.png" width='24px'>
                        </a>
                        </div>
                        <div class="d-flex justify-content-between align-items-center"
                         v-else-if="itemregistro.observacion=='ABANDONO'">
                          <a title="Ver Ubicación"  @click='crearMapa(itemregistro)' style="color: white;"  >
                          <img class='circle' style='padding: 0; display: block' src="../../img/fotos/blank.png" width='24px'>
                        </a>
                        </div>
                        <p v-else="itemregistro.observacion=='INASISTENCIA'"></p>
                    </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div v-else>
                <div class="form-group row">
                  
                  <div class="col-lg-12">
                      <select class="form-control" v-model="justificacion[0].motivosel">
                        <option  v-for="(itemmotivo, index) in motivos" v-bind:value="itemmotivo.data">{{itemmotivo.data}}</option>
                      </select>
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-2 col-form-label">Detalle:</label>
                    <div class="col-lg-12">
                       <textarea class="form-control" rows="3" aria-label="With textarea"  v-model="justificacion[0].detallesel"></textarea>
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
                  <div class="col-lg-4"></div>
                  <div class="col-lg-7">
                  <div class="btn-group" role="group" aria-label="Basic example" style="align:right;">
                    <button type="button" class="btn btn-primary" @click="JustificarAsistencia">Justificar</button>
                    <button class="btn btn-danger" type="button" @click="abrir_cerrar_Justificacion(true, '', 0)">Cancelar</button>
                  </div>
                  <div class="col-lg-1"></div>
                </div>
                </div>
              </div>
            </div>
            <section class="form">
              <div class="modal fade " id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog " role="document">
                <div class="modal-content bg-gradient-primary" style="color: white;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Vista Previa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>                
                    <div class="modal-body">
                      <img class='img-thumbnail' style='padding: 0; display: block' v-bind:src="direccion" width='100%'> 
                    </div>          
                </div>
              </div>
            </section> 
            
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
  <script type="text/javascript" src="controlador.js"></script>
  <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeVS5m2eWT-aFk8k1Nu7UbjRxBh5zQjxM">
    </script>
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
  