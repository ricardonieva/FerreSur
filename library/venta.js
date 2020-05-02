/////////////////////boton buscar articulo
buscarArticulo.addEventListener('click',iniciar,true);
var connect;
var datos;
var total = 0;

function iniciar(e)
{
    e.preventDefault();
    var codigoArt = document.getElementById('Articulo');    
    console.log(codigoArt.value);

    connect = new XMLHttpRequest();
    connect.onreadystatechange = mostrarArticulo;
    connect.open('POST','../controller/VentasController.php',true);
    connect.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    connect.send('Articulo='+codigoArt.value+'&buscarArticulo=true');
}

function mostrarArticulo()
{
    var codigo = document.getElementById('codigo');    
    var nombre = document.getElementById('nombre');
    var precio = document.getElementById('precio');
    var stock = document.getElementById('stock');
    var descripcion = document.getElementById('descripcion');

    if(connect.readyState == 4 ){
        //console.log(connect.responseText);
        datos = JSON.parse(connect.responseText);
        if(datos.codigo != false)
        {
            codigo.innerHTML = datos.codigo;
            nombre.innerHTML = datos.nombre;
            precio.innerHTML = datos.precio;
            stock.innerHTML = datos.stock;
            descripcion.innerHTML = datos.descripcion;
        }
        else
        {
            alert("No se encuentra el articulo");
        }
      

    }
    else
    {
    }

}
/////////////////////agregar articulo
agregarArticulo.addEventListener('click', validarStock,true);

function validarStock(e)
{
    e.preventDefault();
    var cantidad = parseInt(document.getElementById('cantidad').value, 10);

    if(cantidad > parseInt(datos.stock, 10))
    {      
        alert('No hay stock suficiente');
    }
    else
    {
        ajaxDeAgregar(cantidad);
    }
    
}

function ajaxDeAgregar(cantidad){
    connect = new XMLHttpRequest();
    connect.onreadystatechange = function()
    {
        if(connect.readyState == 4 )
        {            
            //console.log(connect.responseText);
            data = JSON.parse(connect.responseText);

            var mostrartotal = document.getElementById('total');
            var respuesta = document.getElementById('res');

            respuesta.innerHTML = ``;   

            var total = 0;
            for(let item of data)
            {
                respuesta.innerHTML += `
                <tr>
                    <td>${item.id}</td>
                    <td>${item.nombre}</td>
                    <td>${item.cantidad}</td>
                    <td>${item.precio}</td>
                    <td>${item.precio * item.cantidad}</td>
                    <td><button type="button" class="btn btn-danger" onclick="quitarArticulo(${item.id})">Quitar</button></td>
                </tr>
                `;
                total = total + item.precio * item.cantidad;
            }  
            mostrartotal.innerHTML = "Total: "+total;    
        
        }else
        {
        }
    };
    connect.open('POST','../controller/VentasController.php',true);
    connect.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    //console.log('cantidad='+cantidad+'&agregarArticulo=true'+'&subtotal='+subtotal);
    connect.send('cantidad='+cantidad+'&agregarArticulo=true');
}

/////////////////////////////////boton buscar cliente
buscarCliente.addEventListener('click', buscarClienteASD, true);

function buscarClienteASD(e){
    e.preventDefault();
    var cliente = document.getElementById('dni').value;
    console.log(cliente);
    var mostrarCliente = document.getElementById('mostrarCliente');
    var datosCliente;
    connect = new XMLHttpRequest();
    connect.onreadystatechange = function()
    {
        if(connect.readyState == 4 )
        {
            //console.log(connect.responseText);  

                if(connect.responseText == 'false'){
                    alert('El cliente no esta registrado');
                }
            datosCliente = JSON.parse(connect.responseText);
            if(datosCliente.nombre != false)
            {
                mostrarCliente.innerHTML = `
                <div class="alert alert-info" role="alert">
                ${datosCliente.nombre} ${datosCliente.apellido}
                </div>
                `;     
            }
            else
            {
                alert("No se encuentra el cliente");
            }
           
        }
        else
        {
        
        }
    }
    connect.open('POST','../controller/VentasController.php',true);
    connect.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    connect.send('dni='+cliente+'&mostrarCliente=true');
}

/////////////////////boton finalizar
finalizar.addEventListener('click', finalizarventa, true);

function finalizarventa(e){
    e.preventDefault();
    var tipodepago = document.getElementById('tipopago').value;
    //alert('se apreto finalizar');

    connect = new XMLHttpRequest();
    connect.onreadystatechange = function()
    {
        if(connect.readyState == 4 )
        {
            console.log('asd'+connect.responseText);
            
                if(connect.responseText)
                {
                    alert('La venta se completo exitosamente');
                    //window.print()                    
                    //location.reload();
                    mostrarFacturaDeVenta();    
                }
                else
                {
                    alert('Error al Procesar la Venta');   
                }
        }
        else
        {
        }
    }
    connect.open('POST','../controller/VentasController.php',true);
    connect.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    connect.send('finalizar=true&tipodepago='+tipodepago);
}

//////////////////////////
function mostrarFacturaDeVenta(){

    const data = new FormData();

    data.append('ultimaVenta', 'true');

    fetch('../controller/VentasController.php',{
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        location.href='../view/ventafactura_view.php?ventaid='+data;    
    })

}

////////////////////////////buscarArticulo por nombre
botonBuscar.addEventListener('click', buscarNombreArticulo, true);

function buscarNombreArticulo(e)
{
    e.preventDefault();

    var mostrarTabla = document.getElementById('tabla');
    var nombreArticulo = document.getElementById('nombrearticulo').value;
    document.getElementById('nombrearticulo').value= "";

    mostrarTabla.innerHTML = ``;
    console.log(nombreArticulo);
    const datos = new FormData();
    datos.append('buscarNombre','true');
    datos.append('nombre',nombreArticulo);
    fetch('../controller/CompraController.php',{
    method: 'POST',
    body: datos
    })
    .then(res => res.json())
    .then(data => {
    console.log('los datos: '+data);

    for(let item of data){
        mostrarTabla.innerHTML += `
        <tr>
        <td onclick="ponerIdEnElImput(${item.idarticulo})">${item.idarticulo}</td>
        <td onclick="ponerIdEnElImput(${item.idarticulo})">${item.nombre}</td>
        <tr>
        `; 
    }
    
    });

}
/////////////////////////pega en el input el id seleccionado
var idprodu = document.getElementById('Articulo');
function ponerIdEnElImput(idprove){
    idprodu.value = idprove;
    $('#exampleModalCenter').modal('hide')
}
////////////////////////boton quitar articulo

function quitarArticulo(idarticulo){

    var r = confirm('Desea eliminar este articulo?');
    if(r){

        const data = new FormData();
        data.append('btnQuitarArticulo', 'true');
        data.append('idarticulo', idarticulo);

        fetch('../controller/VentasController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
        if(data)
        {
            var mostrartotal = document.getElementById('total');
            var respuesta = document.getElementById('res');

            respuesta.innerHTML = ``;   

            var total = 0;
            for(let item of data)
            {
                respuesta.innerHTML += `
                <tr>
                    <td>${item.id}</td>
                    <td>${item.nombre}</td>
                    <td>${item.cantidad}</td>
                    <td>${item.precio}</td>
                    <td>${item.precio * item.cantidad}</td>
                    <td><button type="button" class="btn btn-danger" onclick="quitarArticulo(${item.id})">Quitar</button></td>
                </tr>
                `;
                total = total + item.precio * item.cantidad;
            }  
            mostrartotal.innerHTML = "Total: "+total;    
            //alert('La liquidacion se elimino satisfactoriamente');
        }
        else
        {
            alert('Error al quitar articulo');
        }
    })
    }
}
