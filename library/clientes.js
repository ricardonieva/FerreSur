var tablaCliente = document.getElementById('tablaCliente');

window.addEventListener('load', cargarClientes);

function cargarClientes(){
    
    tablaCliente.innerHTML = ``;
    const data = new FormData();

    data.append('traerClientes', 'true');

    fetch('../controller/ClientesController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {

        for(let item of data){
            tablaCliente.innerHTML += `
                <tr>
                    <th>${item.idcliente}</th>
                    <td>${item.nombre}</td>
                    <td>${item.apellido}</td>
                    <td>${item.dni}</td>
                    <td>${item.email}</td>
                    <td><button class="btn btn-success form-control"  type="button" onclick="botonModificarCliente(${item.idcliente},'${item.nombre}','${item.apellido}',${item.dni},'${item.email}');">Modificar</button></td>
                    <td><button class="btn btn-danger form-control" onclick="eliminarClienteDB(${item.idcliente});">Eliminar</button></td>
                </tr>
            `;
        }
    });


}

////////////////////////////buscar por id

botonBuscar.addEventListener('click', function(e){
    e.preventDefault();

    var dniCliente = document.getElementById('dni');
    tablaCliente.innerHTML = ``;

    const data = new FormData();
    data.append('buscarPorDNI', 'true');
    data.append('dni', dniCliente.value);
    fetch('../controller/ClientesController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
       console.log(data);

       if(data.idcliente != false)
       {    
            tablaCliente.innerHTML += `
            <tr>
                <th>${data.idcliente}</th>
                <td>${data.nombre}</td>
                <td>${data.apellido}</td>
                <td>${data.dni}</td>
                <td>${data.email}</td>
                <td><button class="btn btn-success form-control" onclick="botonModificarCliente(${data.idcliente},'${data.nombre}','${data.apellido}',${data.dni},'${data.email}');">Modificar</button></td>
                <td><button class="btn btn-danger form-control" onclick="eliminarClienteDB(${data.idcliente});">Eliminar</button></td>
            </tr>
            `;
       }
       else
       {
           alert('No se encontro el cliente');
       }
      
        
    });

});

/////////////////////agregar Cliente
botonAgregarCliente.addEventListener('click', function(e){
    e.preventDefault();

    var nombre = document.getElementById('nombreAgregar');
    var apellido = document.getElementById('apellidoAgregar');
    var dni = document.getElementById('dniAgregar');
    var email = document.getElementById('emailAgregar');

    const data = new FormData();
    data.append('agregarCliente', 'true');
    data.append('nombre', nombre.value);
    data.append('apellido',apellido.value);
    data.append('dni',dni.value);
    data.append('email',email.value);

    fetch('../controller/ClientesController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(data => {
       if(data == 'true'){
            alert("se cargo el cliente satisfactoriamente");
       }
       else{
            alert("Error al cargar cliente");
       }
       cargarClientes();
       $('#exampleModal').modal('hide');
    });

});

///////////////////////////modificar cliente
modificarCliente.addEventListener('click', modificarClienteDB);

function modificarClienteDB(){

    var nombre = document.getElementById('nombreModificar');
    var apellido = document.getElementById('apellidoModificar');
    var dni = document.getElementById('dniModificar');
    var email = document.getElementById('emailModificar');

    const data = new FormData();

    data.append('modificarCliente', 'true');
    data.append('idCliente', idClienteGlobal);
    data.append('nombre', nombre.value);
    data.append('apellido',apellido.value);
    data.append('dni',dni.value);
    data.append('email',email.value);

    fetch('../controller/ClientesController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(data => {
       if(data == 'true'){
            alert("se cargo el cliente satisfactoriamente");
       }
       else{
            alert("Error al cargar cliente");
       }
       cargarClientes();
       $('#exampleModal2').modal('hide');
    });
}

////////////////////////boton moficiar cliente
var idClienteGlobal;
function botonModificarCliente(idCliente, nombre, apellido, dni, email){

    idClienteGlobal = idCliente;

    $('#exampleModal2').modal('show');

    document.getElementById('nombreModificar').value = nombre;
    document.getElementById('apellidoModificar').value = apellido;
    document.getElementById('dniModificar').value = dni;
    document.getElementById('emailModificar').value = email;

}
///////////////////////eliminar lciente

function eliminarClienteDB(idcliente){

    var r = confirm("Desea eliminar Este Cliente");
    if(r == true){
        const data = new FormData();

        data.append('eliminarCliente', 'true');
        data.append('idcliente', idcliente);

        fetch('../controller/ClientesController.php', {
            method: 'POST',
            body: data
        })
        .then(res => res.text())
        .then(data => {
        if(data == 'true'){
                alert("se elimino el cliente satisfactoriamente");
        }
        else{
                alert("Error al eliminar cliente");
        }
        cargarClientes();      
        });
    }   
}

/////////////////////////////buscar por nombre
buscarClientePorApellido.addEventListener('click', function(){

    var apellido = document.getElementById('apellidoBuscar').value;
    var tabla = document.getElementById('tablaClienteApellido');
    tabla.innerHTML = ``;
    const data = new FormData();
    data.append('buscarClientePorapellido', 'true');
    data.append('apellido', apellido);

    fetch('../controller/ClientesController.php', {
            method: 'POST',
            body: data
        })
        .then(res => res.json())
        .then(data => {
           
           for(let item of data)
           {
            tabla.innerHTML += `
                <tr>
                    <th>${item.idcliente}</th>
                    <td>${item.nombre}</td>
                    <td>${item.apellido}</td>
                    <td>${item.dni}</td>
                    <td>${item.email}</td>
                </tr>
            `;
           }
        });    

});