<?php
require_once ('../model/UsuarioClass.php');
require_once ('../view/cabecera.php');
Usuario::verificarSesion(24);
?>

<div class="container-fluid">
    <br>
<h3 class="mt-5 text-center">Compra a Proveedores</h3>

    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="input-group">
                <input class="form-control" id="id" type="text" pattern="[0-9]+" title="Ingrese solo numeros" placeholder="Codigo de Proveedor">
                <button class="btn btn-light" id="buscarPorID">Buscar Por id</button>
                <button type="button" class="btn btn-light" id="buscarPorNombre" data-toggle="modal" data-target="#exampleModal">Buscar Por Razon Social</button>                
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Buscar Proveedor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="input-group">
              <input type="text" class="form-control" pattern="[a-zA-Z]+" title="Ingrese solo letras" placeholder="Razon Social" id="modalRazonsocial">
              <button class="btn btn-info" id="buscarPorRazonSocial">Buscar</button>
            </div>   
            
            <table class="table table-hover table-dark">
              <thead>
                <tr>
                  <th>Codigo</th>
                  <th>Razon Social</th>         
                </tr>
              </thead>
              <tbody id="tablaProveedor">
              </tbody>
            </table>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- end modal -->

    <hr>

    <div class="row justify-content-center">
        <div class="col-md-2">
            <strong>Razon Social</strong>
            <p id="dataNombre"></p>
        </div>
        <div class="col-md-2">
            <strong>E-mail</strong>
            <p id="dataMail"></p>
        </div>
    </div>
    
    <div class="row justify-content-center mt-3">

        <div class="input-group col-md-5">
            <input type="text" class="form-control" pattern="[0-9]+" title="Ingrese solo numeros" name="buscarId" id="buscarId" placeholder="codigo de articulo" aria-label="Buscar articulo" aria-describedby="buscarArticulo">
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
                <input type="text" class="form-control" pattern="[a-zA-Z]+" title="Ingrese solo letras" placeholder="Nombre" name="nombrearticulo" id="nombrearticulo">
                <button class="btn btn-outline-secondary" id="botonBuscar" name="botonBuscar" type="submit">Buscar</button>
              </div>

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <table class="table table-hover table-dark">
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
    <!-- mostrar info de articulos -->
        <div class="col-md-8 mt-2" id="datosDeArticulo">

        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-5 input-group">
            <input type="text" class="form-control" pattern="[0-9]+" title="Ingrese solo numeros" placeholder="Cantidad" id="cantidad">
            <input type="text" class="form-control" pattern="[0-9]+" title="Ingrese solo numeros" placeholder="Precio" id="precio">
            <button class="btn btn-primary" id="agregarArticulo">Agregar</button>
        </div>
    </div>

    <div class="row justify-content-center mt-3">
      <div class="col-md-8">
      <table class="table table-hover table-dark">
        <thead>
          <tr>
            <th scope="col">Codigo</th>
            <th scope="col">Nombre</th>
            <th scope="col">Costo Unitario</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Subtotal</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody id="tablaArticulo">    
        </tbody>
      </table>  

      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-6">

      </div>
      <div class="col-md-2" id="divtotal">

      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-2">
        <button class="btn btn-info" id="finalizarCompra">Finalizar</button>
      </div>
    </div>
</div>

<?php
require_once ('../view/pie5.php');
?>

<script type="text/javascript" src="../library/compraProveedores.js"></script>