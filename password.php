<!DOCTYPE html>
<html lang="en">
<?php 
  date_default_timezone_set('America/Guayaquil');
  setlocale(LC_ALL,"es_ES");  
  include "config/data.dc";
  session_start();
  $cedula=base64_decode($_GET['cedula']);
  if (isset($_SESSION['cedula']) && $cedula==$_SESSION['cedula']) {
  }else{
    header('Location: login.php');
  }
?>
<head>
  <head>
  <meta charset="utf-8">
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

<body class="bg-gradient-primary" onload="TiempoActividad()">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block">
                <img src="img/reloj.png" style="width: 100%">
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Cambia tu contraseña?</h1>
                    <p class="mb-4">Estimado usuario, a continuación ingrese su nueva clave para tener acceso al sistema!</p>
                  </div>
                    <div class="form-group">
                      <label class="form-control"><b>Usuario:</b> <?php echo $_SESSION['email']; ?></label>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="txtclave" aria-describedby="emailHelp" placeholder="Ingrese su clave...">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="txtrepclave" aria-describedby="emailHelp" placeholder="Confirme su clave..">
                    </div>
                    <a href="#" onclick="actualizarSeguridad()" class="btn btn-primary btn-user btn-block">
                      Cambiar Clave
                    </a>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="login.php">Omitir! hacerlo en otra ocasión</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="index.php">Cancelar! Ir al registro de asistencia!</a>
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
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>
  <script src="metodos/metpasssword1.js"></script>
  <script src="vendor/jquery/jquery.blockUI1.js"></script>
  <script src="js/bloqueo.js"></script>
  <script src="js/sweetalert.min.js"></script>
</body>

</html>
