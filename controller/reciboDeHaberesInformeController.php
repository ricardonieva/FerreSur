<?php
require_once ('../model/LiquidacionClass.php');
require_once ('../model/EmpleadoClass.php');
require_once ('../model/conceptoClass.php');
require_once ('../model/liquidacion_conceptoClass.php');

$RH = new ReciboDeHaberes();
$con = new Concepto();
$liqCon = new liquidacion_concepto();

if(isset($_POST['reciboDeHaberesInforme'])){
    $RH->idReciboDeHaberes = $_POST['idReciboDeHaberes'];
    $RH->selectReciboDeHaberes();
    $RH->selectAllRecibo_Concepto();
    //var_dump($RH->listaRecibo_Concepto);
    //die;
    echo json_encode($RH);
}

///////////////////////

if(isset($_POST['mostrarLiquidaciones'])){
    $datos = $liq->buscarTodasLasLiquidaciones($_POST['fechaDesde'], $_POST['fechaHasta']);    
    echo json_encode($datos);
}

if(isset($_POST['liquidacionInformeYConceptos'])){
    $liquidacion_concepto = liquidacion_concepto::recuperarLiquidacionesDeConceptosSinAF($_POST['idliquidacion']);
    $conceptos = $con->cargarPercepcionesDeLey();
    $datos = array("liquidacion" => $liquidacion_concepto, "conceptos" => $conceptos);
    echo json_encode($datos);
}

if(isset($_POST['aliminarLiquidacion'])){
    $datos = $liq->eliminarLiquidacion($_POST['idLiquidacion']);
    echo json_encode($datos);
}

if(isset($_POST['eliminarConceptoDeLiquidacion']))
{
    $datos = $liqCon->eliminarConceptoDeLiquidacion($_POST['idLiqConcepto']);
    echo json_encode($datos);
}

if(isset($_POST['agregarConcepto']))
{
    $datos = $liqCon->cargarNuevoConcepto($_POST['idliquidacionGlobal'] ,$_POST['idconcepto']);
    echo json_encode($datos);
}

?>