<?php
require_once ('../view/cabecera.php');
require_once ('../model/UsuarioClass.php');
Usuario::verificarSesion(11);
?>
<br><br><br>
<div class="container-fluid">
    <h3 class="text-center">Asistencia de Empleados</h3>

    <div class="row justify-content-center">
        <div class="input-group col-md-4">
            <input autofocus type="text" class="form-control" name="buscarcuil" id="buscarcuil" placeholder="CUIL">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" name="buscarEmpleado" id="buscarEmpleado">Buscar Empleado</button>
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

    <div class="row justify-content-center mt-3">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Nueva Asistencia</button>
    </div>

    <div class="row justify-content-center mt-3">
      <div class="col-md-8">
        <table class="table" id="tablaAsistenciaHead">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Habil</th>
              <th>Entrada</th>
              <th>Salida</th>
              <th>Novedad</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody id="tablaAsistencia">            
           
          </tbody>
        </table>
      </div>
    </div>

</div>

<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Asistencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="container-fluid">
            <div class="row align-items-start">
                <div class="col-md-6">
                  Fecha:
                  <input type="date" id="fecha" class="form-control">
                </div>

                <div class="col-md-6">
                    Novedad:
                    <select name="novedad" id="novedad" class="form-control">
                        <option>Normal</option>
                        <option>Tardanza</option>
                        <option>Falta Justificada</option>
                        <option>Falta Injustificada</option>
                    </select> 
                </div>                              
            </div>  
            <hr>
            <div class="row justify-content-center">
                <div class="col md-4">
                    Entrada
                    <input type="time" class="form-control" id="entrada">
                </div>  
                
                <div class="col md-4">
                    Salida
                    <input type="time" class="form-control" id="salida">
                </div>    
            </div>      
            
            
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="guardarAsistencia();">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- fin del modal de asistencia nueva -->

<!-- Modal modificar asistencia-->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabelModificar"</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="container-fluid">
            <div class="row align-items-start">
                <!-- <div class="col-md-6">
                  Fecha
                  <input type="date" id="fechaModificar" class="form-control">
                </div> -->

                <div class="col-md-6">
                    Novedad
                    <select name="novedad" id="novedadModificar" class="form-control">
                        <option>Normal</option>
                        <option>Tardanza</option>
                        <option>Falta Justificada</option>
                        <option>Falta Injustificada</option>
                    </select> 
                </div>                              
            </div>  
            <hr>
            <div class="row justify-content-center">
                <div class="col md-4">
                    Entrada
                    <input type="time" class="form-control" id="entradaModificar">
                </div>  
                
                <div class="col md-4">
                    Salida
                    <input type="time" class="form-control" id="salidaModificar">
                </div>    
            </div>                 
            
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="guardarCambiosAsistencia();">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- fin del modal de modificar -->




<?php
require_once ('../view/pie3.php');
?>

<script type="text/javascript" src="../library/asistencia.js"></script>