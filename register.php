<!DOCTYPE html>
<html lang="en">
<?php 
  date_default_timezone_set('America/Guayaquil');
  setlocale(LC_ALL,"es_ES");  
  include "config/data.dc";
  session_start();
  if (isset($_SESSION['cedula']) && $_GET['cedula']==$_SESSION['cedula']) {
  }else{
    //header('Location: index.php');
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

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block">
            <img src="img/reloj.png" style="width: 100%">
          </div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Registro Docente!</h1>
              </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="txtnombres" placeholder="Nombres"  >
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="txtapellidos" placeholder="Apellidos">
                  </div>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-user" id="txtemail" placeholder="Dirección Email">
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="txttelefono" placeholder="Telefono">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" value="<?php echo $_GET['cedula']; ?>" class="form-control form-control-user" id="txtcedula" placeholder="Cedula" readonly>
                  </div>
                </div>
                <a href="#" onclick="guardarDocente()" class="btn btn-primary btn-user btn-block">
                  Registrarme
                </a>                
              <hr>
              <div class="text-center">
                <a class="small" href="index.php">Ya tengo cuenta?</a>
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
  <script src="metodos/metodoregister4.js?id=<?php echo time();?>"></script>
  <script src="vendor/jquery/jquery.blockUI1.js"></script>
  <script src="js/bloqueo.js"></script>
  <script src="js/sweetalert.min.js"></script>
</body>

</html>
