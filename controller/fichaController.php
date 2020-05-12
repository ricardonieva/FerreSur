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
    $ficha->empleado = $_POST['idempleado'];
    $data = $ficha->modificarFicha();
    echo json_encode($data);
}
// jjjj
?>