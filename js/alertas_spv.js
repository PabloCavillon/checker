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

var button_alert = document.getElementById('alerta'); 

button_alert.addEventListener('click',  e => {
    e.preventDefault();
    Swal.fire({
        icon: 'warning',
        title: '<p class="alerta">Alertas SPV</p>',
        html: '<p class="alerta">En caso de detectar problemas con las \'alertas SPV\' reportar al equipo de Tecno Control de Red.</p>',
        allowOutsideClick: false,
         allowEnterKey: true,
        allowEscapeKey: false,
        stopKeydownPropagation: false
    });
})