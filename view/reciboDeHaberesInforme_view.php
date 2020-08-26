<?php
include_once ('../model/UsuarioClass.php');
require_once ('../view/cabecera.php');
Usuario::verificarSesion(27);
$idLiquidacion = (int) $_GET['recibodehaberesid'];
?>
<br><br><br>
<div class="container-fluid mt-1">
    <div class="row justify-content-center">
        <div class="col-md-2 col-md-3 col-2">
        <img src="../view/images/logoferresur.png" class="rounded float-left logo" alt="">
        
        </div>
        <div class="col-md-3 col-sm-3 col-2">
            <p style="line-height:5px;" class="mt-3">Ferre-Sur S.R.L.</p>
            <p style="line-height:5px;">Vélez Sársfield 854</p>
            <p style="line-height:5px;">Aguilares - Tucuman</p>
            <p style="line-height:5px;">CUIT N° 34-99903208-9 </p>
        </div>

        <div class="col-md-3 col-sm-3 col-2">
            <h5 class="mt-2">Recibo de Haberes</h5>
            <h5 id="NumeroDeRecibo"><?php echo $idLiquidacion; ?></h5>
            <h5 id="tipoDeRecibo">Duplicado</h5>
        </div>

    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-9 mt-n3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>CUIL</th>
                    </tr>
                </thead>
                <tbody id="tablaEmpleado">
                   
                </tbody>
            </table>
        </div>

        <div class="col-md-9 mt-n3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Sueldo Basico</th>
                        <th>Forma Laboral</th>
                        <th>Fecha Ingreso</th>
                    </tr>
                </thead>
                <tbody id="tablaCategoria">
                  
                </tbody>
            </table>
        </div>

        <div class="col-md-9 mt-n3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Fecha de Cobro</th>
                        <th>Cuenta Bancaria</th>
                        <th>Periodo</th>
                    </tr>
                </thead>
                <tbody id="tablaPeriodo">
                  
                </tbody>
            </table>
        </div>

        <div class="col-md-9 mt-n3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Detalle</th>
                        <th>Cantidad</th>
                        <th>Haberes</th>
                        <th>Deducciones</th>
                    </tr>
                </thead>
                <tbody id="tablaDetalle">
                   
                </tbody>
            </table>
        </div>

    </div>

    <div class="row justify-content-center">
        <div class="col-md-9 mt-n3">
            <table class="table table-bordered">
                <thead>
                    <tr>    
                        <th>Lugar y Fecha</th>
                        <th>Total Neto</th>
                        <th>Total Haberes</th>
                        <th>Total Deducciones</th>
                    </tr>
                </thead>
                <tbody id="tablaTotal">
                   
                </tbody>
            </table>
        </div>

        <div class="col-md-9 mt-n3">
            <table class="table table-bordered">
                <thead>
                  
                </thead>
                <tbody id="tablaDineroLetra">
                                   
                </tbody>
            </table>
        </div>

        <div class="col-md-9 mt-n3">
            <table class="table table-bordered">
                <thead>                  
                </thead>
                <tbody id="tablaFirma">                   
                    <tr>
                        <td>El presente es duplicado del recibo original que obra en nuestro poder firmado por el empleado.</td>
                        <td class="text-center">Firma Del Empleado <br><img src="../view/images/cuadroblanco.png" alt="firma" width="145" height="81"> </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>     

    <div class="row justify-content-center mt-2">
        <div class="col-md-4">
            <button class="btn btn-primary eliminarImprimir" onclick="window.print();">Imprimir</button>
            <button class="btn btn-primary  eliminarImprimir" onclick="original(event);">Ver Original</button>
            <button class="btn btn-primary  eliminarImprimir" onclick="duplicado(event);">Ver Duplicado</button>
        </div>     
    </div>

</div>

<?php
include_once ('../view/pie3.php');
?>

<script type="text/javascript" src="../library/LiquidacionInforme.js"></script>