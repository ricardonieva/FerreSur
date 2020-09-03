<?php
require_once ('../model/UsuarioClass.php');
require_once ('../view/cabecera.php');
require_once ('../model/EmpleadoClass.php');
require_once ('../model/subModulosClass.php');
Usuario::verificarSesion(2);


if(isset($_POST['btnBuscarEmpleado']))
{   
    unset($_SESSION['listaSubmodulos']);
    unset($_SESSION['objetoEmpleado']);
    $empleado = new Empleado();
    $empleado->cuil = $_POST['buscarcuil'];
    $empleado->selectCuilEmpleado();
    $_SESSION['objetoEmpleado'] = array($empleado->idEmpleado,$empleado->nombre,$empleado->apellido);

    foreach(subModulos::selectAllPermisosDeEmpleado($empleado->idEmpleado) as $row)
    {
        $_SESSION['listaSubmodulos'][] = array($row['idSubmodulos'], $row['submodulonombre'], $row['modulonombre']);
    }
}

if(isset($_POST['btnAgregar']))
{   
    foreach($_POST['listaModulos'] as $row)
    {
        $listaModulos[] = explode(",",$row);
    }

    for($i=0; $i < count($listaModulos); $i++)
    {
        $RolRepetido = false;
        for($j = 0; $j < count($_SESSION['listaSubmodulos']); $j++)
        {
            if($listaModulos[$i][0] == $_SESSION['listaSubmodulos'][$j][0])
            {              
                $RolRepetido = true; 
                break;
            }
        }
        
        if($RolRepetido == false)
        {
            $_SESSION['listaSubmodulos'][] = $listaModulos[$i];
        }
    }
}

if(isset($_POST['btnQuitar']))
{       
    for($i=0; $i < count($_SESSION['listaSubmodulos']); $i++)
    {
        if($_SESSION['listaSubmodulos'][$i][0] == $_POST['btnQuitar'])
        {
            unset($_SESSION['listaSubmodulos'][$i]);
            $_SESSION['listaSubmodulos'] = array_values($_SESSION['listaSubmodulos']);            
            break;
        }
    }
}

if(isset($_POST['btnGuardarCambios']))
{  
    if(isset($_SESSION['listaSubmodulos']) && isset($_SESSION['objetoEmpleado']))
    {
        subModulos::insertEmpleado_has_Submodulo($_SESSION['listaSubmodulos'], $_SESSION['objetoEmpleado'][0]);
        unset($_SESSION['listaSubmodulos']);
        unset($_SESSION['objetoEmpleado']);
        echo "<script> alert('Se Guardaron los Cambios Satisfactoriamente')</script>";
        echo "<script> window.location.href='../view/menuEmpleados_view.php'; </script>";    
    }   
}


?>

<div align="center" class="container">
     <h3 class="mt-5">Asignar Permisos al Empleado</h3>
</div>

<form method="POST" accion="">

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="input-group col-md-4 mt-3">
                <input autofocus type="text" class="form-control" name="buscarcuil" placeholder="CUIL">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="btnBuscarEmpleado">Buscar Empleado</button>
                </div>
            </div>

        </div>
        <hr class="my-3">

        <div class="row justify-content-center">
            <div class="col-md-4" id="datosEmpleado">
                <?php
                    if(isset($_SESSION['objetoEmpleado']))
                    {                    
                ?>
                <p class="text-primary">Nombre: <?php echo $_SESSION['objetoEmpleado'][1]." ".$_SESSION['objetoEmpleado'][2]; ?></p>
                <?php
                    }
                ?>                         
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
               <table class="table" id="tablaRoles">
                   <thead class="table-dark">
                       <tr>
                           <th>Codigo</th>
                           <th>SubModulo</th>
                           <th>Modulo</th>
                           <th>Agregar</th>
                       </tr>
                   </thead>
                   <tbody>
                       <?php
                            foreach(subModulos::selectSubModulosWithModulos() as $row)
                            {
                                echo "<tr>";
                                    echo "<td>$row[idSubmodulos]</td>";
                                    echo "<td>$row[submodulonombre]</td>";
                                    echo "<td>$row[modulonombre]</td>";
                                    echo "<td><input type='checkbox' name='listaModulos[]' value='$row[idSubmodulos],$row[submodulonombre],$row[modulonombre]'></td>";
                                echo "</tr>"; 
                            }
                       ?>
                       
                   </tbody>
               </table>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <button class="btn btn-success" name="btnAgregar">Agregar Conceptos</button>
        </div>

        <h5 class="text-center mt-5">Permisos del Empleado</h5>

        <div class="row justify-content-center mt-3">
            <div class="col-md-6">
                <table class="table " id="tablaRolesEmpleado">
                    <thead class="table-dark">
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($_SESSION['listaSubmodulos']))
                        {
                            foreach($_SESSION['listaSubmodulos'] as $row)
                            {
                                echo "<tr>";
                                    echo "<td>$row[0]</td>";
                                    echo "<td>$row[1]</td>";
                                    echo "<td>$row[2]</td>";
                                    echo "<td><button type='submit' name='btnQuitar' class='btn btn-danger' value='$row[0]'>Quitar</button></td>";
                                echo "</tr>"; 
                            }
                        }
                            
                       ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <button class="btn btn-primary" name="btnGuardarCambios">Guardar Cambios</button>
        </div>
    </div>
</form>



<?php
include_once ('../view/pie3.php');
?>
<script>
    $('#tablaRoles').DataTable();
    $('#tablaRolesEmpleado').DataTable();    
</script>