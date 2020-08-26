<?php
require_once ('../model/UsuarioClass.php');
Usuario::verificarSesion(13);
require_once ('../view/cabecera.php');
require_once ('../model/tiposDeLiquidacionClass.php');
require_once ('../model/conceptoClass.php');

$concep = new Concepto();

$tipoLiq = new tiposDeLiquidacion();
$tipoLiq->idTiposDeLiquidacion = $_GET['idTipoDeLiquidacion'];
$tipoLiq->selectTipoLiquidacionConceptos();

if(isset($_SESSION["listaConceptosModificar"]))
{

}
else
{
    foreach($tipoLiq->TiposDeLiquidacion_conceptos as $fila)
    {
        $array = array($fila->idConcepto,$fila->tipoConcepto,$fila->detalle, $fila->percepcionSalarial);
        $_SESSION["listaConceptosModificar"][] = $array;
    }
    
}

if(isset($_POST['btnAgregar']))
{    
    $esta = false;
    for($i = 0; $i < count($_SESSION['listaConceptosModificar']); $i++)
    {
        if($_SESSION['listaConceptosModificar'][$i][0] == $_POST['concepto'])
        {
            $esta = true;
            echo "<script>alert('El concepto ya esta cargado');</script>";            
            break;
        }   
    }  
    if($esta == false)
    {
        $concep->idConcepto = $_POST['concepto'];
        $concep->selectConcepto();
        $arrayConcepto = array($concep->idConcepto,$concep->tipoConcepto,$concep->detalle, $concep->percepcionSalarial);
        $_SESSION["listaConceptosModificar"][] = $arrayConcepto;
    } 
}


if(isset($_POST['btnQuitar']))
{
    for($i = 0; $i < count($_SESSION['listaConceptosModificar']); $i++)
    {
        if($_SESSION['listaConceptosModificar'][$i][0] == $_POST['btnQuitar'])
        {
            unset($_SESSION['listaConceptosModificar'][$i]);
            $_SESSION['listaConceptosModificar'] = array_values($_SESSION['listaConceptosModificar']);
            break;
        }
    }   
}

if(isset($_POST['btnLimpiar']))
{
    unset($_SESSION['listaConceptosModificar']);
    foreach($tipoLiq->TiposDeLiquidacion_conceptos as $fila)
    {
        $array = array($fila->idConcepto,$fila->tipoConcepto,$fila->detalle, $fila->percepcionSalarial);
        $_SESSION["listaConceptosModificar"][] = $array;
    }
}

if(isset($_POST['btnGuardar']))
{
    $tipoLiq->modificarTiposDeLiquidacionConceptos($_SESSION["listaConceptosModificar"]);
    unset($_SESSION["listaConceptosModificar"]);
}



?>

<br><br><br>
<h4 class="text-center">Modificar Conceptos de Tipos de Liquidacion</h4>


<form action="" method="POST">
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4">
                Nombre:
                <p class="text-primary" id="nombre"></p>
                Tipo:
                <p class="text-primary" id="tipo"></p>
                Conceptos:                   
                <select name="concepto" id="concepto" class="form-control">
                    <?php
                        foreach($concep->cargarConceptos() as $row)
                        {
                            echo "<option value='$row[idconcepto]'>$row[tipoConcepto] - $row[detalle]</option>";
                        }
                    ?>
                </select>
                <button class="btn btn-primary mt-3" name="btnAgregar">Agregar</button>
                <button class="btn btn-info mt-3" name="btnLimpiar">Mostrar Datos Originales</button>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col-12 col-md-10">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>tipoConcepto</th>
                            <th>detalle</th>
                            <th>Percepcion Salarial</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($_SESSION["listaConceptosModificar"]))
                        {
                            foreach($_SESSION["listaConceptosModificar"] as $row2)
                            {
                                echo "<tr>";
                                    echo "<td>$row2[0]</td>";
                                    echo "<td>$row2[1]</td>";
                                    echo "<td>$row2[2]</td>";
                                    echo "<td>$row2[3]</td>";
                                    echo "<td><button class='btn btn-danger' name='btnQuitar' value='$row2[0]'>Quitar</button></td>";
                                echo "</tr>";
                            }     
                        }                                           
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <button class="btn btn-success" name="btnGuardar">Guardar Cambios</button>
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

        document.getElementById('nombre').innerHTML = '<?php echo $tipoLiq->nombre; ?>';
        document.getElementById('tipo').innerHTML = '<?php echo $tipoLiq->tipo; ?>';
    });
</script>