<?php 
class claseHorariosDocentes {   
    private $tabla="horariosdocentes";
    public function insertar($iddocente, $idhorario){
        $sql="Insert into ".$this->tabla."  values(null,".$iddocente.", '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."', 'ACTIVO', '".$idhorario."');";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";
        return GuardarActualizarEliminar($sql);  
    }
    public function actualizar($idhorariodocente, $iddocente){
        $sql="Update ".$this->tabla."  set estado='INACTIVO', fechacaducidad='".date('Y-m-d H:i:s')."' where(idhorario='".$idhorariodocente."' and iddocente='".$iddocente."');";
        include $_SERVER['DOCUMENT_ROOT'] . "/docentes/config/conection.php";
        return GuardarActualizarEliminar($sql);  
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