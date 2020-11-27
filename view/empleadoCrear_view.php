<?php
require_once ('../model/UsuarioClass.php');
require_once ('../model/EmpleadoClass.php');
require_once ('../model/categoriaClass.php');
Usuario::verificarSesion(34);
$categoria = new Categoria();

if(isset($_POST['btnAgregarEmpleado']))
{
    $empleado = new Empleado();
    $empleado->nombre = $_POST['nombre'];
    $empleado->apellido = $_POST['apellido'];
    $empleado->cuil = $_POST['cuil'];
    $empleado->fechanac = $_POST['fechaNac'];
    $empleado->fechaingreso = $_POST['fechaingreso'];
    $empleado->telefono = $_POST['telefono'];
    $empleado->cuentaBancaria = $_POST['ctaBancaria'];
    $empleado->categoria = $_POST['categoria'];
    if($empleado->insertEmpleado())
    {
      echo "<script> alert('Se cargo empleado satisfactoriamente') </script>";
    }
}

 ?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <title>Nuevo Empleado</title>
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
<br>
 <div align="center">
     <br><br><br><h3 class="mt-3">Nuevo Empleado</h3>
 </div>

<form method="POST" accion="">

 <div class="container">
     <div class="row justify-content-center">
        <div class="form-group col-md-4">
          <label for="nombre">Nombre</label>
          <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre del Empleado">
        </div>
        <div class="form-group col-md-4">
          <label for="apellido">Apellido</label>
          <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Apellido del Empleado">
        </div>
     </div>

     <div class="row justify-content-center">
       <div class="form-group col-md-4">
        <label for="cuil">Cuil del empleado</label>
        <input type="text" class="form-control" name="cuil" id="cuil" placeholder="cuil">
       </div>
       <div class="form-group col-md-4">
        <label for="fechaNac">Fecha de nacimiento</label>
        <input type="date" class="form-control" name="fechaNac" id="fechaNac" placeholder="Fecha de nacimiento">
       </div>
     </div>

     <div class="row justify-content-center">
       <div class="form-group col-md-4">
         <label for="fechaingreso">Fecha de Ingreso</label>
         <input type="date" class="form-control" name="fechaingreso"id="fechaingreso" placeholder="Fecha de ingreso">
       </div>
       <div class="form-group col-md-4">
         <label for="margen">Id categoria</label>
         <select name="categoria" class="form-control">
            <?php
              foreach($categoria->buscarTodasLasCategoria() as $row)
              {
                echo "<option value='$row[idCategoria]'>$row[Tipo] - $ $row[sueldoBasico]</option>";
              }
            ?>
         </select>
       </div>
     </div>

    <div class="row justify-content-center">
      <div class="form-group col-md-4">
        <label for="direccion">Telefono</label>
        <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Telefono">
      </div>
      <div class="form-group col-md-4">
        <label for="direccion">cuenta Bancaria</label>
        <input type="text" class="form-control" name="ctaBancaria" placeholder="Cuenta Bancaria">
      </div>     
    </div>  
     <div class="col-md-4 offset-md-2 ">
       <button type="submit" class="btn btn-primary" name="btnAgregarEmpleado">Agregar empleado</button>
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
<style>
  body {
      background: rgb(38, 130, 181);
      background: linear-gradient(90deg, rgba(38, 130, 181, 0.5102240725391719) 0%, rgba(179, 153, 153, 1) 100%);
      

    }
</style>
</html>
