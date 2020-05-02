<?php 
require_once ('../persistence/database.php');

class Rubro
{    
    public $idrubro;
    public $nombre;
    public $descripcion;

    public function insertRubro()
    {
        $connect = Database::connectDB();
        $sql="INSERT INTO rubro (nombre,descripcion) VALUES ('$this->nombre','$this->descripcion')";
        $result = $connect->query($sql);
        if(!$result)
        {
            echo "<script>window.alert('Error al cargar rubro');</script>";  
        }
        else
        {
            echo "<script>window.alert('se Cargo rubro Exitosamente');</script>";  
        }
        
    }

    public static function selectAllRubro()
    {
        $connect = Database::connectDB();
        $sql="SELECT * FROM rubro";
        $result = $connect->query($sql);
        if(!$result)
        {
            echo "<script>window.alert('Error al consultar rubro');</script>";  
        }
        else
        {
            if($result->rowCount() > 0)
            {
                return $result->fetchAll();
            }            
        }    
    }

    public function updateRubro()
    {
        $connect = Database::connectDB();
        $sql = "UPDATE rubro SET nombre = '$this->nombre', descripcion = '$this->descripcion' WHERE idrubro = $this->idrubro";
        var_dump($sql);
        $result = $connect->query($sql);
        if(!$result)
        {
            echo "<script>window.alert('Error al modificar rubro');</script>";   
        }
        else
        {
            echo "<script>window.alert('se modifico rubro Exitosamente');</script>";   
        }        
    }

    public function selectRubro()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM rubro WHERE idrubro = $this->idrubro";
        $result = $connect->query($sql);
        if(!$result)
        {
            echo "<script>window.alert('No se encontro el rubro');</script>";
        }
        else
        {
            if($result->rowCount() >0)
            {
                $result = $result->fetchObject();
                $this->nombre = $result->nombre;
                $this->descripcion = $result->descripcion;
            }
        }     
    }

    

    public function deleteRubro()
    {
        $connect = Database::connectDB();
        $sql = "DELETE FROM rubro WHERE rubro.idrubro = $this->idrubro";
        $result = $connect->query($sql);
        if(!$result)
        {
            echo "<script>window.alert('Error al aliminar rubro');</script>";  
        }
        else
        {
            echo "<script>window.alert('Se elimino rubro correctamente');</script>";  
        }
    }

}

?>