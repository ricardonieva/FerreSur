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
                <td><button class="btn btn-success form-control"  type="button" onclick="botonModificarFicha();">Modificar</button></td>
                <td><button class="btn btn-danger form-control" onclick="eliminarFicha();">Eliminar</button></td>
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

//*************Nueva ficha */