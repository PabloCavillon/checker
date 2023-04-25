let url = window.location.href;

let day = document.getElementById('day');
let week = document.getElementById('week');
let month = document.getElementById('month');
let vista = document.getElementById('vista');
let tipo = document.getElementById('tipo');
let div_emision = document.getElementById('emision');
let div_adquirencia = document.getElementById('adquirencia');


if(readCookie('tipo') == 'emision'){
	day.classList += ' hide';
	week.classList += ' hide';
	month.classList.remove('hide');
	vista.classList += ' hide';
	div_adquirencia.classList += ' hide';
	div_emision.classList.remove('hide');
	tipo.value = 'emision';
	month.value = readCookie('valor');
} else {

	vista.classList.remove('hide');

	if(readCookie('day') != null || (readCookie('week') == null && readCookie('month') == null)){
		eraseCookie('day');
		day.classList.remove('hide');
		day.value = readCookie('valor');
		week.classList += ' hide';
		month.classList += ' hide';
		vista.value = 'diaria';
		console.log(readCookie('vista'));
		document.cookie = 'vista='+vista.value;
	}
	if(readCookie('week') != null){
		eraseCookie('week');
		day.classList += ' hide';
		week.classList.remove('hide');
		week.value = readCookie('valor');
		month.classList += ' hide';
		vista.value = 'semanal';
		console.log(readCookie('vista'));
	}
	if(readCookie('month') != null){
		eraseCookie('month');
		day.classList += ' hide';
		week.classList += ' hide';
		month.classList.remove('hide');
		month.value = readCookie('valor');
		vista.value = 'mensual';
		console.log(readCookie('vista'));
	}
}


tipo.addEventListener('change', ()=>{
	document.cookie = "tipo=" + tipo.value;

	window.location = url;
})

vista.addEventListener('change', e => {
	e.preventDefault();
	
	day.classList += ' hide';
	week.classList += ' hide';
	month.classList += ' hide';

	switch(vista.value){
		case 'diaria':
			day.classList.remove('hide');
			break;
		case 'semanal':
			week.classList.remove('hide');
			break;
		case 'mensual':
			month.classList.remove('hide');
			break;
	}
	document.cookie = 'vista='+vista.value;
});

if (tipo.value == 'adquirencia'){
	day.addEventListener('change', e =>{
		e.preventDefault();
		
		document.cookie = "valor=" + day.value;
		document.cookie = "day="+day.value;

		window.location = url;
	});

	week.addEventListener('change', e =>{
		e.preventDefault();
		let aux = week.value.split('-');  
		let nro_semana = aux[1].replace('W','');
		let fecha = new Date(aux[0], 0, (nro_semana - 1) * 7 + 1);

		let dia = fecha.getDay();
		if (dia < 10){
			dia = '0' + dia;
		} 
		let mes = fecha.getMonth();
		if(mes < 10){
			mes = '0' + mes;
		}
		let year = fecha.getFullYear();

		fecha = `${year}${mes}${dia}`;

		document.cookie = 'valor=' + week.value;
		document.cookie = "week="+fecha;

		window.location = url;
	});

	month.addEventListener('change', e =>{
		e.preventDefault();
		
		document.cookie = 'valor=' + month.value;
		document.cookie = 'month=' + month.value.replace('-', '');

		window.location = url; 
	});

	if (adquirencia.length != 0){
		let bancos = [];
		let liquidaciones = [];
		let movimientos = [];
		let count = 0;

		adquirencia.forEach( indicador => {	
			bancos[count] = indicador['banco'];
			liquidaciones[count] = indicador['liquidaciones'];
			movimientos[count] = indicador['movimientos'];
			count++;
		});

		let ctx = document.getElementById('grafica_adquirencia');
		let myBarChart = new Chart(ctx, {
			type: 'bar',
			data:{
				labels:bancos,
				datasets:[{
					label: 'Liquidaciones',
					data: liquidaciones,
					backgroundColor: 'rgba(255, 82, 101, 0.9)',
					borderColor: 'rgb(252, 42, 63)'
				},
				{
					label: 'Movimientos',
					data: movimientos,
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

if (tipo.value == 'emision'){
	month.addEventListener('change', e =>{
		e.preventDefault();
		
		document.cookie = 'valor=' + month.value;
		document.cookie = 'month=' + month.value.replace('-', '');

		window.location = url; 
	});

	if (emision.length != 0){
		let carteras = [];
		let cuentas = [];
		let cuentas_con_movimientos = [];
		let movimientos = [];
		let count = 0;

		emision.forEach( indicador => {	
			carteras[count] = indicador['cartera'];
			cuentas[count] = indicador['cuentas'];
			cuentas_con_movimientos[count] = indicador['cuentas_con_movimientos'];
			movimientos[count] = indicador['movimientos'];
			count++;
		});

		let ctx = document.getElementById('grafica_emision');
		let myBarChart = new Chart(ctx, {
			type: 'bar',
			data:{
				labels:carteras,
				datasets:[{
					label: 'CUENTAS',
					data: cuentas,
					backgroundColor: 'rgba(255, 82, 101, 0.9)',
					borderColor: 'rgb(252, 42, 63)'
				},{
					label: 'CUENTAS CON MOVIMIENTOS',
					data: cuentas_con_movimientos,
					backgroundColor: 'rgba(228, 159, 57, 0.9)',
					borderColor: 'rgb(228,159,57)'
				},{
					label: 'MOVIMIENTOS',
					data: movimientos,
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

adquirencia = [];
emision = [];

eraseCookie('valor');