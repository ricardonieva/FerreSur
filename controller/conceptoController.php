<?php
require_once ('../model/conceptoClass.php');

$concepto = new Concepto();

if(isset($_POST['nuevoConcepto'])){
    $concepto->tipoConcepto = $_POST['tipoconcepto'];
    $concepto->detalle = $_POST['detalle'];
    $concepto->percepcionSalarial = $_POST['percepcionSalarial'];
    $concepto->tipo = $_POST['tipo'];
    $concepto->valor = $_POST['valor'];
    $data = $concepto->nuevoConcepto();   
    echo json_encode($data);
}

if(isset($_POST['cargarConceptos'])){
    $data = $concepto->cargarConceptos();
    echo json_encode($data);
}

if(isset($_POST['eliminarConcepto'])){
    $concepto->idConcepto = $_POST['idConcepto'];
    $data = $concepto->eliminarConcepto();
    echo json_encode($data);
}

if(isset($_POST['modificarConcepto'])){
    $concepto->idConcepto = $_POST['idconcepto'];
    $concepto->tipoConcepto = $_POST['tipoconcepto'];
    $concepto->detalle = $_POST['detalle'];
    $concepto->percepcionSalarial = $_POST['percepcionSalarial'];
    $concepto->tipo = $_POST['tipo'];
    $concepto->valor = $_POST['valor'];
    $data = $concepto->modificarConcepto();
    echo json_encode($data);
}

?>