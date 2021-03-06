<?php
require_once ('../model/UsuarioClass.php');
require_once ('../view/cabecera.php');
require_once ('../model/ProveedorClass.php');
Usuario::verificarSesion(23);

if(isset($_POST['agregarProveedor']))
{ 
  $proveedor = new Proveedor();
  $proveedor->razonSocial = $_POST['razonSocial'];
  $proveedor->email = $_POST['email'];
  $proveedor->condicioniva = $_POST['condicioniva'];
  $proveedor->cuil = $_POST['cuil'];
  $proveedor->telefono = $_POST['telefono'];
  $proveedor->direccion = $_POST['direccion'];
  $proveedor->insertProveedor();
}

?>

<br><br><br><h3 class="text-center">Nuevo Proveedor</h3>
<form method="POST" accion="">
  <div class="container-fluid mt-4">
      
          <div class="row justify-content-center">
              <div class="form-group col-md-4">
                  <label for="razonSocial">Razon social</label>
                  <input autofocus type="text" class="form-control" name="razonSocial" placeholder="Razon Social">
              </div>
              <div class="form-group col-md-4">
                <label for="email">Condicion frente al IVA</label>
                <select name="condicioniva" class="form-control">
                  <option>RI</option>
                  <option>EX</option>
                  <option>MT</option>
                  <option>CF</option>
                </select>
              </div>
          </div>

       
          <div class="row justify-content-center">        
            <div class="form-group col-md-4">
              <label>CUIT/CUIL</label>
              <input tyme="text" class="form-control" name="cuil" placeholder="CUIL"></input>
            </div>
            <div class="form-group col-md-4">
              <label>Direccion</label>
              <input type="text" class="form-control" name="direccion" placeholder="Direccion">
            </div>
          </div>

          <div class="row justify-content-center">    
            <div class="form-group col-md-4">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Email">
            </div>
            <div class="form-group col-md-4">
              <label>Telefono</label>
              <input type="text" class="form-control" name="telefono" placeholder="Telefono">
            </div>         
          </div>         
      

      <div class="row ">
        <div class="col-md-4 offset-md-2 ">
          <button type="submit" class="btn btn-primary" name="agregarProveedor">Agregar proveedor</button>
        </div>
      </div>

  </div> 
</form>
<?php require_once ('../view/pie5.php') ?>
