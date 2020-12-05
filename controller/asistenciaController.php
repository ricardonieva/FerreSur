<?php
session_start();
include_once ('../model/EmpleadoClass.php');
include_once ('../model/asistenciaClass.php');
//$_SESSION['_idEmpleado']= 0;

$asistencia = new Asistencia();
$emp = new Empleado();


if(isset($_POST['buscarEmpleado'])){
    $emp->cuil = $_POST['CUIL'];
    $emp->selectCuilEmpleado();    
    $_SESSION['idDelEmpleado'] = $emp->idEmpleado;
    echo json_encode($emp); 
}

if(isset($_POST['buscarTodosLosEmpleado'])){
    $datos = $emp->allSelectEmpleados();;
    echo json_encode($datos); 
}

if(isset($_POST['agregarAsistencia'])){
    $datos = $asistencia->nuevaAsistencia($_POST['fecha'],$_POST['entrada'], $_POST['salida'], $_POST['novedad'], $_SESSION['idDelEmpleado']);
    echo json_encode($datos);    
}

if(isset($_POST['mostrarAsistencia'])){
    $datos = $asistencia->mostrarAsistenciaDeEmpleado($_SESSION['idDelEmpleado']);
    echo json_encode($datos);    
}

if(isset($_POST['eliminarAsistencia'])){
    $datos = $asistencia->eliminarAsistencia($_POST['idasistencia']);
    echo json_encode($datos);    
}

if(isset($_POST['modificarAsistencia'])){
    $datos = $asistencia->modificarAsistencia($_POST['idasistencia'], $_POST['entradaModificar'], $_POST['salidaModificar'], $_POST['novedadModificar']);
    echo json_encode($datos);    
}

?>