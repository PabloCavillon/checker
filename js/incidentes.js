var url = window.location.href;
eraseCookie('tags');

var tags_obj = document.getElementById('tags');
tags_obj.addEventListener('keypress', e => {
    if (e.key === 'Enter') {
        e.preventDefault();
        cargar_incidentes();
    }
     else
    {
        return false;
    }
 })

 var btn_search = document.getElementById('btn_buscar');
 btn_search.addEventListener('click', e => {
    cargar_incidentes();
 })

 var cargar_incidentes = () => {
    var tags = tags_obj.value.trim().replace(",", " ").replace(".", " ");

    while(tags.includes("  ")) {
        tags = tags.replace("  ", " "); 
    }

    regex = /([A-Za-z]{3,})/g;
    var matches = tags.match(regex);

    tags="";
    matches.forEach(match => {
        tags += match + " "; 
    })

    document.cookie = "tags="+tags;
    
    window.location = url;
 }


var btn_agregar = document.getElementById('btn_agregar');
btn_agregar.addEventListener('click', () => {
     
    var oculto = document.getElementById('new_incidente');
    oculto.classList.toggle('oculto');

});

var new_incidente = document.getElementById('new_incidente');

var clickeable_salir = document.getElementById('clickeable_salir');
clickeable_salir.addEventListener('click', e => {
    if(!new_incidente.classList.contains('oculto')) {
        new_incidente.classList.toggle('oculto');
    }
})

document.addEventListener('keydown', e => {
    if(e.key === "Escape" && !new_incidente.classList.contains('oculto')) {
        new_incidente.classList.toggle('oculto');
    }
});

var btn_cargar = document.getElementById('btn_cargar');
btn_cargar.addEventListener('click', e => {
    e.preventDefault();
    var todo_ok = 1;
    var banco_elemento = document.getElementById('banco');
    var numero_elemento = document.getElementById('numero');
    var fecha_elemento = document.getElementById('fecha');
    var tema_elemento = document.getElementById('tema');
    var tags_elemento = document.getElementById('new_tags');

    var banco =  banco_elemento.value;

    if (banco === "null") {
        banco_elemento.classList.toggle('input_red');
        document.getElementById('error_banco').classList.toggle('oculto');
        todo_ok = 0;
    }

    var numero = numero_elemento.value.trim();
    var regex = /^[A-Z]{3}\d{12}$/i;  

    if (!regex.exec(numero)) {
        numero_elemento.classList.toggle('input_red');
        document.getElementById('error_numero').classList.toggle('oculto');
        todo_ok = 0;
    }

    var fecha = fecha_elemento.value;
    
    if (fecha === "") {
        fecha_elemento.classList.toggle('input_red');
        document.getElementById('error_fecha').classList.toggle('oculto');
        todo_ok = 0;
    }

    var tema = tema_elemento.value.trim();

    if (tema.length < 10) {
        tema_elemento.classList.toggle('input_red');
        document.getElementById('error_tema').classList.toggle('oculto');
        todo_ok = 0;
    }

    var tags = tags_elemento.value.trim();

    while (tags.includes("  ")) {
        tags = tags.replace("  ", " ");
    }

    regex = /([A-Za-z]{3,})/g;
    var matches = tags.match(regex);

    if(matches === null) {
        tags_elemento.classList.toggle('input_red');
        document.getElementById('error_tags').classList.toggle('oculto');
        todo_ok = 0;
    }

    if (!todo_ok) {
        return false;
    }

	var incidente_x_tags = [];
	matches.forEach(tag => {
		var incidente_x_tag = {
			'banco': banco,
            'numero': numero,
			'fecha': fecha,
            'tema': tema,
            'tag' : tag
        };
		incidente_x_tags.push(incidente_x_tag);
	}) 
	var data = JSON.stringify(incidente_x_tags);

	var peticion = new XMLHttpRequest();
	peticion.onload = function(){
		window.location = url;
	}
	peticion.open('POST', url + "/load_incidente", true);
	peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	peticion.send('data=' + data);

});
