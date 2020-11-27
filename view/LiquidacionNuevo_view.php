<?php
require_once ('../model/UsuarioClass.php');
require_once ('../view/cabecera.php');
require_once ('../model/LiquidacionClass.php');
require_once ('../model/tiposDeLiquidacionClass.php');
Usuario::verificarSesion(38);

if(isset($_POST['btnGenerar']))
{
    $liq = new Liquidacion();
    $liq->nombre = $_POST['txtNombre'];
    $liq->desde = $_POST['txtDesde'];
    $liq->hasta = $_POST['txtHasta'];
    $liq->banco = $_POST['selectBanco'];
    $liq->fechaDePago = $_POST['txtFechaDePago'];
    $liq->TipoDeLiquidacion = $_POST['selectTipoDeLiquidacion'];
    $liq->insertLiquidacion();
}

?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <title>Tipo de Liquidacion</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../view/images/logo.ico">

    <!-- Bootstrap CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link href="../library/bootstrap.css" rel="stylesheet">
    <link href="../library/sticky-footer-navbar.css" rel="stylesheet">
    <!-- <script src="../library/bootstrap.js" type="text/javascript"></script> -->

    <!-- <script type="text/javascript" src="../library/misFunciones.js"></script> -->

    <style>
      .logo {
          width: 150px;
          height: 100px;
      }
    </style>
        
    <style type="text/css" media="print">
    
    .eliminarImprimir {
        display: none;
    }
    
    </style>

  </head>
  <body>
  <header>

<br>

<form action="" method="POST">
    <h3 class="text-center mt-5">Crear Liquidacion</h3>
        <div class="container-fluid eliminarImprimir mt-5">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    Nombre
                    <input type="text" class="form-control" name="txtNombre">
                    Desde
                    <input type="date" class="form-control" name="txtDesde">
                    Hasta
                    <input type="date" class="form-control" name="txtHasta">
                    Banco
                    <select class="form-control" name="selectBanco">
                        <option>Macro</option>
                        <option>Santander</option>
                        <option>Banco Nacion</option>
                        <option>Macro</option>
                        <option>BBVA</option>
                    </select>
                    Fecha de Pago
                    <input type="date" class="form-control" name="txtFechaDePago">
                    Selecciones Tipo de Liquidacion
                    <select class="form-control" name="selectTipoDeLiquidacion">
                        <?php
                            $tiposDeLiq = new tiposDeLiquidacion();
                            $datos = $tiposDeLiq->SelectAllTiposLiq();
                            foreach($datos as $row)
                            {
                                echo "<option value='$row[idTiposDeLiquidacion]'>$row[Nombre]</option>";
                            }
                        ?>
                    </select>

                    <button class="btn btn-success mt-3" name="btnGenerar" type="submit">Generar Liquidacion</button>

                </div>
            </div>

        </div>
</form>    


 <!-- boton menu empleado -->
 <div class="container eliminarImprimir evitarSalto">
    <div class="row align-items-end">
            <div class="col-sm ">            
                <br><a href="../view/liquidaciones_view.php">Lista de Liquidaciones de Sueldo</a>    
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

<script type="text/javascript" src="../library/liquidacion.js"></script>