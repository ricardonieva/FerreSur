<?php
require_once ('../model/UsuarioClass.php');
require_once ('../view/cabecera.php');
require_once ('../model/RubroClass.php');
require_once ('../model/subModulosClass.php');

Usuario::verificarSesion(22);

if(isset($_POST['btnEliminar']))
{
    $rubro = new Rubro();
    $rubro->idrubro = $_POST['btnEliminar'];
    $rubro->deleteRubro();
}

?>

<br><br><br>
<h4 class="text-center">Lista de Rubros</h4>

<div class="d-flex justify-content-center">
    <a href="../view/rubroCrear_view.php" class="btn btn-success">Nuevo Rubro</a>
    
</div>
<form action="" method="POST">
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-12">
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach(Rubro::selectAllRubro() as $row)
                        {
                            echo "<tr>";
                                echo "<td class='center'>$row[idrubro]</td>";
                                echo "<td>$row[nombre]</td>";
                                echo "<td>$row[descripcion]</td>";
                                echo "<td><a class='btn btn-info' href='../view/rubroModificar_view.php?idrubro=$row[idrubro]'>Modificar</a></td>";
                                echo "<td><button class='btn btn-danger' name='btnEliminar' value='$row[idrubro]'>Eliminar</button></td>";
                            echo "</tr>";
                        }                    
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>
<style>
    
th {
  color: #81b214;
  text-align: center;
}

.center {
  text-align: center;
}


</style>
<?php
require_once ('../view/pie2.php');
?>
