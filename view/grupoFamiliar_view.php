<?php
require_once ('../view/cabecera.php');
require_once ('../model/UsuarioClass.php');
Usuario::verificarSesion(4);
?>

<div class="container-fluid">
    <br><br><br>
    <h3 class="text-center mt-3">Grupo Familiar</h3>

    <div class="row justify-content-center">
        <div class="input-group col-md-4">
            <input autofocus type="text" class="form-control" name="buscarcuil" id="buscarcuil" placeholder="CUIL">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" name="buscarEmpleado" id="buscarEmpleado">Buscar Empleado</button>
            </div>
        </div>
    </div>
    <hr class="my-3">

    <div class="row justify-content-center">
        <div class="col-md-4">
            <label for="">Nombre</label>
            <input type="text" class="form-control" disabled="true" id="nombreEmpleado" name="nombreEmpleado">
        </div>
    </div>

    <!-- Button trigger modal -->

    <div class="row justify-content-center">
        <div class="col-md-2 mt-3">
            <button type="button" class="btn btn-success form-control" data-toggle="modal" data-target="#exampleModalCenter">Agregar</button>
        </div>
    </div>    

<!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Integrante Familiar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            Apellido
            <input type="text" class="form-control" id="modalApellido" name="modalApellido">
            Nombre
            <input type="text" class="form-control" id="modalNombre" name="modalNombre">          
           
            <div class="container-fluid mt-3">

                <div class="row justify-content-center">
                    <div class="col-md-4">
                        DNI
                        <input type="text" class="form-control" id="modalDNI" name="modalDNI">
                    </div>
                    <div class="col-md-4">
                        Parentesco
                        <select name="parentesco" id="modalParentesco" class="form-control">
                            <option value="Hijo">Hijo</option>
                            <option value="Hermano">Hermano</option>
                            <option value="Señora">Señora</option>
                            <option value="Etc">Etc.</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        Fecha de Nacimiento
                        <input type="date" class="form-control" id="modalFechaNac">
                    </div>
                </div>

                <div class="row justify-content-center mt-3">

                    <div class="col-md-4 mt-4">
                        Discapacidad
                        <input type="checkbox" id="modalDiscapacidad" value="1">             
                    </div>

                    <div class="col-md-4 mt-4">
                        Estudio
                        <input type="checkbox" id="modalEstudio" value="1"> 
                    </div>

                    <div class="col-md-4">
                    Nivel
                    <select name="nivel" class="form-control" id="modalNivel">
                        <option></option>
                        <option>Primario</option>
                        <option>Secundario</option>
                        <option>Universidad</option>
                    </select>
                    </div>
                </div>
            </div>          
          
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="agregarFamiliar">Agregar Familiar</button>
        </div>
        </div>
    </div>
    </div>
    <!-- fin de modal -->

    <div class="row justify-content-center mt-3">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id Integrante</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">DNI</th>
                        <th scope="col">Parentesco</th>
                        <th scope="col">Fecha de Nacimiento</th>
                        <th scope="col">Discapacidad</th>
                        <th scope="col">Estudio</th>
                        <th scope="col">Nivel</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="tabla">
                </tbody>
            </table>
        </div>
    </div>

    <!-- modal moficiar -->

<!-- Modal editar-->
    <div class="modal fade" id="ModalModificar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Integrante Familiar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Apellido
            <input type="text" class="form-control" id="modalEditApellido" name="modalEditApellido">
            Nombre
            <input type="text" class="form-control" id="modalEditNombre" name="modalEditNombre">          
           
            <div class="container-fluid mt-3">

                <div class="row justify-content-center">
                    <div class="col-md-4">
                        DNI
                        <input type="text" class="form-control" id="modalEditDNI" name="modalEditDNI">
                    </div>
                    <div class="col-md-4">
                        Parentesco
                        <select name="parentesco" id="modalEditParentesco" class="form-control">
                            <option value="Hijo">Hijo</option>
                            <option value="Hermano">Hermano</option>
                            <option value="Señora">Señora</option>
                            <option value="Etc">Etc.</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        Fecha de Nacimiento
                        <input type="date" class="form-control" id="modalEditFechaNac">
                    </div>
                </div>

                <div class="row justify-content-center mt-3">

                    <div class="col-md-4 mt-4">
                        Discapacidad
                        <input type="checkbox" id="modalEditDiscapacidad" value="1">             
                    </div>

                    <div class="col-md-4 mt-4">
                        Estudio
                        <input type="checkbox" id="modalEditEstudio" value="1"> 
                    </div>

                    <div class="col-md-4">
                    Nivel
                    <select name="nivel" class="form-control" id="modalEditNivel">
                        <option></option>
                        <option>Primario</option>
                        <option>Secundario</option>
                        <option>Universidad</option>
                    </select>
                    </div>
                </div>
            </div>          
          
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="EditFamiliar" onclick="modificarFamiliar2()">Guardar Cambios</button>
        </div>
        </div>
    </div>
    </div>
    <!-- fin de modal edit-->


</div>




<?php
require_once ('../view/pie3.php');
?>

<script type="text/javascript" src="../library/grupoFamiliar.js"></script>