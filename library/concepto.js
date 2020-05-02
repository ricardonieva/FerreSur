window.addEventListener('load', cargarConceptos);

function cargarConceptos(){

    const data = new FormData();
    data.append('cargarConceptos', 'true');

    fetch('../controller/conceptoController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {

        var tablaConcepto = document.getElementById('tablaConcepto');
        tablaConcepto.innerHTML = ``;

        for(let item of data)
        {
            tablaConcepto.innerHTML += `
                <tr>
                    <td>${item.tipoConcepto}</td>
                    <td>${item.detalle}</td>
                    <td>${item.percepcionSalarial}</td>
                    <td>${item.tipo}</td>
                    <td>${item.valor}</td>
                    <td><button class="btn btn-info" onclick="abrirModalModificarConcepto(${item.idconcepto},'${item.tipoConcepto}', '${item.detalle}', '${item.percepcionSalarial}', '${item.tipo}', ${item.valor});">Modificar</button></td>
                    <td><button class="btn btn-danger" onclick="eliminarConcepto(${item.idconcepto});">Eliminar</button></td>
                </tr>
            `;
        }
    });
}

/////////////////////////////////nuevo concepto

function nuevoConcepto(){
    var concep = document.getElementById('tipoconcepto');
    var deta = document.getElementById('detalle');
    var percep = document.getElementById('percepcionSalarial');
    var tip = document.getElementById('tipo');
    var val = document.getElementById('valor');

    const data = new FormData();
    data.append('nuevoConcepto', 'true');
    data.append('tipoconcepto', concep.value);    
    data.append('detalle', deta.value);
    data.append('percepcionSalarial', percep.value);
    data.append('tipo', tip.value);
    data.append('valor', val.value);

    fetch('../controller/conceptoController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        alert(data);
        if(data)
        {
            alert('Se cargo el concepto satisfactoriamente');
            cargarConceptos();
        }
        else
        {
            alert('Error al cargar el concepto');
        }
    });
}

///////////////////////////////boton eliminar

function eliminarConcepto(idconcepto){

    var r = confirm('Desea Eliminar Este Concepto?');
    if(r)
    {
        const data = new FormData();
        data.append('eliminarConcepto', 'true');
        data.append('idConcepto', idconcepto);

        fetch('../controller/conceptoController.php', {
            method: 'POST',
            body: data
        })
        .then(res => res.json())
        .then(data => {
            if(data)
            {
                alert('Se elimino el concepto satisfactoriamente');
                cargarConceptos();
            }
            else
            {
                alert('Error al eliminar el concepto');
            }
        });
    }    
}

//////////////boton que abre el modal de modificar
var auxidconcepto;
function abrirModalModificarConcepto(idconcepto, tipoConcepto, detalle, percepcionSalarial, tipo, valor){
    var concep = document.getElementById('tipoconceptoModificar');
    var deta = document.getElementById('detalleModificar');
    var percep = document.getElementById('percepcionSalarialModificar');
    var tip = document.getElementById('tipoModificar');
    var val = document.getElementById('valorModificar');

    auxidconcepto = idconcepto;
    concep.value = tipoConcepto;
    deta.value = detalle;
    percep.value = percepcionSalarial;
    tip.value = tipo;
    val.value = valor;

    $('#exampleModal2').modal('show')
}

///////////////////modificar Concepto

function modificarConcepto(){
    var concep = document.getElementById('tipoconceptoModificar');
    var deta = document.getElementById('detalleModificar');
    var percep = document.getElementById('percepcionSalarialModificar');
    var tip = document.getElementById('tipoModificar');
    var val = document.getElementById('valorModificar');
    
    const data = new FormData();
    data.append('modificarConcepto', 'true');
    data.append('idconcepto', auxidconcepto);
    data.append('tipoconcepto', concep.value);    
    data.append('detalle', deta.value);
    data.append('percepcionSalarial', percep.value);
    data.append('tipo', tip.value);
    data.append('valor', val.value);

    fetch('../controller/conceptoController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        if(data)
        {
            alert('Se modifico el concepto satisfactoriamente');
            cargarConceptos();
        }
        else
        {
            alert('Error al modificar el concepto');
        }
    });
}