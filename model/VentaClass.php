<?php
require_once ('../persistence/database.php');
class Venta
{
    public $idventa;
    public $fechaHora;
    public $tipodepago;
    public $estado;
    public $idEmpleado;
    public $idcliente;

    public function insertrVenta()
    {
        $connect = Database::connectDB();
        $sql = "INSERT INTO venta (fechaHora, tipodepago, estado, idEmpleado, idcliente)
        VALUES (now(), '$this->tipodepago', '$this->estado', $this->idEmpleado, $this->idcliente)";
        //var_dump($sql);
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

    public function consultarVenta()
    {
        $connect = Database::connectDB();
        $sql = $sql= "SELECT MAX(idventa) AS id FROM venta";
        $result = $connect->query($sql);
        $result = $result->fetchObject();
        $idVenta = $result->id; 

        $sql = "SELECT * FROM venta WHERE idventa = $idVenta";
        $result = $connect->query($sql);
        $result = $result->fetchObject();
        return $result;
    }

    public function consultarVentasFechas($desde, $hasta)
    {
        $connect = Database::connectDB();
        if($desde == '' || $hasta == '')
        {
            $sql = "SELECT *, empleado.apellido as AP FROM venta,empleado,cliente WHERE venta.idEmpleado = empleado.idEmpleado AND venta.idcliente = cliente.idcliente ORDER BY fechaHora DESC";
        }
        else
        {
            $sql = "SELECT *, empleado.apellido as AP FROM venta,empleado,cliente WHERE venta.fechaHora BETWEEN '$desde' AND '$hasta' AND venta.idEmpleado = empleado.idEmpleado AND venta.idcliente = cliente.idcliente ORDER BY fechaHora DESC";
        }
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false)
        {
            if($result->rowCount() > 0)
            {
                return $result->fetchAll();
            }
            else
            {
                return false;
            }        
        }
        else
        {
            return false;
        }
    }

    public function buscarVentaPorId($idventa)
    {
        $connect = Database::connectDB();    
        $sql = "SELECT * FROM venta, lineaventa, articulo, cliente WHERE venta.idventa = $idventa AND venta.idcliente = cliente.idcliente AND 
        lineaventa.idventa = venta.idventa AND lineaventa.idarticulo = articulo.idarticulo";    
        $result = $connect->query($sql);
        if($result != false)
        {
            $count = $result->rowCount();
            if($count > 0)
            {
                return $result->fetchAll();
            }
            else
            {
                return false;
            }        
        }
        else
        {
            return false;
        }
    }

    public function ultimaIdDeVenta()
    {
        $connect = Database::connectDB();    
        $sql = "SELECT MAX(idventa) AS id FROM venta";    
        $result = $connect->query($sql);
        if($result != false)
        {
            if($result->rowCount() > 0)
            {
                return $result->fetchObject();
            }
            else
            {
                return false;
            }        
        }
        else
        {
            return false;
        }
    }

    public function deleteVenta()
    {
        try
        {
            $connect = Database::connectDB();    
            $connect->beginTransaction();
            $sql = "DELETE FROM lineaventa WHERE lineaventa.idventa = $this->idventa";
            $connect->exec($sql);
            $sql = "DELETE FROM venta WHERE venta.idventa = $this->idventa";  
            $connect->exec($sql);
            $connect->commit();
            return true;
        }
        catch(Exception $e)
        {
            $connect->rollBack();
            return false;
        }
    }

    public function anularVenta()
    {
        try
        {            
            $connect = Database::connectDB();
            $connect->beginTransaction();
            $sql = "SELECT * FROM venta WHERE venta.idventa = $this->idventa AND venta.estado = 'Finalizado'";
            //var_dump($sql);
            $result = $connect->query($sql);
            if($result->rowCount() > 0)
            {
                $sql = "UPDATE venta SET estado = 'Anulado' WHERE venta.idventa = $this->idventa";
                $result = $connect->exec($sql);
    
                $sql = "SELECT * FROM lineaventa WHERE lineaventa.idventa = $this->idventa";                
                $result = $connect->query($sql);
                if($result->rowCount() > 0)
                {                    
                    foreach($result->fetchAll() as $row)
                    {
                        $sql = "SELECT * FROM articulo WHERE articulo.idarticulo = ".$row['idarticulo'];
                        
                        $result = $connect->query($sql)->fetchObject();
                        $stock = $result->stock + $row['cantidad'];
                        $sql = "UPDATE articulo SET stock = $stock WHERE articulo.idarticulo = ".$row['idarticulo'];
                        $connect->exec($sql);
                    }
                    $connect->commit();
                    return true;
                }
                else
                {
                    return false;
                }    
            }
            else
            {
                return false;
            }          
        }
        catch(Exception $e)
        {
            $connect->rollBack();
            return false;
        }
    }
}
?>