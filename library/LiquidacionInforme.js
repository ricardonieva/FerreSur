    function original(e){
        e.preventDefault();
        document.getElementById('tipoDeRecibo').innerHTML = "Original";
        var tablafir = document.getElementById('tablaFirma');
        
        tablafir.innerHTML = `
        <tr>
            <td>El presente es el recibo original que obra en poder del empleado firmado por el empleador.</td>
            <td class="text-center">Firma Del Empleador <br><img src="../view/images/firma.png" alt="firma" width="145" height="81"></td>
        </tr>
        `;
    }

    function duplicado(e){
        e.preventDefault();
        document.getElementById('tipoDeRecibo').innerHTML = "Duplicado";
        var tablafir = document.getElementById('tablaFirma');
        
        tablafir.innerHTML = `
        <tr>
            <td>El presente es duplicado del recibo original que obra en nuestro poder firmado por el empleado.</td>
            <td class="text-center">Firma Del Empleado <br><img src="../view/images/cuadroblanco.png" alt="firma" width="145" height="81"></td>
        </tr>
        `;
    }

window.addEventListener('load', function(){
    var liq = document.getElementById('NumeroDeRecibo').innerHTML;    

    var tablaEmp = document.getElementById('tablaEmpleado');
    var tablaCat = document.getElementById('tablaCategoria');
    var tablaPer = document.getElementById('tablaPeriodo');
    var tablaDet = document.getElementById('tablaDetalle');
    var tablaTot = document.getElementById('tablaTotal');
    var TablaLetra = document.getElementById('tablaDineroLetra');

    const data = new FormData();

    data.append('reciboDeHaberesInforme', 'true');
    data.append('idReciboDeHaberes', liq);

    fetch('../controller/reciboDeHaberesInformeController.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.json())
    .then(data => {

        document.title = 'Factura de Haberes N° '+data['idReciboDeHaberes'];
        document.getElementById('NumeroDeRecibo').innerHTML = 'N° '+data['idReciboDeHaberes'];
        // document.getElementById('FechaDeRecibo').innerHTML = formato(data['cabecera'][0].fechaliquidacion);

        tablaEmp.innerHTML =`
        <tr>
            <td>${data['empleado'].nombre}</td>
            <td>${data['empleado'].apellido}</td>
            <td>${data['empleado'].cuil}</td>
        </tr>
        `;

        tablaCat.innerHTML = `
        <tr>
            <td>${data['empleado']['categoria'].Tipo}</td>
            <td>${data['empleado']['categoria'].sueldoBasico}</td>
            <td>${data['empleado']['categoria'].formaLaboral}</td>
            <td>${formato(data['empleado'].fechaingreso)}</td>
        </tr>
        `;

        tablaPer.innerHTML = `
        <tr>
            <td>${formato(data['liquidacion'].fechaDePago)}</td>
            <td>${data['empleado'].cuentaBancaria}</td>
            <td>${formato(data['liquidacion'].desde)} - ${formato(data['liquidacion'].hasta)}</td>
        </tr>
        `;

        var totalHaberes= 0;
        var TotalDeducciones = 0;
            
        for(let item of data['listaRecibo_Concepto'])
        {
            var haberes = 0;
            var deducciones = 0;

            if(item['concepto'].percepcionSalarial == 'Haber')
            {               
                haberes = item.importe;
                deducciones = "";    
                totalHaberes = totalHaberes + parseFloat(item.importe);
            }
            else
            {                
                deducciones = item.importe;
                haberes = "";
                TotalDeducciones = TotalDeducciones + parseFloat(item.importe);                
            }
          
            tablaDet.innerHTML += `
            <tr>
                <td>${item['concepto'].idConcepto}</td>
                <td>${item.concepto_detalle}</td>
                <td>${item.cantidad}</td>
                <td>${haberes}</td>
                <td>${deducciones}</td>
            </tr>
            `;           
        }

        var totalneto = totalHaberes - TotalDeducciones;
        tablaTot.innerHTML = `
            <tr>
                <td>Aguilares - ${formato(data.fechaDeGeneracion)}</td>
                <td>${parseFloat(totalneto).toFixed(2)}</td>
                <td>${totalHaberes.toFixed(2)}</td>
                <td>${TotalDeducciones.toFixed(2)}</td>
            </tr>
        `;

        TablaLetra.innerHTML = `
            <tr>
                <td>${numeroALetras(totalneto , {
                plural: "PESOS",
                singular: "PESO",
                centPlural: "CENTAVOS",
                centSingular: "CENTAVO"
                })}
                </td>               
            </tr>
        `;


    });
});    
///////////////////

// function cargarTablasDeconceptos()
// {
//     const data = new FormData();

//     data.append('reciboDeHaberesInforme', 'true');
//     data.append('idReciboDeHaberes', liq);

//     fetch('http://localhost/ferresur/controller/LiquidacionInformeController.php', {
//         method: 'POST',
//         body: data
//     })
//     .then(res => res.json())
//     .then(data => {});
// }

////////////////////////////da formato a la fecha
function formato(texto){
  return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
}



///////////////////////////////controller

var numeroALetras = (function() {
    
    function Unidades(num) {

        switch (num) {
            case 1:
                return 'UN';
            case 2:
                return 'DOS';
            case 3:
                return 'TRES';
            case 4:
                return 'CUATRO';
            case 5:
                return 'CINCO';
            case 6:
                return 'SEIS';
            case 7:
                return 'SIETE';
            case 8:
                return 'OCHO';
            case 9:
                return 'NUEVE';
        }

        return '';
    } //Unidades()

    function Decenas(num) {

        let decena = Math.floor(num / 10);
        let unidad = num - (decena * 10);

        switch (decena) {
            case 1:
                switch (unidad) {
                    case 0:
                        return 'DIEZ';
                    case 1:
                        return 'ONCE';
                    case 2:
                        return 'DOCE';
                    case 3:
                        return 'TRECE';
                    case 4:
                        return 'CATORCE';
                    case 5:
                        return 'QUINCE';
                    default:
                        return 'DIECI' + Unidades(unidad);
                }
            case 2:
                switch (unidad) {
                    case 0:
                        return 'VEINTE';
                    default:
                        return 'VEINTI' + Unidades(unidad);
                }
            case 3:
                return DecenasY('TREINTA', unidad);
            case 4:
                return DecenasY('CUARENTA', unidad);
            case 5:
                return DecenasY('CINCUENTA', unidad);
            case 6:
                return DecenasY('SESENTA', unidad);
            case 7:
                return DecenasY('SETENTA', unidad);
            case 8:
                return DecenasY('OCHENTA', unidad);
            case 9:
                return DecenasY('NOVENTA', unidad);
            case 0:
                return Unidades(unidad);
        }
    } //Unidades()

    function DecenasY(strSin, numUnidades) {
        if (numUnidades > 0)
            return strSin + ' Y ' + Unidades(numUnidades)

        return strSin;
    } //DecenasY()

    function Centenas(num) {
        let centenas = Math.floor(num / 100);
        let decenas = num - (centenas * 100);

        switch (centenas) {
            case 1:
                if (decenas > 0)
                    return 'CIENTO ' + Decenas(decenas);
                return 'CIEN';
            case 2:
                return 'DOSCIENTOS ' + Decenas(decenas);
            case 3:
                return 'TRESCIENTOS ' + Decenas(decenas);
            case 4:
                return 'CUATROCIENTOS ' + Decenas(decenas);
            case 5:
                return 'QUINIENTOS ' + Decenas(decenas);
            case 6:
                return 'SEISCIENTOS ' + Decenas(decenas);
            case 7:
                return 'SETECIENTOS ' + Decenas(decenas);
            case 8:
                return 'OCHOCIENTOS ' + Decenas(decenas);
            case 9:
                return 'NOVECIENTOS ' + Decenas(decenas);
        }

        return Decenas(decenas);
    } //Centenas()

    function Seccion(num, divisor, strSingular, strPlural) {
        let cientos = Math.floor(num / divisor)
        let resto = num - (cientos * divisor)

        let letras = '';

        if (cientos > 0)
            if (cientos > 1)
                letras = Centenas(cientos) + ' ' + strPlural;
            else
                letras = strSingular;

        if (resto > 0)
            letras += '';

        return letras;
    } //Seccion()

    function Miles(num) {
        let divisor = 1000;
        let cientos = Math.floor(num / divisor)
        let resto = num - (cientos * divisor)

        let strMiles = Seccion(num, divisor, 'UN MIL', 'MIL');
        let strCentenas = Centenas(resto);

        if (strMiles == '')
            return strCentenas;

        return strMiles + ' ' + strCentenas;
    } //Miles()

    function Millones(num) {
        let divisor = 1000000;
        let cientos = Math.floor(num / divisor)
        let resto = num - (cientos * divisor)

        let strMillones = Seccion(num, divisor, 'UN MILLON DE', 'MILLONES DE');
        let strMiles = Miles(resto);

        if (strMillones == '')
            return strMiles;

        return strMillones + ' ' + strMiles;
    } //Millones()

    return function NumeroALetras(num, currency) {
        currency = currency || {};
        let data = {
            numero: num,
            enteros: Math.floor(num),
            centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
            letrasCentavos: '',
            letrasMonedaPlural: currency.plural || 'PESOS CHILENOS', //'PESOS', 'Dólares', 'Bolívares', 'etcs'
            letrasMonedaSingular: currency.singular || 'PESO CHILENO', //'PESO', 'Dólar', 'Bolivar', 'etc'
            letrasMonedaCentavoPlural: currency.centPlural || 'CHIQUI PESOS CHILENOS',
            letrasMonedaCentavoSingular: currency.centSingular || 'CHIQUI PESO CHILENO'
        };

        if (data.centavos > 0) {
            data.letrasCentavos = 'CON ' + (function() {
                if (data.centavos == 1)
                    return Millones(data.centavos) + ' ' + data.letrasMonedaCentavoSingular;
                else
                    return Millones(data.centavos) + ' ' + data.letrasMonedaCentavoPlural;
            })();
        };

        if (data.enteros == 0)
            return 'CERO ' + data.letrasMonedaPlural + ' ' + data.letrasCentavos;
        if (data.enteros == 1)
            return Millones(data.enteros) + ' ' + data.letrasMonedaSingular + ' ' + data.letrasCentavos;
        else
            return Millones(data.enteros) + ' ' + data.letrasMonedaPlural + ' ' + data.letrasCentavos;
    }
})();