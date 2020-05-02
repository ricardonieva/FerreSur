<?php
require_once ('../view/cabecera.php');
require_once ('../model/UsuarioClass.php');
Usuario::verificarSesion(21);
?>
<form method="POST" id="formulario">
  <div align="center">

      <br><br><h3 class="mt-5">Actualizar Stock de Articulo</h3>

      <div class="input-group col-md-5">
        <input autofocus type="text" class="form-control" name="buscarId" id="buscarId" placeholder="codigo de articulo" aria-label="Buscar articulo" aria-describedby="buscarArticulo">
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="submit" name="buscarArticulo" id="buscarArticulo">Buscar por Codigo</button>
          <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModalCenter">
            Buscar por Nombre
          </button>
        </div>
      </div>

    

      <!-- Modal -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Nombre" name="nombrearticulo" id="nombrearticulo">
                <button class="btn btn-outline-secondary" id="botonBuscar" name="botonBuscar" type="submit">Buscar</button>
              </div>

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <table class="table">
                <thead>
                  <tr>
                    <th>Codigo</th>
                    <th>Nombre</th>
                  </tr>
                </thead>
                <tbody id="tabla">

                </tbody>
              </table>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Fin Modal -->
      <hr>
  </div>

  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-10" id="datosDeArticulo">
        
      </div>
    </div>
  </div>

  <div class="container-fluid" id="formularioDeStock">
    <div class="row justify-content-center">
      <div class="col-2">
        <label>Agregar Stock</label>
        <input type="number" placeholder="Cantidad" class="form-control" id="cantidadStock" name="cantidadStock">
        
      </div>
      <div class="col-8">
      <label>Agregar Descripcion (opcional)</label>
        <textarea class="form-control" name="descripcionStock" id="descripcionStock" cols="100" rows="2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio placeat dignissimos libero nihil. Fuga doloribus deleniti in ut officiis vero, ab ducimus maxime repellat sapiente eum laborum? Saepe, eos ad.</textarea>
      </div>     
    </div>
    <div class="row justify-content-center mt-lg-2">
        <div class="col-2">
          <button class="btn btn-primary" id="botonAgregarStock" type="submit">Agregar stock</button>
        </div>
        <div class="col-8"></div>
    </div>
    
  </div>

</form>

<?php
require_once ('../view/pie2.php');

?>


<script>

buscarArticulo.addEventListener('click', buscarCodigoArticulo, true);
var codigoArticulo;

function buscarCodigoArticulo(e){
e.preventDefault();
var mostrarDatosArticulo = document.getElementById('datosDeArticulo');

codigoArticulo = document.getElementById('buscarId').value;

const datos = new FormData();
datos.append('buscarCodigo', 'true');
datos.append('idArtidculo', codigoArticulo);
fetch('http://localhost/ferresur/controller/actualizarStockController.php',{
  method: 'POST',
  body: datos
})
.then(res => res.json())
.then(data => {
console.log(data);
mostrarDatosArticulo.innerHTML = `
<table class="table">
  <thead>
    <tr>
      <th scope="col">Codigo</th>
      <th scope="col">Nombre</th>
      <th scope="col">Descripcion</th>
      <th scope="col">Stock</th>
      <th scope="col">Stock Minimo</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td id="codigo">${data.codigo}</td>
      <td>${data.nombre}</td>
      <td>${data.descripcion}</td>
      <td>${data.stock}</td>
      <td>${data.stockminimo}</td>
    </tr>    
  </tbody>
</table>
`;

var formStock = document.getElementById('formularioDeStock');

}
);
}

//////////////////////////////
botonBuscar.addEventListener('click', buscarNombreArticulo, true);

function buscarNombreArticulo(e){
e.preventDefault();

var mostrarTabla = document.getElementById('tabla');
var nombreArticulo = document.getElementById('nombrearticulo').value;
document.getElementById('nombrearticulo').value= "";

mostrarTabla.innerHTML = ``;
console.log(nombreArticulo);
const datos = new FormData();
datos.append('buscarNombre','true');
datos.append('nombre',nombreArticulo);
fetch('http://localhost/ferresur/controller/actualizarStockController.php',{
  method: 'POST',
  body: datos
})
.then(res => res.json())
.then(data => {
  console.log('los datos: '+data);

  for(let item of data){
    mostrarTabla.innerHTML += `
    <tr>
      <td>${item.idarticulo}</td>
      <td>${item.nombre}</td>
    <tr>
    `; 
  }
  
});

}
////////////////////////////////
botonAgregarStock.addEventListener('click',agregarStock,true);

function agregarStock(e){
e.preventDefault();
var cantidad = document.getElementById('cantidadStock').value;
var descripcionHistorial = document.getElementById('descripcionStock').value;

const datos = new FormData();
datos.append('AgregarStock', 'true');
datos.append('cantidad', cantidad);
datos.append('idArticulo', codigoArticulo);
datos.append('descripcion', descripcionHistorial);
fetch('http://localhost/ferresur/controller/actualizarStockController.php',{
  method: 'POST',
  body: datos
})
.then(res => res.text())
.then(data => {
  alert(data);
})
}

</script>