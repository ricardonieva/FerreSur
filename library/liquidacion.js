function buscarEmpleado(){
    
    var cuil = document.getElementById('buscarcuil')
    var nombre = document.getElementById('nombre')
    var apellido = document.getElementById('apellido')
    var formcuil = document.getElementById('cuil')
    
    const data = new FormData();
    data.append('buscarEmpleado', 'true');
    data.append('CUIL', cuil.value);
    fetch('../controller/LiquidacionController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        if(data){
            nombre.value = data.nombre;
            apellido.value = data.apellido;
            formcuil.value = data.cuil;
        }else{
            alert('Empleado No Encontrado');
        }
    
    })
}

///////////////////////cargar conceptos de ley
window.addEventListener('load', cargarPercepcionesDeLey);
var arrayConceptos = [];
function cargarPercepcionesDeLey(){
    const data = new FormData();
    data.append('cargarPercepcionesDeLey', 'true');
    fetch('../controller/LiquidacionController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {
        var concep = document.getElementById('selecConceptos');

        for(let item of data)
        {
            concep.innerHTML += `
                <option value="${item.idconcepto}">${item.detalle} - ${item.percepcionSalarial} </option>
            `;
            var concepto = {idconcepto:item.idconcepto, tipoConcepto:item.tipoConcepto, detalle:item.detalle, percepcionSalarial:item.percepcionSalarial, tipo:item.tipo, valor:item.valor};
            arrayConceptos.push(concepto);
        }
    });
}

////////////////////boton agregar conceptos

var linea_liquidacion = [];
function agregarLineaDeLiquidacion(){

    var selectConcepto = document.getElementById('selecConceptos').value;

    for(let item of arrayConceptos)
    {
        if(item.idconcepto == selectConcepto) 
        {
            $bandera = false;//esta bandera sirve para determinar si un concepto ya fue agregado a la linea, para no agregar dos veces el mismo
            for(let item2 of linea_liquidacion)
            {
                if(item2.idconcepto == selectConcepto)
                {
                    $bandera = true;                                       
                }
            } 
            if($bandera == false)
            {
                $bandera2 = false;//esta bandera es para no cargar dos sueldos basicos
                for(let item3 of linea_liquidacion)
                {                    
                    if(item3.tipoConcepto == 'Sueldo Basico' && item.tipoConcepto == 'Sueldo Basico')
                    {
                        $bandera2 = true;                                       
                    }
                }
                if($bandera2 == false)
                {
                    var conceptoAgregado = {idconcepto:item.idconcepto, tipoConcepto:item.tipoConcepto, detalle:item.detalle, percepcionSalarial:item.percepcionSalarial, tipo:item.tipo, valor:item.valor};
                    linea_liquidacion.push(conceptoAgregado);
                } 
                
            }          
           
        }    
    }
    cargarTablaConcepto();
}

/////////////////////cargar tabla de conceptos

function cargarTablaConcepto(){
    var tabla = document.getElementById('tablaConcepto');
    tabla.innerHTML = ``;

    for(let item of linea_liquidacion)
    {
        tabla.innerHTML += `
            <tr>
                <td>${item.idconcepto}</td>
                <td>${item.tipoConcepto}</td>
                <td>${item.detalle}</td>           
                <td>${item.percepcionSalarial}</td>
                <td>${item.tipo}</td>
                <td>${item.valor}</td>
                <td><button class="btn btn-danger" onclick="quitarConceptoDeTablaConcepto(${item.idconcepto});">Quitar</button></td>
            </tr>
        `;
    }
}

/////////////////////////boton "QUITAR" de la tabla de conceptos agregados

function quitarConceptoDeTablaConcepto(id){

    for(var i =0; i< linea_liquidacion.length; i++){
        if(linea_liquidacion[i].idconcepto == id){
            linea_liquidacion.splice(i, 1);
        }
    }
    cargarTablaConcepto();
}

//////////////////////boton "generar liquidacion"

function generarLiquidacion(){
    var periodo = document.getElementById('periodo');
    var fechaCobro = document.getElementById('fechaCobro');
    var tipo = document.getElementById('tipo');
    var array = JSON.stringify(linea_liquidacion);

    const data = new FormData();
    data.append('generarLiquidacion', 'true');
    data.append('periodo', periodo.value);
    data.append('fechaCobro', fechaCobro.value);
    data.append('tipo', tipo.value);
    data.append('linea_liquidacion', array);
    fetch('../controller/LiquidacionController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(data => {
        alert(data);

    });
}