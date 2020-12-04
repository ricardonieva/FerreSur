<?php
include_once ('../persistence/database.php');

class Asistencia{

    public $idasistencia;
    public $entrada;
    public $salida;
    public $novedades;
    public $horasExt;
    public $empleado;
    public $calendario;

    public function nuevaAsistencia($fecha, $entrada, $salida, $novedad, $idempleado){
        //var_dump($idempleado);

        $apertura = new DateTime($entrada);
        $cierre = new DateTime($salida);
        $tiempo = $apertura->diff($cierre);
        $tiempo = (int)$tiempo->format('%H');
        $tiempo = $tiempo - 4;
        if($tiempo < 0){
            $tiempo = 0;
        }

        $connect = Database::connectDB();
        // $fecha = date("Y-m-d");

        $sql = "SELECT * FROM asistencia,calendario WHERE asistencia.calendario_idcalendario =  calendario.idcalendario AND calendario.fecha = '$fecha' AND asistencia.empleado_idEmpleado = $idempleado";
        //var_dump($sql);
        $result = $connect->query($sql);
        $count = $result->rowCount();
        //var_dump($count);
        if($count < 2){
            $sql = "SELECT * FROM calendario WHERE calendario.fecha = '$fecha'";
            //var_dump($sql);
            $result = $connect->query($sql)->fetchObject();

            $sql = "INSERT INTO asistencia(entrada, salida, novedades, horasExt, empleado_idEmpleado, calendario_idcalendario) VALUES ('$entrada', '$salida', '$novedad', '$tiempo', $idempleado, $result->idcalendario)";
            //var_dump($sql);
            $result = $connect->query($sql);
            if($result != false){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

        
    }

    public function mostrarAsistenciaDeEmpleado($idempleado){
        $connect = Database::connectDB();
        $sql = "SELECT * FROM asistencia, calendario WHERE asistencia.empleado_idEmpleado = $idempleado AND asistencia.calendario_idcalendario = calendario.idcalendario ORDER BY calendario.fecha DESC LIMIT 100";
        //var_dump($sql);
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

    public function eliminarAsistencia($idasistencia){
        $connect = Database::connectDB();
        $sql = "DELETE FROM asistencia WHERE asistencia.idasistencia = $idasistencia";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false){
            return true;
           
        }else{
            return false;
        }
    }

    public function modificarAsistencia($idasistencia, $entrada, $salida, $novedad){

        $apertura = new DateTime($entrada);
        $cierre = new DateTime($salida);
        $tiempo = $apertura->diff($cierre);
        $tiempo = (int)$tiempo->format('%H');
        $tiempo = $tiempo - 4;
        if($tiempo < 0){
            $tiempo = 0;
        }

        $connect = Database::connectDB();
        $sql = "UPDATE asistencia SET entrada= '$entrada', salida= '$salida', novedades= '$novedad', horasExt= $tiempo WHERE asistencia.idasistencia = $idasistencia";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false){
            return true;
           
        }else{
            return false;
        }
    }

    public static function asistenciaDeEmpleadoPorPeriodo($desde, $hasta, $idempleado){
        $connect = Database::connectDB();
        $sql = "SELECT * FROM calendarioasistencia WHERE calendarioasistencia.empleado_idEmpleado = $idempleado AND calendarioasistencia.fecha BETWEEN '$desde' AND '$hasta' ORDER BY calendarioasistencia.fecha ASC";
        //var_dump($sql);
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
}
?>