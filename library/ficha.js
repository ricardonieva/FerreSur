var tablaFicha = document.getElementById('tablaFicha');

window.addEventListener('load', cargarFichas)

function cargarFichas(){
    tablaFicha.innerHTML = ``;
    const data = new FormData();

    data.append('cargarFichas', 'true');
    fetch('../controller/fichaController.php',{
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        for(let item of data){
            tablaFicha.innerHTML += `
            <tr>
                <th>${item.idficha}</th>
                <td>${item.cantidad}</td>
                <td>${item.fecha}</td>
                <td>${item.empleado_idEmpleado}</td>
                <td><button class="btn btn-info form-control"   onclick="botonModificarFicha(${item.idficha},${item.cantidad},'${item.fecha}',${item.empleado_idEmpleado});">Modificar</button></td>
                <td><button class="btn btn-danger form-control"  onclick="eliminarFicha(${item.idficha});">Eliminar</button></td>
            </tr>
            `;
        }
    })
}

//*************Nueva ficha */

function nuevaFicha(){

    var emplead = document.getElementById('idempleado');
    var cantida = document.getElementById('cantidadFicha');
    var fech = document.getElementById('fecha');

    const data = new FormData();
    data.append('nuevaFicha','true');
    data.append('empleado', emplead.value);
    data.append('cantidad',cantida.value);
    data.append('fecha',fech.value);

    fetch('../controller/fichaController.php',{
        method: 'POST',
        body: data
    })
    .then(res=> res.json())
    .then(data => {
        alert(data);
        if(data == true)
        {
            alert('Se cargo la ficha satisfactoriamente');            
        }
        else
        {
            alert('Error al cargar el concepto');
        }
    });



}
//************* end Nueva ficha */

// ************ Modificar ficha
modificarFicha.addEventListener('click', modificarFichaBD);

function modificarFichaBD(){

    var idempleado = document.getElementById('idempleadoModificar');
    var cantidad = document.getElementById('cantidadFichaModificar');
    var fecha = document.getElementById('fechaModificar');

    const data = new FormData();
    data.append('modificarFicha', true);
    data.append('idFicha', idFichaGlobal);
    data.append('cantidad', cantidad.value);
    data.append('fecha', fecha.value);
    data.append('idempleado',idempleado.value);
    
    fetch('../controller/fichaController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
       if(data == 1){
            alert("se cargo la ficha satisfactoriamente");
       }
       else{
            alert("Error al cargar la ficha");
       }
       cargarFichas();
       $('#exampleModal2').modal('hide');
    });
}
// ************ end Modificar ficha

var idFichaGlobal;
// boton modificar ficha

function botonModificarFicha(idficha, cantidad, fecha, idempleado){

    idFichaGlobal = idficha;

    $('#exampleModal2').modal('show');

    document.getElementById('idempleadoModificar').value = idempleado;
    document.getElementById('cantidadFichaModificar').value = cantidad;
    document.getElementById('fechaModificar').value = fecha;
    
    

}
// end boton modificar ficha

// ELIMINAR FICHA

function eliminarFicha(idficha){
    
    idFichaGlobal = idficha;
    var r = confirm('Desea Eliminar Esta ficha?');
    if(r)
    {
        const data = new FormData();
        data.append('eliminarFicha', 'true');
        data.append('idFicha', idficha);

        fetch('../controller/fichaController.php', {
            method: 'POST',
            body: data
        })
        .then(res => res.json())
        .then(data => {
            
            if(data != 0)
            {
                alert('Se elimino la ficha satisfactoriamente');
                cargarFichas();
            }
            else
            {
                alert('Error al eliminar la ficha');
            }
        });
    }    
}