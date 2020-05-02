<?php
require_once ('../view/cabecera.php');
require_once ('../model/UsuarioClass.php');
Usuario::verificarSesion(8);

?>

<div align="center">
    <br><br><h3 class="mt-5">Menu Empleados</h3>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <ul>
                <li><a href="../view/empleados_view.php">Lista De Empleados</a></li>
                <li><a href="../view/RolAsignar_view.php">Agregar Rol a Empleado</a></li> 
                <li><a href="../view/categoria_view.php">Categoria</a></li>
                <li><a href="../view/grupoFamiliar_view.php">Grupo Familiar</a></li>         
                <li><a href="../view/calendario_view.php">Calendario</a></li>
                <li><a href="../view/asistencia_view.php">Asistencia</a></li>
                <li><a href="../view/concepto_view.php">Conceptos</a></li>
                <li><a href="../view/fichas_view.php">Ficha</a></li>
                <li><a href="../view/tipoDeLiquidaciones_view.php">Lista Tipo de Liquidacion</a></li>
                <li><a href="../view/Liquidaciones_view.php">Lista de Liquidacion de Sueldos</a></li>
                <li><a href="../view/generarLiquidaciones_view.php">Generar Liquidaciones</a></li>
                <li><a href="../view/libroUnicoDeLiquidacionDeHaberes.php">Libro Unico</a></li>
                <li><a href="../view/menuPrincipal_view.php">Volver</a></li>

            </ul>

        </div>
    </div>
</div>

<?php
require_once ('../view/pie.php');
?>
