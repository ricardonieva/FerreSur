<?php
require_once ('../model/CompraClass.php');
require_once ('../model/UsuarioClass.php');
//Usuario::verificarSesion(25);
require_once ('../view/cabecera.php');

if(isset($_POST['btnMostrar']))
{
    $compras = new Compra();
    $compras = $compras->consultarComprasFechas($_POST['fechadesde'], $_POST['fechahasta']);
    //var_dump($compras);
}
?>

<br><br><br>
<form action="" method="POST">
    <div class="container-fluid">
        <h5 class="text-center">Libro IVA Compra</h5>
        <div class="row justify-content-center mt-3 eliminarImprimir">
            <div class="col-md-3">
                Fecha Desde:
                <input type="date" class="form-control input-group" placeholder="Fecha Desde" id="fechadesde" name="fechadesde"> 
            </div>
            <div class="col-md-3">
                Fecha Hasta:
                <input type="date" class="form-control input-group" placeholder="Fecha Hasta" id="fechahasta" name="fechahasta">
            </div>   
            <div class="col-md-1 mt-4">
                <button class="btn btn-primary" name="btnMostrar">Mostrar</button>
            </div>      
        </div>           
        <hr>
        <div class="row justify-content-center">
            <div class="col-md-3">
                <img src="../view/images/logoferresur.png" class="rounded float-left logo" alt="">            
            </div>
            <div class="col-md-3">
                <p style="line-height:5px;" class="mt-3">Ferre-Sur S.R.L.</p>
                <p style="line-height:5px;">Vélez Sársfield 854</p>
                <p style="line-height:5px;">Aguilares</p>
                <p style="line-height:5px;">CUIT N° 34-99903208-9 </p>
            </div>
            <div class="col-md-2">
                <h6 class="mt-2">Libro IVA Compras</h6>
                <h6><?php if(isset($_POST['fechadesde'])) { echo "Desde ".date("d/m/Y", strtotime($_POST['fechadesde'])); }?></h6>
                <h6><?php if(isset($_POST['fechahasta'])) { echo "Hasta ".date("d/m/Y", strtotime($_POST['fechahasta'])); }?></h6>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>N°</th>                            
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>CUIT</th>
                            <th>Condicion</th>
                            <th>Tipo Factura</th>
                            <th>Total</th>
                            <th>Neto Gravado</th>
                            <th>IVA Credito Fiscal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($compras)) {
                            $total = 0;
                            $netoGravado = 0;
                            $iva = 0;
                            foreach($compras as $row) { ?>
                                <tr>
                                    <th><?php echo $row['idcompra']; ?></th>
                                    <td><?php echo date("d/m/Y", strtotime($row['fecha'])); ?></td>
                                    <td><?php echo $row['razonSocial']; ?></td>
                                    <td><?php echo $row['cuil']; ?></td>
                                    <td><?php echo $row['condicioniva'] ?></td>
                                    <td><?php echo ($row['condicioniva'] == "MT") ? "Factura C" : "Factura A"; ?></td>
                                    <?php $calculosIVA = Compra::calcularIVACompra($row['idcompra'], $row['condicioniva']); ?>
                                    <td><?php echo "$ ".$calculosIVA['total']; ?></td>
                                    <td><?php echo ($calculosIVA['netoGravado'] != "-") ? "$ ".$calculosIVA['netoGravado'] : $calculosIVA['netoGravado']; ?></td>
                                    <td><?php echo ($calculosIVA['iva'] != "-") ? "$ ".$calculosIVA['iva'] : $calculosIVA['iva']; ?></td>
                                </tr>
                        <?php 
                                $total = $total + $calculosIVA['total'];
                                if($calculosIVA['netoGravado'] != "-") { $netoGravado = $netoGravado + $calculosIVA['netoGravado']; }
                                if($calculosIVA['iva'] != "-") { $iva = $iva + $calculosIVA['iva']; }
                            } 
                        } ?>

                    </tbody>
                    <tfoot>
                        <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Total</th>
                        <th><?php echo "$ ".$total; ?></th>
                        <th><?php echo "$ ".$netoGravado; ?></th>
                        <th><?php echo "$ ".$iva; ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</form>

    <div class="eliminarImprimir">
        <div class="d-flex justify-content-center">
                <button class="btn btn-primary" onclick="window.print();">Imprirmir</button>
        </div>     
    </div>
<?php
require_once ('../view/pie5.php');
?>