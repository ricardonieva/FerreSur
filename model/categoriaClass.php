<?php
require_once ('../persistence/database.php');

class Categoria{

    public $idCategoria;
    public $Tipo;
    public $sueldoBasico;
    public $formaLaboral;

     public function selectCategoria()
    {
        $connect = Database::connectDB();      
        $sql = "SELECT * FROM categoria WHERE categoria.idcategoria = $this->idCategoria";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false)
        {
            $count = $result->rowCount();
            if($count > 0)
            {                
                $datos = $result->fetchObject();
                $this->Tipo = $datos->Tipo;
                $this->sueldoBasico = $datos->sueldoBasico;
                $this->formaLaboral = $datos->formaLaboral;
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

    
    public function buscarTodasLasCategoria()
    {
        $connect = Database::connectDB();      
        $sql = "SELECT * FROM categoria";
        //var_dump($sql);
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
          
        }else
        {
            return false;
        }
    }

    public function insertCategoria()
    {
        $connect = Database::connectDB();      
        $sql = "INSERT INTO categoria(Tipo, sueldoBasico, formaLaboral) VALUES ('$this->Tipo', $this->sueldoBasico, '$this->formaLaboral')";
        var_dump($sql);
        $result = $connect->query($sql);
        if($result != false)
        {
            return true;          
        }else
        {
            return false;
        }
    }

    public function eliminarCategoria()
    {
        $connect = Database::connectDB();      
        $sql = "DELETE FROM categoria WHERE categoria.idCategoria = $this->idCategoria";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false)
        {
            return true;          
        }else
        {
            return false;
        }
    }

    public function updateCategoria()
    {
        $connect = Database::connectDB();      
        $sql = "UPDATE categoria SET Tipo='$this->Tipo',sueldoBasico=$this->sueldoBasico, formaLaboral = '$this->formaLaboral' WHERE categoria.idCategoria =$this->idCategoria";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false)
        {
            return true;          
        }else
        {
            return false;
        }
    }

}
?>