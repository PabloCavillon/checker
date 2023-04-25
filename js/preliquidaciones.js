var url = window.location.href;
var abierto = false;
var cartera = "000";

eraseCookie('username');

var btn_ok = document.getElementById('ok');
btn_ok.addEventListener("click", function(e){
	e.preventDefault();
	var ids = get_ids_checked();
	var tareas = [];
	ids.forEach(id => {
		var btn_comentario = document.getElementById('btn_' + id);
		var comentario = btn_comentario.value;
		var tarea = {
			'id': id,
			'comentario': comentario
		};
		tareas.push(tarea);
	}) 
	var data = JSON.stringify(tareas);

	var peticion = new XMLHttpRequest();
	peticion.onload = function(){
		window.location = url;
	}
	peticion.open('POST', url + "/set_ok", true);
	peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	peticion.send('data=' + data);
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
	})

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
			window.location = url;
		}

		peticion.open('POST', url + "/set_error", true);
		peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		peticion.send('data=' + data);
	}
});

var btn_mio = document.getElementById('mio');
btn_mio.addEventListener("click", function(e){
	e.preventDefault();
	var ids = get_ids_checked();
	var tareas = [];
	ids.forEach(id => {
		var btn_comentario = document.getElementById('btn_' + id);
		var comentario = btn_comentario.value;
		var tarea = {
			'id': id
		};
		tareas.push(tarea);
	})

	var data = JSON.stringify(tareas);

	var peticion = new XMLHttpRequest();

	peticion.onload = function(){
		window.location = url;
	}
	peticion.open('POST', url + "/set_mine", true);
	peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	peticion.send('data=' + data);

});

var btn_ver_mios = document.getElementById('ver_mios');
btn_ver_mios.addEventListener("click", function(e){
	e.preventDefault();
	
	var usuario = btn_ver_mios.value;
	
	document.cookie = "username=" + usuario;

	window.location = url;
});

var buttons_comentario = document.getElementsByName('comentario');
buttons_comentario.forEach(btn => {
	document.getElementById(btn.id).addEventListener("click", function(e){
		e.preventDefault();
		var aux = btn.id.split("_");
		console.log(aux[1]);
		comentario(aux[1]);
	});
});

var buttons_cartera = document.getElementsByName('btn_cartera');
buttons_cartera.forEach(btn => {
    btn.addEventListener('click', function(e){
        e.preventDefault();
        var id = btn.id;
        var h2 = document.getElementById("h2_" + id);
        var div = document.getElementById(id);

        if (cartera == id || cartera == "000"){
            if (abierto){
                document.getElementById('table_' + id).style.display="none";
                h2.innerHTML = "<i class='fas fa-hand-point-down' aria-hidden='true'></i> CARTERA " + id + " <i class='fas fa-hand-point-down' aria-hidden='true'></i>";
                div.classList.toggle('activo');
                cartera = "000";
                abierto = false;
            } else {
                document.getElementById('table_' + id).style.display="block";
                h2.innerHTML = "<i class='fas fa-hand-point-up'></i> CARTERA " + id + " <i class='fas fa-hand-point-up'></i>";
                div.classList.toggle('activo');
                cartera = id;
                abierto = true;
            }   
        }
    });
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
		
		if(text){
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