<?php
require_once ('../model/ClienteClass.php');
$cliente = new Cliente();

if(isset($_POST['traerClientes'])){
    $datos = $cliente->selectAllClientes();
    echo json_encode($datos);
}

if(isset($_POST['buscarPorCuit'])){
    $cliente->cuit = $_POST['cuit']; 
    if($cliente->selectCuitCliente())
    {
        echo json_encode($cliente);
    }
    else
    {
        echo json_encode(array("idcliente" => false));
    }
}

if(isset($_POST['agregarCliente']))
{
    $cliente->nombre = $_POST['nombre'];
    $cliente->cuit = $_POST['cuit'];
    $cliente->direccion = $_POST['direccion'];
    $cliente->localidad = $_POST['localidad'];
    $cliente->condicioniva = $_POST['iva'];   
    $datos = $cliente->insertCliente();
    echo json_encode($datos);
}

if(isset($_POST['modificarCliente']))
{
    $cliente->idcliente = $_POST['idCliente'];
    $cliente->nombre = $_POST['nombre'];
    $cliente->cuit = $_POST['cuit'];
    $cliente->direccion = $_POST['direccion'];
    $cliente->localidad = $_POST['localidad'];
    $cliente->condicioniva = $_POST['iva'];
    $datos = $cliente->updateCliente();
    echo json_encode($datos);
}

if(isset($_POST['eliminarCliente'])){
    $cliente->idcliente = $_POST['idcliente'];
    $datos = $cliente->deleteCliente();
    echo json_encode($datos);
}

if(isset($_POST['buscarClientePorapellido'])){
    $datos = $cliente->buscarClientePorApellido($_POST['apellido']);
    echo json_encode($datos);
}

?>