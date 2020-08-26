<?php
require_once ('../model/UsuarioClass.php');
require_once ('../view/cabecera.php');
Usuario::verificarSesion(9);

?>

<div align="center">
    <br><br><h3 class="mt-5">Menu Ventas</h3>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <ul>
                <li><a href="../view/ventas_view.php">Nueva Venta</a></li>
                <li><a href="../view/ventasInforme_view.php">Informe de Venta</a></li>
                <li><a href="../view/Clientes_view.php">Clientes</a></li>

                <li><a href="../view/menuPrincipal_view.php">Volver</a></li>

            </ul>

        </div>
    </div>
</div>

<?php
require_once ('../view/pie.php');
?>
