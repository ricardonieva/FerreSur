<?php
require_once ('../model/UsuarioClass.php');
require_once ('../view/cabecera.php');
require_once ('../model/ProveedorClass.php');
require_once ('../model/subModulosClass.php');
Usuario::verificarSesion(23);


if(isset($_POST['btnEliminar']))
{
   $proveedor = new Proveedor();
   $proveedor->idproveedor = $_POST['btnEliminar'];
   $proveedor->deleteProveedor();
}
?>

<br><br><br>
<h4 class="text-center">Lista de Proveedores</h4>

<div class="d-flex justify-content-center">
    <a href="../view/proveedorCrear_view.php" class="btn btn-success">Nuevo Proveedor</a>
</div>
<form action="" method="POST">
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Razon Social</th>
                            <th>Email</th>
                            <th>CUIL</th>
                            <th>Telefono</th>
                            <th>Direccion</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach(Proveedor::selectAllProveedor() as $row)
                        {
                            echo "<tr>";
                                echo "<td>$row[idproveedor]</td>";
                                echo "<td>$row[razonSocial]</td>";
                                echo "<td>$row[email]</td>";
                                echo "<td>$row[cuil]</td>";
                                echo "<td>$row[telefono]</td>";
                                echo "<td>$row[direccion]</td>";
                                echo "<td><a class='btn btn-info' href='../view/proveedorModificar_view.php?idproveedor=$row[idproveedor]'>Modificar</a></td>";
                                echo "<td><button class='btn btn-danger' name='btnEliminar' value='$row[idproveedor]'>Eliminar</button></td>";
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
require_once ('../view/pie5.php');
?>
