<?php
require_once('../model/UsuarioClass.php');
require_once('../view/cabecera.php');
Usuario::verificarSesion(7);

?>

<div align="center">
    <br><br>
    <h3 class="mt-5">Menu proveedores</h3>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <ul class="lista">
                <li><button class="box" onclick="window.open('../view/proveedores_view.php','_parent')">Lista proveedores</button></li>
                <li><button class="box" onclick="window.open('../view/compraProveedores_view.php','_parent')">Compra a Proveedores</button></li>
                <li><button class="box" onclick="window.open('../view/CompraLista_view.php','_parent')">Lista de Compra a Proveedores</button></li>
                <li><button class="box" onclick="window.open('../view/menuPrincipal_view.php','_parent')">
                <img class="imagen" src="images/Logos/back.svg" alt="volver"> Volver</button></li>
                

            </ul>

        </div>
    </div>
</div>

<?php
require_once('../view/pie.php');
?>