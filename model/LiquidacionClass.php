<?php
require_once ('../persistence/database.php');
require_once ('../model/tiposDeLiquidacionClass.php');
require_once ('../model/reciboDeHaberesClass.php');
require_once ('../model/EmpleadoClass.php');
class Liquidacion
{
    public $idliquidacion;
    public $nombre;
    public $desde;
    public $hasta;
    public $banco;
    public $fechaDePago;
    public $cerrado;
    public $TipoDeLiquidacion;
    public $listaReciboDeHaberes = array();
   
    public function ultimaIdLiquidacion(){
        $connect = Database::connectDB();
        $sql = "SELECT MAX(idliquidacion) AS id FROM liquidacion";
        $result = $connect->query($sql);
        $result = $result->fetchObject();
        return $result->id;        
    }

    public function insertLiquidacion()
    {
        $connect = Database::connectDB();
        $sql = "INSERT INTO liquidacion(nombre, desde, hasta, banco, fechaDePago, TiposDeLiquidacion_idTiposDeLiquidacion) 
        VALUES ('$this->nombre', '$this->desde', '$this->hasta', '$this->banco', '$this->fechaDePago', $this->TipoDeLiquidacion)";
        $result = $connect->query($sql);
        //var_dump($sql);
        if ($result == false) {
            //echo "\nPDO::errorInfo():\n";
            $error = $connect->errorInfo();
            $error = str_replace("'","",$error[2]);
            echo "<script>alert('".$error."')</script>";
        }
        else
        {
            echo "<script>alert('Se genero la liquidacion satisfactoriamente')</script>";
        }
    }

    //usa generar liquidaciones y la lista de liquidaciones
    public static function selectAllLiquidacion()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM liquidacion, tiposdeliquidacion 
        WHERE liquidacion.TiposDeLiquidacion_idTiposDeLiquidacion = tiposdeliquidacion.idTiposDeLiquidacion order by idliquidacion DESC";
        $result = $connect->query($sql);
        if (!$result) {
            echo "\nPDO::errorInfo():\n";
            print_r($connect->errorInfo());
        }
        else
        {
           return $result->fetchAll();
        }
    }

    public function selectLiquidacion()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM liquidacion WHERE liquidacion.idliquidacion = $this->idliquidacion";
        $result = $connect->query($sql);
        if ($result == false) {
            echo "\nPDO::errorInfo():\n";
            print_r($connect->errorInfo());
        }
        else
        {   
            if($result->rowCount() > 0)
            {
                $result = $result->fetchObject();
                $this->nombre = $result->nombre;
                $this->desde = $result->desde;
                $this->hasta = $result->hasta;
                $this->banco = $result->banco;
                $this->fechaDePago = $result->fechaDePago;
                $this->cerrado = $result->cerrado;
                $tiposLiq = new tiposDeLiquidacion();
                $tiposLiq->idTiposDeLiquidacion = $result->TiposDeLiquidacion_idTiposDeLiquidacion;
                $tiposLiq->SelectTiposLiq();
                $this->TipoDeLiquidacion = $tiposLiq;
            }
        }
    }
    ////////
    public function selectAllReciboDeHaberes()
    {
        $connect = Database::connectDB();
        $sql = "SELECT * FROM recibodehaberes WHERE recibodehaberes.liquidacion_idliquidacion = $this->idliquidacion";
        $result = $connect->query($sql);
        if (!$result) {
            echo "\nPDO::errorInfo():\n";
            print_r($connect->errorInfo());
        }
        else
        {   
            foreach($result->fetchAll() as $row)
            {
                $RH = new ReciboDeHaberes();
                $RH->idReciboDeHaberes = $row["idReciboDeHaberes"];
                $RH->liquidacion = $row["liquidacion_idliquidacion"];
                $empleado = new Empleado();
                $empleado->idEmpleado = $row["empleado_idEmpleado"];
                $empleado->selectEmpleado();
                $RH->empleado = $empleado;
                $RH->categoria_tipo = $row["categoria_tipo"];
                $RH->categoria_sueldoBasico = $row["categoria_sueldoBasico"];
                $RH->categoria_formalaboral = $row["categoria_formaLaboral"];
                $RH->fechaDeGeneracion = $row["fechaDeGeneracion"];
                $RH->selectAllRecibo_Concepto();

                $this->listaReciboDeHaberes[] = $RH;
            }
        }
    }

    public function deleteLiquidacion()
    {
        $connect = Database::connectDB();
        $sql = "DELETE FROM liquidacion WHERE liquidacion.idliquidacion = $this->idliquidacion";
        $result = $connect->query($sql);
        if (!$result) {
            echo "\nPDO::errorInfo():\n";
            print_r($connect->errorInfo());
        }
        else
        {
            echo "<script>alert('Se elimino liquidacion correctamente')</script>";
        }
    }

    public function updateLiquidacion()
    {
        $connect = Database::connectDB();
        $sql = "UPDATE liquidacion SET nombre='$this->nombre',desde='$this->desde',hasta='$this->hasta',banco='$this->banco',fechaDePago='$this->fechaDePago',TiposDeLiquidacion_idTiposDeLiquidacion=$this->TipoDeLiquidacion WHERE liquidacion.idliquidacion =  $this->idliquidacion";
        $result = $connect->query($sql);
        if (!$result) {
            echo "\nPDO::errorInfo():\n";
            print_r($connect->errorInfo());
        }
        else
        {
            echo "<script>alert('Se modifico liquidacion correctamente')</script>";
            return true;
        }
    }

    public function cerrarLiquidacion(){
        $connect = Database::connectDB();
        $sql = "UPDATE liquidacion SET cerrado = 1 WHERE liquidacion.idliquidacion = $this->idliquidacion";
        $result = $connect->query($sql);
        if ($result == false) {
            echo "\nPDO::errorInfo():\n";
            print_r($connect->errorInfo());
            echo "<script>alert('Error al cerrar la liquidacion')</script>";
            return false;
        }
        else
        {
            echo "<script>alert('Se cerro liquidacion correctamente')</script>";
            return true;
        }
    }

}    
?>