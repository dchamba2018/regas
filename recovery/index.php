<!DOCTYPE html>
<?php 
  date_default_timezone_set('America/Guayaquil');
  setlocale(LC_ALL,"es_ES");  
  include "../config/data.dc";
  $display='none';
  $cedula='';
  $host= @$_SERVER["HTTP_HOST"];
  if (isset($_SERVER['HTTPS']) || $host=="localhost" || $host=="localhost:8080") {    
    session_start();
    session_unset();
    session_destroy();    
  } else {      
      $url= "/docentes/";
      $ir="https://" . $host . "". $url;    
      if($host=="localhost"){
        echo "<SCRIPT>window.location='$url';</SCRIPT>";    
      }else{
        echo "<SCRIPT>window.location='$ir';</SCRIPT>"; 
      }
  }  
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="apple-touch-icon" sizes="76x76" href="../img/favicon.png" />
  <link rel="icon" type="image/png" href="../img/favicon.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?php echo $titulo; ?></title>
  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../css/css.css" rel="stylesheet">
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">  
  <script src="../js/vue.js"></script>
  <script src="../js/axios.min.js"></script>
  <script src="../js/axios.min.js"></script>
  <style type="text/css">
    [v-cloak] {
      display: none;
    }
    #encabezado {display:none} 
    @media print {
      #print {display:none;}     
      #encabezado {display:block} 
      #accordionSidebar{display:none}
    }
  </style>
</head>

<body class="bg-gradient-primary" onload="TiempoActividad()">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block ">
                <img src="../img/reloj.png" style="width: 100%">
              </div>
              <div class="col-lg-6" id="appJustificacion" v-cloak>
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Recupera tu clave!</h1>
                  </div>
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="txtemail" aria-describedby="emailHelp" placeholder="Escriba su email..." required v-model="correo">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="txtclave" placeholder="Cedula" v-model="cedula">
                    </div>
                    <div class="form-group">
                      <div class="card bg-danger text-white shadow" v-if="mensaje">
                        <div class="card-body" >
                          Error
                          <div class="text-white-50 small">No se pudo verificar su cuenta, compruebe su correo o cedula</div>
                        </div>
                      </div>
                      <div class="form-group" v-else>
                        Escriba su email y cedula para recuperar su cuenta!
                      </div>
                    </div>
                    <a href="#"  @click="VerificarCuenta" class="btn btn-primary btn-user btn-block">
                      Recuperar
                    </a>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="../login.php">Cancelar!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>
  <script src="../vendor/jquery/jquery.blockUI1.js"></script>
  <script src="controller1.js"></script>
  <script src="../js/sweetalert.min.js"></script>
  <script src="../js/bloqueo.js"></script>
  <script src="../js/bloqueapantalla.js"></script>
  <script src="../js/session.js"></script>
</body>
</html>
