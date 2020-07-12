<?php 
class claseHorarios {   
    private $tabla="horarios";
    public function insertar($nombre, $entrada, $salida){
        $sql="Insert into ".$this->tabla."  values(null,'".$nombre."', '".$entrada."', '".$salida."');";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";

        return GuardarActualizarEliminar($sql);  
    }
    public function getHorario($id){
        $conn=$this->conectarbd();
        $sql = "SELECT * from ".$this->tabla." where(id=".$id.")";
        $result = $conn->query($sql);
        $persona="";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $persona=$row;
            }
        }
        $conn->close();
        return $persona;
    }
    public function getHorarioDocSel($iddocente){
        $conn=$this->conectarbd();
        $sql = "SELECT horarios.id, nombre, entrada, salida FROM horarios, horariosdocentes WHERE(horarios.id=`horariosdocentes`.`idhorario` AND iddocente=".$iddocente." AND estado='ACTIVO')";
        $result = $conn->query($sql);
        $persona="";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $persona=$row;
            }
        }
        $conn->close();
        return $persona;
    }
    public function getHorarioMensual($idhorario){
        $conn=$this->conectarbd();
        $sql = "SELECT cedula, docentes.id as iddocente, CONCAT(apellidos, ' ', nombres) AS docente FROM docentes, horarios, horariosdocentes WHERE(horarios.`id`=".$idhorario." AND `horariosdocentes`.`idhorario`=`horarios`.id AND
`horariosdocentes`.`iddocente`=`docentes`.id AND `horariosdocentes`.`estado`='ACTIVO') order by docente";
       $result = $conn->query($sql);
        $persona=array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $persona[]=$row;
            }
        }
        $conn->close();
        return $persona;
    }
    public function getHorarios(){
        $conn=$this->conectarbd();
        $sql = "SELECT * from ".$this->tabla.";";
        //$sql = "SELECT id, nombre, entrada, salida, numDocentesHorario(id) AS numero  FROM ".$this->tabla.";";
        $result = $conn->query($sql);
        $aItems=array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $aItems[]=$row;
            }
        }
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