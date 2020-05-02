<?php
require_once ('../model/ClienteClass.php');
$cliente = new Cliente();

if(isset($_POST['traerClientes'])){
    $datos = $cliente->selectAllClientes();
    echo json_encode($datos);
}

if(isset($_POST['buscarPorDNI'])){
    $cliente->dni = $_POST['dni']; 
    if($cliente->selectDNICliente($_POST['dni']))
    {
        echo json_encode($cliente);
    }
    else
    {
        echo json_encode(array("idcliente" => false));
    }
}

if(isset($_POST['agregarCliente'])){

    $cliente->nombre = $_POST['nombre'];
    $cliente->apellido = $_POST['apellido'];
    $cliente->dni = $_POST['dni'];
    $cliente->email = $_POST['email'];

    $datos = $cliente->insertCliente();
    echo json_encode($datos);
}

if(isset($_POST['modificarCliente'])){

    $cliente->idcliente = $_POST['idCliente'];
    $cliente->nombre = $_POST['nombre'];
    $cliente->apellido = $_POST['apellido'];
    $cliente->dni = $_POST['dni'];
    $cliente->email = $_POST['email'];

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