<?php 
class claseVacaciones {   
    private $tabla="vacaciones";
    public function insertar($iddocente, $desde, $hasta, $dias, $fecha, $estado, $respaldo){
        $sql="Insert into ".$this->tabla."  values(null,".$iddocente.", '".$desde."', '".$hasta."', ".$dias.", '".$fecha."', '".$estado."', '".$respaldo."');";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";
        return GuardarActualizarEliminar($sql);  
    }
    public function eliminar($id){
        $sql="delete from ".$this->tabla." where(id=".$id.");";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";
        return GuardarActualizarEliminar($sql);  
    }
    public function actualizarEstado($id, $estado){
        $sql="Update ".$this->tabla."  set estado='".$estado."' where(id=".$id.");";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";
        return GuardarActualizarEliminar($sql);  
    }
    public function getSumaVacacionesDocente($iddocente, $year){
        $conn=$this->conectarbd();
        $sql = "SELECT ifnull(sum(dias), '0') as num from ".$this->tabla." where(
            iddocente=".$iddocente." and 
            year(desde)=".$year." and 
            estado='APROBADO'
        )";
        $result = $conn->query($sql);
        $vacaciones="0";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $vacaciones=$row['num'];
            }
        }
        $conn->close();
        return $vacaciones;
    }
    public function getSumaVacacionesDocenteMes($iddocente, $mes){
        $conn=$this->conectarbd();
        $sql = "SELECT IFNULL(SUM(dias), 0) AS suma FROM vacaciones WHERE (`iddocente`=".$iddocente." AND 
        CONCAT(MONTH(desde),'/',YEAR(desde))='".$mes."' AND CONCAT(MONTH(hasta),'/',YEAR(hasta))='".$mes."');";
        $result = $conn->query($sql);
        $vacaciones="0";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $vacaciones=$row['suma'];
            }
        }
        $conn->close();
        return $vacaciones;
    }
    public function getSumaVacacionesDocenteDesde($iddocente, $mes){
        $conn=$this->conectarbd();
        $sql = "SELECT IFNULL(SUM(DATEDIFF(LAST_DAY(DATE_FORMAT(desde,'%Y-%m-01')), desde)+1),0) AS total 
FROM vacaciones
WHERE (`iddocente`=".$iddocente." AND
    CONCAT(MONTH(desde),'/',YEAR(desde))='".$mes."' AND
    CONCAT(MONTH(hasta),'/',YEAR(hasta))!='".$mes."');";
        $result = $conn->query($sql);
        $vacaciones="0";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $vacaciones=$row['total'];
            }
        }
        $conn->close();
        return $vacaciones;
    }
    public function getSumaVacacionesDocenteHasta($iddocente, $mes){
        $conn=$this->conectarbd();
        $sql = "SELECT  IFNULL(SUM(DATEDIFF(hasta, DATE_FORMAT(hasta,'%Y-%m-01'))+1),0) AS total 
        FROM vacaciones
        WHERE (`iddocente`=".$iddocente." AND
            CONCAT(MONTH(desde),'/',YEAR(desde))!='".$mes."' AND
            CONCAT(MONTH(hasta),'/',YEAR(hasta))='".$mes."'
        );";
        $result = $conn->query($sql);
        $vacaciones="0";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $vacaciones=$row['total'];
            }
        }
        $conn->close();
        return $vacaciones;
    }
    /*public function getSumaVacacionesDocenteMensuales($iddocente, $mes){
        $conn=$this->conectarbd();
        //$sql = "SELECT IFNULL(SUM(dias), 0) AS suma FROM vacaciones WHERE (`iddocente`=".$iddocente." AND 
        //CONCAT(MONTH(desde),'/',YEAR(desde))='".$mes."' AND CONCAT(MONTH(hasta),'/',YEAR(hasta))='".$mes."');";
        $sql = "SELECT IFNULL(SUM(dias), 0) AS suma FROM vacaciones WHERE (`iddocente`=".$iddocente." AND 
        CONCAT(MONTH(desde),'/',YEAR(desde))='".$mes."');";
        $result = $conn->query($sql);
        $vacaciones="0";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $vacaciones=$row['suma'];
            }
        }
        $conn->close();
        return $vacaciones;
    }*/
     public function getRegistroVacaciones($iddocente, $fecha){
        $conn=$this->conectarbd();
        $sql = "SELECT * from ".$this->tabla." where(desde<='".$fecha."' and hasta>='".$fecha."' and iddocente=".$iddocente.")";
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
    public function getVacaionesAnualesDocente($iddocente, $year){
        $conn=$this->conectarbd();
        $sql = "SELECT * from ".$this->tabla." where(iddocente=".$iddocente." and year(fecha)=".$year.")";
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
    public function getVacacionesApi(){
        $conn=$this->conectarbd();
        $sql = "SELECT vacaciones.id, 
        concat(docentes.nombres, ' ', docentes.apellidos) as docente,
        vacaciones.desde,
        vacaciones.hasta,
        vacaciones.dias,
        vacaciones.fecha,
        vacaciones.estado,
        vacaciones.respaldo
         FROM ".$this->tabla.", docentes 
        where (
            docentes.id=vacaciones.iddocente
        ) order by vacaciones.estado Desc;";
        $result = mysqli_query($conn, $sql);
        $conn->close();
        return $result;
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