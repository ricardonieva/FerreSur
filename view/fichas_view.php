<?php
require_once ('../view/cabecera.php');
require_once ('../model/UsuarioClass.php');
Usuario::verificarSesion(12);

?>
<br><br><br>

<h3 class="text-center mt-3">Lista de fichas</h3>

<div class="container-fulid">
    <div class="row justify-content-center">
        <div class="col-md-2">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Agregar nueva ficha</button>
        </div>
    </div>    

    <div class="row justify-content-center mt-3">
        <div class="col-md-10">
            <table class="table ">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th>Codigo Empleado</th>
                        <th>Empleado</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tablaFicha">                   
                </tbody>
            </table>
        </div>
    </div>
</div> 



<hr>
<!-- Modal Nueva Ficha -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nueva Ficha</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="container-fluid">
        
      <div class="row justify-content-center">
            <div class="col-md-6">
                Empleado
                <input type="number" placeholder="id de empleado" name="empleado" id="idempleado" class="form-control">
            </div>
            <div class="col-md-6">
                Cantidad de ficha
                <input type="text" placeholder="Cantidad de ficha" id="cantidadFicha" class="form-control">
            </div>
        </div>

        <div class="row justify-align-content-md-start">
            <div class="col-md-6">
                Fecha
                <input type="date" name="fecha" id="fecha" class="form-control">
            </div>
        </div>

      </div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-primary" onclick="nuevaFicha();">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal Nueva Ficha -->

<!-- Modal Ficha MODIFICAR-->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel2">Modificar Ficha</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="container-fluid">
        
      <div class="row justify-content-center">
            <div class="col-md-6">
                Empleado
                <input type="number" placeholder="id de empleado" name="empleado" id="idempleadoModificar" class="form-control">
            </div>
            <div class="col-md-6">
                Cantidad de ficha
                <input type="text" placeholder="Cantidad de ficha" id="cantidadFichaModificar" class="form-control">
            </div>
        </div>

        <div class="row justify-align-content-md-start">
            <div class="col-md-6">
                Fecha
                <input type="date" name="fecha" id="fechaModificar" class="form-control">
            </div>
        </div>

      </div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-primary" id="modificarFicha">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal Ficha MODIFICAR-->

<!-- Modal modificar concepto-->
<!-- <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar Concepto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                Tipo concepto
                <select id="tipoconceptoModificar" class="form-control">
                    <option></option>
                    <option>Obligaciones de la Empresa</option>
                    <option>Asignacion Familiar</option>
                    <option>Percepciones de Ley</option>
                    <option>Presentismo</option>
                    <option>Sueldo</option>
                    <option>Dias Feriados</option>
                </select>
            </div>
            <div class="col-md-6">
                Detalle
                <input type="text" placeholder="Detalle" id="detalleModificar" class="form-control">
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                Percepcion Salarial
                <select id="percepcionSalarialModificar" class="form-control">
                    <option>Deduccion</option>
                    <option>Haber</option>
                </select>
            </div>

            <div class="col-md-6">
                Tipo
                <select id="tipoModificar" class="form-control">
                    <option>Porcentual</option>
                    <option>Fijo</option>
                </select>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                Valor
                <input type="number" placeholder="Valor" id="valorModificar" class="form-control">
            </div>

            <div class="col-md-6"></div>
        </div>

      </div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-primary" onclick="modificarConcepto();">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div> -->



<?php
require_once ('../view/pie3.php');
?>

<script type="text/javascript" src="../library/ficha.js"></script>