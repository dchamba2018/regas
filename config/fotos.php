<?php 
function imagensuperior($foto){
	$urlimagen = $_SERVER['DOCUMENT_ROOT']."/docentes/img/fotos/".$foto;
  	if($foto==""){
		$dirfoto="../img/fotos/foto.jpg";
	}else if(file_exists($urlimagen)){
		$dirfoto="img/fotos/".$foto;
	}else{
		$dirfoto="../img/fotos/foto.jpg";
	}
	return $dirfoto;
}
function imagensuperiorsublinea($foto){
	$urlimagen = $_SERVER['DOCUMENT_ROOT']."/docentes/img/fotos/".$foto;
  	if($foto==""){
		$dirfoto="../img/fotos/foto.jpg";
	}else if(file_exists($urlimagen)){
		$dirfoto="../img/fotos/".$foto;
	}else{
		$dirfoto="../img/fotos/foto.jpg";
	}
	return $dirfoto;
}
?>