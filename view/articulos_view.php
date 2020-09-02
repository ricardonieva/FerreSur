<?php
require_once('../model/UsuarioClass.php');
require_once('../view/cabecera.php');
require_once('../model/ArticuloClass.php');
Usuario::verificarSesion(20);

if (isset($_POST['btnEliminar'])) {
    $articulo = new Articulo();
    $articulo->idarticulo = $_POST['btnEliminar'];
    $articulo->deleteArticulo();
}

?>

<br><br><br><br>
<h3 class="text-center">Lista de Articulos</h3>

<div class="container-fluid mt-4">

    <div class="d-flex justify-content-center">
        <a href="../view/articulocrear_view.php" class="btn btn-success">Nuevo Articulo</a>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Precio de Venta</th>
                        <th>Stock</th>
                        <th>IVA</th>

                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach (Articulo::selectAllArticulos() as $row) {
                        echo "<tr>";
                        echo "<td class='center'>$row[idarticulo]</td>";
                        echo "<td>$row[nombre]</td>";
                        echo "<td>$row[descripcion]</td>";
                        echo "<td>$row[precioVenta]</td>";
                        echo "<td>$row[stock]</td>";
                        echo "<td>$row[iva] %</td>";
                        echo "<td><a href='../view/articuloModificar_view.php?idArticulo=$row[idarticulo]' class='btn btn-info'>Modificar</a></td>";
                        echo "<td><form method='POST'><button type='submit' class='btn btn-danger' name='btnEliminar' value='$row[idarticulo]'>Eliminar</button></form></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php

?>