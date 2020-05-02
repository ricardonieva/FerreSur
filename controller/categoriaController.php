<?php
require_once ('../model/categoriaClass.php');

$cat = new Categoria();

if(isset($_POST['cargarTablaCategoria']))
{
    $data = $cat->buscarTodasLasCategoria();
    echo json_encode($data);
}

if(isset($_POST['cargarNuevaCategoria']))
{
    $cat->Tipo = $_POST['descripcion'];
    $cat->sueldoBasico = $_POST['sueldoBasico'];
    $cat->formaLaboral = $_POST['formaLaboral'];
    $data = $cat->insertCategoria();
    echo json_encode($data);
}

if(isset($_POST['eliminarCategoria']))
{
    $cat->idCategoria =$_POST['idcategoria'];
    $data = $cat->eliminarCategoria();
    echo json_encode($data);
}

if(isset($_POST['modificarCategoria']))
{
    $cat->idCategoria = $_POST['idcategoria'];
    $cat->Tipo = $_POST['descripcion'];
    $cat->sueldoBasico = $_POST['sueldobasico'];
    $cat->formaLaboral = $_POST['formaLaboral'];
    $data = $cat->updateCategoria();
    echo json_encode($data);
}

?>