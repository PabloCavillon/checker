var url = window.location.href;
eraseCookie('fecha');


var datepicker = document.getElementById('datepicker');
datepicker.addEventListener('change', function(e){
    e.preventDefault();
    var fecha = e.target.value;
    if(fecha != ""){
        document.cookie = 'fecha='+fecha;
    }
    window.location = url;
});


const bancos = ['701', '703', '720', '734', '790', 'MELI'];  

const green = 'rgb(99, 255, 60)';
const yellow = 'rgb(242, 255, 60)';
const red = 'rgb(223, 54, 54)';
const cyan = 'rgb(48, 201, 193)';
const blue = 'rgb(6, 75, 143)'
const grey = 'rgb(206, 206, 206)';
const black = 'rgb(0, 0, 0)';

bancos.forEach(banco => {
    if (adquirencia[banco]){
        const totales = Number(adquirencia[banco]['totales']);
        const pendientes = Number(adquirencia[banco]['pendientes']);
        const liquidados = totales - pendientes;
        const porcentaje_liquidados = Number((liquidados*100/totales).toFixed(2));

        var celdas_externas = [yellow, cyan, blue]; 
        var labels= ['% Liquidado', 'Mov. Liquidados', 'Mov.pendientes'];

        if(porcentaje_liquidados < 80){
            var labels = ['% Liquidado', 'Mov. Liquidados', 'Mov.pendientes'];
            var celdas_externas = [red, cyan, blue]; 
        }
        if(porcentaje_liquidados === 100){
        var labels = ['% Liquidado', 'Mov. Liquidados', 'Mov.pendientes'];
        var celdas_externas = [green, cyan, blue]; 
        }
        var data_externa = [porcentaje_liquidados, 0, 0];

        var detalle = document.getElementById('detalle' + banco);

        detalle.addEventListener('click', function(e) {
            Swal.fire({
                title: "<h3><p class='alerta'>" + banco + "</p></h3>",
                html: "<p class='alerta'><strong>Totales: </strong>" + totales +
                      "<br/><strong>Pendientes: </strong>" + pendientes +
                      "<br/><strong>Liquidados: </strong>" + liquidados +
                      "<br/><br/><strong>Porcentaje de liquidación: </strong>" + porcentaje_liquidados + " %</p>",
                icon: 'info'
            })
        });

        const celdas_interior = [grey, cyan, blue];
        const data_interior = [0, liquidados, pendientes];
        
        var ctx = document.getElementById('chart' + banco).getContext('2d');

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
        
            // Configuration options go here
            options: {
                legend:{
                    position:'left'
                }
            }
        });
    }
})
