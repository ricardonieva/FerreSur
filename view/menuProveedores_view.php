<?php
require_once ('../view/cabecera.php');
require_once ('../model/UsuarioClass.php');
Usuario::verificarSesion(7);
?>

<div align="center">
    <br><br><h3 class="mt-5">Menu proveedores</h3>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <ul>
                <li><a href="../view/proveedores_view.php">Lista Proveedores</a></li>
                <li><a href="../view/compraProveedores_view.php">Compra a Proveedores</a></li>
                <li><a href="../view/CompraLista_view.php">Lista de Compra a Proveedores</a></li>


                <li><a href="../view/menuPrincipal_view.php">Volver</a></li>

            </ul>

        </div>
    </div>
</div>

<?php
require_once ('../view/pie.php');
?>
