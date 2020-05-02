<?php
require_once ('../persistence/database.php');

class Concepto{

    public $idConcepto;
    public $tipoConcepto;
    public $detalle;
    public $tipo;
    public $valor;
    public $percepcionSalarial;

    public function nuevoConcepto(){
        $connect = Database::connectDB();
        $sql = "INSERT INTO concepto (tipoConcepto, detalle, percepcionSalarial, tipo, valor) 
        VALUES ('$this->tipoConcepto', '$this->detalle', '$this->percepcionSalarial', '$this->tipo', $this->valor)";
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

    public function cargarConceptos(){
        $connect = Database::connectDB();
        $sql = "SELECT * FROM concepto ";
        $result = $connect->query($sql);
        $count = $result->rowCount();
        if($count > 0)
        {
            return $result->fetchAll();
        }
        else
        {
            return false;
        }
    }

    public function eliminarConcepto(){
        $connect = Database::connectDB();
        $sql = "DELETE FROM concepto WHERE concepto.idconcepto = $this->idConcepto";
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

    public function modificarConcepto(){
        $connect = Database::connectDB();
        $sql = "UPDATE concepto SET tipoConcepto= '$this->tipoConcepto',detalle= '$this->detalle',percepcionSalarial= '$this->percepcionSalarial',tipo= '$this->tipo', valor= $this->valor WHERE concepto.idconcepto = $this->idConcepto";
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
    
    public function cargarPercepcionesDeLey(){
        $connect = Database::connectDB();
        $sql = "SELECT * FROM concepto WHERE concepto.tipoConcepto = 'Percepciones de Ley' OR concepto.tipoConcepto = 'Obligaciones de la Empresa'";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false)
        {
            $count= $result->rowCount();
            if($count > 0)
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

    public static function importeDeConcepto($detalle)
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM concepto WHERE concepto.detalle = '$detalle'";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false)
        {
            $count= $result->rowCount();
            if($count > 0)
            {                   
                return $result->fetchObject();
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

    public function selectConcepto()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM concepto WHERE concepto.idconcepto = $this->idConcepto";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false)
        {
            $count= $result->rowCount();
            if($count > 0)
            {                   
                $datos = $result->fetchObject();
                $this->detalle = $datos->detalle;
                $this->tipoConcepto = $datos->tipoConcepto;
                $this->tipo = $datos->tipo;
                $this->valor = $datos->valor;
                $this->percepcionSalarial = $datos->percepcionSalarial;                
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