<?php 
require_once ('../model/UsuarioClass.php');
require_once ('../view/cabecera.php');
Usuario::verificarSesion(17);

?>

<br><br>

<form action="" method="POST" id="formulario">
    <div class="container-fluid mt-5 eliminarImprimir">
        <h4 class="text-center">Ventas</h4>
        <div class="row justify-content-center mt-3">

            <div class="input-group col-md-5">
                <input autofocus type="text" class="form-control" name="Articulo" id="Articulo" placeholder="Codigo de Articulo">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="buscarArticulo" id="buscarArticulo">Buscar Articulo</button>
                    <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModalCenter">Buscar por Nombre</button>
                </div>
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
        
        <div class="row justify-content-center mt-4">
            <div class="col-md-2">
                <p>codigo</p>
                <div id="codigo"></div>
            </div>

            <div class="col-md-2">
                <p>Nombre</p>
                <div id="nombre"></div>
            </div>
            
            <div class="col-md-2">
                <p>Precio</p>
                <div id="precio"></div>
            </div>

            <div class="col-md-2">
                <p>Stock</p>
                <div id="stock"></div>
            </div>

            <div class="col-md-2">
                <p>Descripcion</p>
                <div id="descripcion"></div>
            </div>
            
        </div>


        <div class="row justify-content-center mt-3">

            <div class="input-group col-md-2">
            <input type="text" class="form-control" name="cantidad" id="cantidad" placeholder="Cantidad">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" name="agregarArticulo" id="agregarArticulo">Agregar</button>
            </div>
        </div>

    </div>


        <div class="row justify-content-center mt-3">
            <div class="col-md-8">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>codigo</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="res">
                       
                    </tbody>
                   
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><div class="alert alert-primary" role="alert" id="total" name="total">Total:</div></td>
                            <td></td>
                        </tr>
                   

                </table>

            </div>          

        </div>
       

        <div class="row justify-content-center">
            <div class="col-md-3">
                Tipo de Pago:
                <select name="tipopago" id="tipopago" class="form-control">
                    <option>efectivo</option>
                    <option>tarjeta</option>
                </select>
            </div>
        </div>


        <div class="row justify-content-center">

            <div class="input-group col-md-3 mt-4">
                <input autofocus type="text" class="form-control" name="cuit" id="cuit" placeholder="Ingrese CUIT/CUIL">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="buscarCliente" id="buscarCliente">Buscar Cliente</button>
                </div>
            </div>

        </div>

        <div class="row justify-content-center mt-3">
            <div class="col-md-3 text-center" id="mostrarCliente"></div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-1">
                <button class="btn btn-info" type="submit"name="finalizar" id="finalizar">Finalizar</button>
            </div>
        </div>
    </div>
  
</form>

<?php 
require_once ('../view/pie4.php');
?>

<script type="text/javascript" src="../library/venta.js"></script>