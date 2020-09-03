<?php
  require_once ('../view/cabecera.php');
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <title>Ferre-Sur</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../view/images/logo.ico">

    <!-- Bootstrap CSS -->
    <script type="text/javascript" charset="utf8">src="../library/jquery-3.4.0.js"</script>
    <link href="../library/bootstrap.css" rel="stylesheet">
    <link href="../library/sticky-footer-navbar.css" rel="stylesheet">
    <script type="text/javascript" charset="utf8">src="../library/bootstrap.js"</script>
    
  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active"><h1 class="navbar-brand">Ferre-Sur  </h1></li>
          </ul>

          <a class="btn btn-info" href="../controller/logNuevoController.php">Crear Cuenta</a> 

        </div>
      </nav>
    </header>

<div class="container">
  <h3 class="mt-5">Ferre-Sur</h3>
  <hr>
  <div class="row">
    <div class="col-12 col-md-6"> 
      <!-- Contenido -->
       
           <br />  
                             
                <form method="post" action="../controller/loginController.php">  
                  <div class="form-group">
                      <label for="Usuario">Usuario</label>
                      <input type="text" autofocus="autofocus" name="usuario" class="form-control" placeholder="Ingrese usuario" autocomplete="off">  
                  </div>
    
                  <div class="form-group">
                      <label for="Contraseña">Contraseña</label>
                      <input type="password" name="contraseña" class="form-control" placeholder="Ingrese Contraseña" autocomplete="off">  
                  </div>
                        
                      <br />  
                      <input type="submit" name="login" class="btn btn-info" value="Iniciar Sesion" />  
                </form>  
            
            <br><p class="text-danger"> <?php if(isset($error)){echo $error;} ?> </p>

      <!-- Fin Contenido --> 
    </div>
  </div>
  <!-- Fin row --> 
  
</div>
<!-- Fin container -->


<?php
require_once ('../view/pie.php');
?>