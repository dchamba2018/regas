<?php 
$para = 'dchamba@live.com';
include "mail.php";
$mensaje = crearplantillaVacia();
$cabeceras = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$cabeceras .= 'From: admin@ikerany.com';
$titulo="Registro Asistencias";
$enviado = mail($para, $titulo, $mensaje, $cabeceras); 
if ($enviado)
  echo 'Email enviado correctamente';
else
  echo 'Error en el envío del email';
?>