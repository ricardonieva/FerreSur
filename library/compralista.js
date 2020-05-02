botonMostrar.addEventListener('click', cargarCompras);

function cargarCompras()
{

    var tablaVenta = document.getElementById('tablaCompra');
    tablaVenta.innerHTML = ``;
    var fechaDesde = document.getElementById('fechadesde').value;
    var fechaHasta = document.getElementById('fechahasta').value;
    const data = new FormData();
    data.append('buscarCompra', 'true');
    data.append('desde', fechaDesde);
    data.append('hasta', fechaHasta);

    fetch('../controller/compraListaController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        
        for(let item of data){
            tablaVenta.innerHTML += `
                <tr>
                    <td>${item.idcompra}</td>
                    <td>${item.fecha}</td>
                    <td>${item.nombre}, ${item.apellido}</td>
                    <td>${item.razonSocial}</td>
                    <td>${item.estado}</td>
                    <td><button class="btn btn-info" onclick="mostrarFacturaCompra(${item.idcompra});">Ver</button></td>
                    <td><button class="btn btn-warning" onclick="cambiarEstadoDeCompra(${item.idcompra});">Finalizar</button></td>
                    <td><button class="btn btn-success" onclick="modificarCompra(${item.idcompra});">Modificar</button></td>
                    <td><button class="btn btn-danger" onclick="eliminarCompra(${item.idcompra});">Eliminar</button></td>
                </tr>
            `;
        }
    });
}

//////////cambia el estado de la compra de "en proceso" a "Finalizado" y carga el stock de los prodcutos de la compra
function cambiarEstadoDeCompra(idcompra)
{
    var r = confirm("Desea Finalizar esta compra?");
    if(r == true){

        const data = new FormData();
        data.append('finalizarEstadoCompra', 'true');
        data.append('idcompra', idcompra);

        fetch('../controller/compraListaController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        if(data.compra == true){
            alert('La compra finalizo satisfactoriamente');
            cargarCompras();
        }else{  
            alert('Error al finalizar y cargar los productos de la compra');
        }
    })
    }
}

////////////////////ver factura de compra
function mostrarFacturaCompra(idcompra)
{
    window.open("../view/compraInforme_view.php?idcompra="+idcompra);
}
/////////////////////boton eliminar
function eliminarCompra(idcompra){

    var r = confirm("Desea eliminar esta compra?");
    if(r == true){

        const data = new FormData();
        data.append('aliminarCompra', 'true');
        data.append('idCompra', idcompra);

        fetch('../controller/compraListaController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {

        //console.log(data);
        if(data.compra == true){
            alert('La compra se elimino satisfactoriamente');
            cargarCompras();
        }
        else
        {  
            alert('Error al eliminar la compra');
        }
    })
    }
}
//////////////////////// boton modificar compra
var detalle = [];
var tabla = document.getElementById('tablaDetalleCompra');
var idcompraGlobal;
function modificarCompra(idcompra){
    idcompraGlobal = idcompra;
    tabla.innerHTML = ``;
    detalle = [];

    const data = new FormData();
    data.append('buscarCompraCompleta', 'true');
    data.append('idcompra', idcompra);

    fetch('../controller/compraListaController.php', {
    method: 'POST',
    body: data
    })
    .then(res => res.json())
    .then(data => {

        $('#exampleModal').modal('show');

        for(let item of data){
            var detalle_compra = {codigo:item.idarticulo, nombre:item.articulo_nombre, unidades:item.unidades, costounitario:item.articulo_costounitario};
            detalle.push(detalle_compra);
        }
        iterarArrayDeArticulo(detalle);
        document.getElementById('tablaArticulo').innerHTML = ``;
        
    }) 
      
}
//////////////////////////////

function iterarArrayDeArticulo(detalle){
         var total = 0;
         tabla.innerHTML = ``;
        for(let item of detalle){            
            var subtotal = item.unidades * item.costounitario;
            total = total + subtotal;
            tabla.innerHTML += `
            <tr>
                <td>${item.codigo}</td>
                <td>${item.nombre}</td>
                <td>${item.unidades}</td>                
                <td>${item.costounitario}</td>
                <td>${subtotal}</td>
                <td><button type="button" class="btn btn-danger" onclick="quitarArticuloDeCompra(${item.codigo})">Quitar</button></td>
            </tr>
            `;
        }
        document.getElementById('totalCompra').innerHTML = total;
}

//////////////////////////////

function quitarArticuloDeCompra(codigo){
    
    for(var i =0; i< detalle.length; i++){
        if(detalle[i].codigo == codigo){
            detalle.splice(i, 1);
        }
    }
    iterarArrayDeArticulo(detalle);
}

////////////////////////////


///////////////////////buscar articulo
function buscarArticulo(){
    var id = document.getElementById('buscarIdArticulo').value;
    var tablaArticulo = document.getElementById('tablaArticulo');
    tablaArticulo.innerHTML = ``;

    const datos = new FormData();
    datos.append('buscarCodigo', 'true');
    datos.append('idArtidculo', id);
    fetch('../controller/CompraController.php',{
    method: 'POST',
    body: datos
    })
    .then(res => res.json())
    .then(data => {
        //alert('datos: '+data.nombre);
        tablaArticulo.innerHTML +=`
            <tr>
                <td>${data.codigo}</td>
                <td>${data.nombre}</td>
                <td>${data.descripcion}</td>
                <td>${data.costoUnitario}</td>
                <td><input type="text" class="form-control" placeholder="Cantidad" id="cantidad" size="5"></td>
                <td><button class="btn btn-primary" id="agregarArticulo" onclick="botonAgregarArticulo(${data.codigo}, '${data.nombre}', ${data.costoUnitario});">Agregar</button></td>
            </tr>
        `;
    });
}
//////////////////////////agregar articulo con la cantidad

function botonAgregarArticulo(codigoArt, nombre, costounitario){
    var cantidad = document.getElementById('cantidad').value;
    var long = detalle.length;
    for(var i=0; i < long; i++)
    {
        if(detalle[i].codigo == codigoArt)
        {           
            detalle[i].unidades = parseFloat(detalle[i].unidades) + parseFloat(cantidad);
            break;
        }
        else
        {   
            if(i == long-1)
            {
                var detalle_compra = {codigo:codigoArt, nombre:nombre, unidades:cantidad, costounitario:costounitario};
                detalle.push(detalle_compra);            
            }
          
        }        
    }
    iterarArrayDeArticulo(detalle);  
}

////////////////////////////boton guardar Cambios

function guardarCambios(){

    var r = confirm('Desea modificar la compra?');

    if(r == true){
        const data = new FormData();
        data.append('guardarCambios', 'true');
        var datos = JSON.stringify(detalle);
        data.append('detalleCompra', datos);
        data.append('idcompra', idcompraGlobal);
        fetch('../controller/compraListaController.php',{
        method: 'POST',
        // contentType: 'application/json; charset=utf-8',
        body: data
        })
        .then(res => res.text())
        .then(data => {                     
            if(data){
                alert('La compra se modifico satisfactoriamente');
            }           
        });
    }
}