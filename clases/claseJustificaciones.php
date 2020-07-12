<?php 
class claseJustificaciones {   
    private $tabla="justificaciones";
    public function insertar($idmarcacion, $motivo, $archivo, $fecha, $estado, $detalle, $tipo){
        $sql="Insert into ".$this->tabla."  values(null,".$idmarcacion.", '".$motivo."', '".$archivo."', '".$fecha."', '".$estado."', '".$detalle."', '','".$tipo."');";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";

        return GuardarActualizarEliminar($sql);  
    }
    public function actualizar($id, $motivo, $archivo, $fecha){
        $sql="Update ".$this->tabla."  set motivo='".$motivo."', archivo='".$archivo."', fecha='".$fecha."'where(id=".$id.");";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";

        return GuardarActualizarEliminar($sql);  
    }
    public function actualizarEstado($id, $estado, $observacion){
        $sql="Update ".$this->tabla."  set estado='".$estado."', observacion='".$observacion."' where(id=".$id.");";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";

        return GuardarActualizarEliminar($sql);  
    }
    public function actualizarEstadoObservacionArchivo($id, $estado, $observacion, $archivo){
        $sql="Update ".$this->tabla."  set estado='".$estado."', observacion='".$observacion."', archivo='".$archivo."' where(id=".$id.");";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";

        return GuardarActualizarEliminar($sql);  
    }
    public function getJustificacionesMes(){
        $conn=$this->conectarbd();
        $sql = "SELECT count(*) as num from ".$this->tabla;
        $result = $conn->query($sql);
        $marcaciones="0";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $marcaciones=$row['num'];
            }
        }
        $conn->close();
        return $marcaciones;
    }
    public function getJustificacionesMarcacionTipo($idmarcacion, $tipo){
        $conn=$this->conectarbd();
        $sql = "SELECT * from ".$this->tabla." where(idmarcacion=".$idmarcacion." and tipo='".$tipo."')";
        $result = $conn->query($sql);
        $marcaciones="";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $marcaciones=$row;
            }
        }
        $conn->close();
        return $marcaciones;
    }
    public function getDocenteJustificacion($idjustificacion){
        $conn=$this->conectarbd();
        $sql = "SELECT CONCAT(DATE(marcaciones.`entrada`),' ', horarios.`salida`) AS salida, CONCAT(DATE(marcaciones.`entrada`),' ', horarios.`entrada`) AS entrada, marcaciones.id  FROM justificaciones, marcaciones, `horariosdocentes`, `horarios`, `docentes` WHERE
(justificaciones.`id`=".$idjustificacion." AND `justificaciones`.`idmarcacion`= `marcaciones`.`id` AND marcaciones.`iddocente`=docentes.`id` AND
docentes.id=`horariosdocentes`.`iddocente` AND `horariosdocentes`.`estado`='ACTIVO' AND `horariosdocentes`.`idhorario`=`horarios`.id);";    
        $result = $conn->query($sql);
        $docente="";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $docente=$row;
            }
        }
        $conn->close();
        return $docente;
    }
    public function getJustificacionesPendientesMes(){
        $conn=$this->conectarbd();
        $sql = "SELECT justificaciones.`id`, motivo, fecha, CONCAT(`docentes`.`nombres`, ' ', `docentes`.`apellidos`) AS docente,
`docentes`.`foto` FROM justificaciones, `docentes`, marcaciones 
WHERE (`justificaciones`.`idmarcacion`=`marcaciones`.`id` AND `marcaciones`.`iddocente`=`docentes`.id AND justificaciones.`estado`='REVISION') order by fecha Desc;";
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