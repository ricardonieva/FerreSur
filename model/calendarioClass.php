<?php
include_once ('../persistence/database.php');

class Calendario{

    public $idcalendario;
    public $fecha;
    public $habil;

    public function agregarFecha(){
        $connect = Database::connectDB();
        $sql = "INSERT INTO calendario(fecha, habil) VALUES ('$this->fecha', $this->habil)";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false){
            return true;                    
        }else{
            $sql = "UPDATE calendario SET habil= $this->habil WHERE fecha = '$this->fecha'";
            $result = $connect->query($sql);
            if($result != false){
                return true;   
            }else{
                return false;
            }
        }    
    }

    public static function obtenerDiasLaborables($desde, $hasta)
    {
        try
        {
            $connect = Database::connectDB();
            $sql = "SELECT COUNT(*) AS dias FROM calendario WHERE calendario.fecha 
            BETWEEN '$desde' AND '$hasta' AND calendario.habil = 1";
            $result = $connect->query($sql);
             if (!$result) {
                echo "\nPDO::errorInfo():\n";
                print_r($connect->errorInfo());
            }
            else
            {
                $result = $result->fetchObject();
                return $result->dias;
            }
        }
        catch(Exception $ex)
        {
            echo "error".$ex->getMessage();
        }
        
    }
}

?>