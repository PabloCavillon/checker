var url = window.location.href;
eraseCookie('username');
eraseCookie('year'); 

var btn_asignarme = document.getElementById('asignarme');
btn_asignarme.addEventListener("click", function(e){
	e.preventDefault();
	var ids = get_ids_checked();
	var feriados = [];
	ids.forEach(id => {
		var feriado = {
            'id': id
		};
		feriados.push(feriado);
	})
	var data = JSON.stringify(feriados);
	var peticion = new XMLHttpRequest();
	peticion.onload = () => {
		var btn_year = document.getElementById('year');
		var year = btn_year.value;
		document.cookie = "year="+year;
		window.location = url;
	}
	peticion.open('POST', url + "/asignar", true);
	peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	peticion.send('data=' + data);
});

var btn_desasignarme = document.getElementById('desasignarme');
btn_desasignarme.addEventListener("click", function(e){
	e.preventDefault();
	
	var ids = get_ids_checked();
	var feriados = [];
	ids.forEach(id => {
		var feriado = {
			'id': id	
		};
		feriados.push(feriado);
	})

    var data = JSON.stringify(feriados);
    var peticion = new XMLHttpRequest();

    peticion.onload = function(){
        var btn_year = document.getElementById('year');
        var year = btn_year.value;
        document.cookie = "year="+year;
        window.location = url;
    }

    peticion.open('POST', url + "/desasignar", true);
    peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    peticion.send('data=' + data);
});

var year = document.getElementById('year');
year.addEventListener('change', function(e){
    e.preventDefault();
	document.cookie = 'year=' + year.value;
	window.location = url;	
});

var new_activo = false;
var conmemoracion = document.getElementById('conmemoracion');
var fecha = document.getElementById('fecha');
var new_feriado = document.getElementById('new_feriado');
if (new_feriado){
	new_feriado.addEventListener('click', function(e){
		e.preventDefault();
		if (new_activo) {
			var conmemoracion_value = conmemoracion.value;
			var fecha_value = fecha.value;
			var arr_fecha = fecha_value.split('-');
			console.log(fecha_value);
			if (fecha_value != "" && conmemoracion_value != ""){
				Swal.fire({
					title: '¿Agregar feriado?',
					text: "Confirma que están bien los datos",
					html: "<table class='table'>" +
							"<tr>" +
								"<td>Fecha</td>" +
								"<td>" + arr_fecha[2] + "-" + arr_fecha[1] + "-" + arr_fecha[0] + "</td>" +
							"</tr>" +
							"<tr>" +
								"<td>Feriado</td>" +
								"<td>" + conmemoracion_value + "</td>" +
							"</tr>" +
						"</table>",
					icon: 'question',
					showCancelButton: true,
					confirmButtonColor: '#5CB85C',
					cancelButtonColor: '#FF5265',
					confirmButtonText: 'Agregar',
					cancelButtonText: 'Cancelar',
					customClass:{
						title: "title_alert",
						text: "text_alert"
					}
				}).then( result => {
					console.log(result);
					if(result.isConfirmed){
						let feriado = {
							dia: arr_fecha[2],
							mes: arr_fecha[1],
							year: arr_fecha[0],
							conmemoracion: conmemoracion_value
						};
						data = JSON.stringify(feriado);
						var peticion = new XMLHttpRequest();
					
						peticion.onload = function(){
							var btn_year = document.getElementById('year');
							var year = btn_year.value;
							document.cookie = "year="+year;
							window.location = url;
						}
					
						peticion.open('POST', url + "/agregar_feriado", true);
						peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
						peticion.send('data=' + data);
						console.log('Cargado!');
					}
				})
			}
		} else {
			fecha.classList.toggle('activate');
			conmemoracion.classList.toggle('activate');
			new_activo = !new_activo;
		}
	});
}
var btns_delete_feriado = document.getElementsByName('delete');
btns_delete_feriado.forEach(delete_feriado => {
	delete_feriado.addEventListener('click', function(e){
		e.preventDefault();
		var id_feriado = delete_feriado.value;
		var data = {
			id_feriado
		};
		data = JSON.stringify(data);
    	var peticion = new XMLHttpRequest();

    	peticion.onload = function(){
			var btn_year = document.getElementById('year');
			var year = btn_year.value;
			document.cookie = "year="+year;
			window.location = url;
		}

		peticion.open('POST', url + "/eliminar_feriado", true);
		peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		peticion.send('data=' + data);
	})
});

function get_ids_checked(){
	var checkboxes = document.getElementsByName('checkbox');
	var checks = [];
	checkboxes.forEach(checkbox => {
		if (checkbox.checked){
			checks.push(checkbox.id);
		}
	});
	return checks;
}

