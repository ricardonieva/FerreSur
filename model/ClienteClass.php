<?php
require_once ('../persistence/database.php');
class Cliente
{
    public $idcliente;
    public $nombre;
    public $apellido;
    public $dni;
    public $email;
    public $condicioniva;

    public function selectDNICliente()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM cliente WHERE dni=$this->dni";
        //var_dump($sql);
        $result = $connect->query($sql);
        
        if($result != false)
        {    
            if($result->rowCount() > 0)
            {
                $result = $result->fetchObject();
                $this->idcliente = $result->idcliente;
                $this->nombre = $result->nombre;
                $this->apellido = $result->apellido;
                $this->dni = $result->dni;
                $this->email = $result->email;
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
        $sql = "INSERT INTO cliente(nombre, apellido, dni, email, condicioniva)
        VALUES ('$this->nombre', '$this->apellido', '$this->dni', '$this->email', '$this->condicioniva')";
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
        $sql = "UPDATE cliente SET nombre= '$this->nombre',apellido= '$this->apellido',dni= $this->dni,email= '$this->email', condicioniva = '$this->condicioniva'
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

    public function buscarClientePorApellido($apellido)
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM `cliente` WHERE cliente.apellido LIKE '%$apellido%'";
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