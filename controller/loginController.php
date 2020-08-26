<?php
require_once ('../model/UsuarioClass.php');

$error = "";
//boton login
if(isset($_POST['login']))
{
    $sesion = new Usuario();
    $existe=$sesion->iniciarSesion($_POST['usuario'], $_POST['contraseña']);
    
    if($existe == true)
    {
        echo "<script> window.location.href='../view/menuPrincipal_view.php'; </script>";
    }
    else
    {
        $error = "Usuario o contraseña incorrectos";
    }

}

require ('../view/log_view.php');        
?>