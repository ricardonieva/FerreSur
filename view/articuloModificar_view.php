<?php
require_once ('../model/UsuarioClass.php');
require_once ('../view/cabecera.php');
require_once ('../model/RubroClass.php');
require_once ('../model/ArticuloClass.php');
Usuario::verificarSesion(31);

$articulo = new Articulo();
$articulo->idarticulo = $_GET['idArticulo'];
$articulo->selectArticulo();

if(isset($_POST['btnGuardar']))
{
  $articulo->nombre = $_POST['nombre'];
  $articulo->descripcion = $_POST['descripcion'];
  $articulo->precioVenta = $_POST['precioVenta'];
  $articulo->costoUnitario = $_POST['costoUnitario'];
  $articulo->iva = $_POST['selectIva'];
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
  $articulo->updateArticulo();
}

?>

  <br><br><br><h3 class="text-center mt-3">Modificar articulo</h3>

<div class="container-fluid">
  <form method="POST" accion="">    

    <div class="row justify-content-center">
      <div class="form-group col-md-4">
        <label for="nombreArticulo">Nombre</label>
        <input type="text" class="form-control" name="nombre" placeholder="Nombre del articulo" value="<?php echo $articulo->nombre; ?>">
      </div>
      <div class="form-group col-md-4">
        <label for="descripcionArticulo">Descripcion</label>
        <input type="text" class="form-control" name="descripcion" placeholder="Descripción del articulo" value="<?php echo $articulo->descripcion; ?>">
      </div>
    </div>      

    <div class="row justify-content-center">
      <div class="form-group col-md-4">
          <label for="costoUnitario">Costo unitario</label>
          <input type="text" class="form-control" name="costoUnitario" id="costoUnitario" placeholder="Costo unitario del articulo" value="<?php echo $articulo->costoUnitario; ?>">     
      </div>
      <div class="form-group col-md-4">
        <label for="selectIva">IVA %</label>
        <select name="selectIva" id="selectIva" class="form-control">
          <option></option>
          <option>10.5</option>
          <option>21</option>
        </select>
      </div>     
    </div>

    <div class="row justify-content-center">
      <div class="form-group col-md-4">
        <label for="precioVenta">Precio de venta</label>
        <input type="text" class="form-control" name="precioVenta" id="precioVenta" placeholder="Precio del articulo" value="<?php echo $articulo->precioVenta; ?>">
      </div>
      <div class="form-group col-md-4">
        <label for="rubro">Rubro</label>
        <select name="rubro" id="rubro" class="form-control">
          <?php 
            foreach(Rubro::selectAllRubro() as $row)
            {
              echo "<option value='$row[idrubro]'>$row[nombre]</option>";
            } 
          ?>    

        </select>
      </div>
    </div>  

    <div class="row justify-content-center">          
      <div class="form-group col-md-4">
        <label for="stock">Stock</label>
        <input type="text" class="form-control" name="stock" placeholder="Stock del articulo" value="<?php echo $articulo->stock; ?>">
      </div>
      
      <div class="form-group col-md-4">
        <label for="stockMinimo">Stock Minimo</label>
        <input type="text" class="form-control" name="stockMinimo" placeholder="Stock minimo del articulo" value="<?php echo $articulo->stockminimo; ?>">
      </div>   
    </div>

    <div class="row justify-content-center">       
       <div class="form-group col-md-4">     
          <label for="estadoArticulo">Habilitado
          <input type="checkbox" class="form-control" name="estado" checked>    
          </label>   
       </div>
       <div class="form-group col-md-4">
      </div>
    </div>    

    <div class="col-md-4 offset-md-2 ">
      <button type="submit" class="btn btn-primary" name="btnGuardar">Guardar Cambios</button>
      <br><br><a href="../view/menuArticulos_view.php">Menu de Articulos</a>    
    </div>

  </form>
</div>
<?php require_once ('../view/pie.php') ?>

<script type="text/javascript">

  selectIva.addEventListener('change', function () {
    var precioUnitario = document.getElementById('costoUnitario').value;
    var iva = document.getElementById('selectIva').value;

    var precio = precioUnitario * (1+ iva/100);
    precio = Math.round(precio * 100) / 100

    var precioVenta = document.getElementById('precioVenta').value = precio;
  });

  document.getElementById('selectIva').value = "<?php echo $articulo->iva; ?>";
  document.getElementById('rubro').value = "<?php echo $articulo->Rubro;?>";

</script>