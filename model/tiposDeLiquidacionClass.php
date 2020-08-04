<?php
require_once ('../persistence/database.php');
require_once ('../model/conceptoClass.php');
class tiposDeLiquidacion
{
    public $idTiposDeLiquidacion;
    public $nombre;
    public $tipo;
    public $TiposDeLiquidacion_conceptos = array();


    public function lista_TiposDeLiquidacion_conceptos($concepto)
    {
        $this->TiposDeLiquidacion_conceptos[] = $concepto;
    }

    public function insertTiposDeLiquidacion()
    {
        $connect = Database::connectDB();
        $sql="INSERT INTO tiposdeliquidacion(Nombre, Tipo) VALUES ('$this->nombre', '$this->tipo')";
        $result=$connect->query($sql);
        if(!$result){
            echo "<script> alert('error al generar operacion') </script>";
        }else
        {
            $this->insertTiposDeLiquidacionConceptos();
            echo "<script> alert('se cargo correctamente') </script>";
        }
       
    }

    public function insertTiposDeLiquidacionConceptos()
    {
        $connect = Database::connectDB();
        $sql = "SELECT MAX(idTiposDeLiquidacion) AS id FROM tiposdeliquidacion";
        $result = $connect->query($sql)->fetchObject();        
        $idTipoLiq = $result->id;
        foreach($this->TiposDeLiquidacion_conceptos as $row)
        {            
            $sql="INSERT INTO tiposdeliquidacion_concepto(`TiposDeLiquidacion_idTiposDeLiquidacion`, `concepto_idconcepto`) VALUES ($idTipoLiq, $row->idConcepto)";
            //var_dump($sql);
            $result=$connect->query($sql);
            if(!$result){
                echo "<script> alert('error al cargar tiposdeliquidacion_concepto') </script>";
            }        
        }
       
    }

    public static function SelectAllTiposLiq()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM tiposdeliquidacion";
        $result = $connect->query($sql);        
        if (!$result) {
            echo "Error el seleccionar tiposdeliquidacion";
            print_r($connect->errorInfo());
        }
        else
        {
            return $result->fetchAll();
        }  
    }

    public function SelectTiposLiq()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM tiposdeliquidacion, tiposdeliquidacion_concepto WHERE 
        tiposdeliquidacion.idTiposDeLiquidacion = tiposdeliquidacion_concepto.TiposDeLiquidacion_idTiposDeLiquidacion AND tiposdeliquidacion.idTiposDeLiquidacion = $this->idTiposDeLiquidacion";
        //var_dump($sql);
        $result = $connect->query($sql);        
        if (!$result) {
            echo "Error el seleccionar tiposdeliquidacion";
            print_r($connect->errorInfo());
        }
        else
        {
            foreach($result->fetchAll() as $row)
            {
                //var_dump($row);
                $this->nombre = $row["Nombre"];
                $this->tipo = $row["Tipo"];
                $concep = new Concepto();
                $concep->idConcepto = $row["concepto_idconcepto"];
                $concep->selectConcepto();
                $this->lista_TiposDeLiquidacion_conceptos($concep);
            }

        }  
    }

    public function deleteTipoDeLiquidacion()
    {
        try
        {
            $connect = Database::connectDB();
            $connect->beginTransaction();
            $sql = "DELETE FROM tiposdeliquidacion_concepto WHERE TiposDeLiquidacion_idTiposDeLiquidacion = $this->idTiposDeLiquidacion";
            $connect->query($sql);
            $sql = "DELETE FROM tiposdeliquidacion WHERE idTiposDeLiquidacion = $this->idTiposDeLiquidacion";
            $connect->query($sql);             
            $connect->commit();
        }
        catch(Exception $ex)
        {
            $connect->rollBack();
            echo "Error: ".$ex->getMessage();
        }
       
    }

    //usado en la vista tipoDeliquidacionModificar_view.php
    public function selectTipoLiquidacionConceptos()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM tipoliquidacionconconceptos WHERE idTiposDeLiquidacion = $this->idTiposDeLiquidacion";
        //var_dump($sql);
        $result = $connect->query($sql);        
        if (!$result) {
            echo "Error el seleccionar tiposdeliquidacion";
            print_r($connect->errorInfo());
        }
        else
        {
            foreach($result->fetchAll() as $row)
            {
                //var_dump($row);
                $this->nombre = $row["Nombre"];
                $this->tipo = $row["Tipo"];
                $concep = new Concepto();
                if($row["concepto_idconcepto"] != "")
                {
                    $concep->idConcepto = $row["concepto_idconcepto"];
                    $concep->selectConcepto();
                    $this->lista_TiposDeLiquidacion_conceptos($concep);
                }
              
            }

        }  
    }

    //usado en tipoDeliquidacionModificar_view.php
    public function updateTipoLiquidacion()
    {
        $connect = Database::connectDB();
        $sql = "UPDATE tiposdeliquidacion SET Nombre='$this->nombre',Tipo='$this->tipo' WHERE idTiposDeLiquidacion = $this->idTiposDeLiquidacion";
        $result = $connect->query($sql);        
        if (!$result) 
        {
            echo "Error el seleccionar tiposdeliquidacion";
            print_r($connect->errorInfo());
        }
        else
        {
            echo "<script>alert('Se modifico satisfactoriamente')</script>";
        }  
    }

    //usado en tipoDeliquidacionModificarConceptos_view.php
    public function modificarTiposDeLiquidacionConceptos($listaDeConceptos)
    {   
        $bandera = true;
        while($bandera)
        {
            $bandera= false;
            for($i = 0; $i < count($this->TiposDeLiquidacion_conceptos); $i++)
            {   
                for($j = 0; $j < count($listaDeConceptos); $j++)
                {
                    if($listaDeConceptos[$j][0] == $this->TiposDeLiquidacion_conceptos[$i]->idConcepto)
                    {
                        //var_dump("pasa 3");
                        //var_dump($listaDeConceptos[$j][0]);
                        //var_dump($this->TiposDeLiquidacion_conceptos[$i]->idConcepto);
                        unset($listaDeConceptos[$j]);
                        unset($this->TiposDeLiquidacion_conceptos[$i]);
                        $listaDeConceptos = array_values($listaDeConceptos);
                        $this->TiposDeLiquidacion_conceptos = array_values($this->TiposDeLiquidacion_conceptos);
                        $bandera = true;
                    }
                }         
            }
        }    
        
        $connect = Database::connectDB();
        foreach($listaDeConceptos as $rowAgregar)
        {
            $sql="INSERT INTO tiposdeliquidacion_concepto(`TiposDeLiquidacion_idTiposDeLiquidacion`, `concepto_idconcepto`) VALUES ($this->idTiposDeLiquidacion, $rowAgregar[0])";
            //var_dump($sql);
            $connect->query($sql);
        }
       
        foreach($this->TiposDeLiquidacion_conceptos as $rowEliminar)
        {
            $sql = "DELETE FROM tiposdeliquidacion_concepto WHERE TiposDeLiquidacion_idTiposDeLiquidacion =$this->idTiposDeLiquidacion AND concepto_idconcepto = $rowEliminar->idConcepto";
            //var_dump($sql);
            $connect->query($sql);
        }
       
    }
}
?>