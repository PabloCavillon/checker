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


var buttons_comentario = document.getElementsByName('comentario');
buttons_comentario.forEach(btn => {
	document.getElementById(btn.id).addEventListener("click", function(e){
		e.preventDefault();
		var aux = btn.id.split("_");
		comentario(aux[1]);
	});
});

var buttons_detalles = document.getElementsByName('detalle');
buttons_detalles.forEach(btn => {
    btn.addEventListener('click', function(e){

        Swal.fire({
            icon: 'question',
            title: '<p class="alerta">Esta en el ESTLIQ:</p>',
            html: '<p class="alerta">' + btn.value + '</p>',
            allowOutsideClick: false,
            allowEnterKey: true,
            allowEscapeKey: false,
            stopKeydownPropagation: false
        });
    });
});