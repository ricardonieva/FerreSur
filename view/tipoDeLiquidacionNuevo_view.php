<?php
require_once ('../model/conceptoClass.php');
require_once ('../model/tiposDeLiquidacionClass.php');
session_start();
$concepto = new Concepto();
if(isset($_POST['botonAgregar']))
{
    $concepto->idConcepto = $_POST['selectConcepto'];
    $concepto->selectConcepto();
    $_SESSION['LISTACONCEPTOS'][] = $concepto;
}

if(isset($_POST['quitarElemento']))
{
    for($i = 0; $i < count($_SESSION['LISTACONCEPTOS']); $i++)
    {
        if($_SESSION['LISTACONCEPTOS'][$i]->idConcepto == $_POST['quitarElemento'])
        {
            unset($_SESSION['LISTACONCEPTOS'][$i]);
            $_SESSION['LISTACONCEPTOS'] = array_values($_SESSION['LISTACONCEPTOS']);
            break;
        }
    }   
}

if(isset($_POST['guadarConceptos']))
{
    $tipoLiq = new tiposDeLiquidacion();
    $tipoLiq->nombre = $_POST['txtNombre'];
    $tipoLiq->tipo = $_POST['tipo'];
    $tipoLiq->TiposDeLiquidacion_conceptos = $_SESSION['LISTACONCEPTOS'];
    $tipoLiq->insertTiposDeLiquidacion();
    unset($_SESSION['LISTACONCEPTOS']);
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
    

    <br><br><br>
    <h1 class="text-center">Nuevo tipo de Liquidacion</h1>
    <form action="" method="POST">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    Nombre:
                    <input type="text" class="form-control" name="txtNombre">
                    Tipo:
                    <select name="tipo" class="form-control">
                        <option>Sueldo</option>
                        <option>Despido</option>
                        <option>Aguinaldo</option>
                    </select>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-4">
                Conceptos
                <select name="selectConcepto" id="" class="form-control">
                        <?php
                            $datos = $concepto->cargarConceptos();
                            //var_dump($datos);
                            foreach($concepto->cargarConceptos() as $row)
                            {
                                echo  "<option value='$row[idconcepto]'>$row[detalle] - $row[idconcepto]</option>";
                            }
                        ?>
                </select>

                    <button class="btn btn-primary mt-3" type="submit" name="botonAgregar">Agregar</button>
                </div>
            </div>      
            <br>

            <?php
                if(isset($_SESSION['LISTACONCEPTOS'])){            
            ?>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Detalle</th>
                            <th scope="col">tipo Concepto</th>
                            <th scope="col">Percepcion Salarial</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                            foreach($_SESSION['LISTACONCEPTOS'] as $row)
                            {
                                echo "<tr>";
                                    echo "<td>".$row->idConcepto."</td>";
                                    echo "<td>".$row->detalle."</td>";
                                    echo "<td>".$row->tipoConcepto."</td>";
                                    echo "<td>".$row->percepcionSalarial."</td>";
                                    echo "<td><button class='btn btn-danger' type='submit' name='quitarElemento' value=".$row->idConcepto.">Quitar</button></td>";
                                echo "</tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
                }
            ?>
            
            <div class="d-flex justify-content-center">             
                <br><button class="btn btn-success" type="submit" name="guadarConceptos">Guardar</button><br>
        </div>
        
        </div>
    </form>


    <!-- boton menu empleado -->
    <div class="container eliminarImprimir evitarSalto">
    <div class="row align-items-end">
            <div class="col-sm ">            
                <br><a href="../view/tipodeliquidaciones_view.php">Lista de Tipo de Liquidacion</a>    
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