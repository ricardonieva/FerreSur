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
  <body id="backgroudPrincipal">
    <header>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active"><h1 class="navbar-brand">Ferre-Sur <img src="../view/images/logo.ico" class="imgsize" alt="icono"> </h1></li>
          </ul>

          <a class="btn btn-info" href="../controller/logNuevoController.php">Crear Cuenta</a> 

        </div>
      </nav>
    </header>

    <div class="container">
  <h1 align=center class="mt-5 bg-secondary text-black">Ferre-Sur</h1>
  <hr>
  <div class="row justify-content-center align-items-center minh-100">
    <div class="col-12 col-md-6 align-self-center text-center"> 
      <!-- Contenido -->
       
           <br />  
                <div class="register">          
                <form method="post" action="../controller/loginController.php">  
                  <div class="form-group">
                      <label for="Usuario">Usuario</label>
                      <input type="text" autofocus="autofocus" name="usuario" class="in" placeholder="Ingrese usuario" autocomplete="off">  
                  </div>
    
                  <div class="form-group">
                      <label for="Contraseña">Contraseña</label>
                      <input type="password" name="contraseña" class="in" placeholder="Ingrese Contraseña" autocomplete="off">  
                  </div>
                        
                      <br />  
                      <input type="submit" name="login" class="btn btn-info" value="Iniciar Sesion" />  
                </form>  
            
            <br><p class="text-danger"> <?php if(isset($error)){echo $error;} ?> </p>
            </div>
      <!-- Fin Contenido --> 
    </div>
    
  </div>
  <!-- Fin row --> 
  
  
</div>
<!-- Fin container -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat+Subrayada:wght@700&display=swap');
body{
    
    background-image: url("https://devmagazine.co/wp-content/uploads/2018/02/herramientas-aso-app-store-optimization.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    
  }
  .minh-100 {
  height: 550px;
}

.register {
  box-shadow: 0 0 250px #000;
  text-align: center;
  padding: 4rem 2rem;
  background-color: rgba(63, 127, 191, 0.33);
}
.in{
  border: 1px solid #242c37;
  border-radius: 999px;
  background-color: #354152;
  text-align: center;
  outline: 0;
  padding: 0.5rem 1rem;
  width: 100%;
  color: #edefee;
  font-size: 20px;
  font-weight: 500;
}
h1{
  font-family:'Montserrat Subrayada', sans-serif;
  color: tomato;
  font-size: 50px;
}
label{
  font-family:'Montserrat Subrayada', sans-serif;
  color: tomato;
}
.caja{
  border: 2px dashed tomato;
  border-radius: 3em;
  padding: 50px 10px 10px 10px;
  background-color: #edefee;
  
  
}
</style>

<?php
require_once ('../view/pie.php');
?>