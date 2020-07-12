<!DOCTYPE html>
<?php 
  session_start();
  session_unset();
  session_destroy(); 
  date_default_timezone_set('America/Guayaquil');
  setlocale(LC_ALL,"es_ES");  
  include "config/data.dc";
  $display='none';
  $cedula='';
  $host= @$_SERVER["HTTP_HOST"];
  if (isset($_SERVER['HTTPS']) || $host=="localhost" || $host=="localhost:8080") {    
    
  } else {      
      $url= "/docentes/";
      $ir="https://" . $host . "". $url;    
      if($host=="localhost"){
        echo "<SCRIPT>window.location='$url';</SCRIPT>";    
      }else{
        echo "<SCRIPT>window.location='$ir';</SCRIPT>"; 
      }
  } 
  if(isset($_GET['cedula'])){
    $cedula=$_GET['cedula'];    
  }   
  echo base64_decode('QWFyb24xMjM0NQ==');
?>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="apple-touch-icon" sizes="76x76" href="img/favicon.png" />
  <link rel="icon" type="image/png" href="img/favicon.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?php echo $titulo; ?></title>
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="css/css.css" rel="stylesheet">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">  
</head>

<body class="bg-gradient-primary" >
  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block ">
                <img src="img/reloj.png" style="width: 100%">
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Ingreso al Sistema!</h1>
                  </div>
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="txtemail" aria-describedby="emailHelp" placeholder="Escriba su email..." required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="txtclave" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <div class="form-group">
                        Si es la primera vez que ingresa al sistema; Escriba su email y digite su número de cedula como la clave de ingreso!
                      </div>
                    </div>
                    <a href="#" onclick="ingresar()" class="btn btn-primary btn-user btn-block">
                      Ingresar
                    </a>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="recovery/">Recuperar Contraseña!</a>
                    <br>
                    <a class="small" href="index.php">Cancelar!</a>
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
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script src="vendor/jquery/jquery.blockUI1.js"></script>
  <script src="metodos/metodologin6.js?<?php echo time();?>""></script>
  <script src="js/sweetalert.min.js"></script>
  <script src="js/bloqueo.js?<?php echo time();?>"></script>
</body>
</html>
