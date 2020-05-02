<?php
require_once ('../view/cabecera.php');
require_once ('../model/UsuarioClass.php');
Usuario::verificarSesion(3);
?>
<br><br><br>
<div class="container-fluid">
    <h3 class="text-center">Categoria</h3>

    <div class="d-flex justify-content-center">       
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Nueva Categoria</button>
    </div>
    <hr>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table">
                <thead>
                    <tr>
                        <th>IdCategoria</th>
                        <th>Descripcion</th>
                        <th>Sueldo Basico</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tablaCategoria">
                   
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
            <h5 class="modal-title" id="exampleModalLabel">Nueva Categoria</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        Descripcion
                        <input type="text" class="form-control" id="modelDescripcion">
                        Sueldo Basico
                        <input type="text" class="form-control" id="modelSueldoBasico">
                        Forma Laboral
                        <select class="form-control" name="formaLaboral" id="formaLaboral">
                            <option>Mensual</option>
                            <option>Hora</option>
                            <option>Ficha</option>
                        </select>
                    </div>
                    
                </div>

            </div>
           
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" onclick="registrarNuevaCategoria();">Guardar</button>
        </div>
        </div>
    </div>
    </div>
<!-- fin modal -->


<!-- Modal  modificiar categoria-->
<div class="modal fade" id="exampleModalModificar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modificar Categoria</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        Descripcion
                        <input type="text" class="form-control" id="modelDescripcionModificar">
                        Sueldo Basico
                        <input type="text" class="form-control" id="modelSueldoBasicoModificar">
                        Forma Laboral
                        <select class="form-control" name="formaLaboralModificar" id="formaLaboralModificar">
                            <option>Mensual</option>
                            <option>Hora</option>
                            <option>Ficha</option>
                        </select>
                    </div>
                    
                </div>

            </div>
           
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" onclick="modificarCategoria();">Guardar</button>
        </div>
        </div>
    </div>
    </div>
<!-- fin modal -->

<?php
require_once ('../view/pie3.php');
?>

<script type="text/javascript" src="../library/categoria.js"></script>