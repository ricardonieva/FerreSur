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
    <h3 class="text-center mt-3">Generar Liquidacion</h3>
        <div class="container-fluid mt-5">
            <div class="row justify-content-center">
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
                <div class="col-md-10">
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
                                <th>Id Recibo</th>
                                <th>CUIL</th>
                                <th>Apellido</th>
                                <th>Nombre</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>         
                    
                    <?php        
                           
                            $liq->selectAllReciboDeHaberes();
                            $total = 0;
                            foreach($liq->listaReciboDeHaberes as $row)
                            {
                                echo "<tr>";
                                    echo "<td>".$row->idReciboDeHaberes."</td>";
                                    echo "<td>".$row->empleado->cuil."</td>";
                                    echo "<td>".$row->empleado->apellido."</td>";
                                    echo "<td>".$row->empleado->nombre."</td>";
                                    echo "<td><button class='btn btn-info' onclick='verReciboDeHaberes($row->idReciboDeHaberes);'>Ver Recibo</button></td>";
                                    echo "<td><button class='btn btn-danger' form='form1' name='btnEliminar' value='$row->idReciboDeHaberes'>Eliminar Recibo</button></td>";
                                echo "</tr>";
                                $row->selectAllRecibo_Concepto();

                                //var_dump($row->listaRecibo_Concepto);
                                foreach($row->listaRecibo_Concepto as $row2)
                                {
                                    if($row2->concepto->percepcionSalarial == "Haber")
                                    {
                                        $total = $total + $row2->importe;
                                    }
                                }
                                
                            }
                        }
                   ?>
                            
                        </tbody>
                    </table>                
                </div>

            
                <div class="col-md-10">
                    <h4>Total Pagado : $ 
                        <?php 
                        if(isset($total))
                        {
                            echo number_format($total, 2, ',', '.'); 
                        }
                        ?>
                    </h4>
                </div>

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