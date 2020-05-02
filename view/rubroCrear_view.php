<?php
require_once ('../view/cabecera.php');
require_once ('../model/RubroClass.php');
require_once ('../model/UsuarioClass.php');
//Usuario::verificarSesion(3);
//boton crear nuevo rubro
if(isset($_POST['btnNuevoRubro']))
{
  $rubro = new Rubro();
  $rubro->nombre = $_POST['nombre'];
  $rubro->descripcion = $_POST['descripcion'];
  $rubro->insertRubro();
}

?>
<div align="center">
    <br><br><h3 class="mt-5">Nuevo Rubro</h3>
</div>

<form action="" method="POST">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      Nombre
      <input class="form-control" type="text" placeholder="Nombre" name="nombre">
      Descripcion
      <input class="form-control" type="text" placeholder="Descripcion" name="descripcion">
      <button class="btn btn-primary mt-3" type="submit" name="btnNuevoRubro">crear Rubro</button>
      <br><br><a href="../view/rubro_view.php">Menu Rubro</a>
    </div>    
  </div>
</div>
</form>

<?php
require_once ('../view/pie.php');
?>