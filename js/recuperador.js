var url = window.location.href;
eraseCookie("fecha");

var datepicker = document.getElementById('datepicker');
datepicker.addEventListener('change', function(e){
    e.preventDefault();
    var fecha = datepicker.value;

    document.cookie = "fecha="+fecha;
    window.location = url;
});

var buttons_comentario = document.getElementsByName('comentario');
buttons_comentario.forEach(btn => {
	document.getElementById(btn.id).addEventListener("click", function(e){
		e.preventDefault();
		var aux = btn.id.split("_");
		comentario(aux[1]);
	});
});

var btn_ok = document.getElementById('ok');
btn_ok.addEventListener("click", function(e){
	e.preventDefault();
	var ids = get_ids_checked();
	var tareas = [];
	var no_comment = false;
	ids.forEach(id => {
		var btn_comentario = document.getElementById('btn_' + id);
		var comentario = btn_comentario.value;
		if (comentario == ""){
            no_comment = true;
            btn_comentario.classList += " red"; 
		}
		var tarea = {
			'id': id,
			'comentario': comentario
		};
		tareas.push(tarea);
	});

	if (no_comment){
		Swal.fire({
			icon: 'error',
			title: '<p class="alerta">Oops...</p>',
			html: '<p class="alerta">Falta comentar alguna de las tareas seleccionadas</p>',
			footer: '<p class="center alerta">Es necesario el comentario para poder seguir el problema y' + 
					'para que el resto de los controllers estén al tanto de que pasó</p>',
			allowOutsideClick: false,
		 	allowEnterKey: true,
			allowEscapeKey: false,
			stopKeydownPropagation: false
		});
	} else {
		var data = JSON.stringify(tareas);

		var peticion = new XMLHttpRequest();

		peticion.onload = function(){
            var btn_fecha = document.getElementById('datepicker');
            var fecha = btn_fecha.value;
            fecha = (fecha.replace('-', '')).replace('-', '');
            document.cookie = "fecha="+fecha;
			window.location = url;
		}

		peticion.open('POST', url + "/set_ok", true);
		peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		peticion.send('data=' + data);
	}
});

var btn_error = document.getElementById('error');
btn_error.addEventListener("click", function(e){
	e.preventDefault();
	var ids = get_ids_checked();
	var tareas = [];
	var no_comment = false;
	ids.forEach(id => {
		var btn_comentario = document.getElementById('btn_' + id);
		var comentario = btn_comentario.value;
		if (comentario == ""){
			no_comment = true;
            btn_comentario.classList += " red"; 
		}
		var tarea = {
			'id': id,
			'comentario': comentario
		};
		tareas.push(tarea);
	});

	if (no_comment){
		Swal.fire({
			icon: 'error',
			title: '<p class="alerta">Oops...</p>',
			html: '<p class="alerta">Falta comentar alguna de las tareas seleccionadas</p>',
			footer: '<p class="center alerta">Es necesario el comentario para poder seguir el problema y' + 
					'para que el resto de los controllers estén al tanto de que pasó</p>',
			allowOutsideClick: false,
		 	allowEnterKey: true,
			allowEscapeKey: false,
			stopKeydownPropagation: false
		});
	} else {
		var data = JSON.stringify(tareas);

		var peticion = new XMLHttpRequest();

		peticion.onload = function(){
            var btn_fecha = document.getElementById('datepicker');
            var fecha = btn_fecha.value;
            fecha = (fecha.replace('-', '')).replace('-', '');
            document.cookie = "fecha="+fecha;
			window.location = url;
		}

		peticion.open('POST', url + "/set_error", true);
		peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		peticion.send('data=' + data);
	}
});

var buttons_detalles = document.getElementsByName('detalle');
buttons_detalles.forEach(btn => {
    btn.addEventListener('click', function(e){
        e.preventDefault();

        var id_tarea = btn.value;
        var id = {
            'id': id_tarea
        };
        var data = JSON.stringify(id);

        var peticion = new XMLHttpRequest();
		peticion.onload = function(){
            var tarea = JSON.parse(peticion.responseText);
            Swal.fire({
                icon: 'question',
                title: '<p class="alerta">' + tarea['tarea'] + '</p>',
                html: '<p class="alerta"> Usuario: ' + tarea['usuario'] + '<br/>Recuperador: ' + tarea['usuario_recuperador'] + '</p>'
                    + '<p class="alerta"> Comentario: ' + tarea['comentario'] + '</p>',
                allowOutsideClick: false,
                allowEnterKey: true,
                allowEscapeKey: false,
                stopKeydownPropagation: false
            });
        }
		peticion.open('POST', url + "/get_tarea", true);
		peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		peticion.send('data=' + data);

    });
});

var btn_excel = document.getElementById('excel');
btn_excel.addEventListener('click', function(e){
	e.preventDefault();
	var peticion = new XMLHttpRequest();

	peticion.open('POST', url + "/download_excel", true);
	peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	peticion.send();
});

function comentario(id){
	var btn_comentario = document.getElementById("btn_" + id);
	(async () => {
		const { value: text } = await Swal.fire({
			title: '<i class="far fa-comments"> </i>',
			input: 'textarea',
			inputPlaceholder: '¿Qué pasó con la tarea?',
			inputValue: btn_comentario.value,
			showCancelButton: true,
			cancelButtonText: 'Cancelar',
			confirmButtonText: 'Guardar',
			allowEscapeKey: false,
			allowOutsideClick: false,
			confirmButtonColor: '#5CB85C',
			cancelButtonColor: 'rgb(247, 35, 35)',
			customClass: {
				input: 'alert_textarea',
			}
		})
		
		if (text) {
			btn_comentario.value = text; 
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 1500,
				timerProgressBar: true,
				onOpen: (toast) => {
				  toast.addEventListener('mouseenter', Swal.stopTimer)
				  toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			  })
			  
			  Toast.fire({
				icon: 'success',
				title: '¡GUARDADO!'
			  })
		}
		
		})()
}

function comentar(){
	var tr = document.getElementById("tr_comentario");
	var id = tr.value;
	var textarea = document.getElementById("textarea_comentario");
	var btn = document.getElementById("btn_" + id);
	btn.classList.remove("red");
	btn.classList.remove("green");
	btn.classList.remove("yellow");
	
	btn.value =  textarea.value;

	if(textarea.value == "")
	{
		btn.classList += " red";
	}
	else
	{
		btn.classList += " green";
	}

	tr.remove();

}

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
