<?php
require_once ('../model/UsuarioClass.php');
require_once ('../view/cabecera.php');
usuario::verificarSesion(28);
require_once ('../model/VentaClass.php');
require_once ('../model/ClienteClass.php');
require_once ('../model/convertirNumeros.php');


$venta = new Venta();
$venta = $venta->buscarVentaPorId($_GET['ventaid']);
//var_dump($venta);
$total = 0;
$netoGrabado = 0;
$iva21 = 0;
$iva10 = 0;
?>

<br><br>
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-3">
        <img src="../view/images/logoferresur.png" class="rounded float-left logo" alt="">
        
        </div>
        <div class="col-md-3">
            <p style="line-height:5px;" class="mt-1">Ferre-Sur S.R.L.</p>
            <p style="line-height:5px;">Vélez Sársfield 854</p>
            <p style="line-height:5px;">Aguilares</p>
            <p style="line-height:5px;">CUIT N° 34-99903208-9</p>
            <p style="line-height:5px;">RESPONSABLE INSCRIPTO</p>
        </div>

        <div class="col-md-2">
            <h5 class="mt-2"><?php echo ($venta[0]['condicioniva'] == "RI") ? "Factura A" : "Factura B"; ?></h5>
            <h5>N° <?php echo $venta[0]['idventa']; ?></h5>
            <h6>Fecha <?php echo date("d/m/Y", strtotime($venta[0]['fechaHora'])); ?> </h6>
        </div>
    </div>

    <br>
    <div class="row justify-content-center">
        <div class="col-md-2">
        
        </div>
        <div class="col-md-10">
           <h6>Señor/es: <?php echo $venta[0]['nombre']; ?></h6>
           <h6>Domicilio: <?php echo $venta[0]['direccion']; ?> - Localidad: <?php echo $venta[0]['localidad']; ?></h6>
           <h6>IVA: <?php echo Cliente::descripcionDeCondicionDeIva($venta[0]['condicioniva']); ?></h6>
           <?php echo ($venta[0]['cuit'] != "" && $venta[0]['cuit'] != 0) ? "<h6>CUIT/CUIL: ".$venta[0]['cuit']."</h6>" : ""; ?>
        </div>

        <div class="col-md-1">
        
        </div>
    </div>


    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>codigo</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <?php echo ($venta[0]['condicioniva'] == "RI") ? "<th>P. Unitario</th>" : ""; ?>
                        <?php echo ($venta[0]['condicioniva'] == "RI") ? "<th>IVA</th>" : ""; ?>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($venta as $row) {
                        $subTotal = $row["cantidad"] * $row["articulo_precioVenta"];
                        $total = $total + $subTotal;
                        $precioUnitario = $row["articulo_precioVenta"] - ($row["articulo_precioVenta"] * ($row["iva"]/100));
                        $precioUnitario = round($precioUnitario, 2);
                        $netoGrabado = $netoGrabado + ($precioUnitario * $row["cantidad"]);
                        if($row["iva"] == 21) {
                            //$iva21 = $iva21 + ($row["cantidad"] * ($row["articulo_precioVenta"] * ($row["iva"]/100)));
                            $iva21 = $iva21 + ($subTotal * ($row["iva"]/100));
                        }
                        else {
                            //$iva10 = $iva10 + ($row["cantidad"] * ($row["articulo_precioVenta"] * ($row["iva"]/100)));
                            $iva10 = $iva10 + ($subTotal * ($row["iva"]/100));
                        }
                        echo "<tr>";
                            echo "<th>$row[idarticulo]</th>";
                            echo "<td>$row[articulo_nombre]</td>";
                            echo "<td>$row[cantidad]</td>";                            
                            echo "<td>$row[articulo_precioVenta]</td>";
                            echo ($row["condicioniva"] == "RI") ? "<td>$precioUnitario</td>" : "";
                            echo ($row["condicioniva"] == "RI") ? "<td>$row[iva] %</td>" : "";
                            echo "<td>$subTotal</td>";
                        echo "</tr>";
                    } 
                    ?>
                </tbody>

            </table>

        </div>          

    </div>

    <?php if($venta[0]['condicioniva'] == "RI") { ?>

    <div class="row justify-content-center">
        <div class="col-md-4 mt-3">          
            <h6><?php echo "Neto Gravado: ".$netoGrabado; ?></h6>
            <h6><?php echo "IVA 21% : ".$iva21; ?></h6>
            <h6><?php echo "IVA 10,5% : ".$iva10; ?></h6>
            <h6>Son Pesos: <?php echo strtoupper (numeral($total)); ?></h6>
        </div>

        <div class="col-md-2">
            <h5 class="text-right mt-3">Total $ </h5>
        </div>
        <div class="col-md-2">
            <div class="alert alert-primary text-center" role="alert">
                <?php echo $total; ?>
            </div>
        </div>
    </div>

    <?php }
    else { ?>

        <div class="row justify-content-center">
        <div class="col-md-4 mt-3">          
            <h6>Son Pesos: <?php echo strtoupper (numeral($total)); ?></h6>
        </div>

        <div class="col-md-2">
            <h5 class="text-right mt-3">Total $ </h5>
        </div>
        <div class="col-md-2">
            <div class="alert alert-primary text-center" role="alert">
                <?php echo $total; ?>
            </div>
        </div>
        </div>

    <?php } ?>
    <div class="eliminarImprimir">
        <div class="d-flex justify-content-center">        
            <button class="btn btn-primary" onclick="botonImprimir()">Imprirmir</button>
        </div>

        <div class="d-flex justify-content-center mt-3">
            <a class="btn btn-primary" href="../view/ventas_view.php">Volver</a>
        </div>
    </div>
    

</div>

<?php
require_once ('../view/pie4.php');
?>

<script type="text/javascript">
    document.title = "Factura N° "+ <?php echo $_GET['ventaid']; ?>;
    function botonImprimir(){
        window.print();
    }
</script>