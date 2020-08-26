<?php
require_once ('../persistence/database.php');

class Recibo_concepto
{
    public $idRecibo_concepto;
    public $importe;
    public $cantidad;
    public $concepto_detalle;
    public $concepto;
    public $ReciboDeHaberes;

    public function insertRecibo_concepto()
    {
        try
        {
            $connect = Database::connectDB();
            // $sql = "INSERT INTO recibo_concepto(importe, cantidad, concepto_detalle, concepto_idconcepto, ReciboDeHaberes_idReciboDeHaberes) 
            // VALUES ($this->importe, $this->cantidad, '$this->concepto_detalle',$this->concepto,$this->ReciboDeHaberes)";
            $sql = "INSERT INTO recibo_concepto(importe, concepto_idconcepto, ReciboDeHaberes_idReciboDeHaberes) 
            VALUES ($this->importe, $this->concepto,$this->ReciboDeHaberes)";
            //var_dump($sql);
            $result = $connect->query($sql);
             if (!$result) {
                echo "\nPDO::errorInfo():\n";
                print_r($connect->errorInfo());
            }
            else
            {
            }
        }
        catch(Exception $ex)
        {
            echo "error".$ex->getMessage();
        }       
    }

    public function selectRecibo_concepto()
    {
        try
        {
            $connect = Database::connectDB();
            $sql = "SELECT * FROM recibo_concepto WHERE recibo_concepto.idRecibo_concepto = $this->idRecibo_concepto";
            //var_dump($sql);
            $result = $connect->query($sql);
             if (!$result) {
                echo "\nPDO::errorInfo():\n";
                print_r($connect->errorInfo());
            }
            else
            {
                
            }
        }
        catch(Exception $ex)
        {
            echo "error".$ex->getMessage();
        }       
    }
}
?>