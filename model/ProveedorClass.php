<?php
require_once ('../persistence/database.php');

class Proveedor
{
    public $idproveedor;
    public $razonSocial;
    public $condicioniva;
    public $email;
    public $cuil;
    public $telefono;
    public $direccion;

    public function insertProveedor()
    {
        $connect = Database::connectDB();
        $sql = "INSERT INTO proveedor(razonSocial, email, condicioniva, cuil, telefono, direccion) 
        VALUES ('$this->razonSocial', '$this->email', '$this->condicioniva','$this->cuil','$this->telefono', '$this->direccion')";
        //var_dump($sql);
        $result = $connect->query($sql);
        if(!$result)
        {
            echo "<script>alert('Error al guardar Proveedor');</script> ";
        }
        else
        {
            echo "<script>alert('Proveedor se registro satisfactoriamente');</script> ";
        }
      
    }

    public function selectProveedor(){
        $connect = Database::connectDB();
        $sql = "SELECT * FROM proveedor WHERE idproveedor = $this->idproveedor";
        $result = $connect->query($sql);
        if(!$result)
        {           
            return false;
        }
        else
        {
            if($result->rowCount() > 0)
            {
                $result = $result->fetchObject();
                $this->razonSocial = $result->razonSocial;
                $this->condicioniva = $result->condicioniva;
                $this->email = $result->email;
                $this->cuil = $result->cuil;
                $this->telefono = $result->telefono;
                $this->direccion = $result->direccion;
            }
        }
    }

    public static function selectAllProveedor()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM proveedor";
        //var_dump($sql);
        $result = $connect->query($sql);
        if(!$result)
        {            
            return false;           
        }else{
            if($result->rowCount() > 0)
            {
                return $result->fetchAll();
            }
        }
    }

    

    public function updateProveedor(){
        $connect = Database::connectDB();
        $sql = "UPDATE proveedor SET razonSocial='$this->razonSocial', condicioniva= '$this->condicioniva',email='$this->email',cuil='$this->cuil',telefono='$this->telefono',direccion='$this->direccion' 
        WHERE idproveedor = $this->idproveedor";
        //var_dump($sql);
        $result = $connect->query($sql);
        if(!$result){
            echo "<script>alert('Error al modificar proveedor');</script>";
        }else{
            echo "<script>alert('Se modifico proveedor satisfactoriamente');</script>";
        }
    }

  

   
    public function deleteProveedor()
    {
        $connect = Database::connectDB();
        $sql = "DELETE FROM proveedor WHERE idproveedor = $this->idproveedor";
        $result = $connect->query($sql);
        if(!$result)
        {
            echo "<script>alert('Error al eliminar proveedor');</script>";
        }
        else
        {
            echo "<script>alert('Se elimino proveedor satisfactoriamente');</script>";
        }
    }
   

    public function selectProveedorPorRazonSocial($razonSocial)
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM proveedor WHERE razonSocial like '%$razonSocial%'";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false)
        {
            if($result->rowCount() > 0)
            {
                return $result->fetchAll();
            }
        }
        else
        {
            return false;
        }
    }

}
?>