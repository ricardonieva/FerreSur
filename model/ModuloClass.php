<?php
require_once ('../persistence/database.php');

class Modulo{

    public $idmodulo;
    public $nombre;
    public $descripcion; 

    public $listaDeSubModulos = array();

    public static function selectAllModulos(){
        $connect = Database::connectDB();
        $sql = "SELECT * FROM modulo";
        $result = $connect->query($sql)->fetchAll();
        if($result != false){
            return $result;
        }else{
            return false;
        }
    }

    public function traerRolEmpleado($idEmpleado){
        $connect = Database::connectDB();
        $sql = "SELECT * FROM empleado_has_modulo, modulo where empleado_idEmpleado = $idEmpleado AND empleado_has_modulo.modulo_idmodulo = modulo.idmodulo";
        //var_dump($sql);
        $result = $connect->query($sql)->fetchAll();
        if($result != false){
            return $result;
        }else{
            return false;
        }
    }

    public function cargarRolEmpleado($idRol, $idEmpleado){
        $connect = Database::connectDB();
        $sql = "INSERT INTO empleado_has_modulo (modulo_idmodulo, empleado_idEmpleado) VALUES ($idRol, $idEmpleado)";
        $result = $connect->query($sql);
        if($result != false){
            return true;
        }else{
            return false;
        }
    }

    //esta funcion consulta si el rol ya esta asginado al empleado
    public function consultaRolEmpleado($idRol, $idEmpleado){
        $connect = Database::connectDB();
        $sql = "SELECT * FROM empleado_has_modulo WHERE modulo_idmodulo = $idRol AND empleado_idEmpleado = $idEmpleado";
        //var_dump($sql);
        $result = $connect->query($sql)->rowCount();
        if($result > 0){
            return true;
        }else{
            return false;
        }
    }

    public function eliminarRolEmpleado($idRol, $idEmpleado){
        $connect = Database::connectDB();
        $sql = "DELETE FROM empleado_has_modulo WHERE modulo_idmodulo = $idRol AND empleado_idEmpleado = $idEmpleado";
        $result = $connect->query($sql);
        return $result;
    }
}

?>