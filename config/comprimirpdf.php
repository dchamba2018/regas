<?php
	include "operaciones.php";
	include "data.dc";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/docentes/clases/claseMarcaciones.php";
	$objfp=new claseMarcaciones();
	$fecha_actual = date("Y-m-d");
	$fecha_actual = date("Y-m-d",strtotime($fecha_actual."- 6 month"));
	$listaarchivos=$objfp->getComprobantesSeisMeses($fecha_actual);
	$ruta='../img/fotos/';
	if ( count( $listaarchivos ) > 0 ) {
		$zip = new ZipArchive();
		$nombrearchivo="comprobantes".time().".zip";
		$zip->open($nombrearchivo,ZipArchive::CREATE);
		foreach ( $listaarchivos as $item ) {
			$archivo=$ruta.''.$item['foto'];
			$zip->addFile($archivo);
		}
		$zip->close();
		header("Content-type: application/octet-stream");
		header("Content-disposition: attachment; filename=".$nombrearchivo);			
		//readfile($nombrearchivo);
		unlink($nombrearchivo);//Destruye el archivo temporal
	}
	//eliminamos los archivos y actualizamos descargados
	if ( count( $listaarchivos ) > 0 ) {
		foreach ( $listaarchivos as $item ) {
			$objfp->actualizarfotodescargados($item['id']);
			$archivo=$ruta.''.$item['archivo'];
			unlink($archivo);
		}
	}
	echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
?>