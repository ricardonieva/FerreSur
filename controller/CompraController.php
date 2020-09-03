<?php
session_start();
require_once ('../model/ProveedorClass.php');
require_once ('../model/ArticuloClass.php');
require_once ('../model/CompraClass.php');
require_once ('../model/DetalleCompraClass.php');


$art = new Articulo();
$pro = new Proveedor();

if(isset($_POST['buscarProveedor'])){    
    $_SESSION['detalle_Compra']= [];
    $pro->idproveedor = $_POST['idProveedor'];
    $pro->selectProveedor();
    $_SESSION['idProveedor'] = $pro->idproveedor;
    echo json_encode($pro);
}
//buscar proveedor por razon social
if(isset($_POST['buscarPorRazonSocial'])){    
    $arrayDeProveedores = $pro->selectProveedorPorRazonSocial($_POST['razonSocial']);
    echo json_encode($arrayDeProveedores);
}
//////buscar articulo por nombre
if(isset($_POST['buscarNombre'])){
    $datos = $art->selectArticuloPorNombre($_POST['nombre']);
    echo json_encode($datos);
}

//////buscar articulo por id
if(isset($_POST['buscarCodigo'])){
    $art->idarticulo = $_POST['idArtidculo'];
    if($art->selectArticulo())
    {
        $articulo = array("codigo" => $art->idarticulo, "nombre" => $art->nombre, "descripcion" => $art->descripcion, "stock" => $art->stock, "stockminimo" => $art->stockminimo, "costoUnitario" => $art->costoUnitario);
        //$_SESSION['articuloCompra'] = $articulo;
        echo json_encode($articulo);
    }
    else
    {
        echo json_encode(array("articulo" => false));
    }    
}

//boton agregar articulo
if(isset($_POST['agregarArticulo']))
{
    $articuloCargado = false;
    //if(!isset($_SESSION['detalle_Compra'])) { $_SESSION['detalle_Compra']= []; }
    for($i=0; $i< count($_SESSION['detalle_Compra']); $i++) {
        if($_SESSION['detalle_Compra'][$i]['codigo'] == $_POST['idarticulo']) {
            $articuloCargado = true;
            $_SESSION['detalle_Compra'][$i]['cantidad'] = $_SESSION['detalle_Compra'][$i]['cantidad'] + $_POST['unidades'];
            $_SESSION['detalle_Compra'][$i]['costoUnitario'] = $_POST['costoUnitario'];
        }
    }
    if(!$articuloCargado) {
        $_SESSION['detalle_Compra'][] = array("codigo" => $_POST['idarticulo'], "cantidad" => $_POST['unidades'], "costoUnitario" => $_POST['costoUnitario'], "nombre" => $_POST['nombre']);
    }   
    echo json_encode($_SESSION['detalle_Compra']);
}

//boton elimiar articulo
if(isset($_POST['eliminarArticulo']))
{
    //limpia la variable session
    for($i=0; $i< count($_SESSION['detalle_Compra']); $i++)
    {
        if(count($_SESSION['detalle_Compra']) == 1)
        {
            unset($_SESSION['detalle_Compra']);
            $_SESSION['detalle_Compra'] = [];
            break;
        }      
        if($_SESSION['detalle_Compra'][$i]['codigo'] == $_POST['idarticulo'])
        {             
            unset($_SESSION['detalle_Compra'][$i]);
            $_SESSION['detalle_Compra'] = array_values($_SESSION['detalle_Compra']);
        }             
    }
    echo json_encode($_SESSION['detalle_Compra']);
}


////////boton finalizar compra
if(isset($_POST['finalizarCompra']))
{
    $compra = new Compra();
    $compra->numerofactura = $_POST['numeroFactura'];
    $compra->fechafactura = $_POST['fechaFactura'];
    $compra->idproveedor = $_SESSION['idProveedor'];
    $compra->idEmpleado = $_SESSION['idempleado'];

    if($compra->insertCompra())
    {
        foreach($_SESSION['detalle_Compra'] as $row)
        {
            $detalleDeCompra = new DetalleCompra();
            $detalleDeCompra->unidades = $row['cantidad'];
            $detalleDeCompra->articulo_costounitario = $row['costoUnitario'];
            $detalleDeCompra->articulo_nombre = $row['nombre'];
            $detalleDeCompra->idarticulo = $row['codigo'];
            if($detalleDeCompra->insertDetalleDeCompra())
            {

            }
            else
            {
                echo json_encode(array("compra" => false));
                break;
            }
            //echo json_encode($row); 
        }        
        unset($_SESSION['detalle_Compra']);
        $datos = $compra->obtenerMaxId();      
        echo json_encode(array("compra" => $datos->id));

    }
    else
    {
        echo json_encode(array("compra" => false));
    }
    
}

?>