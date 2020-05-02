<?php

require_once ('../model/CompraClass.php');
require_once ('../model/DetalleCompraClass.php');
require_once ('../model/ProveedorClass.php');
require_once ('../model/ArticuloClass.php');


$compra = new Compra();
$detalleDeCompra = new DetalleCompra();
$proveedor = new Proveedor();

if(isset($_POST['buscarCompra'])){

    $compra->idcompra = $_POST['idCompra'];
    $compra->selectCompra();
    
    $proveedor->idproveedor = $compra->idproveedor;
    $proveedor->selectProveedor();
    
    $detalleDeCompra->idcompra = $compra->idcompra;
    $listaDeDetallesDeCompra = $detalleDeCompra->selectAllDetalleCompra();
    
    $datos = array("compra" => $compra, "proveedor" => $proveedor, "detalleDeCompra" => $listaDeDetallesDeCompra);
    echo json_encode($datos);
}
?>