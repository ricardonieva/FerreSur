<?php
require_once ('../model/UsuarioClass.php');
Usuario::verificarSesion(26);
require_once ('../view/cabecera.php');
$idCompra = (int) $_GET['idcompra'];
?>
<br><br>
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-3">
        <img src="../view/images/logoferresur.png" class="rounded float-left logo" alt="">
        
        </div>
        <div class="col-md-3">
            <p style="line-height:5px;" class="mt-3">Ferre-Sur S.R.L.</p>
            <p style="line-height:5px;">Vélez Sársfield 854</p>
            <p style="line-height:5px;">Aguilares</p>
            <p style="line-height:5px;">CUIT N° 34-99903208-9 </p>
        </div>

        <div class="col-md-2">
            <h6 class="mt-2">Factura De Compra</h6>
            <h6 id="numeroDeCompra"></h6>
            <h6 id="fechaDeCompra"></h6>
        </div>
    </div>

    <div class="row justify-content-center mt-2">
        <div class="col-md-8">
            <strong>Proveedor</strong>
            <ul class="list-group" id="listaProveedor">
             
            </ul>
          
        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>codigo</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Costo Unitario</th>
                        <th>Subtotal</th>

                    </tr>
                </thead>
                <tbody id="tablaCompra">
                  
                </tbody>

            </table>

        </div>          

    </div>

    <div class="row justify-content-center">
        <div class="col-md-4"></div>
        <div class="col-md-2">
            <h5 class="text-right mt-3">Total $</h5>
        </div>
        <div class="col-md-2">
            <div class="alert alert-primary text-center" role="alert" id="totalCompra">
                
            </div>
        </div>
    </div>

    <div class="eliminarImprimir">
        <div class="d-flex justify-content-center">
                <button class="btn btn-primary" onclick="window.print();">Imprirmir</button>
        </div>

        <div class="d-flex justify-content-center mt-3">
            <a class="btn btn-primary" href="../view/menuProveedores_view.php">Volver</a>
        </div>
    </div>
</div>

<?php
require_once ('../view/pie5.php');
?>

<script type="text/javascript">
var compra = <?php echo $idCompra; ?>;

document.title = "Orden de Compra N° "+compra;

window.addEventListener('load', cargarDatosDeLquidacion);

function cargarDatosDeLquidacion(idCompra){

    const data = new FormData();
    data.append('buscarCompra', 'true');
    data.append('idCompra', compra);

    fetch('../controller/CompraInformeController.php',{
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        //alert(data);
        document.getElementById('numeroDeCompra').innerHTML = `N° ${data.compra.idcompra}`;
        document.getElementById('fechaDeCompra').innerHTML = `${formato(data.compra.fecha)}`;

        document.getElementById('listaProveedor').innerHTML = `
        <li>Nombre: ${data.proveedor.razonSocial}</li>
        <li>Email: ${data.proveedor.email}</li>
        <li>Telefono: ${data.proveedor.telefono}</li>
        <li>Direccion: ${data.proveedor.direccion} </li>
        `;

        var total = 0;
        for(let item of data.detalleDeCompra){
            var subtotal = item.articulo_costounitario * item.unidades;
            total = total + subtotal;
            document.getElementById('tablaCompra').innerHTML += `
            <tr>
                <td>${item.idarticulo}</td>
                <td>${item.nombre}</td>
                <td>${item.unidades}</td>
                <td>${item.articulo_costounitario}</td>
                <td>${subtotal}</td>               
            </tr>
            `;
        }

        document.getElementById('totalCompra').innerHTML = total;
    })

}




function botonImprimir(){
   
    window.print();
}
////////////////////////////da formato a la fecha
function formato(texto){
  return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
}
//////////////////////////////////
</script>