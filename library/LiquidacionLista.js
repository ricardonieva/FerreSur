botonBuscar.addEventListener('click', cargarLiquidaciones);

    function cargarLiquidaciones(){
    //e.preventDefault();

    var fDesde = document.getElementById('fechaDesde').value;
    var fHasta = document.getElementById('fechaHasta').value;

    const data = new FormData();
    data.append('mostrarLiquidaciones', 'true');
    data.append('fechaDesde', fDesde);
    data.append('fechaHasta', fHasta);

    try{
        fetch('http://localhost/ferresur/controller/LiquidacionInformeController.php', {
            method: 'POST',
            body: data
        })
        .then(res => res.json())
        .then(data => {
            var tabla = document.getElementById('tablaLiquidacion');
            tabla.innerHTML = ``;
            if(data != false){
                for(let item of data){
                    tabla.innerHTML += `
                        <tr>
                            <td id="idDataLiqui">${item.idliquidacion}</td>
                            <td>${formato(item.fechaliquidacion)}</td>
                            <td>${item.periodo}</td>
                            <td>${formato(item.fechadecobro)}</td>
                            <td>${item.tipo}</td>
                            <td>${item.nombre}, ${item.apellido}</td>
                            <td>${item.cuil}</td>
                            <td><button class="btn btn-info form-control" id="botonVer" onclick="verLiquidacion(${item.idliquidacion});">Ver</button></td>
                            <td><button class="btn btn-success form-control" id="botonModificar" onclick="modificarLiquidacion(${item.idliquidacion}, '${item.fechaliquidacion}', '${item.tipo}', '${item.nombre}', '${item.apellido}');">Modificar</button></td>
                            <td><button class="btn btn-danger form-control" onclick="eliminarLiquidacion(${item.idliquidacion});">Eliminar</button></td>
                        </tr>
                    `;
                }
           
            }
            else{
                alert('No se encontraron Liquidaciones de Sueldo entre esas fechas');
            }
        })
    }catch(error)
    {
        alert(error);
    }
}

////////////////////////////da formato a la fecha
function formato(texto){
  return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
}

///////////////////////////////boton ver para mostrar la liquidacion

function verLiquidacion(idliquidacion){
    window.open("http://localhost/ferresur/view/LiquidacionInforme_view.php?liquidacionid="+idliquidacion);
}

///////////////////eliminar liquidacion

function eliminarLiquidacion(idliquidacion){

    var r = confirm('Desea eliminar esta Liquidacion?');
    if(r){

        const data = new FormData();
        data.append('aliminarLiquidacion', 'true');
        data.append('idLiquidacion', idliquidacion);

        fetch('../controller/LiquidacionInformeController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(data => {
        if(data){
            alert('La liquidacion se elimino satisfactoriamente');
            cargarLiquidaciones();
        }else{
            alert('Error al eliminar liquidacion');
        }
    })
    }
}

////////////////////////////modificarLiquidacion
var liquidacion_concepto = [];
var idliquidacionGlobal;
var title = document.getElementById('exampleModalLabel');
var fechaCobroModal = document.getElementById('fechaCobroModal');  
var tipoModal = document.getElementById('tipoModal');
var modalSelectConcepto = document.getElementById('modalSelectConcepto');
var modalTablaConcepto = document.getElementById('modalTablaConcepto');

function modificarLiquidacion(idliquidacion, fecha, tipo, nombre, apellido){

    $('#exampleModal').modal('show');
    idliquidacionGlobal = idliquidacion;

    title.innerHTML = nombre+", "+apellido;
    fechaCobroModal.value = fecha;  
    tipoModal.value = tipo;
    modalSelectConcepto.innerHTML = ``;
    modalTablaConcepto.innerHTML = ``;

    cargarDatos();

}

//////////////////

function cargarDatos()
{
    const data = new FormData();
    data.append('liquidacionInformeYConceptos', 'true');
    data.append('idliquidacion', idliquidacionGlobal);

    fetch('http://localhost/ferresur/controller/LiquidacionInformeController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        for(let item of data['conceptos'])
        {
            modalSelectConcepto.innerHTML += `
            <option value="${item.idconcepto}">${item.detalle} - ${item.percepcionSalarial}</option>
            `;
        }

        for(let item of data['liquidacion'])
        {
            modalTablaConcepto.innerHTML += `
            <tr>
                <th>${item.idconcepto}</th>
                <td>${item.detalle}</td>
                <td>${item.tipoConcepto}</td>
                <td>${item.valor}</td>            
                <td>${item.tipo}</td>
                <td>${item.percepcionSalarial}</td>
                <td><button class="btn btn-danger" onclick="quitarConcepto(${item.idliquidacion_concepto});">Quitar</button></td>
            </tr>
            `;
        }

    });
}
/////////////////////// eliminar concepto

function quitarConcepto(codigo){
    var r = confirm('Desea eliminar este concepto de la liquidacion?');
    if(r)
    {
        const data = new FormData();
        data.append('eliminarConceptoDeLiquidacion', 'true');
        data.append('idLiqConcepto', codigo);

        fetch('http://localhost/ferresur/controller/LiquidacionInformeController.php', {
            method: 'POST',
            body: data
        })
        .then(res => res.json())
        .then(data => {
        if(data)
        {
            alert('Se elimino el concepto');
        }
        cargarDatos()
        });
    }
    
}
////////////////////////


function botonAgregarConcepto(){
    var concepto = document.getElementById('modalSelectConcepto').value;
    
    const data = new FormData();
    data.append('agregarConcepto', 'true');
    data.append('idconcepto', concepto);
    data.append('idliquidacion', idliquidacionGlobal);

    fetch('http://localhost/ferresur/controller/LiquidacionInformeController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
    if(data)
    {
        alert('Se cargo el concepto');
    }
    cargarDatos()
    });
    
}


