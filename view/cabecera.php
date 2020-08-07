<?php
//session_start();
error_reporting(0);
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link href="../library/bootstrap.css" rel="stylesheet">
    <link href="../library/sticky-footer-navbar.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">  
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <!-- <script src="../library/bootstrap.js" type="text/javascript"></script> -->

    <!-- <script type="text/javascript" src="../library/misFunciones.js"></script> -->

    <style>
      .logo {
          width: 150px;
          height: 100px;
      }
    </style>
        
    <style type="text/css" media="print">
      @media print 
      {
      .eliminarImprimir {display:none;}	
      }	

      .eventText
      {
        font-size: x-large;
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

