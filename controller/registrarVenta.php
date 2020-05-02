<h1>intento de venta</h1>

<?php
include ('../modelo/VentaClass.php');
include ('../modelo/LineaDeVentaClass.php');
include ('../modelo/ArticuloClass.php');
include ('../modelo/ClienteClass.php');
include ('../modelo/DireccionClass.php');

$articulo1 = new Articulo();
$articulo1->setNombre("Taladro gamma");
$articulo1->setDescripcion("es un taladro kapo, q mas queres?");
$articulo1->setPrecioVenta(5000);
$articulo1->setCostoUnitario(4500);
$articulo1->setFechaCosto(new DateTime());
$articulo1->setEstado("ACTIVO");
$articulo1->setMargen(80);
$articulo1->setStock(20);
$articulo1->setStockMinimo(5);

$linea1 = new LineaDeVenta();
$linea1->setArticulo($articulo1);
$linea1->setCantidad(2);
$linea1->calcularSubTotal();

echo "sub total: ".$linea1->getSubTotal();
var_dump($articulo1);


?>