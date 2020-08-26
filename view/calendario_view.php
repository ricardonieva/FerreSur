<?php
require_once ('../model/UsuarioClass.php');
include_once ('../view/cabecera.php');
Usuario::verificarSesion(10);
?>

<br><br><br><br>
<div class="container-fluid">
    <h3 class="text-center">Calendario</h3>
    <div class="row justify-content-center">
        <div class="col-md-2">
            Fecha:
            <input type="date" class="form-control" id="fecha">
        </div>
        <div class="col-md-2 mt-4">
            Habil:
            <input type="checkbox" id="habil" checked>

        </div>
        <div class="col-md-2 mt-4">
        <button class="btn btn-info" onclick="agregarFecha();">Cargar Fecha</button>
        </div>
    
    </div>

</div>
<?php
include_once ('../view/pie3.php');
?>

<script type="text/javascript" src="../library/calendario.js"></script>