<?php
session_start();
//$_SESSION['idempleado']= 8;
//se recuerda que se usan 3 sesiones para articulo, linea de venta y ausuario
require_once ('../model/ArticuloClass.php');
require_once ('../model/ClienteClass.php');
require_once ('../model/VentaClass.php');
require_once ('../model/LineaDeVentaClass.php');

$articulo = new Articulo();

if(isset($_POST['buscarArticulo']))
{
    $articulo->idarticulo = $_POST['Articulo'];
    if($articulo->selectArticulo())
    {
        $array = array("codigo" => $articulo->idarticulo, "nombre" => "$articulo->nombre", "precio" =>$articulo->precioVenta, "stock" => $articulo->stock, "descripcion" => "$articulo->descripcion");
        $_SESSION['idArticulo'] = $array;
        echo json_encode($array);
    }
    else
    {
        echo json_encode(array("codigo" => false));
    }
}


if(isset($_POST['agregarArticulo']))
{    
    if(isset($_SESSION['lineadeventa']))
    {
        $esta = false;
        for($i = 0; $i < count($_SESSION['lineadeventa']); $i++)
        {
            if($_SESSION['lineadeventa'][$i]['id'] == $_SESSION['idArticulo']['codigo'])
            {
                $esta = true;
                $_SESSION['lineadeventa'][$i]['cantidad'] = $_SESSION['lineadeventa'][$i]['cantidad'] + $_POST['cantidad'];
                echo json_encode($_SESSION['lineadeventa']);
                break;
            }            
        }
        if($esta == false)
        {
            $linea = array("id" => $_SESSION['idArticulo']["codigo"], "cantidad" => $_POST['cantidad'], "precio" => $_SESSION['idArticulo']["precio"], "nombre" => $_SESSION['idArticulo']["nombre"]);
            $_SESSION['lineadeventa'][] = $linea;
            //unset($_SESSION['idArticulo']);
            echo json_encode($_SESSION['lineadeventa']);
        }
    }
    else
    {
        $linea = array("id" => $_SESSION['idArticulo']["codigo"], "cantidad" => $_POST['cantidad'], "precio" => $_SESSION['idArticulo']["precio"], "nombre" => $_SESSION['idArticulo']["nombre"]);
        $_SESSION['lineadeventa'][] = $linea;
        //unset($_SESSION['idArticulo']);
        echo json_encode($_SESSION['lineadeventa']);
    }
   
}

if(isset($_POST['mostrarCliente']))
{
    $cliente = new Cliente();
    $cliente->cuit = $_POST['cuit'];
    if($cliente->selectCuitCliente())
    {
        $_SESSION['cliente'] = $cliente->idcliente;
        echo json_encode($cliente);
    }    
    else
    {
        echo json_encode(array("nombre" => false));
    }
}
//finalziar venta
if(isset($_POST['finalizar']))
{
    $fecha = date('Y-m-d H:i:s');
       
    $venta = new Venta();
    //$venta->fechaHora = $fecha;
    $venta->tipodepago = $_POST['tipodepago'];
    $venta->estado = "Finalizado";
    $venta->idEmpleado = $_SESSION['idempleado'];
    $venta->idcliente = $_SESSION['cliente'];
    //var_dump($_SESSION['lineadeventa']);
    if($venta->insertrVenta())
    {
        foreach($_SESSION['lineadeventa'] as $row)
        {
            $linea = new LineaDeVenta();
            $linea->cantidad = $row['cantidad']; 
            $linea->articulo_precioVenta = $row['precio']; 
            //$linea->articulo_nombre = $row['nombre']; 
            $linea->cantidad = $row['cantidad']; 
            $linea->idarticulo = $row['id'];
            //var_dump($linea);
            
            $linea->insertLineaDeVenta();
            $articulo = new Articulo();
            $articulo->idarticulo = $row['id'];
            $articulo->reducirStock($row['cantidad']);

        }
        echo "true";    
    }
    else
    {
        //echo "Error al procesar la Venta";
    }
    unset($_SESSION['cliente']);
    unset($_SESSION['idArticulo']);
    unset($_SESSION['lineadeventa']);

}


if(isset($_POST['limpiar'])){
    unset($_SESSION['idArticulo']);
    unset($_SESSION['lineadeventa']);
    unset($_SESSION['idempleado']);
    echo "todo limpito";

}

if(isset($_POST['ultimaVenta'])){
    $ventaAUX = new Venta();
    $data = $ventaAUX->ultimaIdDeVenta();
    echo $data->id;
}

if(isset($_POST['btnQuitarArticulo']))
{
    for($i = 0; $i < count($_SESSION['lineadeventa']); $i++)
    {
        if($_SESSION['lineadeventa'][$i]['id'] == $_POST['idarticulo'])
        {            
            unset($_SESSION['lineadeventa'][$i]);
            $_SESSION['lineadeventa'] = array_values($_SESSION['lineadeventa']);
            echo json_encode($_SESSION['lineadeventa']);
            break;
        }            
    }
    
}

?>

