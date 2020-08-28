<?php
require_once ('../model/fichaClass.php');
require_once ('../model/EmpleadoClass.php');

$ficha = new ficha();
$empleado = new Empleado();

if(isset($_POST['nuevaFicha']))
{
    $empleado->cuil = $_POST['cuil'];
    $empleado->selectCuilEmpleado();
    $ficha->empleado = $empleado->idEmpleado;
    $ficha->cantidad = $_POST['cantidad'];
    $ficha->fecha = $_POST['fecha'];
    $data = $ficha->nuevaFicha();   
    echo json_encode($data);    
}

if(isset($_POST['cargarFichas'])){
    $data = $ficha->cargarFichas();
    echo json_encode($data);
}

if(isset($_POST['eliminarFicha'])){
    $ficha->idficha = $_POST['idFicha'];
    $data = $ficha->eliminarFicha();
    echo json_encode($data);
}

if(isset($_POST['modificarFicha'])){
    $ficha->idficha = $_POST['idFicha'];
    $ficha->cantidad = $_POST['cantidad'];
    $ficha->fecha = $_POST['fecha'];
    $empleado->cuil = $_POST['cuil'];
    $empleado->selectCuilEmpleado();
    $ficha->empleado = $empleado->idEmpleado;
    $data = $ficha->modificarFicha();
    echo json_encode($data);
}
// jjjj
?>