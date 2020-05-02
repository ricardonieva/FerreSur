//////buscar empleado
buscarEmpleado.addEventListener('click', function (e){
    e.preventDefault();
    
    var cuil = document.getElementById('buscarcuil')
    
    const data = new FormData();
    data.append('buscarEmpleado', 'true');
    data.append('CUIL', cuil.value);
    fetch('../controller/asistenciaController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
    
    if(data != false){
       //idEmpleado = data.idEmpleado;//capturamos el id del empleado buscado
        var datos = document.getElementById('nombreEmpleado');
        datos.value = data.apellido+", "+data.nombre;
    }else{
        alert('Empleado No Encontrado');
    }
    
    })
    
    cargarTabla();
    
    });

    //////////////////////////guardar nueva asistencia

    function guardarAsistencia(){
        var fec = document.getElementById('fecha');
        var nov = document.getElementById('novedad');
        var ent = document.getElementById('entrada');
        var sal = document.getElementById('salida');

        const data = new FormData();

        data.append('agregarAsistencia', 'true');
        data.append('fecha', fec.value);
        data.append('novedad', nov.value);
        data.append('entrada', ent.value);
        data.append('salida', sal.value);
        fetch('../controller/asistenciaController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(data => {
        alert(data);
        cargarTabla();

    });

    }

    ////////////////////////////cargar tabla de asistencia
    function cargarTabla(){
       
        const data = new FormData();
        data.append('mostrarAsistencia', 'true');       
        fetch('../controller/asistenciaController.php', {
        method: 'POST',
        body: data
        })
        .then(res => res.json())
        .then(data => {
            //alert(data);

            var tabla = document.getElementById('tablaAsistencia');
            tabla.innerHTML = ``;

            for(let item of data)
            {
                tabla.innerHTML += `
                    <tr>                       
                        <td>${item.fecha}</td>
                        <td>${item.habil}</td>
                        <td>${item.entrada}</td>
                        <td>${item.salida}</td>
                        <td>${item.novedades}</td>
                        <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal2" onclick="modalDeModificar(${item.idasistencia}, '${item.fecha}', '${item.entrada}', '${item.salida}', '${item.novedades}');">Modificar</button></td>
                        <td><button type="button" class="btn btn-danger" onclick="eliminarAsistenicia(${item.idasistencia});">Eliminar</button></td>
                    </tr>
                `;
            }

            $('#tablaAsistenciaHead').DataTable();
        });


    }

    ///////////////////////boton eliminar asistencia

    function eliminarAsistenicia(idasistencia){

        var res = confirm('Desea eliminar esta asistencia?');
        if(res){
            const data = new FormData();
            data.append('eliminarAsistencia', 'true');      
            data.append('idasistencia', idasistencia);
            fetch('../controller/asistenciaController.php', {
            method: 'POST',
            body: data
            })
            .then(res => res.json())
            .then(data => {
                if(data){
                    alert('Se elimino la asistencia satisfactoriamente');
                    cargarTabla();
                }else
                {
                    alert('Error al eliminar la asistencia');
                }
    
            });
        }       
    }
    ////////////////////////////////moda modificar
    var idasistenciaAUX;

    function modalDeModificar(idasistencia, fecha, entrada, salida, novedades){
        idasistenciaAUX = idasistencia;
        var title = document.getElementById('exampleModalLabelModificar');
        var nov = document.getElementById('novedadModificar');
        var ent = document.getElementById('entradaModificar');
        var sal = document.getElementById('salidaModificar');

        title.innerHTML = `Asistencia de ${fecha}`;
        nov.value = novedades;
        ent.value = entrada;
        sal.value = salida;
    }

    function guardarCambiosAsistencia(){
        var nov = document.getElementById('novedadModificar');
        var ent = document.getElementById('entradaModificar');
        var sal = document.getElementById('salidaModificar');

        const data = new FormData();
        data.append('modificarAsistencia', 'true');      
        data.append('idasistencia', idasistenciaAUX);
        data.append('entradaModificar', ent.value);
        data.append('salidaModificar', sal.value);
        data.append('novedadModificar', nov.value);
        fetch('../controller/asistenciaController.php', {
        method: 'POST',
        body: data
        })
        .then(res => res.json())
        .then(data => {
            //alert(data);
            if(data){
                alert('Se modifico la asistencia satisfactoriamente');
                cargarTabla();
            }else
            {
                alert('Error al modificar la asistencia');
            }

        });
    }