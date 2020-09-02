<?php
require_once ('../model/UsuarioClass.php');
Usuario::verificarSesion(25);
require_once ('../view/cabecera.php');
?>

<br><br><br><br>
<div class="container-fluid">
    <h5 class="text-center">Lista de Compra</h5>
    <div class="row justify-content-center mt-3">
        <div class="col-md-3">
            Fecha Desde:
            <input type="date" class="form-control input-group" placeholder="Fecha Desde" id="fechadesde" name="fechadesde"> 
        </div>
        <div class="col-md-3">
            Fecha Hasta:
            <input type="date" class="form-control input-group" placeholder="Fecha Hasta" id="fechahasta" name="fechahasta">
        </div>   
        <div class="col-md-1 mt-4">
            <button class="btn btn-primary form-control" id="botonMostrar">Mostrar</button>
        </div>
        <div class="col-md-2 mt-4">
            <button class="btn btn-primary form-control" id="btnLibroIVA">IVA Compra</button>
        </div>
        <div class="col-md-1 mt-4">
            <button class="btn btn-primary form-control" id="btnGraficos">Graficos</button>
        </div>
    </div>      
 
    <div class="row justify-content-center mt-3">
        <div class="col-md-12">
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th>N°</th>                            
                        <th>Fecha</th>
                        <th>Proveedor</th>
                        <th>CUIT</th>
                        <th>Condicion</th>
                        <th>Estado</th>
                        <th></th>
                        <th></th>
                        <th></th>                       
                    </tr>
                </thead>
                <tbody id="tablaCompra">

                </tbody>

            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar Compra</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row justify-content-center">

            <div class="input-group col-md-10">
                <input type="text" class="form-control" name="buscarIdArtoculo" id="buscarIdArticulo" placeholder="codigo de articulo" aria-label="Buscar articulo" aria-describedby="buscarArticulo">
                    <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" onclick="buscarArticulo();">Buscar Articulo</button>
                    </div>
            </div>
        </div>

       

        <div class="row justify-content-center mt-3">
            <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Codigo</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Costo Unitario</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody id="tablaArticulo">    
                </tbody>
            </table>  

            </div>
        </div>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Costo Unitario</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tablaDetalleCompra">              
            </tbody>
        </table>

        <div class="row justify-content-center">
            <div class="col-md-4"></div>
            <div class="col-md-2">
                <h5 class="text-right mt-3">Total $</h5>
            </div>
            <div class="col-md-2">
                <div class="alert alert-primary text-center" role="alert" id="totalCompra">                    
                </div>
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-primary" onclick="guardarCambios();">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal -->

<?php
require_once ('../view/pie5.php');
?>


<script type="text/javascript" src="../library/compralista.js"></script>