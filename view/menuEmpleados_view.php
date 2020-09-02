<?php
require_once ('../model/UsuarioClass.php');
require_once ('../view/cabecera.php');
Usuario::verificarSesion(8);

?>

<div align="center">
    <br><br><h3 class="mt-5">Menu Empleados</h3>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <ul class="lista">
                

                <li><button class="box" onclick="window.open('../view/empleados_view.php','_parent')">Lista De Empleados</button></li>
                <li><button class="box" onclick="window.open('../view/RolAsignar_view.php','_parent')">Agregar Rol a Empleado</button></li>
                <li><button class="box" onclick="window.open('../view/categoria_view.php','_parent')">Categoria</button></li>
                <li><button class="box" onclick="window.open('../view/grupoFamiliar_view.php','_parent')">Grupo Familiar</button></li>
                <li><button class="box" onclick="window.open('../view/calendario_view.php','_parent')">Calendario</button></li>
                <li><button class="box" onclick="window.open('../view/asistencia_view.php','_parent')">Asistencia</button></li>
                <li><button class="box" onclick="window.open('../view/concepto_view.php','_parent')">Conceptos</button></li>
                <li><button class="box" onclick="window.open('../view/fichas_view.php','_parent')">Ficha</button></li>
                <li><button class="box" onclick="window.open('../view/tipoDeLiquidaciones_view.php','_parent')">Lista de Liquidación</button></li>
                <li><button class="box" onclick="window.open('../view/Liquidaciones_view.php','_parent')">Lista de Liquidacion de Sueldos</button></li>
                <li><button class="box" onclick="window.open('../view/generarLiquidaciones_view.php','_parent')">Generar Liquidaciones</button></li>
                <li><button class="box" onclick="window.open('../view/libroUnicoDeLiquidacionDeHaberes.php','_parent')">Libro Unico</button></li>
                <li><button class="box" onclick="window.open('../view/menuPrincipal_view.php','_parent')"><img class="imagen" src="images/Logos/back.svg" alt="volver">Volver</button></li> 

            </ul>

        </div>
    </div>
</div>

<?php
require_once ('../view/pie.php');
?>
