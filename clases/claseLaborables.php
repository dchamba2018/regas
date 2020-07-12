<?php 
class claseLaborables {   
    private $tabla="nolaborables";
    public function insertar($id, $inicio, $fin, $motivo){
        $sql="Insert into ".$this->tabla."  values(null,'".$inicio."', '".$fin."', '".$motivo."');";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";

        return GuardarActualizarEliminar($sql);  
    }
    public function actualizar($id, $inicio, $fin, $motivo){
        $sql="Update ".$this->tabla."  set inicio='".$inicio."', fin='".$fin."', motivo='".$motivo."'where(id=".$id.");";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";

        return GuardarActualizarEliminar($sql);  
    }
    public function eliminar($id){
        $sql="Delete from ".$this->tabla." where(id=".$id.");";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";

        return GuardarActualizarEliminar($sql);  
    }
    public function getRegistroNolaborable($fecha){
        $conn=$this->conectarbd();
        $sql = "SELECT * from ".$this->tabla." where(inicio<='".$fecha."' and fin>='".$fecha."')";
        $result = $conn->query($sql);
        $dia="";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $dia=$row;
            }
        }
        $conn->close();
        return $dia;
    }
    public function getTotalNolaborable($mes){
        $conn=$this->conectarbd();
        $sql = "SELECT SUM(DATEDIFF(fin,inicio)+1) AS total FROM `nolaborables` WHERE (CONCAT(MONTH(inicio),'/',YEAR(inicio)) = '".$mes."');";
        $result = $conn->query($sql);
        $total=0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $total=$row['total'];
            }
        }
        $conn->close();
        return $total;
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