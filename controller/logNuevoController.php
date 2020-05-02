<?php
session_start();
require_once ('../model/UsuarioClass.php');
require_once ('../model/EmpleadoClass.php');

$emp = new Empleado();
$sesion = new Usuario();
$existe = false;
$nombre = "";


if(isset($_POST['buscarEmpleado']))
{    
    $emp->cuil = $_POST['buscarcuil'];
    $datos = $emp->selectCuilEmpleado();

    if($datos == false)
    {
        $sesioncreada = $sesion->sesionConsulta($emp->idEmpleado);
        if($sesioncreada == false)
        {
            $_SESSION['idempleado'] = $emp->idEmpleado;
            $nombre = "Nombre : ".$emp->nombre.", ".$emp->apellido;
            $existe = true;
        }
        else
        {
            echo "<script> alert('El empleado ya tiene una cuenta creada'); </script>";
        }
        
    }
    else
    {
        echo "<script> alert('El empleado no existe'); </script>";
    }

}

if(isset($_POST['guardar']))
{
    $sesion->usuario = $_POST['usuario'];
    $sesion->password = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $sesion->estado = 'Activo';
    $sesion->empleado = $_SESSION['idempleado'];
    if($sesion->insertUsuario())
    {
        echo "<script> alert('Cuenta Creada Satisfactoriamente'); </script>"; 
        echo "<script> window.location.href='../index.php'; </script>";
    }
    else
    {
        echo "<script>alert('Error al crear la cuenta'); </script>";
    }
}


require_once ('../view/logNuevo_view.php');
?>