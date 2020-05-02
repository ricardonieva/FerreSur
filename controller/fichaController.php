<?php
require_once ('../model/fichaClass.php');

$ficha = new ficha();

if(isset($_POST['nuevaFicha']))
{
    $ficha->empleado = $_POST['empleado'];
    $ficha->cantidad = $_POST['cantidad'];
    $ficha->fecha = $_POST['fecha'];
    $data = $ficha->nuevaFicha();   
    echo json_encode($data);
}
/* 
if(isset($_POST['cargarFichas'])){
    $data = $ficha->cargarFichas();
    echo json_encode($data);
}

if(isset($_POST['eliminarFicha'])){
    $ficha->idFicha = $_POST['idFicha'];
    $data = $ficha->eliminarFicha();
    echo json_encode($data);
}

if(isset($_POST['modificarFicha'])){
    $ficha->idFicha = $_POST['idFicha'];
    $ficha->tipoFicha = $_POST['tipoFicha'];
    $ficha->detalle = $_POST['detalle'];
    $ficha->percepcionSalarial = $_POST['percepcionSalarial'];
    $ficha->tipo = $_POST['tipo'];
    $ficha->valor = $_POST['valor'];
    $data = $ficha->modificarFicha();
    echo json_encode($data);
} */
// jjjj
?>