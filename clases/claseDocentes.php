<?php 
class claseDocentes {   
    private $tabla="docentes";
    public function insertar($nombres, $apellidos, $cedula, $celular, $email, $clave, $estado, $foto, $idapk){
        $sql="Insert into ".$this->tabla."  values(null,'".$nombres."', '".$apellidos."', '".$cedula."', '".$celular."', '".$email."', '".$clave."', '".$estado."', '".$foto."', '".$idapk."');";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";

        return GuardarActualizarEliminar($sql);  
    }
    public function actualizarEstadoDocente($id,  $estado){
        $sql="Update ".$this->tabla."  set  estado='".$estado."' where (id=".$id.");";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";
        return GuardarActualizarEliminar($sql);  
    }
    public function actualizarDocente($id, $nombres, $apellidos, $cedula, $celular, $email, $clave, $estado, $foto, $idapk){
        $sql="Update ".$this->tabla."  set nombres='".$nombres."', apellidos='".$apellidos."', cedula='".$cedula."', celular='".$celular."', email='".$email."' where (id=".$id.");";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";
        return GuardarActualizarEliminar($sql);  
    }
    public function actualizarDocenteApi($id, $nombres, $apellidos){
        $sql="Update ".$this->tabla."  set nombres='".$nombres."', apellidos='".$apellidos."' where (id=".$id.");";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";
        return GuardarActualizarEliminar($sql);  
    }
    public function actualizarDocenteVue($id, $nombres, $apellidos, $celular, $email){
        $sql="Update ".$this->tabla."  set 
        nombres='".$nombres."', 
        apellidos='".$apellidos."',
        celular='".$celular."', 
        email='".$email."' where (id=".$id.");";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";
        return GuardarActualizarEliminar($sql);  
    }
    public function actualizarDocenteVueFoto($id, $nombres, $apellidos, $celular, $email, $foto){
        $sql="Update ".$this->tabla."  set 
        nombres='".$nombres."', 
        apellidos='".$apellidos."',
        celular='".$celular."',
        email='".$email."',
        foto='".$foto."' where (id=".$id.");";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";
        return GuardarActualizarEliminar($sql);  
    }
    public function getDocente($id){
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
    public function getDocenteNoTienenHorario(){
        $conn=$this->conectarbd();
        $sql = "SELECT * FROM docentes t1 WHERE NOT EXISTS (SELECT NULL FROM `horariosdocentes` t2 WHERE t2.`iddocente` = t1.`id` and t2.estado='ACTIVO')";
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
    public function getDocenteTienenHorario($idhorario){
        $conn=$this->conectarbd();
        $sql = "SELECT * FROM docentes t1 WHERE EXISTS (SELECT NULL FROM `horariosdocentes` t2 WHERE t2.`iddocente` = t1.`id` AND t2.`idhorario`=".$idhorario." and t2.estado='ACTIVO')";
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
    public function getDocenteCedula($cedula){
        $conn=$this->conectarbd();
        $sql = "SELECT * from ".$this->tabla." where(cedula='".$cedula."')";
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
    public function getDocenteCedulaEmail($cedula, $email){
        $conn=$this->conectarbd();
        $sql = "SELECT * from ".$this->tabla." where(cedula='".$cedula."' and email='".$email."')";
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
    public function getDocenteEmail($email){
        $conn=$this->conectarbd();
        $sql = "SELECT * from ".$this->tabla." where(email='".$email."')";
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
    public function getDocentes($estado){
        $conn=$this->conectarbd();
        $sql = "SELECT * from ".$this->tabla." where(estado='".$estado."') order by apellidos";
        $result = $conn->query($sql);
        $aItems=array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $aItems[]=$row;
            }
        }
        return $aItems;
    }
    public function getDocentesApi($dato, $estado){
        $conn=$this->conectarbd();
        $sql = "SELECT id, cedula, concat(nombres, ' ', apellidos) as persona, celular, 
        concat('https://netclics.com/docentes/img/fotos/',foto) as foto,
        email, estado
         FROM ".$this->tabla." where (
            concat(cedula, ' ', nombres,' ', apellidos) like '%".$dato."%' and estado='".$estado."'
        );";
        
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