<?php
session_start();
require_once ('../model/EmpleadoClass.php');
require_once ('../model/ModuloClass.php');

$mol = new Modulo();

if(isset($_POST['buscarEmpleado'])){
    $emp = new Empleado();
    $emp->selectCuilEmpleado($_POST['CUIL']);    
    $_SESSION['_idEmpleado'] = $emp->idEmpleado;
    echo json_encode($emp);    
}

if(isset($_POST['buscarModulos'])){
    $datos = $mol->traerModulos();
    echo json_encode($datos);
}

if(isset($_POST['buscarRolEmpleado'])){
    $datos = $mol->traerRolEmpleado($_SESSION['_idEmpleado']);
    //unset($_SESSION['_idEmpleado']);
    echo json_encode($datos);
}

if(isset($_POST['botonRolEmpleado'])){
    $datos = $mol->consultaRolEmpleado($_POST['idRol'], $_SESSION['_idEmpleado']);
    if($datos == false){
        $datos = $mol->cargarRolEmpleado($_POST['idRol'], $_SESSION['_idEmpleado']);
    }
    echo json_encode($datos);
}

if(isset($_POST['EliminarRol'])){
    $datos = $mol->eliminarRolEmpleado($_POST['idRol'], $_SESSION['_idEmpleado']);
    echo json_encode("pasa");
}

?>