<?php
require_once ('../persistence/database.php');
require_once ('../model/categoriaClass.php');
require_once ('../model/grupoFamiliarClass.php');
require_once ('../model/fichaClass.php');
require_once ('../model/asistenciaClass.php');

class Empleado{

    public $idEmpleado;
    public $nombre;
    public $apellido;
    public $cuil;
    public $fechanac;
    public $fechaingreso;
    public $telefono;
    public $cuentaBancaria;
    public $categoria;

    public $grupoFamiliar = array();

    public $listaFichas = array();

    public function cantidadDeHorasTrabajadas($desde, $hasta)
    {
        $totalHorasTranajadas = 0;
        foreach(Asistencia::asistenciaDeEmpleadoPorPeriodo($desde, $hasta, $this->idEmpleado) as $row)
        {
            $date1 = new DateTime($row["entrada"]);
            $date2 = new DateTime($row["salida"]);
            $diff = $date1->diff($date2);
            $totalHorasTranajadas = $totalHorasTranajadas + $diff->h;
        }
        return $totalHorasTranajadas;
    }

    public function selectAllFichas($desde, $hasta){

        $connect = Database::connectDB();
        $sql = "SELECT * FROM ficha WHERE ficha.empleado_idEmpleado = $this->idEmpleado AND ficha.fecha BETWEEN '$desde' AND '$hasta'";
        $result = $connect->query($sql);
        if (!$result) {
           echo "\nPDO::errorInfo():\n";
           print_r($connect->errorInfo());
       }
       else
       {
           foreach($result->fetchAll() as $row)
           {
               $ficha = new ficha();
               $ficha->idficha = $row["idficha"];
               $ficha->cantidad = $row["cantidad"];
               $ficha->fecha = $row["cantidad"];

               $this->listaFichas[] = $ficha;
           }
       }
    }

    public function calcularAntiguedadDelEmpleado()
    {
        $date1 = new DateTime($this->fechaingreso);
        $date2 = new DateTime('NOW');
        $diff = $date1->diff($date2);
        //var_dump($diff);
        return $diff->y;
    }

    public function selectFamiliares(){

        $connect = Database::connectDB();
        $sql = "SELECT * FROM grupofamiliar WHERE empleado_idEmpleado = $this->idEmpleado";
        $result = $connect->query($sql);
        if (!$result) {
           echo "\nPDO::errorInfo():\n";
           print_r($connect->errorInfo());
       }
       else
       {
           foreach($result->fetchAll() as $row)
           {
                $GF = new GrupoFamiliar();
                $GF->idgrupofamiliar = $row["idgrupofamiliar"];
                $GF->apellido = $row["apellido"];
                $GF->nombre = $row["nombre"];
                $GF->dni  = $row["dni"];
                $GF->parentesco = $row["parentesco"];
                $GF->fechanacimiento = $row["fechanacimiento"];
                $GF->empleado_idEmpleado  = $row["empleado_idEmpleado"];
                $GF->discapacidad = $row["discapacidad"];
                $GF->estudio = $row["estudio"];
                $GF->nivel = $row["nivel"];

                $this->grupoFamiliar[] = $GF;
           }
       }
    }

    public function datosDeFamiliares()
    {
        $this->selectFamiliares();
        $hijos = 0;
        $hijosConDiscapacidad = 0;
        $hijosPrimario = 0;
        $hijosSecundario = 0;
        $hijosUniversitario = 0;
        foreach($this->grupoFamiliar as $row)
        {
            if($row->parentesco == "Hijo")
            {
                $date1 = new DateTime( $row->fechanacimiento);
                $date2 = new DateTime('NOW');
                $diff = $date1->diff($date2);                
                if($diff->y < 22)
                {
                    $hijos = $hijos +1;
                }
                if($row->discapacidad == 1)
                {
                    $hijosConDiscapacidad = $hijosConDiscapacidad +1;
                }
                if($row->nivel == "Primario")
                {
                    $hijosPrimario = $hijosPrimario +1;
                }
                if($row->nivel == "Secundario")
                {
                    $hijosSecundario = $hijosSecundario +1;
                }
                if($row->nivel == "Universidad")
                {
                    $hijosUniversitario = $hijosUniversitario +1;
                }
            }
        }
        $datos = array("hijos" => $hijos, "hijosConDiscapacidad" => $hijosConDiscapacidad, "hijosPrimario" => $hijosPrimario,
        "hijosSecundario" => $hijosSecundario, "hijosUniversitario" => $hijosUniversitario);
        return $datos;
    }
   
    public function selectEmpleado()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM empleado WHERE empleado.idEmpleado = $this->idEmpleado";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false){
            $count = $result->rowCount();
            if($count > 0){
                $datosEmp = $result->fetchObject();
                $this->nombre = $datosEmp->nombre;
                $this->apellido = $datosEmp->apellido;
                $this->cuil  = $datosEmp->cuil ;
                $this->fechanac = $datosEmp->fechanac;
                $this->fechaingreso = $datosEmp->fechaingreso;
                $this->telefono = $datosEmp->telefono;
                $this->cuentaBancaria = $datosEmp->cuentaBancaria;
                $categoria = new Categoria();
                $categoria->idCategoria = $datosEmp->Categoria_idCategoria;
                $categoria->selectCategoria();
                $this->categoria=$categoria;
            }else{
                return false;        
            }
        }
        else{
            return false;
        }
    }

    public function selectCuilEmpleado()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM empleado WHERE empleado.cuil = $this->cuil";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false){
            $count = $result->rowCount();
            if($count > 0){
                $datosEmp = $result->fetchObject();
                $this->idEmpleado = $datosEmp->idEmpleado;
                $this->nombre = $datosEmp->nombre;
                $this->apellido = $datosEmp->apellido;
                $this->cuil  = $datosEmp->cuil ;
                $this->fechanac = $datosEmp->fechanac;
                $this->fechaingreso = $datosEmp->fechaingreso;
                $this->telefono = $datosEmp->telefono;
                $this->cuentaBancaria = $datosEmp->cuentaBancaria;
                $this->categoria = $datosEmp->Categoria_idCategoria;              
            }else{
                return false;        
            }
        }
        else{
            return false;
        }
    }

    public function AsistenciaMensual($desde, $hasta)
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM calendarioasistencia WHERE calendarioasistencia.empleado_idEmpleado = $this->idEmpleado 
        AND calendarioasistencia.fecha BETWEEN '$desde' AND '$hasta' ORDER BY calendarioasistencia.fecha DESC";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false){
            $count = $result->rowCount();
            $diasTrabajadosHabiles = 0;
            $diasTrabajadosFeriados = 0;
            if($count > 0){
                foreach($result->fetchAll() as $row)
                {
                    //var_dump($row);
                    if($row["habil"] == 1)
                    {
                        $diasTrabajadosHabiles = $diasTrabajadosHabiles + 1;
                    }
                    else
                    {
                        $diasTrabajadosFeriados = $diasTrabajadosFeriados + 1; 
                    }
                }
                $asistencia = array("diasTrabajadosHabiles" => $diasTrabajadosHabiles, "diasTrabajadosFeriados" => $diasTrabajadosFeriados);
                return $asistencia;
            }else{
                return false;        
            }
        }
        else{
            return false;
        }
    }

    public function allSelectEmpleados()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM empleado";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false){
            $count = $result->rowCount();
            if($count > 0){
            return $result->fetchAll();
            }else{
                return false;        
            }
        }
        else{
            return false;
        }
    }

    public function insertEmpleado(){
        $connect = Database::connectDB();
        $sql = "INSERT INTO empleado(nombre, apellido, cuil, fechanac, fechaingreso, telefono, cuentaBancaria, Categoria_idCategoria) 
        VALUES ('$this->nombre','$this->apellido', '$this->cuil', '$this->fechanac', '$this->fechaingreso', $this->telefono, '$this->cuentaBancaria','$this->categoria')";
        //var_dump($sql);
        $result = $connect->query($sql);
        if(!$result){
            echo "\nPDO::errorInfo():\n";
            print_r($connect->errorInfo());
            return false;
        }else{
            return true;
        }
    }
   

    public function updateEmpleado(){
        $connect = Database::connectDB();
        $sql = "UPDATE empleado SET nombre= '$this->nombre', apellido = '$this->apellido', cuil = '$this->cuil', fechanac= '$this->fechanac', fechaingreso='$this->fechaingreso', cuentaBancaria='$this->cuentaBancaria' ,Categoria_idCategoria=$this->categoria WHERE idEmpleado = $this->idEmpleado";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false){
            echo "<script> alert('se cargo los datos correctamente'); </script>";
        }else{
            echo "<script> alert('error al cargar los datos'); </script>";
        }
    }

    public function deleteEmpleado(){
        $connect = Database::connectDB();
        $sql =" DELETE FROM empleado WHERE idEmpleado = $this->idEmpleado";
        //var_dump($sql);
        $result = $connect->query($sql);
        if($result != false){
            echo "<script> alert('se elimino los datos correctamente'); </script>";
        }else{
            echo "<script> alert('error al eliminar'); </script>";
        }
    }

    
}
?>