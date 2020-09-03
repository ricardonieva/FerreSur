
////////////buscar proveedor    
var id = document.getElementById('id');

buscarPorID.addEventListener('click', function(e){

    e.preventDefault();    

    const data = new FormData()
    data.append('buscarProveedor', 'true');
    data.append('idProveedor', id.value);
    fetch('../controller/CompraController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        var dato1 = document.getElementById('dataNombre');
        dato1.innerHTML = `${data.razonSocial}`;

        var dato2 = document.getElementById('dataMail');
        dato2.innerHTML = `${data.email}`;
    });    

});
////////////////////////////buscarArticulo por nombre
botonBuscar.addEventListener('click', buscarNombreArticulo, true);

function buscarNombreArticulo(e){
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
  //console.log('los datos: '+data);

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
var idprodu = document.getElementById('buscarId');
function ponerIdEnElImput(idprove){
    idprodu.value = idprove;
    $('#exampleModalCenter').modal('hide')
}

////////////////////////busca articulo por ID
buscarArticulo.addEventListener('click', buscarCodigoArticulo, true);
var codigoArticulo;
var articulo;

function buscarCodigoArticulo(e){
    e.preventDefault();
    var mostrarDatosArticulo = document.getElementById('datosDeArticulo');

    codigoArticulo = document.getElementById('buscarId').value;

    const datos = new FormData();
    datos.append('buscarCodigo', 'true');
    datos.append('idArtidculo', codigoArticulo);
    fetch('../controller/CompraController.php',
    {
        method: 'POST',
        body: datos
        })
        .then(res => res.json())
        .then(data => {
        //console.log(data);
        if(data.articulo == false)
        {
            alert('No se encontro el articulo');
        }
        else
        {
            articulo = data;
            mostrarDatosArticulo.innerHTML = `
            <table class="table">
            <thead>
                <tr>
                <th scope="col">Codigo</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Costo Unitario</th>
                <th scope="col">Stock</th>
                <th scope="col">Stock Minimo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td id="codigo">${data.codigo}</td>
                <td>${data.nombre}</td>
                <td>${data.descripcion}</td>
                <td>${data.costoUnitario}</td>
                <td>${data.stock}</td>
                <td>${data.stockminimo}</td>
                </tr>    
            </tbody>
            </table>
            `;
    
        }
      

    });
}

//////// 
function iterarTabla(detalle) {
  var tabla = document.getElementById('tablaArticulo');
  var total = 0;
  tabla.innerHTML = ``;
  for(let item of detalle) {
    var subtotal = item.costoUnitario * item.cantidad;
    total = total + subtotal;
    tabla.innerHTML += `
    <tr>
      <td>${item.codigo}</td>
      <td>${item.nombre}</td>
      <td>${item.costoUnitario}</td>
      <td>${item.cantidad}</td>
      <td>${subtotal}</td>
      <td><button class='btn btn-danger' onclick='eliminarArticulo(${item.codigo})'>Eliminar</button></td>
    </tr>    
    `;
  }
  document.getElementById('divtotal').innerHTML = `
  <div class="alert alert-primary" role="alert" id="total">
    Total: $ ${total}
  </div>
  `;

}

///// eliminar articulo de la lista
function eliminarArticulo(idarticulo) {
    const data = new FormData();
    data.append('eliminarArticulo', 'true');
    data.append('idarticulo', idarticulo);

    fetch('../controller/CompraController.php',{
      method: 'POST',
      body: data
    })
    .then(res => res.json())
    .then(data => {
        //console.log(data);
        iterarTabla(data);
    });
}

//////////////////////// botom agregar articulo
var total = 0;
agregarArticulo.addEventListener('click', function(e) {
    e.preventDefault();
    var cantidadinput = document.getElementById('cantidad');
    var precioinput = document.getElementById('precio');
    var subtotal = cantidadinput.value * precioinput.value;
    total = total + subtotal;     

    const data = new FormData();
    data.append('agregarArticulo', 'true');
    data.append('idarticulo', articulo.codigo);
    data.append('unidades', cantidadinput.value);
    data.append('costoUnitario', precioinput.value);    
    data.append('nombre', articulo.nombre); 

    fetch('../controller/CompraController.php',{
      method: 'POST',
      body: data
    })
    .then(res => res.json())
    .then(data => {
        iterarTabla(data);
    });
        
    });
//////////////////////finalizar compra proveedores
finalizarCompra.addEventListener('click', function(e){  
  e.preventDefault();
  
  var r = confirm('Finalizar Compra?');
  if(r == true){

    const data = new FormData();
    data.append('finalizarCompra', 'true');
    data.append('idproveedor', id.value);
    data.append('numeroFactura', document.getElementById('numeroFactura').value);
    data.append('fechaFactura', document.getElementById('fechaFactura').value);
    
    fetch('../controller/CompraController.php',{
      method: 'POST',
      body: data
    })
    .then(res => res.json())
    .then(data => {

      console.log(data);
      if(data.compra != false){
        alert("Se Compelto la Venta Satisfactioriamente")
        window.location.href = '../view/CompraInforme_view.php?idcompra='+data.compra;
      }
      else
      {
        alert("Error al completar la Venta")
      }
      ;
    })
}
});

////////////////////////////////// verfica que razon social no este vacia

function verificarRazonSocial(){
  var razon = document.getElementById('dataNombre').innerHTML;
 
      alert('Debe Seleccionar un Proveedor: '+id.value);
    
  
}
      
//////////////////////////////busca proveedor por razon social
buscarPorRazonSocial.addEventListener('click', buscarProveedorPorRazonSocial);

function buscarProveedorPorRazonSocial(e){
  e.preventDefault();

  var razon = document.getElementById('modalRazonsocial').value;
  var tablaPro = document.getElementById('tablaProveedor');
  tablaPro.innerHTML = ``;

  const data = new FormData();
  data.append('buscarPorRazonSocial', 'true');
  data.append('razonSocial', razon);

  fetch('../controller/CompraController.php', {
    method: 'POST',
    body: data
  })
  .then(res => res.json())
  .then(data => {
     
      for(let item of data){
        tablaPro.innerHTML +=`
        <tr>
          <td onclick="ponerIdEnElImputProveedor(${item.idproveedor})">${item.idproveedor}</td>
          <td onclick="ponerIdEnElImputProveedor(${item.idproveedor})">${item.razonSocial}</td>
        </tr>
        `;
      }
    
      
  })

}

/////////////////////////pega en el input de razon social en el id seleccionado de proveedor
var idprovee = document.getElementById('id');
function ponerIdEnElImputProveedor(provedorID){
    idprovee.value = provedorID;
    $('#exampleModal').modal('hide')
}
////////////////////////
