<?php
require_once ('../view/cabecera.php');
require_once ('../model/EmpleadoClass.php');
require_once ('../model/UsuarioClass.php');
Usuario::verificarSesion(1);

$empleado = new Empleado();

if(isset($_POST['btnEliminar']))
{
    var_dump($_POST['btnEliminar']);
    $empleado->idEmpleado = $_POST['btnEliminar'];
    $empleado->deleteEmpleado();
}

?>
<br><br><br>
<h3 class="text-center">Menu Empleados</h3>
<form action="" method="POST">
    <div class="d-flex justify-content-center"> 
        <a href="../view/empleadoCrear_view.php" class="btn btn-success mt-3">Nuevo Empleado</a>
    </div>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="form-group col-md-10">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>CUIL</th>
                            <th>Apellido y Nombre</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>    
                        <?php
                            foreach($empleado->allSelectEmpleados() as $row)
                            {
                                echo "<tr>";
                                    echo "<td>$row[idEmpleado]</td>";
                                    echo "<td>$row[cuil]</td>";
                                    echo "<td>$row[apellido] $row[nombre]</td>";
                                    echo "<td><a href='../view/empleadoEditar_view.php?idEmpleado=$row[idEmpleado]' class='btn btn-info'>Modificar</a></td>";
                                    echo "<td><button type='submit' class='btn btn-danger' name='btnEliminar' value='$row[idEmpleado]'>Eliminar</button></td>";
                                echo "</tr>";
                            }
                        ?>                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>
<?php
require_once ('../view/pie3.php');
?>
