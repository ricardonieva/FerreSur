<?php
require_once ('../model/UsuarioClass.php');
require_once ('../view/cabecera.php');
Usuario::verificarSesion(12);

?>
<br><br><br>

<h3 class="text-center mt-3">Lista Concepto</h3>

<div class="container-fulid">
    <div class="row justify-content-center">
        <div class="col-md-1">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Agregar</button>
        </div>
    </div>    

    <div class="rol justify-content-center mt-3">
        <div class="col-md-12">
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th>Tipo Concepto</th>
                        <th>Detalle</th>
                        <th>Percepcion Salarial</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tablaConcepto">                   
                </tbody>
            </table>
        </div>
    </div>
</div> 



<hr>
<!-- Modal concepto-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Concepto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                Tipo concepto
                <select id="tipoconcepto" class="form-control">
                    <option></option>
                    <option>Obligaciones de la Empresa</option>
                    <option>Asignacion Familiar</option>
                    <option>Percepciones de Ley</option>
                    <option>Presentismo</option>
                    <option>Sueldo</option>
                    <option>Dias Feriados</option>
                    <option>Despido</option>
                    <option>SAC</option>
                </select>
            </div>
            <div class="col-md-6">
                Detalle
                <input type="text" placeholder="Detalle" id="detalle" class="form-control">
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                Percepcion Salarial
                <select id="percepcionSalarial" class="form-control">
                    <option>Deduccion</option>
                    <option>Haber</option>
                </select>
            </div>

            <div class="col-md-6">
                Tipo
                <select id="tipo" class="form-control">
                    <option>Porcentual</option>
                    <option>Fijo</option>
                </select>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                Valor
                <input type="number" placeholder="Valor" id="valor" class="form-control">
            </div>

            <div class="col-md-6"></div>
        </div>

      </div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-primary" onclick="nuevoConcepto();">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal concepto -->

<!-- Modal modificar concepto-->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div>
<!-- end modal modificar concepto -->


<?php
require_once ('../view/pie3.php');
?>

<script type="text/javascript" src="../library/concepto.js"></script>