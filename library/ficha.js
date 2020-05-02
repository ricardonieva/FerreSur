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
            alert('Se cargo el ficha satisfactoriamente');            
        }
        else
        {
            alert('Error al cargar el concepto');
        }
    });



}

//*************Nueva ficha */