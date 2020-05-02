<?php
class LineaDeVenta
{
    public $idlineaVenta;
    public $cantidad;
    public $articulo_precioVenta;
    public $articulo_nombre;
    public $idventa;
    public $idarticulo;

    public function insertLineaDeVenta()
    {
        $connect = Database::connectDB();
        $sql= "SELECT MAX(idventa) AS id FROM venta";
        $result = $connect->query($sql);
        $result = $result->fetchObject();
        $idVenta = $result->id; 
        //var_dump($idVenta);

        $sql = "INSERT INTO lineaventa(cantidad, articulo_precioVenta, articulo_nombre, idventa, idarticulo) 
        VALUES ($this->cantidad, $this->articulo_precioVenta, '$this->articulo_nombre', $idVenta, $this->idarticulo)";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false)
        {
          //  echo "<script> alert('La LV cargo exitosamente'); </script>";
        }
        else
        {
            //echo "<script> alert('error al cargar LV'); </script>";
        }
    }

    public function selectAllLineaDeVentas(){
        $connect = Database::connectDB();
        $sql = "SELECT * FROM lineaventa WHERE idventa = $this->idventa";
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