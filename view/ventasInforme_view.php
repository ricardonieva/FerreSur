<?php
require_once ('../view/cabecera.php');
require_once ('../model/UsuarioClass.php');
Usuario::verificarSesion(18);
?>

<br><br><br><br>
<div class="container-fluid">
    <h5 class="text-center">Informe de Ventas</h5>
    <div class="row justify-content-center mt-3">
        <div class="col-md-3">
            Fecha Desde:
            <input type="date" class="form-control input-group" placeholder="Fecha Desde" id="fechadesde" name="fechadesde"> 
        </div>
        <div class="col-md-3">
            Fecha Hasta:
            <input type="date" class="form-control input-group" placeholder="Fecha Hasta" id="fechahasta" name="fechahasta">
        </div>   
        <div class="col-md-1 mt-4">
            <button class="btn btn-primary form-control" id="botonMostrar">Mostrar</button>
        </div>
        <div class="col-md-1 mt-4">
            <button class="btn btn-info form-control" id="btnIva">IVA Venta</button>
        </div>
        <div class="col-md-1 mt-4">
            <button class="btn btn-success form-control" id="btnGraficos">Graficos</button>
        </div>
    </div>           
 
    <div class="row justify-content-center mt-3">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>N°</th>                            
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Empleado</th>
                        <th>Estado</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tablaVenta">

                </tbody>

            </table>
        </div>
    </div>
</div>

<?php
require_once ('../view/pie4.php');
?>


<script>

botonMostrar.addEventListener('click', cargarVentas);

function cargarVentas(){

    var tablaVenta = document.getElementById('tablaVenta');
    tablaVenta.innerHTML = ``;

    var fechaDesde = document.getElementById('fechadesde').value;
    var fechaHasta = document.getElementById('fechahasta').value;



    const data = new FormData();
    data.append('buscarVentas', 'true');
    data.append('desde', fechaDesde);
    data.append('hasta', fechaHasta);

    fetch('../controller/ventasInformeController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        
        for(let item of data){
            tablaVenta.innerHTML += `
                <tr>
                    <td>${item.idventa}</td>
                    <td>${item.fechaHora}</td>
                    <td>${item.nombre}</td>
                    <td>${item.AP}</td>
                    <td>${item.estado}</td>
                    <td><button class="btn btn-info" onclick="mostrarFacturaDeVenta(${item.idventa});">Ver</button></td>
                    <td><button class="btn btn-warning" onclick="anularVenta(${item.idventa}, '${item.estado}');">Anular</button></td>
                    <td><button class="btn btn-danger" onclick="eliminarVenta(${item.idventa});">Eliminar</button></td>

                </tr>
            `;
        }
    });
}
////////////////////ver factura
function mostrarFacturaDeVenta(idventa){
    window.open("../view/ventafactura_view.php?ventaid="+idventa);
}
/////////////////////boton eliminar
function eliminarVenta(idventa){

    var r = confirm('Desea eliminar esta venta?');
    if(r){

        const data = new FormData();
        data.append('aliminarVenta', 'true');
        data.append('idventa', idventa);

        fetch('../controller/ventasInformeController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(data => {
        if(data){
            alert('La venta se elimino satisfactoriamente');
            cargarVentas();
        }else{
            alert('Error al eliminar la venta');
        }
    })
    }
}
////////////////////////boton anular

function anularVenta(idventa, estado){
    if(estado == 'Finalizado'){
        var r = confirm('Desea anular esta venta?');
        if(r){

            const data = new FormData();
            data.append('anularVenta', 'true');
            data.append('idventa', idventa);

            fetch('../controller/ventasInformeController.php', {
            method: 'POST',
            body: data
        })
        .then(res => res.text())
        .then(data => {
            if(data){
                alert('La venta se anulo satisfactoriamente');
                cargarVentas();
            }else{
                alert('Error al anular la venta');
            }
        })
        }
    }
    else{
        alert('La venta ya esta anulada');
    }    
}

///////

    btnIva.addEventListener('click', function() {
        var fechaDesde = document.getElementById('fechadesde').value;
        var fechaHasta = document.getElementById('fechahasta').value;
        window.open( '../view/ventaLibroIva.php?fechadesde='+fechaDesde+'&fechahasta='+fechaHasta);
    });

////
    btnGraficos.addEventListener('click', function() {
        var fechaDesde = document.getElementById('fechadesde').value;
        var fechaHasta = document.getElementById('fechahasta').value;
        window.open( '../view/ventaGrafico.php?fechadesde='+fechaDesde+'&fechahasta='+fechaHasta);
    });
</script>