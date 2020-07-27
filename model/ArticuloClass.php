<?php
require_once ('../persistence/database.php');
class Articulo
{
    public $idarticulo;
    public $nombre;
    public $descripcion;
    public $precioVenta;
    public $costoUnitario;
    public $estado;
    public $stock;
    public $stockminimo;
    public $Rubro;              

    public function calcularStock($cantidad){
        $this->stock=$this->stock+$cantidad;
    }  

    public static function selectAllArticulos()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM articulo";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result->rowCount() >0)
        {
            return $result->fetchAll();
        }
        else
        {
            echo "<script> alert('No se encontro articulo'); </script>";
        }
    }

    public function insertArticulo()
    {
        $connect = Database::connectDB();
        $sql="INSERT INTO articulo(nombre, descripcion, precioVenta, costoUnitario, estado, stock, stockminimo, idRubro) 
        VALUES ('$this->nombre','$this->descripcion',$this->precioVenta, $this->costoUnitario, '$this->estado', $this->stock, $this->stockminimo, $this->Rubro)";
        $result = $connect->query($sql);
        if(!$result)
        {
            echo "<script>alert('Error al cargar Artoculo'); </script>";
        }
        else
        {
            echo "<script>alert('se cargo exitosamente'); </script>";
        }
    }

    public function selectArticulo()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM articulo WHERE idarticulo = $this->idarticulo";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result->rowCount() >0)
        {
            $row = $result->fetchObject();
            $this->idarticulo = $row->idarticulo;
            $this->nombre = $row->nombre;
            $this->descripcion = $row->descripcion;
            $this->precioVenta = $row->precioVenta;
            $this->costoUnitario = $row->costoUnitario;
            $this->estado = $row->estado;
            $this->stock  = $row->stock;
            $this->stockminimo = $row->stockminimo;
            $this->Rubro = $row->idRubro;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function updateArticulo()
    {
        $connect = Database::connectDB();
        $sql = "UPDATE articulo SET nombre='$this->nombre',descripcion='$this->descripcion',precioVenta=$this->precioVenta,costoUnitario=$this->costoUnitario,estado='$this->estado',stock=$this->stock,stockminimo=$this->stockminimo,idRubro=$this->Rubro WHERE idarticulo = $this->idarticulo";
        var_dump($sql);
        $result = $connect->query($sql);
        if(!$result)
        {
            echo "<script> alert('Error al modificar Articulo'); </script>";
        }
        else
        {
            echo "<script> alert('Se modifico el articulo exitosamente'); </script>";
        }
    }

    public function deleteArticulo()
    {
        $connect = Database::connectDB();
        $sql = "DELETE FROM articulo WHERE idarticulo = $this->idarticulo";
        $result = $connect->query($sql);
        if(!$result)
        {
            echo "<script> alert('Error al borrar'); </script>";
        }
        else
        {
            echo "<script> alert('se elimino exitosamente'); </script>";
        }
    }

    public function reducirStock($cantidad)
    {        
        $cantidad = (int) $cantidad;
        $connect = Database::connectDB();
        $sql = "SELECT * FROM articulo WHERE idarticulo = $this->idarticulo";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result->rowCount() > 0)
        {
            $result = $result->fetchObject();
            $stock = $result->stock - $cantidad;
            $sql= "UPDATE articulo SET stock=$stock WHERE idarticulo = $this->idarticulo";
            //var_dump($sql);
            $connect->query($sql);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function selectArticuloPorNombre($nombre)
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM articulo WHERE nombre LIKE '%$nombre%'";
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
