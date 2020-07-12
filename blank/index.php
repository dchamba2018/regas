<!DOCTYPE html>
<?php 
  session_start();
    session_unset();
    session_destroy(); 
  date_default_timezone_set('America/Guayaquil');
  setlocale(LC_ALL,"es_ES");  
  include "../config/data.dc";
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
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../img/favicon.png" />
  <link rel="icon" type="image/png" href="../img/favicon.png" />
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?php echo $titulo; ?></title>
  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
  <div id="wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
        </nav>
        <div class="container-fluid">
          <!-- 404 Error Text -->
          <div>
            <img src="../img/header.png" width="100%">
          </div>
          <hr>
          <div class="text-center">
            <div class="mx-auto text-center" data-text="404">
              <h2 class="text-primary">#QUEDATEENCASA</h2>
            </div>
            <p class="lead text-gray-800 mb-5">ASIS DOCENTES</p>
            <p class="text-danger mb-1"><b>
              El horario de registro es de Lunes a Viernes desde las 13H30 hasta las 23H59 <br><br>
             Ante la emergencia sanitaria lo mejor es permaner en Casa, <br>Se habilitado la plataforma para el registro docente desde la comodidad de tu hogar!
            </b></p>            
            <hr>
            <div class="text-center" style="display:;">
              <a href="../login.php">Administrar Cuenta &rarr;</a>
            </div>
            <a href="../">&larr; Retornar</a>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; ISTPM-2019 [DCH]</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->

   <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>
  <script src="../js/bloqueo.js"></script>
  
</body>

</html>
