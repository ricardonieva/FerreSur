<?php
require_once ('../model/UsuarioClass.php');
require_once ('../model/LiquidacionClass.php');
require_once ('../model/EmpleadoClass.php');
require_once ('../model/reciboDeHaberesClass.php');
Usuario::verificarSesion(16);

$liq = new Liquidacion();
$empleado = new Empleado();

if(isset($_POST['btnEliminar']))
{
    $recibo = new ReciboDeHaberes();
    $recibo->idReciboDeHaberes = $_POST['btnEliminar'];
    $recibo->deleteReciboDeHaberes();
    unset($_POST['selectLiquidacion']);
}

?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <title>Libro unico</title>
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

    <header>
      <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item active"><a href="../view/menuPrincipal_view.php" class="navbar-brand">Ferre-Sur  </a></li>
                <li class="nav-item active"><p class="navbar-brand"> <?php echo $_SESSION['usuario']; ?> </p></li>
                </ul> 

                <a class="btn btn-primary" href="../controller/cerrarSesionController.php">Cerrar Sesion</a> 
            </div>
        </nav>
    </header>


<br><br><br>

<form action="" method="POST" id="form1">
    <h3 class="text-center mt-3">Libro Unico de Liquidación de Haberes</h3>
        <div class="container-fluid mt-5">
            <div class="row justify-content-center eliminarImprimir">
                <div class="col-md-6">
                    Codigo:
                    <select name="selectLiquidacion" class="form-control" onchange="this.form.submit()">
                        <option></option>
                        <?php                            
                            foreach($liq->selectAllLiquidacion() as $row)
                            {
                                echo "<option value='$row[idliquidacion]'> $row[nombre]</option>";             
                            }
                        ?>   
                    </select>      
                </div>
            </div>   
        </div>
</form>    
        

        <div class="container-fluid mt-5">
            <div class="row justify-content-center">
                <div class="col-md-12">
                   <?php
                        if(isset($_POST['selectLiquidacion']))
                        {
                            $liq->idliquidacion = $_POST['selectLiquidacion'];
                            $liq->selectLiquidacion();
                    ?>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                                <th>Banco</th>
                                <th>fechaDePago</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            <tr>
                                <td><?php echo $liq->idliquidacion; ?></td>
                                <td><?php echo $liq->nombre; ?></td>
                                <td><?php echo date("d/m/Y", strtotime($liq->desde)); ?></td>
                                <td><?php echo date("d/m/Y", strtotime($liq->hasta)); ?></td>
                                <td><?php echo $liq->banco; ?></td>
                                <td><?php echo date("d/m/Y", strtotime($liq->fechaDePago)); ?></td>
                                <td><?php echo $liq->TipoDeLiquidacion->nombre; ?></td>
                            </tr>
                        </tbody>
                    </table>
                       
                    <table class="table mt-5">
                        <thead>
                            <tr>                                
                                <th>Recibo</th>
                                <th>CUIL</th>
                                <th>Empelado</th>
                                <th>Fecha</th>
                                <th>Credito</th>
                                <th>Debito</th>
                                <th>Netos</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>         
                    
                    <?php        
                           
                            $liq->selectAllReciboDeHaberes();
                            $totalHaberes = 0;
                            $totalDeducciones = 0;
                            $totalNeto = 0;
                            //var_dump($liq->listaReciboDeHaberes);
                            //die();
                            foreach($liq->listaReciboDeHaberes as $row)
                            {
                                $haberes = 0;
                                $deducciones = 0;
                                $neto = 0;
                                $row->selectAllRecibo_Concepto();
                                foreach($row->listaRecibo_Concepto as $row2)
                                {
                                    if($row2->concepto->percepcionSalarial === "Haber")
                                    {
                                        $haberes = $haberes + $row2->importe;
                                    }
                                    else
                                    {
                                        $deducciones = $deducciones + $row2->importe;
                                    }
                                }
                                $haberes = $haberes /2;
                                $deducciones = $deducciones /2;
                                $neto = $haberes - $deducciones;

                                echo "<tr>";
                                    echo "<td>".$row->idReciboDeHaberes."</td>";
                                    echo "<td>".$row->empleado->cuil."</td>";
                                    echo "<td>".$row->empleado->apellido." ".$row->empleado->nombre."</td>";
                                    echo "<td>".date("d/m/Y", strtotime($row->fechaDeGeneracion))."</td>";
                                    echo "<td>".number_format($haberes, 2, ',', '.')."</td>";
                                    echo "<td>".number_format($deducciones, 2, ',', '.')."</td>";
                                    echo "<td>".number_format($neto, 2, ',', '.')."</td>";

                                    echo "<td><button class='btn btn-info eliminarImprimir' onclick='verReciboDeHaberes($row->idReciboDeHaberes);'>Ver Recibo</button></td>";
                                    echo "<td><button class='btn btn-danger eliminarImprimir' form='form1' name='btnEliminar' value='$row->idReciboDeHaberes'>Eliminar Recibo</button></td>";
                                echo "</tr>";
                               
                                // sumamos todos los total
                                $totalHaberes = $totalHaberes + $haberes;
                                $totalDeducciones = $totalDeducciones + $deducciones;
                                $totalNeto = $totalNeto + $neto;
                            }
                            
                        }
                   ?>
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><?php if(isset($totalHaberes)) { echo "Total"; } ?></td>
                                <td><?php if(isset($totalHaberes)) { echo number_format($totalHaberes, 2, ',', '.'); } ?></td>
                                <td><?php if(isset($totalDeducciones)) { echo number_format($totalDeducciones, 2, ',', '.'); } ?></td>
                                <td><?php if(isset($totalNeto)) { echo number_format($totalNeto, 2, ',', '.'); } ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>                
                </div>     

            </div>   
        </div>

    <div class="eliminarImprimir">
        <div class="d-flex justify-content-center">
                <button class="btn btn-primary" onclick="window.print();">Imprirmir</button>
        </div>     
    </div>


 <!-- boton menu empleado -->
 <div class="container eliminarImprimir evitarSalto">
    <div class="row align-items-end">
            <div class="col-sm ">            
                <br><a href="../view/menuEmpleados_view.php">Menu de Empleados</a>    
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
    function verReciboDeHaberes(idReciboDeHaberes)
    {
        window.open("../view/recibodehaberesinforme_view.php?recibodehaberesid="+idReciboDeHaberes);
    }
</script>