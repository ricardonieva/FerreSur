<?php
require_once ('../view/cabecera.php');
require_once ('../model/ProveedorClass.php');
require_once ('../model/UsuarioClass.php');
//Usuario::verificarSesion(2);//2 es todo lo q sea articulos

$proveedor = new Proveedor();
$proveedor->idproveedor = $_GET['idproveedor'];
$proveedor->selectProveedor();

if(isset($_POST['btnGuaradar']))
{ 
  $proveedor->razonSocial = $_POST['razonSocial'];
  $proveedor->email = $_POST['email'];
  $proveedor->cuil = $_POST['cuil'];
  $proveedor->telefono = $_POST['telefono'];
  $proveedor->direccion = $_POST['direccion'];
  $proveedor->updateProveedor();
}

?>

<br><br><br><h3 class="text-center">Modificar Proveedor</h3>
<form method="POST" accion="">
  <div class="container-fluid mt-4">
      
          <div class="row justify-content-center">
              <div class="form-group col-md-4">
                  <label for="razonSocial">Razon social</label>
                  <input autofocus type="text" class="form-control" name="razonSocial" placeholder="Razon Social" value="<?php echo $proveedor->razonSocial; ?>">
              </div>
              <div class="form-group col-md-4">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $proveedor->email; ?>">
              </div>
          </div>

       
          <div class="row justify-content-center">        
            <div class="form-group col-md-4">
              <label>CUIL</label>
              <input tyme="text" class="form-control" name="cuil" placeholder="CUIL" value="<?php echo $proveedor->cuil; ?>">
            </div>
            <div class="form-group col-md-4">
              <label>Direccion</label>
              <input type="text" class="form-control" name="direccion" placeholder="Direccion" value="<?php echo $proveedor->direccion; ?>">
            </div>
          </div>

          <div class="row justify-content-center">    
            <div class="form-group col-md-4">
              <label>Telefono</label>
              <input type="text" class="form-control" name="telefono" placeholder="Telefono" value="<?php echo $proveedor->telefono; ?>">
            </div>
            <div class="form-group col-md-4">            
            </div>
          
          </div>         
      

      <div class="row ">
        <div class="col-md-4 offset-md-2 ">
          <button type="submit" class="btn btn-primary" name="btnGuaradar">Guardar Cambios</button>
        </div>
      </div>

  </div> 
</form>
<?php require_once ('../view/pie5.php') ?>
