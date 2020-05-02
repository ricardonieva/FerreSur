<?php 
require_once ('../model/CompraClass.php');

$compra = new Compra();

if(isset($_POST['buscarCompra']))
{
    $datos = $compra->consultarComprasFechas($_POST['desde'], $_POST['hasta']);
    echo json_encode($datos);
}

if(isset($_POST['buscarCompraCompleta']))
{
    $compra->idcompra = $_POST['idcompra'];
    $datos = $compra->buscarCompraCompleta();
    echo json_encode($datos);
}

if(isset($_POST['guardarCambios']))
{
    $datos = json_decode($_POST['detalleCompra']);
    $datos = $compra->guardarCambiosDeCompra($_POST['idcompra'], $datos);
    echo json_encode($datos);
}

if(isset($_POST['aliminarCompra']))
{
    $compra->idcompra = $_POST['idCompra'];
    $datos = $compra->deleteCompra();
    echo json_encode(array("compra" => $datos));
}

if(isset($_POST['finalizarEstadoCompra']))
{
    $compra->idcompra = $_POST['idcompra'];
    $datos = $compra->cambiarEstadoDeCompra();
    echo json_encode(array("compra" => $datos));
}


?>