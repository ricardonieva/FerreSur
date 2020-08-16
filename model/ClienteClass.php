<?php
require_once ('../persistence/database.php');
class Cliente
{
    public $idcliente;
    public $nombre;
    public $cuit;
    public $direccion;
    public $localidad;
    public $condicioniva;

    public function selectCuitCliente()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM cliente WHERE cuit=$this->cuit";
        //var_dump($sql);
        $result = $connect->query($sql);
        
        if($result != false)
        {    
            if($result->rowCount() > 0)
            {
                $result = $result->fetchObject();
                $this->idcliente = $result->idcliente;
                $this->nombre = $result->nombre;
                $this->cuit = $result->cuit;
                $this->direccion = $result->direccion;
                $this->localidad = $result->localidad;
                $this->condicioniva = $result->condicioniva;

                return true;
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

    public function selectAllClientes()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM cliente";
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

    public function insertCliente()
    {
        $connect = Database::connectDB();
        $sql = "INSERT INTO cliente(nombre, cuit, direccion, localidad, condicioniva)
        VALUES ('$this->nombre', '$this->cuit', '$this->direccion', '$this->localidad', '$this->condicioniva')";
        $result = $connect->query($sql);
        if($result != false)
        {    
           return true;
           //return $sql;
        }
        else
        {          
            return false;
        }
    }

    public function updateCliente()
    {
        $connect = Database::connectDB();
        $sql = "UPDATE cliente SET nombre= '$this->nombre', cuit= $this->cuit, direccion= '$this->direccion',localidad= '$this->localidad', condicioniva = '$this->condicioniva'
        WHERE idcliente = $this->idcliente";
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

    public function deleteCliente()
    {
        $connect = Database::connectDB();
        $sql = "DELETE FROM cliente WHERE idcliente = $this->idcliente";
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

    public function buscarClientePorApellido($nombre)
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM `cliente` WHERE cliente.nombre LIKE '%$nombre%'";
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
}
?>