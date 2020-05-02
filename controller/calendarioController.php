<?php
include_once ('../model/calendarioClass.php');

$calendario = new Calendario();

if(isset($_POST['agregarFecha'])){
    $calendario->fecha = $_POST['fecha'];
    $calendario->habil = $_POST['habil'];
    $datos = $calendario->agregarFecha();
    echo json_encode($datos);
}


?>