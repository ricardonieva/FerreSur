<?php
require_once ('../view/cabecera.php');
require_once ('../model/tiposDeLiquidacionClass.php');

$tipoLiq = new tiposDeLiquidacion();
$tipoLiq->idTiposDeLiquidacion = $_GET['idTipoDeLiquidacion'];
$tipoLiq->selectTipoLiquidacionConceptos();

if(isset($_POST['btnGuardar']))
{
    $tipoLiq->tipo = $_POST['nombre'];
    $tipoLiq->tipo = $_POST['Tipo'];
    $tipoLiq->updateTipoLiquidacion();
}

?>

<br><br><br>
<h4 class="text-center">Modificar Tipos de Liquidacion</h4>


<form action="" method="POST">
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4">
                Nombre:
                <input type="text" class="form-control" placeholder="Nombre" name="nombre" id="nombre">
                Tipo:
                <select name="Tipo" id="Tipo" class="form-control">
                    <option>Sueldo</option>
                    <option>Despido</option>
                    <option>Aguinaldo</option>
                </select>
                <button class="btn btn-primary mt-3" name="btnGuardar">Guardar Cambios</button>
            </div>
        </div>
    </div>
</form>

<!-- boton menu empleado -->
<div class="container eliminarImprimir evitarSalto">
   <div class="row align-items-end">
        <div class="col-sm ">            
             <br><a href="../view/tipoDeLiquidaciones_view.php">Lista de Tipos de Liquidacion</a>    
        </div>    
    </div>  
</div>
    
<!-- fin boton articulo -->
    
<footer class="footer">
  <div class="container"> <span class="text-muted">
    <p>FINAL GESTION DE DATOS</p></span> 
  </div>
</footer>   
  </body>
</html>

<script>
    window.addEventListener('load', function(){
        document.getElementById('Tipo').value = '<?php echo $tipoLiq->tipo; ?>';
        document.getElementById('nombre').value = '<?php echo $tipoLiq->nombre; ?>';

    });
</script>