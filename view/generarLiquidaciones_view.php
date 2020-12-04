<?php
require_once ('../model/UsuarioClass.php');
Usuario::verificarSesion(15);
require_once ('../model/EmpleadoClass.php');
require_once ('../model/reciboDeHaberesClass.php');
require_once ('../view/cabecera.php');
require_once ('../model/LiquidacionClass.php');

$empleado = new Empleado();
if(isset($_POST['btnGenerarLiquidaciones'])){
    $liquidacion = new Liquidacion();
    $liquidacion->idliquidacion = $_POST['selectLiquidacion'];
    $liquidacion->selectLiquidacion();
    foreach($_POST['checkEmpleado'] as $row){
        if($empleado->verificarSiTieneDiasFichasHoras($row, $liquidacion->desde, $liquidacion->hasta) != false){
            $RH = new ReciboDeHaberes();
            $RH->eliminarRecibosRepetidos($_POST['selectLiquidacion'], $row);
            $RH->calcularRecibo_Concepto($_POST['selectLiquidacion'], $row);
        }        
    }
    echo "<script>alert('Se generaron las respectivas liquidaciones Satisfactoriamente')</script>";
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

<form action="" method="POST" name="form1">
    <h3 class="text-center mt-3">Generar Liquidacion</h3>
        <div class="container-fluid eliminarImprimir mt-3">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    Codigo:
                    <select name="selectLiquidacion" class="form-control">
                        <?php                            
                            foreach(Liquidacion::selectAllLiquidacion() as $row)
                            {
                                if($row["cerrado"] == 0){
                                    echo "<option value='$row[idliquidacion]'> $row[nombre]</option>";
                                }
                            }
                        ?>   
                    </select>
                    <div class="table-responsive">      
                        <table class="table mt-3 table-hover table-dark">
                            <thead>
                                <tr>
                                    <th>CUIL</th>
                                    <th>Apellido</th>
                                    <th>Nombre</th>
                                    <th>Seleccionar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach($empleado->allSelectEmpleados() as $row)
                                    {
                                        echo "<tr>";
                                            echo "<td>$row[cuil]</td>";
                                            echo "<td>$row[apellido]</td>";
                                            echo "<td>$row[nombre]</td>";
                                            echo "<td><input type='checkbox' name='checkEmpleado[]' value='$row[idEmpleado]'></td>";
                                        echo "</tr>";
                                    }                                
                                ?>                                
                            </tbody>
                        </table>
                    </div>
                    <div class="container-fluid mt-3">
                        <div class="row justify-content-center">
                            <div class="col-md-3">
                                <button class="btn btn-info" name="btnGenerarLiquidaciones" type="submit">Generar Liquidaciones</button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-info" id="btnMarcar" onclick="seleccionar_todo(event)">Marcar Todos</button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-info" id="btnDesmarcar" onclick="deseleccionar_todo(event)">Desarcar Todos</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
</form>    


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

<script type="text/javascript">
    function seleccionar_todo(evt){
        evt.preventDefault();
        for (i=0;i<document.form1.elements.length;i++){
            if(document.form1.elements[i].type == "checkbox"){
                document.form1.elements[i].checked=1;
            }
        }
    }

    function deseleccionar_todo(evt){
        evt.preventDefault();
        for (i=0;i<document.form1.elements.length;i++){
            if(document.form1.elements[i].type == "checkbox"){
                document.form1.elements[i].checked=0;
            }
        }
    }
</script>