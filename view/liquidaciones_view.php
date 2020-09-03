<?php
require_once ('../model/UsuarioClass.php');
require_once ('../view/cabecera.php');
require_once ('../model/LiquidacionClass.php');
Usuario::verificarSesion(14);


if(isset($_POST['btnEliminar']))
{
    $liq = new Liquidacion();
    $liq->idliquidacion = $_POST['btnEliminar'];
    $liq->deleteLiquidacion();
}

?>
<br><br>
<h3 class="text-center mt-4">Lista de Liquidaciones</h3>
<form action="" method="POST">
    <div class="d-flex justify-content-center"> 
        <a href="../view/LiquidacionNuevo_view.php" class="btn btn-success mt-3">Nueva Liquidacion</a>
    </div>

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="form-group col-md-12">
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th>codigo</th>
                            <th>nombre</th>
                            <th>desde</th>
                            <th>Hasta</th>
                            <th>Tipo</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>    
                        <?php
                            foreach(Liquidacion::selectAllLiquidacion() as $row)
                            {
                                echo "<tr>";
                                    echo "<td>$row[idliquidacion]</td>";
                                    echo "<td>$row[nombre]</td>";
                                    echo "<td>".date("d/m/Y", strtotime($row['desde']))."</td>";
                                    echo "<td>".date("d/m/Y", strtotime($row['hasta']))."</td>";
                                    echo "<td>$row[Nombre]</td>";
                                    echo "<td><a href='../view/liquidacionModificar_view.php?idLiquidacion=$row[idliquidacion]' class='btn btn-info'>Modificar</a></td>";
                                    echo "<td><button type='submit' class='btn btn-danger' name='btnEliminar' value='$row[idliquidacion]'>Eliminar</button></td>";
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
