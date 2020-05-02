<?php
require_once ('../persistence/database.php');

class subModulos
{
    public $idSubModulos;
    public $nombre;
    public $descripcion;

    public static function selectSubModulosWithModulos()
    {
        $connect = Database::connectDB();
        $sql = "SELECT *,submodulos.nombre as submodulonombre, modulo.nombre as modulonombre FROM submodulos, modulo 
        WHERE submodulos.modulo_idmodulo = modulo.idmodulo";
        //var_dump($sql);
        $result = $connect->query($sql);
        if(!$result){
            echo "\nPDO::errorInfo():\n";
            print_r($connect->errorInfo());
            return false;
        }else{
            return $result->fetchAll();
        }
    }

    public static function insertEmpleado_has_Submodulo($listaDePermisos, $idEmpleado)
    {
        $connect = Database::connectDB();
        foreach($listaDePermisos as $row)
        {
            $sql = "SELECT * FROM empleado_has_submodulo WHERE empleado_idEmpleado =$idEmpleado AND Submodulos_idSubmodulos = $row[0]";
            $result = $connect->query($sql);
            if($result->rowCount() > 0)
            {

            }
            else
            {
                $sql = "INSERT INTO empleado_has_submodulo(empleado_idEmpleado, Submodulos_idSubmodulos) VALUES ($idEmpleado, $row[0])";
                $result = $connect->query($sql);
            }
        }      
        
        $sql = "SELECT * FROM empleado_has_submodulo WHERE empleado_idEmpleado = $idEmpleado";
        $result = $connect->query($sql);
        if($result->rowCount() > 0)
        {
            foreach($result->fetchAll() as $row)
            {
                $PermisoExiste = false;
                foreach($listaDePermisos as $row2)
                {                    
                    if($row['Submodulos_idSubmodulos'] == $row2[0])
                    {
                        $PermisoExiste = true;
                    }
                }
                if($PermisoExiste == false)
                {
                    $sql = "DELETE FROM empleado_has_submodulo WHERE idempleado_has_submodulo = $row[idempleado_has_submodulo]";
                    $connect->query($sql);
                }
            }            
        }
    }

    public static function selectAllPermisosDeEmpleado($idEmpleado)
    {
        $connect = Database::connectDB();
        $sql = "SELECT *,submodulos.nombre as submodulonombre, modulo.nombre as modulonombre FROM submodulos,modulo, empleado_has_submodulo 
        WHERE submodulos.modulo_idmodulo = modulo.idmodulo AND submodulos.idSubmodulos = empleado_has_submodulo.Submodulos_idSubmodulos 
        AND empleado_has_submodulo.empleado_idEmpleado = $idEmpleado";
        //var_dump($sql);
        $result = $connect->query($sql);
        if(!$result){
            echo "\nPDO::errorInfo():\n";
            print_r($connect->errorInfo());
            return false;
        }else{
            return $result->fetchAll();
        }
    }
}
?>