<?php
require_once ('../persistence/database.php');
require_once ('../model/EmpleadoClass.php');
require_once ('../model/LiquidacionClass.php');
require_once ('../model/calendarioClass.php');
require_once ('../model/recibo_conceptoClass.php');
require_once ('../model/conceptoClass.php');

class ReciboDeHaberes
{
    public $idReciboDeHaberes;
    public $liquidacion;
    public $empleado;
    public $categoria_tipo;
    public $categoria_sueldoBasico;
    public $categoria_formalaboral;
    public $fechaDeGeneracion;
    public $TipoDeRecibo;
    public $totalHaberes;
    public $totalDeducciones;

    public $listaRecibo_Concepto = array();


    public function deleteReciboDeHaberes()
    {
        try
        {
            $connect = Database::connectDB();
            $connect->beginTransaction();
            $sql = "DELETE FROM recibo_concepto WHERE recibo_concepto.ReciboDeHaberes_idReciboDeHaberes = $this->idReciboDeHaberes";
            $connect->query($sql);
            $sql = "DELETE FROM recibodehaberes WHERE recibodehaberes.idReciboDeHaberes = $this->idReciboDeHaberes";
            $connect->query($sql);
            $connect->commit();
            return true;
        }
        catch(Exception $ex)
        {
            $connect->rollBack();
            echo "<script>alert('Error al eliminar Recibo de Haberes ".$this->idReciboDeHaberes."');</script>";
            return false;
        }
    }

    public function selectReciboDeHaberes()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM recibodehaberes WHERE recibodehaberes.idReciboDeHaberes = $this->idReciboDeHaberes";
        //var_dump($sql);
        $result = $connect->query($sql);
         if (!$result) {
            echo "\nPDO::errorInfo():\n";
            print_r($connect->errorInfo());
        }
        else
        {
            foreach($result->fetchAll() as $row)
            {
                $this->idReciboDeHaberes = $row["idReciboDeHaberes"];
                $liq = new Liquidacion();
                $liq->idliquidacion = $row["liquidacion_idliquidacion"];
                $liq->selectLiquidacion();
                $this->liquidacion = $liq;
                $this->TipoDeRecibo = $liq->TipoDeLiquidacion->tipo;
                $empleado = new Empleado();
                $empleado->idEmpleado = $row["empleado_idEmpleado"];
                $empleado->selectEmpleado();
                $this->empleado = $empleado;
                $this->categoria_tipo = $row["categoria_tipo"];
                $this->categoria_sueldoBasico = $row["categoria_sueldoBasico"];
                $this->categoria_formalaboral = $row["categoria_formaLaboral"];
                $this->fechaDeGeneracion = $row["fechaDeGeneracion"];
            }            
        }
    }

    public function selectAllRecibo_Concepto()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM recibo_concepto WHERE recibo_concepto.ReciboDeHaberes_idReciboDeHaberes = $this->idReciboDeHaberes";
        //var_dump($sql);
        $result = $connect->query($sql);
         if (!$result) {
            echo "\nPDO::errorInfo():\n";
            print_r($connect->errorInfo());
        }
        else
        {
            foreach($result->fetchAll() as $row)
            {
                $RC = new Recibo_concepto();
                $RC->idRecibo_concepto = $row["idRecibo_concepto"];
                $RC->importe = $row["importe"];
                $RC->cantidad = $row["cantidad"];
                //$RC->concepto_detalle = $row["concepto_detalle"];
                $concep = new Concepto();
                $concep->idConcepto = $row["concepto_idconcepto"];
                $concep->selectConcepto();
                $RC->concepto = $concep;
                $RC->ReciboDeHaberes = $row["ReciboDeHaberes_idReciboDeHaberes"];
                $this->listaRecibo_Concepto[] = $RC;
            }            
        }
    }

    
    public function insertReciboDeHaberes()
    {
        try
        {
            $connect = Database::connectDB();
            // $sql = "INSERT INTO recibodehaberes(liquidacion_idliquidacion, empleado_idEmpleado, categoria_tipo, categoria_sueldoBasico, categoria_formaLaboral, fechaDeGeneracion, TipoDeRecibo) 
            // VALUES (".$this->liquidacion->idliquidacion.",".$this->empleado->idEmpleado.",'$this->categoria_tipo',$this->categoria_sueldoBasico,'$this->categoria_formalaboral', '$this->fechaDeGeneracion', '$this->TipoDeRecibo')";
             $sql = "INSERT INTO recibodehaberes(liquidacion_idliquidacion, empleado_idEmpleado, categoria_tipo, categoria_sueldoBasico, categoria_formaLaboral, fechaDeGeneracion) 
             VALUES (".$this->liquidacion->idliquidacion.",".$this->empleado->idEmpleado.",'$this->categoria_tipo',$this->categoria_sueldoBasico,'$this->categoria_formalaboral', '$this->fechaDeGeneracion')";
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

    public function lastIdReciboDeHaberes()
    {
        $connect = Database::connectDB();
        $sql = "SELECT MAX(idReciboDeHaberes) AS id FROM recibodehaberes";
        $result = $connect->query($sql);
        $result = $result->fetchObject();
        return $result->id;       
    }

    public function calcularRecibo_Concepto($idLiquidacion, $idEmpleado)
    {
        $this->liquidacion = new Liquidacion();
        $this->liquidacion->idliquidacion = $idLiquidacion;
        $this->liquidacion->selectLiquidacion();
        $this->empleado = new Empleado();
        $this->empleado->idEmpleado = $idEmpleado;
        $this->empleado->selectEmpleado();
        $this->categoria_tipo = $this->empleado->categoria->Tipo;
        $this->categoria_sueldoBasico = $this->empleado->categoria->sueldoBasico;
        $this->categoria_formalaboral = $this->empleado->categoria->formaLaboral;
        //$this->TipoDeRecibo = $this->liquidacion->TipoDeLiquidacion->tipo;
        $this->fechaDeGeneracion = date('Y-m-d');
        $this->insertReciboDeHaberes();
        $this->idReciboDeHaberes = $this->lastIdReciboDeHaberes();

        $sueldoBrutoSinConceptos = 0;
        $sueldoBrutoConConceptos = 0;
        /////////////////
        if($this->categoria_formalaboral == 'Mensual')
        {
            $asistencia = $this->empleado->AsistenciaMensual($this->liquidacion->desde, $this->liquidacion->hasta); 
            $diasHabiles = Calendario::obtenerDiasLaborables($this->liquidacion->desde, $this->liquidacion->hasta);
            foreach($this->liquidacion->TipoDeLiquidacion->TiposDeLiquidacion_conceptos as $row)
            {
                if($row->detalle == "Sueldo Basico")
                {                    
                    $diasPorcentualTrabajados = ($asistencia["diasTrabajadosHabiles"] / $diasHabiles) / 2;
                    $sueldoDiasHabilesBrutos = $diasPorcentualTrabajados * $this->empleado->categoria->sueldoBasico;   
                    $recibo_concepto = new Recibo_concepto();
                    $recibo_concepto->importe = $sueldoDiasHabilesBrutos;
                    $recibo_concepto->cantidad = $diasPorcentualTrabajados * 100;
                    $recibo_concepto->concepto_detalle = $row->detalle;
                    $recibo_concepto->concepto = $row->idConcepto;
                    $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                    $recibo_concepto->insertRecibo_concepto();
                    $sueldoBrutoSinConceptos = $sueldoBrutoSinConceptos + $sueldoDiasHabilesBrutos;
                    //var_dump($recibo_concepto);
                }
            }
       
            foreach($this->liquidacion->TipoDeLiquidacion->TiposDeLiquidacion_conceptos as $row)
            {
                if($row->tipoConcepto == "Dias Feriados")
                {                    
                    $diasProcentualFeriados = $asistencia["diasTrabajadosFeriados"] / $diasHabiles;
                    if($diasProcentualFeriados > 0)
                    {
                        $sueldoDiasFeriadosBrutos = $diasProcentualFeriados * $this->empleado->categoria->sueldoBasico;   
                        $recibo_concepto = new Recibo_concepto();
                        $recibo_concepto->importe = $sueldoDiasFeriadosBrutos;
                        $recibo_concepto->cantidad =$diasProcentualFeriados * 100;
                        $recibo_concepto->concepto_detalle = $row->detalle;
                        $recibo_concepto->concepto = $row->idConcepto;
                        $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                        $recibo_concepto->insertRecibo_concepto();
                        $sueldoBrutoSinConceptos = $sueldoBrutoSinConceptos + $sueldoDiasFeriadosBrutos;
                        //var_dump($recibo_concepto);
                    }                    
                }
            }

            
            foreach($this->liquidacion->TipoDeLiquidacion->TiposDeLiquidacion_conceptos as $row)
            {
                if($row->tipoConcepto == "Presentismo")
                {                    
                    $diasPorcentualTrabajados = ($asistencia["diasTrabajadosHabiles"] / $diasHabiles) / 2;
                    if($diasPorcentualTrabajados >= 1)
                    {
                        if($row->tipo == "Porcentual")
                        {
                            $totalPresentismo = $sueldoBrutoSinConceptos * $row->valor / 100;
                            $sueldoBrutoConConceptos = $sueldoBrutoConConceptos + $totalPresentismo;
                            $recibo_concepto = new Recibo_concepto();
                            $recibo_concepto->importe = $totalPresentismo;
                            $recibo_concepto->cantidad = $row->valor;
                            $recibo_concepto->concepto_detalle = $row->detalle;
                            $recibo_concepto->concepto = $row->idConcepto;
                            $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                            $recibo_concepto->insertRecibo_concepto();
                        }
                        else
                        {
                            $totalPresentismo = $row->valor;
                            $sueldoBrutoConConceptos = $sueldoBrutoConConceptos + $totalPresentismo;
                            $recibo_concepto = new Recibo_concepto();
                            $recibo_concepto->importe = $totalPresentismo;
                            $recibo_concepto->cantidad = $totalPresentismo;
                            $recibo_concepto->concepto_detalle = $row->detalle;
                            $recibo_concepto->concepto = $row->idConcepto;
                            $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                            $recibo_concepto->insertRecibo_concepto();
                        }
                    }
                }
            }
        }
///////////////
        if($this->categoria_formalaboral == 'Ficha')
        {
            $SuledoPorLasFichas = 0;
            $CantidadDeFichas = 0;
            $this->empleado->selectAllFichas($this->liquidacion->desde, $this->liquidacion->hasta);
            foreach($this->empleado->listaFichas as $row2)
            {
                $CantidadDeFichas = $CantidadDeFichas + $row2->cantidad;
            }
            $SuledoPorLasFichas = $CantidadDeFichas * $this->empleado->categoria->sueldoBasico;
            foreach($this->liquidacion->TipoDeLiquidacion->TiposDeLiquidacion_conceptos as $row)
            {
                if($row->detalle == "Sueldo Ficha")
                {                
                    $recibo_concepto = new Recibo_concepto();
                    $recibo_concepto->importe = $SuledoPorLasFichas;
                    $recibo_concepto->cantidad = $CantidadDeFichas;
                    $recibo_concepto->concepto_detalle = $row->detalle;
                    $recibo_concepto->concepto = $row->idConcepto;
                    $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                    $recibo_concepto->insertRecibo_concepto();
                    $sueldoBrutoSinConceptos = $sueldoBrutoSinConceptos + $SuledoPorLasFichas;
                    //var_dump($recibo_concepto);
                } 
            }
        }

        ////////////////      
        /////////////// por horas
        if($this->categoria_formalaboral == 'Hora')
        {
            $horasTrabajadas = $this->empleado->cantidadDeHorasTrabajadas($this->liquidacion->desde, $this->liquidacion->hasta);

            $SuledoTotalPorHorasTrabajadas = $horasTrabajadas * $this->empleado->categoria->sueldoBasico;
            foreach($this->liquidacion->TipoDeLiquidacion->TiposDeLiquidacion_conceptos as $row)
            {
                if($row->detalle == "Sueldo Hora")
                {                
                    $recibo_concepto = new Recibo_concepto();
                    $recibo_concepto->importe = $SuledoTotalPorHorasTrabajadas;
                    $recibo_concepto->cantidad = $horasTrabajadas;
                    $recibo_concepto->concepto_detalle = $row->detalle;
                    $recibo_concepto->concepto = $row->idConcepto;
                    $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                    $recibo_concepto->insertRecibo_concepto();
                    $sueldoBrutoSinConceptos = $sueldoBrutoSinConceptos + $SuledoTotalPorHorasTrabajadas;
                    //var_dump($recibo_concepto);
                } 
            }
        }

       /////////////////


        foreach($this->liquidacion->TipoDeLiquidacion->TiposDeLiquidacion_conceptos as $row)
        {

            if($row->tipoConcepto == "Antiguedad")
            {      
                $AñosAntiguedad = $this->empleado->calcularAntiguedadDelEmpleado();
                if($AñosAntiguedad > 0)
                {
                    if($row->tipo == "Porcentual")
                    {
                        $totalAntiguedad =  (($sueldoBrutoSinConceptos * $row->valor) / 100) * $AñosAntiguedad;
                        $sueldoBrutoConConceptos = $sueldoBrutoConConceptos + $totalAntiguedad;
                        $recibo_concepto = new Recibo_concepto();
                        $recibo_concepto->importe = $totalAntiguedad;
                        $recibo_concepto->cantidad = $row->valor;
                        $recibo_concepto->concepto_detalle = $row->detalle;
                        $recibo_concepto->concepto = $row->idConcepto;
                        $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                        $recibo_concepto->insertRecibo_concepto();
                    }        
                    else
                    {
                        $totalAntiguedad =   $row->valor * $AñosAntiguedad;
                        $sueldoBrutoConConceptos = $sueldoBrutoConConceptos + $totalAntiguedad;
                        $recibo_concepto = new Recibo_concepto();
                        $recibo_concepto->importe = $totalAntiguedad;
                        $recibo_concepto->cantidad = $row->valor;
                        $recibo_concepto->concepto_detalle = $row->detalle;
                        $recibo_concepto->concepto = $row->idConcepto;
                        $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                        $recibo_concepto->insertRecibo_concepto();
                    }           
                }                 
            }            
        }

        /////////////////// Despido
        if($this->categoria_formalaboral == 'Mensual')
        {
            $AñosAntiguedad = $this->empleado->calcularAntiguedadDelEmpleado();
            $SuledoTotalPorDespido = $AñosAntiguedad * $this->empleado->categoria->sueldoBasico;
            foreach($this->liquidacion->TipoDeLiquidacion->TiposDeLiquidacion_conceptos as $row)
            {
                if($row->detalle == "Despido")
                {
                    $recibo_concepto = new Recibo_concepto();
                    $recibo_concepto->importe = $SuledoTotalPorDespido;
                    $recibo_concepto->cantidad = $SuledoTotalPorDespido;
                    $recibo_concepto->concepto_detalle = $row->detalle;
                    $recibo_concepto->concepto = $row->idConcepto;
                    $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                    $recibo_concepto->insertRecibo_concepto();
                    $sueldoBrutoSinConceptos = $sueldoBrutoSinConceptos + $SuledoTotalPorDespido;
                    //var_dump($recibo_concepto);
                    //die();
                }
            }
        }
        ///////////////////
        //////////////// Aguinaldo 
        if($this->categoria_formalaboral == 'Mensual')
        {            
            foreach($this->liquidacion->TipoDeLiquidacion->TiposDeLiquidacion_conceptos as $row)
            {
                if($row->detalle == "Sueldo Anual Complementario")
                {   
                    $connect = Database::connectDB();
                    $sql = "SELECT * FROM recibodehaberes WHERE TipoDeRecibo='Sueldo' AND empleado_idEmpleado=".$this->empleado->idEmpleado." ORDER BY idReciboDeHaberes DESC LIMIT 6";
                    $result = $connect->query($sql);
                    if(!$result)
                    {
                        echo "<script>alert('Error al procesar Aguinaldo');</script>";
                    }
                    else
                    {
                        $mayor = 0;
                        if($result->rowCount() > 0)
                        {
                            foreach($result->fetchAll() as $row2)
                            {
                                if($row2['totalHaberes'] > $mayor)
                                {
                                    $mayor = $row2['totalHaberes'];
                                }
                                
                            }
                        }
                    }
                    $recibo_concepto = new Recibo_concepto();
                    $recibo_concepto->importe = $mayor/2;
                    $recibo_concepto->cantidad = $mayor/2;
                    $recibo_concepto->concepto_detalle = $row->detalle;
                    $recibo_concepto->concepto = $row->idConcepto;
                    $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                    $recibo_concepto->insertRecibo_concepto();
                    $sueldoBrutoSinConceptos = $sueldoBrutoSinConceptos + $mayor/2;
                    //var_dump($recibo_concepto);
                } 
            }
        }
        ////////////////      


        foreach($this->liquidacion->TipoDeLiquidacion->TiposDeLiquidacion_conceptos as $row)
        {
            if($row->tipoConcepto == "Percepciones de Ley" && $row->percepcionSalarial == "Haber")
            { 
                if($row->tipo == "Porcentual")
                {
                    $total = $sueldoBrutoSinConceptos * $row->valor / 100;
                    $sueldoBrutoConConceptos = $sueldoBrutoConConceptos + $total;
                    $recibo_concepto = new Recibo_concepto();
                    $recibo_concepto->importe = $total;
                    $recibo_concepto->cantidad = $row->valor;
                    $recibo_concepto->concepto_detalle = $row->detalle;
                    $recibo_concepto->concepto = $row->idConcepto;
                    $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                    $recibo_concepto->insertRecibo_concepto();      
                } 
                else
                {
                    $total = $row->valor;
                    $sueldoBrutoConConceptos = $sueldoBrutoConConceptos + $total;
                    $recibo_concepto = new Recibo_concepto();
                    $recibo_concepto->importe = $total;
                    $recibo_concepto->cantidad = $row->valor;
                    $recibo_concepto->concepto_detalle = $row->detalle;
                    $recibo_concepto->concepto = $row->idConcepto;
                    $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                    $recibo_concepto->insertRecibo_concepto();      
                }                     
            }            
        }

        //$totalSueldoTotal = $sueldoBrutoConConceptos + $sueldoBrutoSinConceptos;

        ////////////
        $datosFamiliares = $this->empleado->datosDeFamiliares();
        //var_dump($datosFamiliares);
        foreach($this->liquidacion->TipoDeLiquidacion->TiposDeLiquidacion_conceptos as $row)
        {
            if($row->tipoConcepto == "Hijos")
            { 
                if($datosFamiliares["hijos"] > 0)
                {
                    $total = $datosFamiliares["hijos"] * $row->valor;
                    $sueldoBrutoConConceptos = $sueldoBrutoConConceptos + $total;
                    $recibo_concepto = new Recibo_concepto();
                    $recibo_concepto->importe = $total;
                    $recibo_concepto->cantidad = $row->valor;
                    $recibo_concepto->concepto_detalle = $row->detalle;
                    $recibo_concepto->concepto = $row->idConcepto;
                    $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                    $recibo_concepto->insertRecibo_concepto();      
                }                      
            }            
        }
        foreach($this->liquidacion->TipoDeLiquidacion->TiposDeLiquidacion_conceptos as $row)
        {
            if($row->tipoConcepto == "Hijos Con Discapacidad")
            { 
                if($datosFamiliares["hijosConDiscapacidad"] > 0)
                {
                    $total = $datosFamiliares["hijosConDiscapacidad"] * $row->valor;
                    $sueldoBrutoConConceptos = $sueldoBrutoConConceptos + $total;
                    $recibo_concepto = new Recibo_concepto();
                    $recibo_concepto->importe = $total;
                    $recibo_concepto->cantidad = $row->valor;
                    $recibo_concepto->concepto_detalle = $row->detalle;
                    $recibo_concepto->concepto = $row->idConcepto;
                    $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                    $recibo_concepto->insertRecibo_concepto();      
                }                      
            }            
        }
        foreach($this->liquidacion->TipoDeLiquidacion->TiposDeLiquidacion_conceptos as $row)
        {
            if($row->tipoConcepto == "Hijos Estudios Primarios")
            { 
                if($datosFamiliares["hijosPrimario"] > 0)
                {
                    $total = $datosFamiliares["hijosPrimario"] * $row->valor;
                    $sueldoBrutoConConceptos = $sueldoBrutoConConceptos + $total;
                    $recibo_concepto = new Recibo_concepto();
                    $recibo_concepto->importe = $total;
                    $recibo_concepto->cantidad = $row->valor;
                    $recibo_concepto->concepto_detalle = $row->detalle;
                    $recibo_concepto->concepto = $row->idConcepto;
                    $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                    $recibo_concepto->insertRecibo_concepto();      
                }                      
            }            
        }

        foreach($this->liquidacion->TipoDeLiquidacion->TiposDeLiquidacion_conceptos as $row)
        {
            if($row->tipoConcepto == "Hijos Estudios Secundario")
            { 
                if($datosFamiliares["hijosSecundario"] > 0)
                {
                    $total = $datosFamiliares["hijosSecundario"] * $row->valor;
                    $sueldoBrutoConConceptos = $sueldoBrutoConConceptos + $total;
                    $recibo_concepto = new Recibo_concepto();
                    $recibo_concepto->importe = $total;
                    $recibo_concepto->cantidad = $row->valor;
                    $recibo_concepto->concepto_detalle = $row->detalle;
                    $recibo_concepto->concepto = $row->idConcepto;
                    $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                    $recibo_concepto->insertRecibo_concepto();      
                }                      
            }            
        }
        foreach($this->liquidacion->TipoDeLiquidacion->TiposDeLiquidacion_conceptos as $row)
        {
            if($row->tipoConcepto == "Hijos Estudios Universidad")
            { 
                if($datosFamiliares["hijosUniversitario"] > 0)
                {
                    $total = $datosFamiliares["hijosUniversitario"] * $row->valor;
                    $sueldoBrutoConConceptos = $sueldoBrutoConConceptos + $total;
                    $recibo_concepto = new Recibo_concepto();
                    $recibo_concepto->importe = $total;
                    $recibo_concepto->cantidad = $row->valor;
                    $recibo_concepto->concepto_detalle = $row->detalle;
                    $recibo_concepto->concepto = $row->idConcepto;
                    $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                    $recibo_concepto->insertRecibo_concepto();      
                }                      
            }            
        }
        
        $totalSueldoTotal = $sueldoBrutoConConceptos + $sueldoBrutoSinConceptos;

        ///////// de aqui solo deducciones
        $totalDeducciones = 0;
        foreach($this->liquidacion->TipoDeLiquidacion->TiposDeLiquidacion_conceptos as $row)
        {
            if($row->tipoConcepto == "Percepciones de Ley" && $row->percepcionSalarial == "Deduccion")
            { 
                if($row->tipo == "Porcentual" )
                {
                    $total = $totalSueldoTotal * $row->valor / 100;
                    //$sueldoBrutoConConceptos = $sueldoBrutoConConceptos + $total;
                    $recibo_concepto = new Recibo_concepto();
                    $recibo_concepto->importe = $total;
                    $recibo_concepto->cantidad = $row->valor;
                    $recibo_concepto->concepto_detalle = $row->detalle;
                    $recibo_concepto->concepto = $row->idConcepto;
                    $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                    $recibo_concepto->insertRecibo_concepto();
                    
                    $totalDeducciones = $total;
                } 
                else
                {
                    $total = $row->valor;
                    //$sueldoBrutoConConceptos = $sueldoBrutoConConceptos + $total;
                    $recibo_concepto = new Recibo_concepto();
                    $recibo_concepto->importe = $total;
                    $recibo_concepto->cantidad = $row->valor;
                    $recibo_concepto->concepto_detalle = $row->detalle;
                    $recibo_concepto->concepto = $row->idConcepto;
                    $recibo_concepto->ReciboDeHaberes = $this->idReciboDeHaberes;
                    $recibo_concepto->insertRecibo_concepto();   
                    
                    $totalDeducciones = $total;
                }                     
            }            
        }

        // $connect = Database::connectDB();
        // $sql = "UPDATE recibodehaberes SET totalHaberes= $totalSueldoTotal,totalDeducciones=$totalDeducciones WHERE recibodehaberes.idReciboDeHaberes = $this->idReciboDeHaberes"; 
        // $connect->query($sql);          
        
    }

    public function eliminarRecibosRepetidos($idLiquidacion, $idEmpleado) {
        try {
            $connect = Database::connectDB();
            $sql = "SELECT idReciboDeHaberes FROM recibodehaberes WHERE recibodehaberes.empleado_idEmpleado = $idEmpleado AND recibodehaberes.liquidacion_idliquidacion = $idLiquidacion";
            $result = $connect->query($sql);
            if($result != false) {
                if(count($result) > 0) {
                    foreach($result->fetchAll() as $row) {
                        $this->idReciboDeHaberes = $row['idReciboDeHaberes'];
                        $this->deleteReciboDeHaberes();
                    }
                }
            }
          
            return true;
        }
        catch(Exception $ex) {
            echo "<script>alert('Error al eliminar Recibo de Haberes ".$this->idReciboDeHaberes."');</script>";
            return false;
        }
       
    }
}
?>