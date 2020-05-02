<?php
require_once ('../view/cabecera.php');
require_once ('../model/UsuarioClass.php');
require_once ('../model/RubroClass.php');
require_once ('../model/ArticuloClass.php');
//Usuario::verificarSesion(3);//3 es todo lo q sea articulos

if(isset($_POST['agregarArticulo']))
{
  $articulo = new Articulo();
  $articulo->nombre = $_POST['nombre'];
  $articulo->descripcion = $_POST['descripcion'];
  $articulo->precioVenta = $_POST['precioVenta'];
  $articulo->costoUnitario = $_POST['costoUnitario'];
  if($_POST['estado'] == 'on')
  {
    $articulo->estado = 1;
  }
  else
  {
    $articulo->estado = 0;
  }
  $articulo->stock = $_POST['stock'];
  $articulo->stockminimo = $_POST['stockMinimo'];
  $articulo->Rubro = $_POST['rubro'];
  $articulo->insertArticulo();
}

?>

  <br><br><br><h3 class="text-center mt-3">Nuevo articulo</h3>

<div class="container-fluid">
  <form method="POST" accion="">    

    <div class="row justify-content-center">
      <div class="form-group col-md-4">
        <label for="nombreArticulo">Nombre</label>
        <input type="text" class="form-control" name="nombre" placeholder="Nombre del articulo">
      </div>
      <div class="form-group col-md-4">
        <label for="descripcionArticulo">Descripcion</label>
        <input type="text" class="form-control" name="descripcion" placeholder="Descripción del articulo">
      </div>
    </div>      

    <div class="row justify-content-center">
      <div class="form-group col-md-4">
        <label for="precioVenta">Precio de venta</label>
        <input type="text" class="form-control" name="precioVenta" placeholder="Precio del articulo">
    
      </div>

      <div class="form-group col-md-4">
          <label for="costoUnitario">Costo unitario</label>
          <input type="text" class="form-control" name="costoUnitario" placeholder="Costo unitario del articulo">     
      </div>
    </div>  

    <div class="row justify-content-center">          
      <div class="form-group col-md-4">
        <label for="stock">Stock</label>
        <input type="text" class="form-control" name="stock" placeholder="Stock del articulo">
      </div>
      
      <div class="form-group col-md-4">
        <label for="stockMinimo">Stock Minimo</label>
        <input type="text" class="form-control" name="stockMinimo" placeholder="Stock minimo del articulo">
      </div>   
    </div>

    <div class="row justify-content-center">       
      <div class="form-group col-md-4">
        Rubro
        <select name="rubro" class="form-control">
          <?php 
            foreach(Rubro::selectAllRubro() as $row)
            {
              echo "<option value='$row[idrubro]'>$row[nombre]</option>";
            } 
          ?>    

        </select>
      </div>
       <div class="form-group col-md-4">     
          <label for="estadoArticulo">Habilitado
          <input type="checkbox" class="form-control" name="estado" checked>    
          </label>   
       </div>
    </div>    

    <div class="col-md-4 offset-md-2 ">
      <button type="submit" class="btn btn-primary" name="agregarArticulo">Agregar articulo</button>
      <br><br><a href="../view/menuArticulos_view.php">Menu de Articulos</a>    
    </div>

  </form>
</div>
<?php require_once ('../view/pie.php') ?>
