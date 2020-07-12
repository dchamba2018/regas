<?php 
class claseMarcaciones {   
    private $tabla="marcaciones";
    public function insertar($iddocente, $entrada, $lat, $longitud, $ip, $observacion, $precision1, $foto, $salida){
        $sql="Insert into ".$this->tabla."  values(null,".$iddocente.", '".$entrada."', '".$lat."', '".$longitud."', '".$ip."', '".$observacion."', ".$precision1.",'".$foto."','".$salida."');";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";

        return GuardarActualizarEliminar($sql);  
    }
    public function actualizarfotodescargados($id){
        date_default_timezone_set('America/Guayaquil');
        $sql="Update ".$this->tabla." set foto='foto.png' where(id=".$id.");";
        include $_SERVER['DOCUMENT_ROOT'] . "/data.dc";
        include $_SERVER['DOCUMENT_ROOT'] . "/".$carpeta."/config/conection.dc";
        return GuardarActualizarEliminar($sql);  
    }
    public function actualizarEstado($idmarcacion, $estado){
        $sql="Update ".$this->tabla." set observacion='".$estado."' where(id=".$idmarcacion.");";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";

        return GuardarActualizarEliminar($sql);  
    }
    public function actualizarFoto($idmarcacion, $foto){
        $sql="Update ".$this->tabla." set foto='".$foto."' where(id=".$idmarcacion.");";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";

        return GuardarActualizarEliminar($sql);  
    }
    public function actualizarEntrada($entrada, $lat, $long, $ip, $observacion, $precision, $foto, $idmarcacion){
        $sql="Update ".$this->tabla."  set entrada='".$entrada."', lat='".$lat."', longitud='".$long."', ip='".$ip."', observacion='".$observacion."', precision1=".$precision.", foto='".$foto."' where(id=".$idmarcacion.");";

        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";
        return GuardarActualizarEliminar($sql);  
    }
    public function actualizarEntradaAtrazado($idmarcacion, $entrada){
        $sql="Update ".$this->tabla."  set entrada='".$entrada."' where(id=".$idmarcacion.");";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";

        return GuardarActualizarEliminar($sql);  
    }
    public function actualizarSalidaAbandono($idmarcacion, $salida){
        $sql="Update ".$this->tabla."  set salida='".$salida."', observacion='SALIDA' where(id=".$idmarcacion.");";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";

        return GuardarActualizarEliminar($sql);  
    }
    public function actualizarSalida($salida, $lat, $long, $ip, $observacion, $precision, $foto, $idmarcacion){
        $sql="Update ".$this->tabla."  set salida='".$salida."', lat='".$lat."', longitud='".$long."', ip='".$ip."', observacion='".$observacion."', precision1=".$precision.", foto='".$foto."' where(id=".$idmarcacion.");";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";

        return GuardarActualizarEliminar($sql);  
    }
    public function consultaMarcacion($listaDocentes){
        date_default_timezone_set('America/Guayaquil');
        $lista=$this->getMarcacionDiarias();
        $dia=$this->get_nombre_dia();
        if($dia=="Domingo" || $dia=="Sabado"){

        }else{
            if(count($lista)==0){
                $sql="Insert into ".$this->tabla."  values";
                $fila=1;
                foreach ( $listaDocentes as $docente ) {
                    if($fila==count($listaDocentes)){
                        $sql.="(null,".$docente['id'].", '".date('Y-m-d H:i:s')."', '', '', '', 'INASISTENCIA', 0,'','".date('Y-m-d H:i:s')."')";    
                    }else{
                        $sql.="(null,".$docente['id'].", '".date('Y-m-d H:i:s')."', '', '', '', 'INASISTENCIA', 0,'','".date('Y-m-d H:i:s')."'),";    
                        $fila++;
                    }                
                }
                include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/operaciones.php";
                include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";
                GuardarActualizarEliminar($sql);  
            }
        }
        
    }
    public function getComprobantesSeisMeses($fecha){
        $conn=$this->conectarbd();
        $sql = "SELECT marcaciones.id,
                        marcaciones.foto 
                FROM ".$this->tabla." 
                where(date(marcaciones.entrada)<='".$fecha."' and marcaciones.foto!='foto.png') ;";
        $result = $conn->query($sql);
        $aItems=array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $aItems[]=$row;
            }
        }
        return $aItems;
    }
    function get_nombre_dia(){
       $fechats = strtotime(date("Y-m-d")); //pasamos a timestamp
        //el parametro w en la funcion date indica que queremos el dia de la semana
        //lo devuelve en numero 0 domingo, 1 lunes,....
        switch (date('w', $fechats)){
            case 0: return "Domingo"; break;
            case 1: return "Lunes"; break;
            case 2: return "Martes"; break;
            case 3: return "Miercoles"; break;
            case 4: return "Jueves"; break;
            case 5: return "Viernes"; break;
            case 6: return "Sabado"; break;
        }
    }
    public function getMarcacionDiarias(){
        date_default_timezone_set('America/Guayaquil');
        $conn=$this->conectarbd();
        $sql = "SELECT * from ".$this->tabla." where(date(entrada)='".date('Y-m-d')."')";
        $result = $conn->query($sql);
        $aItems=array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $aItems[]=$row;
            }
        }
        $conn->close();
        return $aItems;
    }
    public function getListaMeses(){
        date_default_timezone_set('America/Guayaquil');
        $conn=$this->conectarbd();
        $sql = "SELECT DISTINCT(CONCAT(MONTH(entrada),'/',YEAR(entrada))) AS meses FROM marcaciones order by entrada;";

        $result = $conn->query($sql);
        $aItems=array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $aItems[]=$row;
            }
        }
        $conn->close();
        return $aItems;
    }
    public function getMarcacionDiariasDocentes(){
        date_default_timezone_set('America/Guayaquil');
        $conn=$this->conectarbd();
        $sql = "SELECT marcaciones.`id`, UPPER(CONCAT(docentes.`apellidos`, ' ', docentes.`nombres`)) AS docente, time(marcaciones.`entrada`) as entrada,
time(marcaciones.`salida`) as salida, marcaciones.`observacion`, `marcaciones`.`lat`, marcaciones.`longitud`, marcaciones.`foto` FROM marcaciones, docentes
WHERE(DATE(entrada)='".date('Y-m-d')."' AND `docentes`.id=`marcaciones`.`iddocente` and docentes.estado='ACTIVO') order by docente;";
        $result = $conn->query($sql);
        $aItems=array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $aItems[]=$row;
            }
        }
        $conn->close();
        return $aItems;
    }
    public function getMarcacionDiariasDocentesSeleccionado($iddocente){
        date_default_timezone_set('America/Guayaquil');
        $conn=$this->conectarbd();
        $sql = "SELECT marcaciones.`id`, CONCAT(docentes.`nombres`, ' ', docentes.`apellidos`) AS docente, time(marcaciones.`entrada`) as entrada,
time(marcaciones.`salida`) as salida, marcaciones.`observacion`, `marcaciones`.`lat`, marcaciones.`longitud`, marcaciones.`foto` FROM marcaciones, docentes
WHERE(DATE(entrada)='".date('Y-m-d')."' and `docentes`.id=".$iddocente." AND `docentes`.id=`marcaciones`.`iddocente` and docentes.estado='ACTIVO') order by docente;";
        $result = $conn->query($sql);
        $aItems=array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $aItems[]=$row;
            }
        }
        $conn->close();
        return $aItems;
    }
    public function getMarcacionObservacion($iddocente, $fechahora, $observacion){
        $conn=$this->conectarbd();
        $sql = "SELECT * from ".$this->tabla." where(iddocente=".$iddocente." and date(entrada)='".$fechahora."' and observacion='".$observacion."')";
        $result = $conn->query($sql);
        $marcacion="";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $marcacion=$row;
            }
        }
        $conn->close();
        return $marcacion;
    }
    public function getMarcacion($iddocente, $fechahora){
        $conn=$this->conectarbd();
        $sql = "SELECT * from ".$this->tabla." where(iddocente=".$iddocente." and date(entrada)='".$fechahora."')";
        $result = $conn->query($sql);
        $marcacion="";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $marcacion=$row;
            }
        }
        $conn->close();
        return $marcacion;
    }
    public function getContarMarcacionDocente($iddocente){
        $conn=$this->conectarbd();
        $sql = "SELECT count(*) as total from ".$this->tabla." where(iddocente=".$iddocente.")";
        $result = $conn->query($sql);
        $marcacion="0";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $marcacion=$row['total'];
            }
        }
        $conn->close();
        return $marcacion;
    }
    public function getTotalMarcacionDocente($iddocente,$mes, $hentrada){
        $conn=$this->conectarbd();
        $sql = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(TIME(entrada), '".$hentrada."')))) as atrazo
FROM `marcaciones` 
WHERE(iddocente=".$iddocente." AND CONCAT(MONTH(entrada),'/',YEAR(entrada))='".$mes."' AND TIME(entrada)>'".$hentrada."' AND observacion!='INASISTENCIA');";

        $result = $conn->query($sql);
        $atrazo="";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $atrazo=$row['atrazo'];
            }
        }
        $conn->close();
        return $atrazo;
    }
    public function getMarcacionesMes(){
        $conn=$this->conectarbd();
        $sql = "SELECT count(*) as nummarcaciones from ".$this->tabla." where(Year(entrada)='".date('Y')."' and MONTH(entrada)='".date('m')."')";
        $result = $conn->query($sql);
        $marcaciones="0";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $marcaciones=$row['nummarcaciones'];
            }
        }
        $conn->close();
        return $marcaciones;
    }
    public function getDiasLaboradosMesDocente($iddocente){
        $conn=$this->conectarbd();
        $sql = "SELECT count(*) as nummarcaciones from ".$this->tabla." where(Year(entrada)='".date('Y')."' and MONTH(entrada)='".date('m')."' and iddocente=".$iddocente." and observacion='SALIDA')";
        $result = $conn->query($sql);
        $marcaciones="0";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $marcaciones=$row['nummarcaciones'];
            }
        }
        $conn->close();
        return $marcaciones;
    }
    public function getDiasLaboradosMesDocenteAbandono($iddocente){
        $conn=$this->conectarbd();
        $sql = "SELECT count(*) as nummarcaciones from ".$this->tabla." where(Year(entrada)='".date('Y')."' and MONTH(entrada)='".date('m')."' and iddocente=".$iddocente." and observacion='ENTRADA')";
        $result = $conn->query($sql);
        $marcaciones="0";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $marcaciones=$row['nummarcaciones'];
            }
        }
        $conn->close();
        return $marcaciones;
    }
    public function getMarcacionesDocenteMesDesc($iddocente, $mes, $hentrada, $hsalida){
        $conn=$this->conectarbd();
        $sql = "SELECT date(entrada) as fecha, lat, longitud, precision1, foto, id,
        if(observacion='INASISTENCIA','',time(entrada)) as entrada, 
        if(time(salida)<'".$hsalida."','',time(salida)) as salida,  
        IF(time(entrada)>'".$hentrada."',if(observacion='INASISTENCIA','',TIMEDIFF(time(entrada), '".$hentrada."')),'') as atrazo, 
        IF(time(salida)<'".$hsalida."',if(observacion='INASISTENCIA', observacion,'ABANDONO'),if(observacion='SALIDA','',observacion)) as observacion,
        observacion as justificada
        from ".$this->tabla." where(iddocente=".$iddocente." and CONCAT(MONTH(entrada),'/',YEAR(entrada))='".$mes."') order by date(entrada) DESC";
        
        $result = $conn->query($sql);
        $aItems=array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $aItems[]=$row;
            }
        }
        $conn->close();
        return $aItems;
    }
    
    public function getMarcacionesDocenteMes($iddocente, $mes, $hentrada, $hsalida){
        $conn=$this->conectarbd();
        $sql = "SELECT date(entrada) as fecha, lat, longitud, foto, 
        if(observacion='INASISTENCIA','',time(entrada)) as entrada, 
        if(time(salida)<'".$hsalida."','',time(salida)) as salida,  
        IF(time(entrada)>'".$hentrada."',if(observacion='INASISTENCIA','',TIMEDIFF(time(entrada), '".$hentrada."')),'') as atrazo, 
        IF(time(salida)<'".$hsalida."',if(observacion='INASISTENCIA', observacion,'ABANDONO'),if(observacion='SALIDA','',observacion)) as observacion,
        observacion as justificada
        from ".$this->tabla." where(iddocente=".$iddocente." and CONCAT(MONTH(entrada),'/',YEAR(entrada))='".$mes."') order by day(entrada)";
        $result = $conn->query($sql);
        $aItems=array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $aItems[]=$row;
            }
        }
        $conn->close();
        return $aItems;
    }

    public function getTotalDiasLaborados($mes, $observacion){
        $conn=$this->conectarbd();
        $sql = "SELECT CONCAT(nombres, ' ', apellidos) AS docente, COUNT(*) AS dias, docentes.id as iddocente 
FROM marcaciones, `docentes` 
WHERE (`marcaciones`.`iddocente`=`docentes`.`id` 
AND CONCAT(MONTH(entrada),'/',YEAR(entrada))='".$mes."' and marcaciones.`observacion`='".$observacion."') GROUP BY `docentes`.`id`";
        $result = $conn->query($sql);
        $aItems=array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $aItems[]=$row;
            }
        }
        $conn->close();
        return $aItems;
    }
    public function getAtrazosMensuales($mes, $entrada){
        $conn=$this->conectarbd();
        $sql = "SELECT CONCAT(nombres, ' ', apellidos) AS docente, 
        SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(TIME(entrada), '".$entrada."'))))  diferencia FROM `marcaciones`, `docentes`
WHERE(`marcaciones`.`iddocente`=`docentes`.`id` 
AND TIME(entrada)>'".$entrada."' 
AND CONCAT(MONTH(entrada),'/',YEAR(entrada))='".$mes."') GROUP BY `docentes`.`id`;
";
        $result = $conn->query($sql);
        $aItems=array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $aItems[]=$row;
            }
        }
        $conn->close();
        return $aItems;
    }
    public function conectarbd(){
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            $mensaje="NO SE CONECTO";
        }
        return $conn;
    }
}
?>