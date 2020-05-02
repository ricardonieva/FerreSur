function mostrarCartel(){
    alert('sep se llamo a esta funcion');
}

////////////////////////

function buscarCodigoArticulo(codigoArticulo){

const datos = new FormData();
datos.append('buscarCodigo', 'true');
datos.append('idArtidculo', codigoArticulo);
fetch('http://localhost/ferresur/controller/CompraController.php',{
  method: 'POST',
  body: datos
})
.then(res => res.json())
.then(data => {

    return data;
}
);
}