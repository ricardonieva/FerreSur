<?php
require_once ('../persistence/database.php');
require_once ('../model/grupoFamiliarClass.php');
require_once ('../model/conceptoClass.php');
require_once ('../model/categoriaClass.php');

class liquidacion_concepto {

    public function crearConceptosGrupofamiliar($idEmpleado){
        $gf = new GrupoFamiliar();
        $grupoFamiliar = $gf->traerFamiliares($idEmpleado);
        //var_dump($grupoFamiliar);

        $hijos = 0;
        $hijosDiscapacidad = 0;
        $estudiosPrimario = 0;
        $estudiosSecundario = 0;
        $estudioUniversitario = 0;

        foreach($grupoFamiliar as $row)
        {
            $datetime1 = new DateTime($row['fechanacimiento']);
            $datetime2 = new DateTime('now');
            $interval = $datetime1->diff($datetime2);
            $edadDeFamiliar = (int)$interval->format('%Y');           

            if($row['parentesco'] == 'Hijo' && $edadDeFamiliar <= 21)
            {
                $hijos = $hijos +1; 
                if($row['estudio'] == 1)
                {
                    if($row['nivel'] == 'Primario')
                    {
                        $estudiosPrimario = $estudiosPrimario +1; 
                    }
                    if($row['nivel'] == 'Secundario')
                    {
                        $estudiosSecundario = $estudiosSecundario +1; 
                    }
                    if($row['nivel'] == 'Universidad')
                    {
                        $estudioUniversitario = $estudioUniversitario +1; 
                    }
                    
                }
            }
            if($row['discapacidad'] == 1)
            {
                $hijosDiscapacidad = $hijosDiscapacidad +1; 
            }
        }

        $this->liquidacionAsginacionFamiliar($hijos, $hijosDiscapacidad, $estudiosPrimario, $estudiosSecundario, $estudioUniversitario);
    }

    public function liquidacionAsginacionFamiliar($hijos, $hijosDiscapacidad, $estudiosPrimario, $estudiosSecundario, $estudioUniversitario)
    {
        $connect = Database::connectDB();
        $sql = "SELECT MAX(idliquidacion) AS id FROM liquidacion";
        $result = $connect->query($sql)->fetchObject();
        
        if($hijos > 0)
        {
            $datos = Concepto::importeDeConcepto('Hijos');
            $sql ="INSERT INTO liquidacion_concepto(idliquidacion, idconcepto, importe, cantidad) VALUES ($result->id, $datos->idconcepto, $datos->valor, $hijos)";
            //var_dump($sql);
            $connect->query($sql);
        }
        if($hijosDiscapacidad > 0)
        {
            $datos = Concepto::importeDeConcepto('Hijos Con Discapacidad');
            $sql ="INSERT INTO liquidacion_concepto(idliquidacion, idconcepto, importe, cantidad) VALUES ($result->id, $datos->idconcepto, $datos->valor, $hijosDiscapacidad)";
            //var_dump($sql);
            $connect->query($sql);
        }
        if($estudiosPrimario > 0)
        {
            $datos = Concepto::importeDeConcepto('Hijos Estudios Primarios');
            $sql ="INSERT INTO liquidacion_concepto(idliquidacion, idconcepto, importe, cantidad) VALUES ($result->id, $datos->idconcepto, $datos->valor, $estudiosPrimario)";
            //var_dump($sql);
            $connect->query($sql);
        }
        if($estudiosSecundario > 0)
        {
            $datos = Concepto::importeDeConcepto('Hijos Estudios Secundario');
            $sql ="INSERT INTO liquidacion_concepto(idliquidacion, idconcepto, importe, cantidad) VALUES ($result->id, $datos->idconcepto, $datos->valor, $estudiosSecundario)";
            //var_dump($sql);
            $connect->query($sql);
        }
        if($estudioUniversitario > 0)
        {
            $datos = Concepto::importeDeConcepto('Hijos Estudios Universidad');
            $sql ="INSERT INTO liquidacion_concepto(idliquidacion, idconcepto, importe, cantidad) VALUES ($result->id, $datos->idconcepto, $datos->valor, $estudioUniversitario)";
            //var_dump($sql);
            $connect->query($sql);
        }

    }
      
///////////////////////////////////////

    public function generarConceptosSelecccinados($idEmpleado, $linea_liquidacion){
        $connect = Database::connectDB();
        $sql = "SELECT MAX(idliquidacion) AS id FROM liquidacion";
        $result = $connect->query($sql)->fetchObject();
        $idliquidacion = $result->id;

        $sql = "SELECT * FROM liquidacion_concepto WHERE liquidacion_concepto.idliquidacion = $idliquidacion";
        //var_dump($sql);
        $result = $connect->query($sql);

        $sueldoBruto = 0;
        //es de asignacion familiar
        while($row = $result->fetchObject())
        {
            $sueldoBruto = $sueldoBruto + ($row->importe * $row->cantidad);
        }

        $sql = "SELECT * FROM liquidacion_asistencia WHERE liquidacion_asistencia.liquidacion_idliquidacion = $idliquidacion";
        $result = $connect->query($sql);
        $count = $result->rowCount();

        if($count > 0)
        {
            while($row = $result->fetchObject())
            {
                $sueldoBruto = $sueldoBruto + ($row->valor * $row->cantidad);
            }
        }
       
        ////////////////////////recorrermos el array hacemos las correspondientes liquidaciones jaja
        
        // var_dump($sueldoBruto);
        // var_dump($linea_liquidacion);

        foreach($linea_liquidacion as $row)
        {            
            if($row->detalle != 'Antiguedad')
            {
               
                if($row->tipo == 'Porcentual')
                {
                    $importe = ($sueldoBruto * $row->valor) / 100;
                }
                else
                {
                    $importe = $row->valor;
                }
                $this->generarliquidacion($idliquidacion, $row->idconcepto, $importe);                
               
            }
            else
            {
                $cat = new Categoria();
                $datos = $cat->obtenerSueldoBasicoDelEmpleado($idEmpleado); 
                $datetime1 = new DateTime($datos->fechaingreso);
                $datetime2 = new DateTime('now');
                $interval = $datetime1->diff($datetime2);
                $añosTrabajados = (int)$interval->format('%Y Años');
                
                $valor = $añosTrabajados * $row->valor;
                $importe = ($sueldoBruto * $valor) / 100;
                $this->generarliquidacion($idliquidacion, $row->idconcepto, $importe);     
            }
            
        }
        

    }

    function generarliquidacion($idliquidacion, $idconcepto, $importe)
    {
        $connect = Database::connectDB();
        $sql = "INSERT INTO liquidacion_concepto(idliquidacion, idconcepto, importe, cantidad) 
        VALUES ($idliquidacion, $idconcepto, $importe, 1)";
        var_dump($sql);
        $result = $connect->query($sql);
        if($result != false){
            return true;
        }
        else
        {
            return false;
        }
    }
    ///////// usa el informe 
    public static function recuperarLiquidacionesDeConceptos($idliquidacion)
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM liquidacion_concepto,concepto WHERE liquidacion_concepto.idliquidacion = $idliquidacion AND liquidacion_concepto.idconcepto = concepto.idconcepto ORDER BY percepcionSalarial DESC";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false){
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
        else
        {
            return false;
        }
    }   
///////////////////////////usa modificar liquidacion 
public static function recuperarLiquidacionesDeConceptosSinAF($idliquidacion)
{
    $connect = Database::connectDB();
    $sql = "SELECT * FROM liquidacion_concepto,concepto WHERE liquidacion_concepto.idliquidacion = $idliquidacion AND liquidacion_concepto.idconcepto = concepto.idconcepto AND concepto.tipoConcepto != 'Asignacion Familiar'
    ";
    //var_dump($sql);
    $result = $connect->query($sql);
    if($result != false){
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
    else
    {
        return false;
    }
}   



    public function eliminarConceptoDeLiquidacion($idliquidacion_concepto)
    {
        $connect = Database::connectDB();
        $sql = "DELETE FROM liquidacion_concepto WHERE liquidacion_concepto.idliquidacion_concepto = $idliquidacion_concepto";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false){
           return true;
        }
        else
        {
            return false;
        }

    }

    public function cargarNuevoConcepto($idliquidacion ,$idconcepto)
    {

    }

    function generarSueldoBruto()
    {
        
    }
 
}    
?>