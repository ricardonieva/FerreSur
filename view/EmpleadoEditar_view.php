<?php
require_once ('../model/UsuarioClass.php');
require_once ('../view/cabecera.php');
require_once ('../model/categoriaClass.php');
require_once ('../model/EmpleadoClass.php');
Usuario::verificarSesion(35);

$idEmple = (int) $_GET['idEmpleado'];
$categoria = new Categoria();

if(isset($_POST['editarEmpleado']))
{
  $empleado = new Empleado();
  $empleado->idEmpleado = $idEmple;
  $empleado->nombre = $_POST['nombre'];
  $empleado->apellido = $_POST['apellido'];
  $empleado->cuil = $_POST['cuil'];
  $empleado->fechanac = $_POST['fechanac'];
  $empleado->fechaingreso = $_POST['fechaingreso'];
  $empleado->telefono = $_POST['telefono'];
  $empleado->cuentaBancaria = $_POST['ctaBancaria'];
  $empleado->categoria = $_POST['categoria'];
  $empleado->updateEmpleado();
}

 ?>
 <div align="center">
     <br><br><h3 class="mt-5">Modificar Empleado</h3>
 </div>

<form method="POST" accion="">
     <div class="row justify-content-center">
        <div class="form-group col-md-4">
          <label for="nombre">Nombre</label>
          <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre del Empleado">
        </div>
        <div class="form-group col-md-4">
          <label for="apellido">Apellido</label>
          <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Apellido del Empleado">
        </div>
     </div>

     <div class="row justify-content-center">
       <div class="form-group col-md-4">
        <label for="cuil">Cuil del empleado</label>
        <input type="text" class="form-control" name="cuil" id="cuil" placeholder="cuil">
       </div>
       <div class="form-group col-md-4">
        <label for="fechaNac">Fecha de nacimiento</label>
        <input type="date" class="form-control" name="fechanac"id="fechanac" placeholder="Fecha de nacimiento">
       </div>
     </div>

     <div class="row justify-content-center">
       <div class="form-group col-md-4">
         <label for="fechaingreso">Fecha de Ingreso</label>
         <input type="date" class="form-control" name="fechaingreso"id="fechaingreso" placeholder="Fecha de ingreso">
       </div>
       <div class="form-group col-md-4">
         <label for="margen">Categoria</label>
         <select name="categoria" id="categoria" name="categoria" class="form-control">
         <option value=""></option>
          <?php             
              foreach($categoria->buscarTodasLasCategoria() as $row)
              {
                echo "<option value='$row[idCategoria]'>$row[Tipo] - $row[sueldoBasico]</option>";
              }
          ?>
         </select>
       </div>
     </div>    

     <div class="row justify-content-center">
       <div class="form-group col-md-4">
         <label for="fechaingreso">Cuenta Bancaria</label>
         <input type="text" class="form-control" name="ctaBancaria" id="ctaBancaria" placeholder="Cuenta Bancaria">
       </div>

       <div class="form-group col-md-4">
        <label for="fechaingreso">Telefono</label>
        <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Telefono">
       </div>
     </div>    
     

     <div class="col-md-4 offset-md-2 ">
       <button type="submit" class="btn btn-primary" name="editarEmpleado"id="editarEmpleado">Guardar</button>

     </div>

   
 </div>
</form>
<?php require_once ('../view/pie3.php') ?>

<script>
window.addEventListener('load', function (){

var id = <?php echo $idEmple; ?>;

const data = new FormData();
data.append('buscarEmpleado', 'true');
data.append('idEmpleado', id);

fetch('../controller/EmpleadoEEController.php', {
    method: 'POST',
    body: data
})
.then(res => res.json())
.then(data =>{

  document.getElementById('nombre').value = data.nombre;
  document.getElementById('apellido').value = data.apellido;
  document.getElementById('cuil').value = data.cuil;
  document.getElementById('fechanac').value = data.fechanac;
  document.getElementById('fechaingreso').value = data.fechaingreso;
  document.getElementById('categoria').selectedIndex = data['categoria'].idCategoria;
  document.getElementById('ctaBancaria').value = data.cuentaBancaria;
  document.getElementById('telefono').value = data.telefono;

});

}
);




</script>