<?php
require_once ('../model/VentaClass.php');
require_once ('../model/LineaDeVentaClass.php');

$venta = new Venta();
$linea = new LineaDeVenta();

if(isset($_POST['buscarVenta'])){
    $datos = $venta->buscarVentaPorId($_POST['idVenta']);
    echo json_encode($datos);
}


?>