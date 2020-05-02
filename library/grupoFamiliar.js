//variables globales    
var cuil;
var idEmpleado;

buscarEmpleado.addEventListener('click', function (e){
e.preventDefault();

cuil = document.getElementById('buscarcuil')

const data = new FormData();
data.append('buscarEmpleado', 'true');
data.append('CUIL', cuil.value);
fetch('../controller/grupoFamiliarController.php', {
    method: 'POST',
    body: data
})
.then(res => res.json())
.then(data => {

if(data != false){
    idEmpleado = data.idEmpleado;//capturamos el id del empleado buscado
    var datos = document.getElementById('nombreEmpleado');
    datos.value = data.apellido+", "+data.nombre;
}else{
    alert('Empleado No Encontrado');
}

})

cargarTabla();

});
////////////////////////Agregar Familiar
var nom = document.getElementById('modalNombre');
var ape = document.getElementById('modalApellido');
var dni = document.getElementById('modalDNI');
var par = document.getElementById('modalParentesco');
var fechaNac = document.getElementById('modalFechaNac');
var disc = document.getElementById('modalDiscapacidad');
var estu = document.getElementById('modalEstudio');
var niv = document.getElementById('modalNivel');

agregarFamiliar.addEventListener('click', function(e){
e.preventDefault();

const data = new FormData();
data.append('agregarFamiliar', 'true');
data.append('apellido', ape.value);
data.append('nombre', nom.value);
data.append('dni', dni.value);
data.append('parentesco', par.value);
data.append('fechaNac', fechaNac.value);
data.append('discapacidad', disc.checked);
data.append('estudio', estu.checked);
data.append('nivel', niv.value);

fetch('../controller/grupoFamiliarController.php', {
    method: 'POST',
    body: data
})
.then(res => res.text())
.then(data => {
    alert(data);
    cargarTabla();
})

});
//////////////////////cargar tabla con familiares

function cargarTabla(){
    var tablaFamilia = document.getElementById('tabla');
    tablaFamilia.innerHTML = ``; //borra la tabla para despues llenarla, asi no se duplican los datos

const data = new FormData();
data.append('traerFamiliares', 'true');
fetch('../controller/grupoFamiliarController.php', {
    method: 'POST',
    body: data
})
.then(res => res.json())
.then(data => {    
    //alert(data);
    for(let item of data){
        tablaFamilia.innerHTML += `
        <tr>
            <td>${item.idgrupofamiliar}</td>
            <td>${item.apellido}</td>
            <td>${item.nombre}</td>
            <td>${item.dni}</td>           
            <td>${item.parentesco}</td>
            <td>${item.fechanacimiento}</td>
            <td>${item.discapacidad}</td>
            <td>${item.estudio}</td>
            <td>${item.nivel}</td>
            <td><button class="btn btn-danger" onclick="borrarElementoTabla(${item.idgrupofamiliar})">Borrar</button></td>
            <td><button type="button" class="btn btn-primary form-control" onclick="modoficarFamiliar(${item.idgrupofamiliar}, '${item.apellido}', '${item.nombre}', '${item.dni}', '${item.parentesco}', '${item.fechanacimiento}', ${item.discapacidad}, ${item.estudio}, '${item.nivel}')">Modificar</button></td>
        </tr>
        `;
    }

})

}

////////////////////////funcion para ver si anda el onclick dentro de la tabla

function borrarElementoTabla(e){
    var valor = confirm("Estas Seguro de Borrar Este Integrante?");
    if(valor == true){

        const data = new FormData();
        data.append('borrarFamiliar', 'true');
        data.append('idFamiliar', e);
        fetch('../controller/grupoFamiliarController.php', {
            method: 'POST',
            body: data
        })
        .then(res => res.text())
        .then(data => {
            alert(data);
            cargarTabla();
        })
    }
}
////////////////////////////////moton modificar
var idfamiliarAUX;
function modoficarFamiliar(idfamiliar, apellido, nombre, dni, parentesco, fechanacimiento, discapacidad, estudio, nivel){
    idfamiliarAUX = idfamiliar;

    var nomEdit = document.getElementById('modalEditNombre');
    var apeEdit = document.getElementById('modalEditApellido');
    var dniEdit = document.getElementById('modalEditDNI');
    var parEdit = document.getElementById('modalEditParentesco'); 
    var fecnacEdit = document.getElementById('modalEditFechaNac');
    var disEdit = document.getElementById('modalEditDiscapacidad');
    var estEdit = document.getElementById('modalEditEstudio');
    var nivEdit = document.getElementById('modalEditNivel');


    nomEdit.value = nombre;
    apeEdit.value = apellido;
    dniEdit.value = dni;
    parEdit.value = parentesco;
    fecnacEdit.value = fechanacimiento;
    if(discapacidad == 1)
    {
        disEdit.checked="checked";
    }
    else{
        disEdit.checked="";
    }
    if(estudio == 1)
    {
        estEdit.checked="checked";
    }
    else{
        estEdit.checked="";
    }
    nivEdit.value = nivel;

    $('#ModalModificar').modal('show');

}

function modificarFamiliar2(){
    
    var nom = document.getElementById('modalEditNombre').value;
    var ape = document.getElementById('modalEditApellido').value;
    var dni = document.getElementById('modalEditDNI').value;
    var par = document.getElementById('modalEditParentesco').value;
    var fecnac = document.getElementById('modalEditFechaNac').value;
    var dis = document.getElementById('modalEditDiscapacidad');
    var est = document.getElementById('modalEditEstudio');
    var niv = document.getElementById('modalEditNivel').value;

    const data = new FormData();
    data.append('modificarFamiliar','true');
    data.append('idintegrante', idfamiliarAUX);
    data.append('nombre', nom);
    data.append('apellido', ape);
    data.append('dni', dni);
    data.append('paretenesco', par);
    data.append('fechaNac', fecnac);
    data.append('discapacidad', dis.checked);
    data.append('estudio', est.checked);
    data.append('nivel', niv);

    fetch("../controller/grupoFamiliarController.php",{
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(data => {

        alert(data);
        $('#ModalModificar').modal('hide');
        cargarTabla();

    })
    
} 
