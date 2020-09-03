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
            <ul class="lista">
                

                <li><button class="box" onclick="window.open('../view/ventas_view.php','_parent')">Nueva Venta</button></li>
                <li><button class="box" onclick="window.open('../view/ventasInforme_view.php','_parent')">Informe de Venta</button></li>
                <li><button class="box" onclick="window.open('../view/Clientes_view.php','_parent')">Clientes</button></li>
                <li><button class="box" onclick="window.open('../view/menuPrincipal_view.php','_parent')"><img class="imagen" src="images/Logos/back.svg" alt="volver">Volver</button></li>

            </ul>

        </div>
    </div>
</div>

<?php
require_once ('../view/pie.php');
?>
