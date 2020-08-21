<?php
require_once ('../model/UsuarioClass.php');
require_once ('../model/VentaClass.php');
require_once ('../model/ArticuloClass.php');
//Usuario::verificarSesion(25);
require_once ('../view/cabecera.php');


$ventas = new Venta();
$ventas = $ventas->cantidadDeUnidadesVentidas($_GET['fechadesde'], $_GET['fechahasta']);
//var_dump($ventas);

$probando = 123;
$tituloDelGrafico = "Artículos vendidos desde el ".date("d/m/Y", strtotime($_GET['fechadesde']))." hasta ".date("d/m/Y", strtotime($_GET['fechahasta']));
foreach($ventas as $row) {
    $dataPoints[] = array("y" => $row["cantidad"], "label" => $row["nombre"], "indexLabel"=> "$".$row["sumaTotal"]); 
}
//var_dump($dataPoints);

$ventas2 = new Venta();
$ventas2 = $ventas2->dineroIngresadoPorVentasDiarias($_GET['fechadesde'], $_GET['fechahasta']);
//var_dump($ventas2);
$tituloDelGrafico2 = "Ventas diarias desde el ".date("d/m/Y", strtotime($_GET['fechadesde']))." hasta ".date("d/m/Y", strtotime($_GET['fechahasta']));
foreach($ventas2 as $row) {
    $dataPoints2[] = array("y" => $row["sumaTotal"], "label" => $row["fecha"]); 
}


$tituloDelGrafico3 = "";
if(isset($_POST['btnMostrar'])) {
    $fecha =  DateTime::createFromFormat('d/m/Y', $_POST['selectFecha']);
    $ventas3 = new Venta();
    $ventas3 = $ventas3->dineroIngresadoDeVentasEnFechaEspecifica($fecha->format('Y-m-d'));
   
    //var_dump($articulo);
    $tituloDelGrafico3 = "Ventas realizadas en la fecha: ". $_POST['selectFecha'];
    foreach($ventas3 as $row) {
        $dataPoints3[] = array("y" => $row["sumaTotal"], "label" => $row["nombre"], "indexLabel"=> "Unidades: ".$row["unidades"]." Precio: ".$row["precioVenta"]); 
    }
}

?>

<br><br><br>

<h3 align="center">Grafico de Ventas</h3>

<div id="chartContainer" style="height: 370px; width: 100%;"></div>

<br><br>

<div id="chartContainer2" style="height: 370px; width: 100%;"></div>

<br><br>
<form action="" method="POST">
    <div class="container-fluid">
        <div class="row justify-content-center form-group">
            <div class="col-md-2 mt-2">
                <label>Seleccione la fecha</label>
            </div>
            <div class="col-md-4">
                <select class="form-control" name="selectFecha">
                    <?php foreach($ventas2 as $row){ ?>
                    <option><?php echo $row["fecha"]; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-info form-control" name="btnMostrar">Mostrar</button>
            </div>
        </div>
    </div>
</form>

<div id="chartContainer3" style="height: 370px; width: 100%;"></div>


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
    ////

    var chart = new CanvasJS.Chart("chartContainer2", {
        title: {
            text: "<?php echo $tituloDelGrafico2; ?>"
        },
        axisY: {
            title: "Total diario"
        },
        data: [{
            type: "line",
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();
    
     //grafico 3
     var titulo = "<?php echo $tituloDelGrafico3; ?>";
    if(titulo != "") {
        var chart = new CanvasJS.Chart("chartContainer3", {
        animationEnabled: true,
        theme: "light2",
        title:{
            text: "<?php echo $tituloDelGrafico3; ?>"
        },
        axisY: {
            title: "Total por articulo"
        },
        data: [{
            type: "column",
            yValueFormatString: "$ #,##0.##",
            dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
        }]
        });
        chart.render();
    }

    }
    

</script>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


<?php
require_once ('../view/pie4.php');
?>