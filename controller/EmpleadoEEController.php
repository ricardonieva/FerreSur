<?php
require_once ('../model/EmpleadoClass.php');
require_once ('../model/categoriaClass.php');


if(isset($_POST['buscarEmpleado'])){
    $empleado = new Empleado();
    $empleado->idEmpleado = $_POST['idEmpleado'];
    $empleado->selectEmpleado();
    echo json_encode($empleado);
}


?>