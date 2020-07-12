<?php 
class claseUsuarios {   
    private $tabla="usuarios";
    public function insertar($iddocente, $estado, $email, $password, $rol){
        $sql="Insert into ".$this->tabla."  values(null,".$iddocente.", '".$estado."', '".$email."', '".$password."', '".$rol."');";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";
        return GuardarActualizarEliminar($sql);  
    }
    public function getUsuario($id){
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
    public function getUsuarioDocente($iddocente){
        $conn=$this->conectarbd();
        $sql = "SELECT * from ".$this->tabla." where(iddocente=".$iddocente.")";
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
    public function getUsuarioEmailClave($email, $clave){
        $conn=$this->conectarbd();
        $sql = "SELECT * from ".$this->tabla." where(email='".$email."' and password='".$clave."')";
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
    public function getUsuarioEmail($email){
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
    public function getUsuarios(){
        $conn=$this->conectarbd();
        $sql = "SELECT * from ".$this->tabla;
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