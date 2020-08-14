<?php
require_once ('../model/UsuarioClass.php');
require_once ('../model/CompraClass.php');
require_once ('../model/ArticuloClass.php');
//Usuario::verificarSesion(25);
require_once ('../view/cabecera.php');


$compras = new Compra();
$compras = $compras->cantidadDeUnidadesCompradas($_GET['fechadesde'], $_GET['fechahasta']);
//var_dump($compras);
$probando = 123;
$tituloDelGrafico = "Articulos comprados desde el ".date("d/m/Y", strtotime($_GET['fechadesde']))." hasta ".date("d/m/Y", strtotime($_GET['fechahasta']));
foreach($compras as $row) {
    $dataPoints[] = array("y" => $row["cantidad"], "label" => $row["nombre"], "indexLabel"=> "$".$row["sumaTotal"]); 
}
//var_dump($dataPoints);
$tituloDelGrafico2 = "";
if(isset($_POST['btnMostrar'])) {
    $articulo = new Articulo();
    $articulo->idarticulo = $_POST['selectArticulo'];
    $articulo->selectArticulo();
    $compras2 = new Compra();
    $compras2 = $compras2->cantidadDeUnidadesCompradasDeArticulo($_GET['fechadesde'], $_GET['fechahasta'], $_POST['selectArticulo']);
    var_dump($articulo);
    $tituloDelGrafico2 = "$articulo->nombre comprado desde el ".date("d/m/Y", strtotime($_GET['fechadesde']))." hasta ".date("d/m/Y", strtotime($_GET['fechahasta']));
    foreach($compras2 as $row) {
        $dataPoints2[] = array("y" => $row["cantidad"], "label" => $row["razonSocial"], "indexLabel"=> "$".$row["articulo_costounitario"]); 
    }
}

?>

<br><br><br>

<h3 align="center">Grafico</h3>

<div id="chartContainer" style="height: 370px; width: 100%;"></div>

<br><br>
<form action="" method="POST">
    <div class="container-fluid">
        <div class="row justify-content-center form-group">
            <div class="col-md-2 mt-2">
                <label>Seleccione el articulo</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" name="selectArticulo">
                    <?php foreach($compras as $row){ ?>
                    <option value="<?php echo $row["idarticulo"] ?>"><?php echo $row["nombre"] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-info form-control" name="btnMostrar">Mostrar</button>
            </div>
        </div>
    </div>
</form>
<div id="chartContainer2" style="height: 370px; width: 100%;"></div>


<script type="text/javascript">
    window.onload = function() {
    
    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2",
        title:{
            text: "<?php echo $tituloDelGrafico; ?>"
        },
        axisY: {
            title: "Unidades"
        },
        data: [{
            type: "column",
            yValueFormatString: "#,##0.## unidades",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();

    //grafico 2
    var titulo = "<?php echo $tituloDelGrafico2; ?>";
    if(titulo != "") {
        var chart = new CanvasJS.Chart("chartContainer2", {
        animationEnabled: true,
        theme: "light2",
        title:{
            text: "<?php echo $tituloDelGrafico2; ?>"
        },
        axisY: {
            title: "Unidades"
        },
        data: [{
            type: "column",
            yValueFormatString: "#,##0.## unidades",
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
        }]
        });
        chart.render();
    }
    }

</script>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


<?php
require_once ('../view/pie5.php');
?>