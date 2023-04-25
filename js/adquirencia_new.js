var url = window.location.href;

var bancookie = readCookie('banco');
if(bancookie != undefined){
    var opcion = document.getElementById(readCookie('banco'));
    opcion.classList += " active" 
} else {
    var opcion = document.getElementById('701');
    opcion.classList += " active"
}

eraseCookie('fecha');
eraseCookie('banco');

var datepicker = document.getElementById('datepicker');
datepicker.addEventListener('change', function(e){
    e.preventDefault();
    var fecha = e.target.value;
    if(fecha != ""){
        document.cookie = 'fecha='+fecha;
    }
    window.location = url;
});

var options = document.getElementsByName('opcion');
options.forEach(option => {
    option.addEventListener('click', function(e){
        document.cookie= 'banco='+e.target.value;
        window.location = url;
    }) 
});

const bancos = ['701', '703', '720', '730', '734', '790']  

const green = 'rgb(99, 255, 60)';
const yellow = 'rgb(242, 255, 60)';
const red = 'rgb(223, 54, 54)';
const cyan = 'rgb(48, 201, 193)';
const blue = 'rgb(6, 75, 143)'
const grey = 'rgb(206, 206, 206)';
const black = 'rgb(0, 0, 0)';

let div_charts = document.getElementById('charts');

let i = 0;

let totales790 = [];
let pendientes790 = [];
let liquidados790 = [];
let fechas = [];
let control = 0;

adquirencias.forEach(adquirencia => {

    if (bancookie!== '790'){
        let div = document.createElement('div');
        div.id = "banco";
        div.innerHTML += `<h3 id="title${i}"></h3>
                          <canvas id="chart${i}" style="display: inline-block; height: 100%; width:100%;"></canvas>
                          <button class="btn-detalle" id="detalle${i}">Detalle</button> `

        div_charts.appendChild(div);

        const totales = Number(adquirencia['totales']);
        const pendientes = Number(adquirencia['pendientes']);
        const liquidados = totales - pendientes;
        const porcentaje_liquidados = Number((liquidados*100/totales).toFixed(2));
        
        var detalle = document.getElementById('detalle' + i);
        detalle.addEventListener('click', function(e) {
            Swal.fire({
                title: "<h3><p class='alerta'>" + adquirencia['fecha'] + "</p></h3>",
                html: "<p class='alerta'><strong>Totales: </strong>" + totales +
                "<br/><strong>Pendientes: </strong>" + pendientes +
                "<br/><strong>Liquidados: </strong>" + liquidados +
                "<br/><br/><strong>Porcentaje de liquidación: </strong>" + porcentaje_liquidados + " %</p>",
                icon: 'info'
            })
        });
        
        var celdas_externas = [yellow, cyan, blue]; 
        var labels= ['% Liquidación', 'Mov. Liquidados', 'Mov.pendientes'];
        
        if(porcentaje_liquidados < 80){
            var labels = ['% Liquidación', 'Mov. Liquidados', 'Mov.pendientes'];
            var celdas_externas = [red, cyan, blue]; 
        }
        if(porcentaje_liquidados === 100){
            var labels = ['% Liquidación', 'Mov. Liquidados', 'Mov.pendientes'];
            var celdas_externas = [green, cyan, blue]; 
        }
        var data_externa = [porcentaje_liquidados, 0, 0];
        
        const celdas_interior = [grey, cyan, blue];
        const data_interior = [0, liquidados, pendientes];
        
        var title = document.getElementById('title' + i);
        title.textContent += " " + adquirencia['fecha']; 
        
        var ctx = document.getElementById('chart' + i).getContext('2d');
        var chart = new Chart(ctx, {
            type: 'doughnut',
            
            data: {
                labels,
                datasets: [{
                    backgroundColor: celdas_externas,
                    data: data_externa
                },{
                    backgroundColor: celdas_interior,
                    data: data_interior
                }]
            },
            
            options: {
                legend:{
                    position:'left'
                }
            }
        });
        i++;
    } else {
        control++;
        const totales = Number(adquirencia['totales']);
        const pendientes = Number(adquirencia['pendientes']);
        const liquidados = totales - pendientes;

        fechas[control-1] = adquirencia['fecha'];
        totales790[fechas[control-1]] = totales;
        pendientes790[fechas[control-1]] = pendientes;
        liquidados790[fechas[control-1]] = liquidados;

        
        if (control === 9) {

            fechas.forEach(fecha => {
                console.log(totales790[fecha]);
            })

            let div = document.createElement('div');
            div.id = "banco790";
            div.innerHTML += `<canvas id="chart790" style="display: inline-block; height: 100%; width:100%;"></canvas>`
            
            div_charts.appendChild(div);
            
            var ctx = document.getElementById('chart790').getContext('2d');
            
            let myBarChart = new Chart(ctx, {
                type: 'bar',
                data:{
                    labels:fechas,
                    datasets:[{
                        label: 'Totales',
                        data: totales790,
                        backgroundColor: 'rgba(255, 82, 101, 0.9)',
                        borderColor: 'rgb(252, 42, 63)'
                    },
                    {
                        label: 'Pendientes',
                        data: pendientes790,
                        backgroundColor: 'rgba(6, 75, 144, 0.9)',
                        borderColor: 'rgb(4, 40, 76)'
                    },
                    {
                        label: 'Liquidados',
                        data: liquidados790,
                        backgroundColor: 'rgba(6, 75, 144, 0.9)',
                        borderColor: 'rgb(4, 40, 76)'
                    }]
                },
                options:{
                    responsive: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }
    }
})




