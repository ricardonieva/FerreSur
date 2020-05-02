<?php
require_once ('../view/cabecera.php');
require_once ('../model/UsuarioClass.php');
usuario::verificarSesion(2);
$idVenta = (int) $_GET['ventaid'];
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
            <h5 class="mt-2">Factura C</h5>
            <h5 id="numeroDeRecibo"></h5>
            <h6 id="fechaDeRecibo"></h6>
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
                        <th>Precio</th>
                        <th>Subtotal</th>

                    </tr>
                </thead>
                <tbody id="tablaLinea">
                  
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
            <div class="alert alert-primary text-center" role="alert" id="total">
              
            </div>
        </div>
    </div>

    <div class="eliminarImprimir">
        <div class="d-flex justify-content-center">        
            <button class="btn btn-primary" onclick="botonImprimir()">Imprirmir</button>
        </div>

        <div class="d-flex justify-content-center mt-3">
            <a class="btn btn-primary" href="../view/ventas_view.php">Volver</a>
        </div>
    </div>
    

</div>

<?php
require_once ('../view/pie4.php');
?>

<script>
 document.title = "Factura N° "+ <?php echo $idVenta; ?>;
function botonImprimir(){   
    window.print();
}

////////////////////////////da formato a la fecha
function formato(texto){
  return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
}
////////////////////////////

window.addEventListener('load', function(){
    
    var tabla = document.getElementById('tablaLinea');    
    
    const data = new FormData();
    data.append('buscarVenta', 'true');
    data.append('idVenta', <?php echo $idVenta; ?>);
    fetch('../controller/ventaFacturaController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        //alert(data);
        document.getElementById('numeroDeRecibo').innerHTML = `N° ${data[0].idventa}`;
        document.getElementById('fechaDeRecibo').innerHTML = `${formato(data[0].fecha)}`;
        var total = 0;
        for(let item of data)
        {
            tabla.innerHTML += `
                <tr>
                    <td>${item.idarticulo}</td>
                    <td>${item.nombre}</td>    
                    <td>${item.cantidad}</td>  
                    <td>${new Intl.NumberFormat("de-DE").format(item.precioVenta)}</td>  
                    <td>${new Intl.NumberFormat("de-DE").format(item.precioVenta * item.cantidad)}</td>
                </tr>
            `;
            total = total + (item.precioVenta * item.cantidad);
        }

        document.getElementById('total').innerHTML = new Intl.NumberFormat("de-DE").format(total);

    })
});

</script>