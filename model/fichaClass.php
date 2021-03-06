<?php
require_once ('../persistence/database.php');

class ficha 
{
    public $idficha;
    public $cantidad;
    public $fecha;
    public $empleado;

    public function nuevaFicha()
    {
        try
        {
            $connect = Database::connectDB();
            $sql = "INSERT INTO ficha(cantidad, fecha, empleado_idEmpleado) VALUES ($this->cantidad, '$this->fecha', $this->empleado)";
            //var_dump($sql);
            $result = $connect->query($sql);
            if (!$result)
            {
               return false;
            }
            else
            {
                return true;
            }
        }
        catch(Exception $ex)
        {
            return false;
        }
    }

    public function cargarFichas(){
        $connect = Database::connectDB();
        $sql = "SELECT * FROM ficha, empleado WHERE ficha.empleado_idEmpleado = empleado.idEmpleado ORDER BY ficha.fecha DESC";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result->rowCount() >0)
        {
            return $result->fetchAll();
        }
        else
        {
            echo "<script> alert('No se encontro fichas cargadas'); </script>";
        }
    }

    public function eliminarFicha()
    {
        try 
        {
            $connect= Database::connectDB();
            $sql = "DELETE FROM ficha where idficha = $this->idficha";
            //var_dump($sql);
            $result = $connect->query($sql);
            if ($result != false) 
            {
                return true;
            }
            else
            {
                return false;
            }
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

    public function modificarFicha()
    {
        try
        {
            $connect = Database::connectDB();
            $sql = "UPDATE ficha SET cantidad = $this->cantidad, fecha = '$this->fecha', empleado_idEmpleado = $this->empleado WHERE idficha = $this->idficha";
            // var_dump($sql);
            $result = $connect->query($sql);
            if($result != false)
            {
                return true;                
            }
            else
            {
                return false;
            }
        } 
        catch (Exception $e) 
        {
            return false;
        }
    }

}
?>