<!DOCTYPE html>
<html lang="es">
<head>
<title>Ferre-Sur</title>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="icon" href="../view/images/logo.ico">

<!-- Bootstrap CSS -->
<link href="../library/bootstrap.css" rel="stylesheet">
<link href="../library/sticky-footer-navbar.css" rel="stylesheet">
<script>src="../library/bootstrap.js"</script>

</head>
<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active"><h1 class="navbar-brand">Ferre-Sur  </h1></li>
            </ul>

            </div>
        </nav>
    </header>

<form action="../controller/logNuevoController.php" method="POST" id="formulario">

    <div class="container">
        <br>
        <h3 class="mt-5">Ferre-Sur</h3>
        <hr>

        <div class="row">

                <div class="input-group col-md-4">
                    <input autofocus type="text" class="form-control" name="buscarcuil" id="buscarcuil" placeholder="CUIL">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" name="buscarEmpleado" id="buscarEmpleado">Buscar Empleado</button>
                    </div>
                </div>               
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                        <p><?php echo $nombre; ?></p>
                    </div>
            </div>

        <?php
        if($existe == true)
        {
        ?>

        <div class="row">
            <div class="col-12 col-md-6">         
                <br>                                  
                
                <div class="form-group">
                    <label for="Usuario">Usuario</label>
                    <input type="text" autofocus="autofocus" name="usuario" id="usuario" class="form-control" placeholder="Ingrese usuario" autocomplete="off">  
                </div>

                <div class="form-group">
                    <label for="Contraseña">Contraseña</label>
                    <input type="password" name="contraseña" id="contraseña" class="form-control" placeholder="Ingrese Contraseña" autocomplete="off">  
                </div>

                <div class="form-group">
                    <label for="Contraseña">Repita Contraseña</label>
                    <input type="password" name="repitacontraseña" id="repitacontraseña" class="form-control" placeholder="Repita Contraseña" autocomplete="off">  
                </div>
                    
                <br />  
                <input type="submit" name="guardar" class="btn btn-info" value="Guardar" />  
                
            
                

            <!-- Fin Contenido --> 
            </div>
        </div>
           
        <?php
        }//en del if de arriba

        ?>

    <!-- Fin row --> 
    </div>
    
    <!-- Fin container -->
</form>

<?php
require_once ('../view/pie.php');
?>

<script>
formulario.addEventListener('submit', validar,false);

function validar(e){
    var usuario = document.getElementById('usuario');
    var pass = document.getElementById('contraseña');
    var repass= document.getElementById('repitacontraseña');

    if(usuario.value == "" || pass.value == "" || repass.value == ""){
        alert('Debe completar todo los campos');
        e.preventDefault();
    }
    if(pass.value != repass.value){
        alert('Las contraseñas no son iguales');
        e.preventDefault();
    }    
}

</script>