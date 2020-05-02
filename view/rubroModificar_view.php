<?php
require_once ('../view/cabecera.php');
require_once ('../model/RubroClass.php');

$rubro = new Rubro();
$rubro->idrubro = (int)$_GET['idrubro'];
$rubro->selectRubro();

if(isset($_POST['btnModificarRubro']))
{
  $rubro->nombre = $_POST['nombre'];
  $rubro->descripcion = $_POST['descripcion'];
  $rubro->updateRubro();
}

?>

<div align="center">
    <br><br><h3 class="mt-5">Modificar Rubro</h3>
</div>

<form action="" method="POST">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-5">   
        Nombre
        <input class="form-control" type="text" placeholder="Nombre" name="nombre" value="<?php echo $rubro->nombre; ?>">
        Descripcion
        <input class="form-control" type="text" placeholder="Descripcion" name="descripcion" value="<?php echo $rubro->descripcion; ?>">
        <button class="btn btn-primary mt-3" type="submit" name="btnModificarRubro">Guardar Cambios</button>

      </div>  
    </div>
  </div>
</form>

<?php
require_once ('../view/pie2.php');
?>



