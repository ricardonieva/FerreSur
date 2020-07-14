<?php
session_start();
//error_reporting(0);

require_once ('../persistence/database.php');
require_once ('../model/EmpleadoClass.php');

class Usuario{

    public $idusuario;
    public $usuario;
    public $password;
    public $estado;
    public $empleado;

    public function iniciarSesion($usuario, $contraseña)
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM usuario WHERE usuario.usuario = '$usuario' AND usuario.estado = 'Activo'";
        //var_dump($sql);
        $resultSesion = $connect->query($sql);
        if($resultSesion->rowCount() > 0)
        {            
            //agregamos los datos a los atributos de sesionclass
            $result = $resultSesion->fetchObject();           
            if(password_verify($contraseña, $result->password))
            {
                $_SESSION['usuario_id']= $result->idusuario;
                $this->idusuario = $result->idusuario;
                $this->usuario=$result->usuario;
                $this->contraseña=$result->password;
                $this->estado=$result->estado; 
                $this->empleado=$result->idEmpleado;           
                
                //consultamos en la base de datos el empleado
                $sql = "select * from empleado where idEmpleado = $this->empleado";
                $resultEmpleado = $connect->query($sql);
                $result = $resultEmpleado->fetchObject();
                $_SESSION['usuario'] = $result->apellido.", ".$result->nombre;
                $_SESSION['idempleado'] = $result->idEmpleado;
               
                return true; // el usuario y empleado existe
            }
            else
            {
                return false; // contraseña incorrecta
            }
           
        }
        else
        {
            return false; // el usuario y empleado no existe
        }

    }
    
    public function cerrarSesion(){
        if (session_destroy()) {
            header("location:../index.php");          
        } else {
            echo "Error al destruir la sesión";
        }
       
    }

    static function verificarSesion($sitio){
        if(isset($_SESSION['idempleado'])){
            $connect = Database::connectDB();
            $idsesion = $_SESSION['idempleado'];
            $sql ="SELECT * FROM empleado_has_submodulo WHERE empleado_has_submodulo.empleado_idEmpleado = $idsesion AND empleado_has_submodulo.Submodulos_idSubmodulos = $sitio";
            //var_dump($sql);
            $result = $connect->query($sql);
            if($result->rowCount() > 0)
            {
               
            }
            else
            {
                echo "<script> alert('El Empleado no tiene rol asignado'); </script>"; 
                echo "<script> window.location.href='../view/menuprincipal_view.php'; </script>";
            }
        }
        else
        {
            echo "<script> window.location.href='../controller/loginController.php'; </script>";        
        }
    }

    public function verificarSiTieneRol()
    {
        if(isset($_SESSION['idempleado']))
        {
            $connect = Database::connectDB();
            $idsesion = $_SESSION['idempleado'];
            $sql ="SELECT * FROM empleado_has_modulo where empleado_idEmpleado = $idsesion";
            //var_dump($sql);
            $result = $connect->query($sql);
            $count= $result->rowCount();
            if($count > 0){
               
            }
            else
            {
                echo "<script> alert('El Empleado no tiene rol asignado'); </script>"; 

            }
        }
        else
        {
            header("location:../index.php");    
        }

    }
    //////////////////////////////

    public function insertUsuario()
    {
        $connect = Database::connectDB();
        $sql = "INSERT INTO usuario (usuario, password, estado, idEmpleado)  
        VALUES ('$this->usuario','$this->password', '$this->estado', $this->empleado)";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false)
        {            
            return true;
        }
        else
        {
            return false;
        }
    }

    //esta funcion verifica que si el usuario ya tiene una cuenta de Usuario creada
    public function sesionConsulta($id)
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM usuario WHERE idEmpleado = $id";
        $result = $connect->query($sql);
        if($result->rowCount() > 0)
        {            
            return true;
        }
        else
        {
            return false;
        }
        
    }
   
}

?>