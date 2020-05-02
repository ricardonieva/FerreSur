<?php
require_once ('../persistence/database.php');

class GrupoFamiliar{

    public $idgrupofamiliar;
    public $apellido;
    public $nombre;
    public $dni ;
    public $parentesco;
    public $fechanacimiento;
    public $empleado_idEmpleado;
    public $discapacidad;
    public $estudio;
    public $nivel;
    
    public function agregarFamiliar($apellido, $nombre, $dni, $parentesco, $fechaNac, $discapacidad, $estudio, $nivel, $idEmpleado){
        $connect = Database::connectDB();
        $sql = "INSERT INTO grupofamiliar(dni, empleado_idEmpleado, apellido, nombre, parentesco, fechanacimiento, discapacidad, estudio, nivel) VALUES ($dni, $idEmpleado, '$apellido', '$nombre', '$parentesco', '$fechaNac', $discapacidad, $estudio, '$nivel')";
        var_dump($sql);
        $result = $connect->query($sql);
        if($result != false){
            return "Se Cargo Correctamente";
        }else{
            return false;
        }
    }

    public function traerFamiliares($idEmpleado){

            $connect = Database::connectDB();
            $sql = "SELECT * FROM grupofamiliar WHERE empleado_idEmpleado = $idEmpleado";
            $result = $connect->query($sql);
            if($result != false){
                $count = $result->rowCount();
                if($count > 0){                           
                    return $result->fetchAll();
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
    
        }

    public function borrarFamiliar($idIntegrante){
        $connect = Database::connectDB();
        $sql = "DELETE FROM grupofamiliar WHERE idgrupofamiliar = $idIntegrante"; 
        $result = $connect->query($sql);
        if($result != false){
            return "Se borro Correctamente";
        }else{
            return false;
        }


    }

    public function modificarFamiliar($idIntegrante, $nombre, $apellido, $dni, $parentesco, $fechaNac, $discapacidad, $estudio, $nivel){
        $connect = Database::connectDB();
        $sql = "UPDATE grupofamiliar SET apellido = '$apellido', nombre ='$nombre', dni = '$dni', parentesco = '$parentesco', fechanacimiento = '$fechaNac', discapacidad = $discapacidad, estudio = $estudio, nivel = '$nivel'  WHERE idgrupofamiliar = $idIntegrante";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false){
            return "Se cargo correctamente";
        }else{
            return false;
        }
    }

    
  
}
?>