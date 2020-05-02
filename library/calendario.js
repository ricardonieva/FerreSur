
function agregarFecha(){

    var fecha = document.getElementById('fecha');
    var habil = document.getElementById('habil');

    const data = new FormData();
    data.append('agregarFecha', 'true');
    data.append('fecha', fecha.value);
    data.append('habil', habil.checked);

    fetch('../controller/calendarioController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(data =>{
        //alert(data);
        if(data){
            alert('se cargo bien la fecha');
        }else{
            alert('se cargo mal la fecha');
        }
    });

}