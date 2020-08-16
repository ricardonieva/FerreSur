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
                    <td>${item.cuit }</td>
                    <td>${item.direccion}</td>
                    <td>${item.localidad}</td>
                    <td>${item.condicioniva}</td>
                    <td><button class="btn btn-success form-control"  type="button" onclick="botonModificarCliente(${item.idcliente},'${item.nombre}','${item.cuit}','${item.direccion}','${item.localidad}','${item.condicioniva}');">Modificar</button></td>
                    <td><button class="btn btn-danger form-control" onclick="eliminarClienteDB(${item.idcliente});">Eliminar</button></td>
                </tr>
            `;
        }
    });


}

////////////////////////////buscar por cuit

botonBuscar.addEventListener('click', function(e){
    e.preventDefault();

    var cuitCliente = document.getElementById('cuit');
    tablaCliente.innerHTML = ``;

    const data = new FormData();
    data.append('buscarPorCuit', 'true');
    data.append('cuit', cuitCliente.value);
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
                <td>${data.cuit}</td>
                <td>${data.direccion}</td>
                <td>${data.localidad}</td>
                <td>${data.condicioniva}</td>
                <td><button class="btn btn-success form-control" onclick="botonModificarCliente(${data.idcliente},'${data.nombre}','${data.cuit}','${data.direccion}','${data.localidad}','${data.condicioniva}');">Modificar</button></td>
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
    var cuit = document.getElementById('cuitAgregar');
    var direccion = document.getElementById('direccionAgregar');
    var localidad = document.getElementById('localidadAgregar');
    var iva = document.getElementById('ivaAgregar');

    const data = new FormData();
    data.append('agregarCliente', 'true');
    data.append('nombre', nombre.value);
    data.append('cuit',cuit.value);
    data.append('direccion',direccion.value);
    data.append('localidad',localidad.value);
    data.append('iva',iva.value); 

    fetch('../controller/ClientesController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(data => {
        console.log(data);
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
    var cuit = document.getElementById('cuitModificar');
    var direccion = document.getElementById('direccionModificar');
    var localidad = document.getElementById('localidadModificar');
    var iva = document.getElementById('ivaModificar');

    const data = new FormData();

    data.append('modificarCliente', 'true');
    data.append('idCliente', idClienteGlobal);
    data.append('nombre', nombre.value);
    data.append('cuit',cuit.value);
    data.append('direccion',direccion.value);
    data.append('localidad',localidad.value);
    data.append('iva',iva.value);

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
function botonModificarCliente(idCliente, nombre, cuit, direccion, localidad, iva){

    idClienteGlobal = idCliente;

    $('#exampleModal2').modal('show');

    document.getElementById('nombreModificar').value = nombre;
    document.getElementById('cuitModificar').value = cuit;
    document.getElementById('direccionModificar').value = direccion;
    document.getElementById('localidadModificar').value = localidad;
    document.getElementById('ivaModificar').value = iva;

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