<?php
require_once ('../model/VentaClass.php');

$ventas = new Venta();

if(isset($_POST['buscarVentas'])){ 
    $datos = $ventas->consultarVentasFechas($_POST['desde'], $_POST['hasta']);
    echo json_encode($datos);
}

if(isset($_POST['aliminarVenta'])){
    $ventas->idventa = $_POST['idventa'];
    $datos = $ventas->deleteVenta();
    echo json_encode($datos);
}

if(isset($_POST['anularVenta'])){
    $ventas->idventa = $_POST['idventa'];
    $datos = $ventas->anularVenta();
    echo json_encode($datos);
}

?>