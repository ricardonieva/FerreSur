<?php
require_once ('../persistence/database.php');
require_once ('../model/ArticuloClass.php');

class Compra 
{  
    public $idcompra;
    public $idproveedor;
    public $fecha;
    public $estado;
    public $idEmpleado;
    
    public function insertCompra()
    {
        $fecha = date('Y-m-d H:i:s');
        $connect = Database::connectDB();
        $sql = "INSERT INTO compra (idproveedor, fecha, estado, idEmpleado) 
        VALUES ($this->idproveedor, '$fecha', 'en proceso', $this->idEmpleado)";
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

    public function obtenerMaxId()
    {
        $connect = Database::connectDB();
        $sql = "SELECT MAX(idcompra) as id FROM compra";
        //var_dump($sql);
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
        }else
        {
            return false;
        }
    }

    public function selectCompra()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM compra where idcompra = $this->idcompra";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false)
        {
            if($result->rowCount() >0)
            {
                $result = $result->fetchObject();
                $this->idproveedor = $result->idproveedor;
                $this->fecha = $result->fecha;
                $this->estado = $result->estado;
                $this->idEmpleado = $result->idEmpleado ;
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

    public function consultarComprasFechas($desde, $hasta)
    {
        $connect = Database::connectDB();
        if($desde == '' || $hasta == '')
        {
            $sql = "SELECT * FROM compra,empleado,proveedor WHERE compra.idEmpleado = empleado.idEmpleado AND compra.idproveedor = proveedor.idproveedor ORDER BY fecha DESC";
        }
        else
        {
            $sql = "SELECT * FROM compra,empleado,proveedor WHERE compra.fecha BETWEEN '$desde' AND '$hasta' AND compra.idEmpleado = empleado.idEmpleado AND compra.idproveedor = proveedor.idproveedor ORDER BY fecha DESC";
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

    public function buscarCompraCompleta()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM compra, detalle_compra 
        WHERE compra.idcompra = $this->idcompra AND detalle_compra.idcompra = compra.idcompra";
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

    public function guardarCambiosDeCompra($idcompra, $detalle_compra)
    {
        try
        {
            $connect = Database::connectDB();
            $connect->beginTransaction();
            $sql = "DELETE FROM detalle_compra WHERE detalle_compra.idcompra = $idcompra";
            $connect->exec($sql);
            foreach($detalle_compra as $row)
            {
                $sql = "INSERT INTO detalle_compra(idcompra, unidades, articulo_costounitario, articulo_nombre, idarticulo) VALUES ($idcompra, $row->unidades, $row->costounitario, '$row->nombre',$row->codigo)";
                $connect->exec($sql);
            }
            $connect->commit();
            return true;
        }
        catch(Exception $ex)
        {
            $connect->rollBack();
            return false;
        }
    }

    public function deleteCompra()
    {
        try
        {
            $connect = Database::connectDB();
            $connect->beginTransaction();
            $sql = "DELETE FROM detalle_compra WHERE detalle_compra.idcompra = $this->idcompra";
            $connect->exec($sql);
            $sql = "DELETE FROM compra WHERE compra.idcompra = $this->idcompra";
            $connect->exec($sql);
            $connect->commit();
            return true;
        }
        catch(Exception $ex)
        {
            $connect->rollBack();
            return false;
        }
    }

    public function cambiarEstadoDeCompra()
    {
        try
        {
            $connect = Database::connectDB();
            $connect->beginTransaction();
            $sql = "SELECT estado FROM compra WHERE idcompra = $this->idcompra AND estado = 'en proceso'";
            $result =$connect->query($sql);
            if($result->rowCount() > 0)
            {
                $listaDetalleDeCompra = $this->buscarCompraCompleta();
                foreach($listaDetalleDeCompra as $row)
                {
                    $articulo = new Articulo();
                    $articulo->idarticulo = $row['idarticulo'];
                    $articulo->reducirStock(-$row['unidades']);
                }
            }
            $sql = "UPDATE compra SET estado='Finalizado' WHERE idcompra = $this->idcompra";
            $connect->exec($sql);
            $connect->commit();
            return true;
        }
        catch(Exception $ex)
        {
            $connect->rollBack();
            return false;
        }
    }
}
?>