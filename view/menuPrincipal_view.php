<?php
require_once ('../model/UsuarioClass.php');
require_once ('../view/cabecera.php');
Usuario::verificarSesion(5);//2 es todo lo q sea articulos
//sesion::verificarSiTieneRol();
?>

<div align="center">
    <br><h3 class="mt-5">Menu Principal</h3>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <ul class="list-group list-group-horizontal-md">
                <li class="list-group-item"><a href="../view/menuArticulos_view.php"><img src="images/Logos/articulos.jpg" alt="articulo" width="100" height="100"> Articulos</a></li>
                <li class="list-group-item"><a href="../view/menuProveedores_view.php"><img src="images/Logos/proveedores.png" alt="proveedores" width="100" height="100">Proveedores</a></li>
                <li class="list-group-item"><a href="../view/menuEmpleados_view.php"><img src="images/Logos/empleado.png" alt="empleados" width="100" height="100">Empleados</a></li>
                <li class="list-group-item"><a href="../view/menuVentas_view.php"><img src="images/Logos/ventas.jpg" alt="ventas" width="100" height="100">Ventas</a></li>
            </ul>

        </div>
    </div>
</div>
<?php require_once ('../view/pie.php');?>
