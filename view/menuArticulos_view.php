<?php
require_once ('../model/UsuarioClass.php');
require_once ('../view/cabecera.php');
Usuario::verificarSesion(6);
?>

<div align="center">
    <br><br><h3 class="mt-5">Menu Articulos</h3>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <ul>

                <li><a href="../view/Articulos_view.php">Lista de Articulo</a></li>
                <li><a href="../view/rubro_view.php">Rubro</a></li>
                <li><a href="../view/menuprincipal_view.php">Menu Principal</a></li>

               
            </ul>

        </div>
    </div>
</div>

<?php
require_once ('../view/pie.php');
?>
