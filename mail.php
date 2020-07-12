<?php 
	function crearplantillaClave($email, $clave){
		//$idventa="qfrFFbNchrIOeqBzHPmbaxLvfV012rFa60MvJmthTrWaTtY90V";
		$urlheader="http://ikerany.com/docentes/img/header.png";
		$urlfooter="http://ikerany.com/docentes/img/footer.png";
		$cuerpo="
		<!DOCTYPE html>
		<html lang='es'>
		<head>
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		<title>NOTIFICACION</title>
		</head>
		<body style='background-color: white;'>
		<table style='max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;'>
			<tr>
				<td style='padding: 0'>
					<img style='padding: 0; display: block' src='".$urlheader."' width='100%'>
				</td>
			</tr>
			<tr>
				<td style='background-color: #ffe8a1'>
					<div style='color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif'>
						<h3 style='color: #029a46; margin: 0 0 7px'>ESTIMADO DOCENTE</h3>
						<p style='margin: 2px; font-size: 15px'>
							".utf8_decode('La presente es una confirmaci&oacuten de actualizaci&oacuten de su clave')."<br></p>
							<hr>	
						<h4 style='color: #0f1010; margin: 0 0 7px'>INFORMACION REGISTRADA</h4>					
						<br>	
						<p style='margin: 2px; font-size: 15px'>
							EMAIL: ".utf8_decode($email)."<br>
							PASSWORD: ".utf8_decode($clave)."<br>
							IP: ".getRealIP()."<br>
							FECHA DE REGISTRO: ".date('Y-m-d H:i:s')."<br>
							</p>
						<div style='width: 100%; text-align: center'>
							<p style='text-decoration: none; border-radius: 5px; padding: 11px 23px; color: black; background-color: #ffe8a1' href='#'>".utf8_decode('Forj&aacutete un mejor futuro!')."</p><br>	
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td style='padding: 0'>
					<img style='padding: 0; display: block' src='".$urlfooter."' width='100%'>
				</td>
			</tr>
		</table>
		</body>
		</html>";
		return $cuerpo;
	}
	function crearplantilla($docente){
		//$idventa="qfrFFbNchrIOeqBzHPmbaxLvfV012rFa60MvJmthTrWaTtY90V";
		$urlheader="http://ikerany.com/docentes/img/header.png";
		$urlfooter="http://ikerany.com/docentes/img/footer.png";
		$cuerpo="
		<!DOCTYPE html>
		<html lang='es'>
		<head>
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		<title>NOTIFICACION</title>
		</head>
		<body style='background-color: white;'>
		<table style='max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;'>
			<tr>
				<td style='padding: 0'>
					<img style='padding: 0; display: block' src='".$urlheader."' width='100%'>
				</td>
			</tr>
			<tr>
				<td style='background-color: #ffe8a1'>
					<div style='color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif'>
						<h3 style='color: #029a46; margin: 0 0 7px'>ESTIMADO! ".utf8_decode($docente['nombres'])." ".utf8_decode($docente['apellidos'])."</h3>
						<p style='margin: 2px; font-size: 15px'>
							".utf8_decode('La presente es una confirmaci&oacuten de su registro al sistema de control de asistencias de docente ASIS-DOCENTES.')."<br></p>
							<hr>	
						<h4 style='color: #0f1010; margin: 0 0 7px'>DATOS REGISTRADOS</h4>					
						<br>	
						<p style='margin: 2px; font-size: 15px'>
							CEDULA: ".utf8_decode($docente['cedula'])."<br>
							CELULAR: ".utf8_decode($docente['celular'])."<br>
							EMAIL: ".utf8_decode($docente['email'])."<br>
							IP: ".getRealIP()."<br>
							FECHA DE REGISTRO: ".date('Y-m-d H:i:s')."<br>
							</p>
						<div style='width: 100%; text-align: center'>
							<p style='text-decoration: none; border-radius: 5px; padding: 11px 23px; color: black; background-color: #ffe8a1' href='#'>".utf8_decode('Forj&aacutete un mejor futuro!')."</p><br>	
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td style='padding: 0'>
					<img style='padding: 0; display: block' src='".$urlfooter."' width='100%'>
				</td>
			</tr>
		</table>
		</body>
		</html>";
		return $cuerpo;
	}
	function crearplantillaVacia(){
		//$idventa="qfrFFbNchrIOeqBzHPmbaxLvfV012rFa60MvJmthTrWaTtY90V";
		$urlheader="http://ikerany.com/docentes/img/header.png";
		$urlfooter="http://ikerany.com/docentes/img/footer.png";
		$cuerpo="
		<!DOCTYPE html>
		<html lang='es'>
		<head>
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		<title>NOTIFICACION</title>
		</head>
		<body style='background-color: white;'>
		<table style='max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;'>
			<tr>
				<td style='padding: 0'>
					<img style='padding: 0; display: block' src='".$urlheader."' width='100%'>
				</td>
			</tr>
			<tr>
				<td style='background-color: #ffe8a1'>
					<div style='color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif'>
						<h3 style='color: #029a46; margin: 0 0 7px'>ESTIMADO</h3>
						<p style='margin: 2px; font-size: 15px'>
							".utf8_decode('La presente es una confirmaci&oacuten de su registro al sistema de control de asistencias de docente ASIS-DOCENTES.')."<br></p>
							<hr>	
						<h4 style='color: #0f1010; margin: 0 0 7px'>DATOS REGISTRADOS</h4>					
						<br>	
						<p style='margin: 2px; font-size: 15px'>
							POS: ".getRealIP()."<br>
							</p>
						<div style='width: 100%; text-align: center'>
							<p style='text-decoration: none; border-radius: 5px; padding: 11px 23px; color: black; background-color: #ffe8a1' href='#'>".utf8_decode('Forj&aacutete un mejor futuro!')."</p><br>	
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td style='padding: 0'>
					<img style='padding: 0; display: block' src='".$urlfooter."' width='100%'>
				</td>
			</tr>
		</table>
		</body>
		</html>";
		return $cuerpo;
	}
	function crearplantillaEntrada($docente, $marcacion, $observacion){
		if($observacion=='ENTRADA'){
			$fechahora=$marcacion['entrada'];
		}else{
			$fechahora=$marcacion['salida'];
		}
		//$idventa="qfrFFbNchrIOeqBzHPmbaxLvfV012rFa60MvJmthTrWaTtY90V";
		$urlheader="http://ikerany.com/docentes/img/header.png";
		$urlfooter="http://ikerany.com/docentes/img/footer.png";
		$urlfoto="https://netclics.com/docentes/img/fotos/".$marcacion['foto'];
		$cuerpo="
		<!DOCTYPE html>
		<html lang='es'>
		<head>
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		<title>CONFIRMACIÓN DE ASITENCIA</title>
		</head>
		<body style='background-color: white;'>
		<table style='max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;'>
			<tr>
				<td style='padding: 0'>
					<img style='padding: 0; display: block' src='".$urlheader."' width='100%'>
				</td>
			</tr>
			<tr>
				<td style='background-color: #ffe8a1'>
					<div style='color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif'>
						<h3 style='color: #029a46; margin: 0 0 7px'>ESTIMADO! ".utf8_decode($docente['nombres'])." ".utf8_decode($docente['apellidos'])."</h3>
						<p style='margin: 2px; font-size: 15px'>
							".utf8_decode('La presente es una confirmaci&oacuten de asistencia de '.$marcacion['observacion'].' mediante ASIS-DOCENTES.')."<br></p>
							<hr>	
						<h4 style='color: #0f1010; margin: 0 0 7px'>DATOS REGISTRADOS</h4>					
						<br>	
						<p style='margin: 2px; font-size: 15px'>						
							REGISTRO: ".utf8_decode($fechahora)."<br>
							UBICACION: <a href='https://www.google.com/maps/@".$marcacion['lat'].",".$marcacion['longitud'].",20z'>Ver en mapa</a><br>
							POS: ".getRealIP()."<br>
							</p>
						<div style='width: 100%; text-align: center'>
							<p style='text-decoration: none; border-radius: 5px; padding: 11px 23px; color: black; background-color: #ffe8a1' href='#'>
							<img src='".$urlfoto."' class='thumbnail' width='150px'><hr>
							".utf8_decode('Forj&aacutete un mejor futuro!')."</p><br>	
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td style='padding: 0'>
					<img style='padding: 0; display: block' src='".$urlfooter."' width='100%'>
				</td>
			</tr>
		</table>
		</body>
		</html>";
		return $cuerpo;
	}
	function crearplantillaContraseña($clave, $email){
		//$idventa="qfrFFbNchrIOeqBzHPmbaxLvfV012rFa60MvJmthTrWaTtY90V";
		$urlheader="http://ikerany.com/docentes/img/header.png";
		$urlfooter="http://ikerany.com/docentes/img/footer.png";
		$cuerpo="
		<!DOCTYPE html>
		<html lang='es'>
		<head>
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		<title>RECUPERACION DE CLAVE</title>
		</head>
		<body style='background-color: white;'>
		<table style='max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;'>
			<tr>
				<td style='padding: 0'>
					<img style='padding: 0; display: block' src='".$urlheader."' width='100%'>
				</td>
			</tr>
			<tr>
				<td style='background-color: #ffe8a1'>
					<div style='color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif'>
						<h3 style='color: #029a46; margin: 0 0 7px'>ESTIMADO DOCENTE!</h3>
						<p style='margin: 2px; font-size: 15px'>
							".utf8_decode('La presente es una confirmaci&oacuten de recuperaci&oacuten de  su clave mediante ASIS-DOCENTES.')."<br></p>
							<hr>	
						<h4 style='color: #0f1010; margin: 0 0 7px'>DATOS DE USUARIO</h4>					
						<br>	
						<p style='margin: 2px; font-size: 15px'>						
							EMAIL: ".$email."<br>
							CLAVE: ".$clave."<br>
							UBICACION: ".getRealIP()."
							</p>
					</div>
				</td>
			</tr>
			<tr>
				<td style='padding: 0'>
					<img style='padding: 0; display: block' src='".$urlfooter."' width='100%'>
				</td>
			</tr>
		</table>
		</body>
		</html>";
		return $cuerpo;
	}
	function getRealIP(){

        if (isset($_SERVER["HTTP_CLIENT_IP"])){

            return $_SERVER["HTTP_CLIENT_IP"];

        }elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){

            return $_SERVER["HTTP_X_FORWARDED_FOR"];

        }elseif (isset($_SERVER["HTTP_X_FORWARDED"])){

            return $_SERVER["HTTP_X_FORWARDED"];

        }elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){

            return $_SERVER["HTTP_FORWARDED_FOR"];

        }elseif (isset($_SERVER["HTTP_FORWARDED"])){

            return $_SERVER["HTTP_FORWARDED"];

        }else{

            return $_SERVER["REMOTE_ADDR"];

        }
    }   
?>