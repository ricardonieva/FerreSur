<?php
require_once ('../view/cabecera.php');
require_once ('../model/tiposDeLiquidacionClass.php');
require_once ('../model/UsuarioClass.php');
Usuario::verificarSesion(13);

if(isset($_POST['btnEliminar']))
{
    $tipoLiq = new tiposDeLiquidacion();
    $tipoLiq->idTiposDeLiquidacion = $_POST['btnEliminar'];
    $tipoLiq->deleteTipoDeLiquidacion();
}

?>

<br><br><br>
<h4 class="text-center">Lista de Tipos de Liquidacion</h4>

<div class="d-flex justify-content-center">
    <a href="../view/tipoDeLiquidacionNuevo_view.php" class="btn btn-success">Agregar Tipo de Liquidacion</a>
</div>
<form action="" method="POST">
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach(tiposDeLiquidacion::SelectAllTiposLiq() as $row)
                        {
                            echo "<tr>";
                                echo "<td>$row[idTiposDeLiquidacion]</td>";
                                echo "<td>$row[Nombre]</td>";
                                echo "<td>$row[Tipo]</td>";
                                echo "<td><a class='btn btn-info' href='../view/tipoDeLiquidacionModificar_view.php?idTipoDeLiquidacion=$row[idTiposDeLiquidacion]'>Modificar</a></td>";
                                echo "<td><a class='btn btn-info' href='../view/tipoDeLiquidacionModificarConceptos_view.php?idTipoDeLiquidacion=$row[idTiposDeLiquidacion]'>Modificar Conceptos</a></td>";
                                echo "<td><button class='btn btn-danger' name='btnEliminar' value='$row[idTiposDeLiquidacion]'>Eliminar</button></td>";
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
