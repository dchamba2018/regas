<!doctype html>
<?php 
  session_start();
  session_unset();
  session_destroy();
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseMarcaciones.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseDocentes.php";
  $objmarcacion=new claseMarcaciones();
  $objDocente = new claseDocentes();  
  $listaDocentes=$objDocente->getDocentes("ACTIVO");
  $objmarcacion->consultaMarcacion($listaDocentes);
?>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Cache-->
    <meta http-equiv="Expires" content="0"> 
    <meta http-equiv="Last-Modified" content="0"> 
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate"> 
    <meta http-equiv="Pragma" content="no-cache">

    <link rel="apple-touch-icon" sizes="76x76" href="../img/favicon.png" />
    <link rel="icon" type="image/png" href="../img/favicon.png" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>ASIS-DOCENTES!</title>
    <style> 
    #map {
        height: 100%;
        }     
        html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        }
    </style>
    <style type="text/css">
    [v-cloak] {
      display: none;
    }
  </style>
  </head>
  <body onload="localize()">
    <div class="container" id="app" v-cloak>
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block">
                <!-- <img src="img/reloj.png" style="width: 100%"> -->                
                <div id ="map"> </div> 
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h6 text-gray-300 mb-2">
                      <div>
                        <img src="../img/header.png" width="100%">
                      </div>
                        <h3>#QUEDATEENCASA</h3>
                      <div id="clockdate">
                        <div class="clockdate-wrapper">
                          <div id="direccion">Yantzaza, Av. Ivan Riofrio</div>
                          <div>{{fecha}} {{hora}}</div>                          
                        </div>
                      </div>
                    </h1>
                    <hr>
                    <p class="mb-4" v-if="btnvalidar">Estimado docente digite su número de cedula para verificar su ingreso o salida!</p>
                  </div>
                  <div class="form-group">
                    <input maxlength="10" type="number" class="form-control form-control-user" id="txtcedula" aria-describedby="txtcedula" v-model="cedula" placeholder="Escriba su cedula..." v-on:keyup.enter="validar" v-if="btnvalidar">
                    <input type="text" class="form-control form-control-user" id="txtdocente" readonly style="display: none">
                    <input type="hidden" id="txtiddocente" readonly >
                    <input type="hidden" id="txtlatitud" ref="latitudtxt">
                    <input type="hidden" id="txtlongi" ref="longitudtxt" value='0'>
                    <input type="hidden" id="txtprecision" ref="precision1">
                    <input type="hidden" readonly v-model="txtfoto">
                    <input type="hidden" id="txtfecha" value="<?php echo date('d'); ?>">
                  </div>
                  <a href="#" id="btnvalidar" @click="validar" class="btn btn-success btn-user btn-block" v-if="btnvalidar">
                    VALIDAR
                  </a>
                  <div class="text-center">
                    <hr>
                      <a class="small" href="../login.php"><h6>Administrar Cuenta!</h6></a>
                    </div>
                  <hr v-if="!btnvalidar">
                  <div class="alert alert-warning" role="alert" v-if="!btnvalidar">
                     {{textomensaje}}
                    <br>
                    <div class="text-center"><b><h5>{{cronometro}}</h5></b></div>
                     <div class="text-center">
                      <a class="small" href="#" @click="btnvalidar=!btnvalidar"><h6>Intentar Nuevamente!</h6></a>
                    </div>
                    

                  </div>
                    
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="dialogocamara" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" align="center">
              <h5 class="modal-title" id="exampleModalLabel1">Mire la Camara</h5>
            </div>
            <div class="modal-body" align="center">
              <div class="text-center"  >
                <video id="video" style="width: 60%;"></video>
                <br>
                <button id="boton" style="display:none;">Tomar foto</button>
                <p id="estado" style="display:none;"></p>
                <canvas id="canvas" style="display:none; width: 60%;"></canvas>
              </div>
              <div class="container  row" v-for="(objDocente, index) in docente">
                <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                   <h5>HOLA! {{objDocente.nombres}} {{objDocente.apellidos}}</h5>
                 </div>
              </div>
              <div class="container  row" v-for="(objMarcacion, index) in marcacion" v-if="docente[0].estado=='ACTIVO'">
                <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                  <hr v-if="!btnvalidar">
                  <button class="btn btn-success btn-block" @click="registrar('ENTRADA')" v-if="objMarcacion.observacion == 'INASISTENCIA' && !loading">REGISTRAR ENTRADA</button>
                  <img src="../img/loading.gif" alt="img" width="60%" align="center" v-if="loading">
                  <div class="alert alert-success" role="alert" v-if="objMarcacion.observacion === 'ENTRADA'">
                    H. ENTRADA: <b>{{objMarcacion.entrada}}</b>
                  </div>
                  <button class="btn btn-danger btn-block" @click="registrar('SALIDA')" 
                  v-if="objMarcacion.observacion == 'ENTRADA' && !loading && click==0">REGISTRAR SALIDA</button>
                  <div class="alert alert-danger" role="alert" v-if="objMarcacion.observacion === 'SALIDA'">
                    H. ENTRADA: <b>{{objMarcacion.entrada}}</b><br>
                    H. SALIDA: <b>{{objMarcacion.salida}}</b>
                  </div>
                </div>
              </div>
              <hr>
              <div class="text-center">
                <a class="small" href="../login.php"><h6>Administrar Cuenta!</h6></a>
              </div>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script><script src="../js/fechas.js"></script>
    <script src="../js/vue.js"></script>
    <script src="../js/axios.min.js"></script>
    <script src="../js/bloqueapantalla.js"></script>
    <script src="../vendor/jquery/jquery.blockUI1.js"></script>
    <script src="controladorvue1.js?<?php echo time();?>"></script>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeVS5m2eWT-aFk8k1Nu7UbjRxBh5zQjxM">
    </script>
    <script src="mapa.js?id=<?php echo time();?>"></script>    
    <script src="foto.js?id=<?php echo time(); ?>"></script> 
    <script src="../js/sweetalert.min.js"></script>
  </body>
</html>