<?php
require_once ('../view/cabecera.php');
require_once ('../model/UsuarioClass.php');
Usuario::verificarSesion(19);
?>
<br><br><br>
<div class="container-fluid">
    <h3 class="text-center">Clientes</h3>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <input type="text" class="form-control" id="dni" placeholder="Ingrese DNI">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary form-control" id="botonBuscar">Buscar</button>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary form-control" id="buscarPorNombre" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal3">Buscar Por Nombre</button>
        </div>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-md-2">
            <button class="btn btn-success form-control" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Agregar Cliente</button>
        </div>
    </div>
    <hr>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Email</th>
                        <th>Condición IVA</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tablaCliente">
                  
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">                            
                            Nombre:
                            <input type="text" class="form-control" id="nombreAgregar">
                            Apellido
                            <input type="text" class="form-control" id="apellidoAgregar"> 
                            DNI:
                            <input type="text" class="form-control" id="dniAgregar">
                            E-mail:
                            <input type="text" class="form-control" id="emailAgregar">
                            Condición Frente al IVA:
                            <select id="ivaAgregar" class="form-control">
                              <option value="RI">Responsable Inscripto</option>
                              <option value="MT">Monotributista</option>
                              <option value="CF">Consumidor Final</option>
                            </select>
                    </div>
                </div>
            </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="botonAgregarCliente">Agregar Cliente</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal -->

<!-- Modal 2--> 
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">                            
                            Nombre:
                            <input type="text" class="form-control" id="nombreModificar">
                            Apellido
                            <input type="text" class="form-control" id="apellidoModificar"> 
                            DNI:
                            <input type="text" class="form-control" id="dniModificar">
                            E-mail:
                            <input type="text" class="form-control" id="emailModificar">
                            Condición Frente al IVA:
                            <select id="ivaModificar" class="form-control">
                              <option value="RI">Responsable Inscripto</option>
                              <option value="MT">Monotributista</option>
                              <option value="CF">Consumidor Final</option>
                            </select>
                    </div>
                </div>
            </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button class="btn btn-primary" id="modificarCliente">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal -->

<!-- Modal 3--> 
<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Buscar Cliente por Apellido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-9">                            
                            Apellido
                            <input type="text" class="form-control input-group" id="apellidoBuscar"> 
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-info input-group mt-4" id="buscarClientePorApellido">Buscar</button>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>idCliente</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>DNI</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody id="tablaClienteApellido">
                            
                        </tbody>
                    </table>
                    </div>
                </div>

            </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal -->



<?php
require_once ('../view/pie4.php');
?>

<script type="text/javascript" src="../library/clientes.js"></script>