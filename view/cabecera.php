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
    @media print {
      .eliminarImprimir {
        display: none;
      }
    }

    .eventText {
      font-size: x-large;
    }
  </style>
  <style>
    body {
      background: rgb(38, 130, 181);
      background: linear-gradient(90deg, rgba(38, 130, 181, 0.5102240725391719) 0%, rgba(179, 153, 153, 1) 100%);
      

    }

    .lista {
      list-style: none;

    }

    .lista .box {
      line-height: 20px;
      text-align: center;

    }

    .imagen {
        height: 25px;
        margin-right: 5px;
    }
    .box {
      padding: 10px;
      right: 12px;
      border: none;
      background: white;
      margin-bottom: 2%;
      width: 100%;
      position: relative;
      -webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
      -moz-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
      font-weight: 300;
      font-size: 20px;

    }

    .box:hover {
      background: linear-gradient(90deg, #0162c8, #55e7fc);
      -webkit-box-shadow: -4px 3px 77px 13px rgba(255, 255, 255, 1);
      -moz-box-shadow: -4px 3px 77px 13px rgba(255, 255, 255, 1);
      box-shadow: -4px 3px 77px 13px rgba(255, 255, 255, 1);
      color: white;
    }
  </style>
  <style>
    th {
      color: #81b214;
    }

    tr {
      text-align: center;
    }
  </style>

</head>

<body>
  <header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active"><a href="../view/menuPrincipal_view.php" class="navbar-brand">Ferre-Sur </a></li>
          <li class="nav-item active">
            <p class="navbar-brand">| <?php echo $_SESSION['usuario']; ?> </p>
          </li>
        </ul>

        <a class="btn btn-primary" href="../controller/cerrarSesionController.php">Cerrar Sesion</a>
      </div>
    </nav>
  </header>