<?php
session_start();
require_once ('../model/LiquidacionClass.php');
require_once ('../model/EmpleadoClass.php');
require_once ('../model/conceptoClass.php');
//error_reporting(E_ALL ^ E_NOTICE);

$liq = new Liquidacion();
$emp = new Empleado();
$concepto = new Concepto();

if(isset($_POST['buscarEmpleado'])){
    $data = $emp->buscarEmpleado($_POST['CUIL']); 
    $_SESSION['_idEmpleado'] = $data->idEmpleado;
    echo json_encode($data);    
}

if(isset($_POST['cargarPercepcionesDeLey'])){
    $data = $concepto->cargarPercepcionesDeLey(); 
    echo json_encode($data);    
}

if(isset($_POST['generarLiquidacion'])){
    $data = json_decode($_POST['linea_liquidacion']);
    $data = $liq->generarLiquidacion($_POST['periodo'],$_POST['fechaCobro'],$_POST['tipo'],$_SESSION['_idEmpleado'], $data); 
    echo json_encode($data);    
}


?>