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
                <td>${formato(item.fecha)}</td>
                <td>${item.cuil}</td>
                <td>${item.nombre} ${item.apellido}</td>
                <td><button class="btn btn-info form-control" onclick="botonModificarFicha(${item.idficha},${item.cantidad},'${item.fecha}',${item.cuil});">Modificar</button></td>
                <td><button class="btn btn-danger form-control"  onclick="eliminarFicha(${item.idficha});">Eliminar</button></td>
            </tr>
            `;
        }
    })
}

//*************Nueva ficha */

function nuevaFicha(){

    var cuil = document.getElementById('cuil');
    var cantida = document.getElementById('cantidadFicha');
    var fech = document.getElementById('fecha');

    const data = new FormData();
    data.append('nuevaFicha','true');
    data.append('cuil', cuil.value);
    data.append('cantidad',cantida.value);
    data.append('fecha',fech.value);

    fetch('../controller/fichaController.php',{
        method: 'POST',
        body: data
    })
    .then(res=> res.json())
    .then(data => {
        if(data == true)
        {
            alert('Se cargo la ficha satisfactoriamente');   
            cargarFichas()         
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

    var cuil = document.getElementById('cuilModificar');
    var cantidad = document.getElementById('cantidadFichaModificar');
    var fecha = document.getElementById('fechaModificar');

    const data = new FormData();
    data.append('modificarFicha', true);
    data.append('idFicha', idFichaGlobal);
    data.append('cantidad', cantidad.value);
    data.append('fecha', fecha.value);
    data.append('cuil',cuil.value);
    
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

function botonModificarFicha(idficha, cantidad, fecha, cuil){

    idFichaGlobal = idficha;

    $('#exampleModal2').modal('show');

    document.getElementById('cuilModificar').value = cuil;
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

function formato(texto){
    return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
  }