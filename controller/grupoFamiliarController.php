<?php
session_start();
require_once ('../model/grupoFamiliarClass.php');
require_once ('../model/EmpleadoClass.php');
//$_SESSION['_idEmpleado'] = 3;
$grupo = new GrupoFamiliar();

if(isset($_POST['buscarEmpleado'])){
    $emp = new Empleado();
    $emp->cuil = $_POST['CUIL'];
    $emp->selectCuilEmpleado();    
    $_SESSION['_idEmpleado'] = $emp->idEmpleado;
    echo json_encode($emp);    
}

if(isset($_POST['agregarFamiliar'])){
    $datos = $grupo->agregarFamiliar($_POST['apellido'], $_POST['nombre'], $_POST['dni'], $_POST['parentesco'], $_POST['fechaNac'],$_POST['discapacidad'],$_POST['estudio'],$_POST['nivel'],$_SESSION['_idEmpleado']);
    echo json_encode($datos);
}

if(isset($_POST['traerFamiliares'])){
    $datos = $grupo->traerFamiliares($_SESSION['_idEmpleado']);
    echo json_encode($datos);
}

if(isset($_POST['borrarFamiliar'])){
    $datos = $grupo->borrarFamiliar($_POST['idFamiliar']);
    echo json_encode($datos);
}

if(isset($_POST['modificarFamiliar'])){
    $datos = $grupo->modificarFamiliar($_POST['idintegrante'],$_POST['nombre'],$_POST['apellido'],$_POST['dni'],$_POST['paretenesco'], $_POST['fechaNac'],$_POST['discapacidad'],$_POST['estudio'],$_POST['nivel']);
    echo json_encode($datos);
}

?>