<?php
require_once ('../persistence/database.php');

class DetalleCompra
{
    public $iddetalle_compra;
    public $idcompra;
    public $unidades;
    public $articulo_costounitario;
    public $articulo_nombre;
    public $idarticulo;

    public function insertDetalleDeCompra()
    {
        $connect = Database::connectDB();
        $sql = "SELECT MAX(idcompra) as id FROM compra";
        $result = $connect->query($sql)->fetchObject();

        // $sql = "INSERT INTO detalle_compra (idcompra, unidades, articulo_costounitario, articulo_nombre, idarticulo) 
        // VALUES ($result->id, $this->unidades, $this->articulo_costounitario, '$this->articulo_nombre', $this->idarticulo)";
        $sql = "INSERT INTO detalle_compra (idcompra, unidades, articulo_costounitario, idarticulo) 
        VALUES ($result->id, $this->unidades, $this->articulo_costounitario, $this->idarticulo)";
        //var_dump($sql);
        $result = $connect->exec($sql);
        if($result > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function selectAllDetalleCompra()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM detalle_compra, articulo WHERE detalle_compra.idcompra = $this->idcompra AND detalle_compra.idarticulo = articulo.idarticulo";
        $result = $connect->query($sql); 
        //var_dump($sql);       
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