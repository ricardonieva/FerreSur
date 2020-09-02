<?php
require_once('../model/UsuarioClass.php');
require_once('../view/cabecera.php');
Usuario::verificarSesion(6);
?>

<div align="center">
    <br><br>
    <h3 class="mt-5">Menu Articulos</h3>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <ul class="lista">

                <li>
                    <button class="box" onclick="window.open('../view/Articulos_view.php','_parent')">Lista de Articulos</button>
                </li>
                <li>
                    <button class="box" onclick="window.open('../view/rubro_view.php','_parent')">Rubro</button>
                </li>
                <li>
                    <button class="box" onclick="window.open('../view/menuprincipal_view.php','_parent')">
                    <img class="imagen" src="images/Logos/back.svg" alt="volver">Volver</button>
                </li>

            </ul>

        </div>
    </div>
</div>


<?php
require_once('../view/pie.php');
?>