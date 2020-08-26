<?php
require_once ('../model/UsuarioClass.php');
require_once ('../view/cabecera.php');
require_once ('../model/LiquidacionClass.php');
require_once ('../model/tiposDeLiquidacionClass.php');
Usuario::verificarSesion(37);

$liq = new Liquidacion();
$liq->idliquidacion = $_GET['idLiquidacion'];
$liq->selectLiquidacion();

if(isset($_POST['btnGuardar']))
{
    $liq->nombre = $_POST['txtNombre'];
    $liq->desde = $_POST['txtDesde'];
    $liq->hasta = $_POST['txtHasta'];
    $liq->banco = $_POST['selectBanco'];
    $liq->fechaDePago = $_POST['txtFechaDePago'];
    $liq->TipoDeLiquidacion = $_POST['selectTipoDeLiquidacion'];
    if($liq->updateLiquidacion() == true)
    {        
        echo "<script type='text/javascript'>  window.location.href='../view/liquidaciones_view.php'; </script>";
    }
}

?>

<br><br>

<form action="" method="POST">
    <h3 class="text-center mt-3">Modificar Liquidacion</h3>
        <div class="container-fluid eliminarImprimir mt-5">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    Nombre
                    <input type="text" class="form-control" name="txtNombre" id="txtNombre">
                    Desde
                    <input type="date" class="form-control" name="txtDesde" id="txtDesde">
                    Hasta
                    <input type="date" class="form-control" name="txtHasta" id="txtHasta">
                    Banco
                    <select class="form-control" name="selectBanco" id="selectBanco">
                        <option>Macro</option>
                        <option>Santander</option>
                        <option>Banco Nacion</option>
                        <option>Macro</option>
                        <option>BBVA</option>
                    </select>
                    Fecha de Pago
                    <input type="date" class="form-control" name="txtFechaDePago" id="txtFechaDePago">
                    Selecciones Tipo de Liquidacion
                    <select class="form-control" name="selectTipoDeLiquidacion" id="selectTipoDeLiquidacion">
                        <?php
                            $tiposDeLiq = new tiposDeLiquidacion();
                            $datos = $tiposDeLiq->SelectAllTiposLiq();
                            foreach($datos as $row)
                            {
                                echo "<option value='$row[idTiposDeLiquidacion]'>$row[Nombre]</option>";
                            }
                        ?>
                    </select>

                    <button class="btn btn-success mt-3" name="btnGuardar" type="submit">Guardar Cambios</button>

                </div>
            </div>

        </div>
</form>    


 <!-- boton menu empleado -->
 <div class="container eliminarImprimir evitarSalto">
    <div class="row align-items-end">
            <div class="col-sm ">            
                <br><a href="../view/liquidaciones_view.php">Lista de Liquidaciones de sueldo</a>    
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
    document.getElementById('txtNombre').value = '<?php echo $liq->nombre; ?>';
    document.getElementById('txtDesde').value = '<?php echo $liq->desde; ?>';
    document.getElementById('txtHasta').value = '<?php echo $liq->hasta; ?>';
    document.getElementById('selectBanco').value = '<?php echo $liq->banco; ?>';
    document.getElementById('txtFechaDePago').value = '<?php echo $liq->fechaDePago; ?>';
    document.getElementById('selectTipoDeLiquidacion').value = '<?php echo $liq->TipoDeLiquidacion->idTiposDeLiquidacion ?>';


</script>