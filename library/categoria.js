window.addEventListener('load', cargarTablaCategoria);
//agrego este comentario solo para probar git..
function cargarTablaCategoria()
{
    const data = new FormData();
    data.append('cargarTablaCategoria', 'true');

    fetch('../controller/categoriaController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        var tabla = document.getElementById('tablaCategoria');
        tabla.innerHTML = ``;
        
        for(let item of data)
        {
            tabla.innerHTML += `
                <tr>
                    <td>${item.idCategoria}</td>
                    <td>${item.Tipo}</td>
                    <td>${item.sueldoBasico}</td>
                    <td>${item.formaLaboral}</td>
                    <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalModificar" onclick="botonModificarCategoria(${item.idCategoria}, '${item.Tipo}', ${item.sueldoBasico}, '${item.formaLaboral}');">Modificar</button></td>
                    <td><button class="btn btn-danger" onclick="eliminarCategoria(${item.idCategoria});">Eliminar</button></td>
                </tr>
            `;
        }

    });
}
///////////////////
function registrarNuevaCategoria()
{
    var descripcion = document.getElementById('modelDescripcion');
    var sueldoBasico = document.getElementById('modelSueldoBasico');
    var formaLaboral = document.getElementById('formaLaboral');

    const data = new FormData();
    data.append('cargarNuevaCategoria', 'true');
    data.append('descripcion', descripcion.value);
    data.append('sueldoBasico', sueldoBasico.value);
    data.append('formaLaboral', formaLaboral.value);

    fetch('../controller/categoriaController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        if(data)
        {
            alert('Se cargo correctamente');
            cargarTablaCategoria();
        }   
    });
}

//////////////////////////

function eliminarCategoria(idcategoria)
{
    var r = confirm('Desea eliminar esta categoria?');
    if(r)
    {
        const data = new FormData();
        data.append('eliminarCategoria', 'true');
        data.append('idcategoria', idcategoria);
       
        fetch('../controller/categoriaController.php', {
            method: 'POST',
            body: data
        })
        .then(res => res.text())
        .then(data => {
            if(data)
            {
                alert("se elimino satisfactoriamente");
                cargarTablaCategoria();
            }
        });
    }  
}

///////////////////////////////////////////////
var categoriaGlobal;
function botonModificarCategoria(idcategoria, descripcion, sueldoBasico, formaLaboral)
{    
    categoriaGlobal = idcategoria;
    var descripcionModificar = document.getElementById('modelDescripcionModificar');
    var sbModificar = document.getElementById('modelSueldoBasicoModificar');
    var flModificar = document.getElementById('formaLaboralModificar');

    descripcionModificar.value = descripcion;
    sbModificar.value = sueldoBasico; 
    flModificar.selectedIndex = formaLaboral;
}

function modificarCategoria()
{
    var descripcionModificar = document.getElementById('modelDescripcionModificar');
    var sbModificar = document.getElementById('modelSueldoBasicoModificar');
    var flModificar = document.getElementById('formaLaboralModificar');
    
    const data = new FormData();
    data.append('modificarCategoria', 'true');
    data.append('idcategoria', categoriaGlobal);
    data.append('descripcion', descripcionModificar.value);
    data.append('sueldobasico', sbModificar.value);
    data.append('formaLaboral', flModificar.value);

   
    fetch('../controller/categoriaController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(data => {
        if(data)
        {
            alert('Se modifico la categoria satisfactoriamente');
            cargarTablaCategoria();
        }
    });
}