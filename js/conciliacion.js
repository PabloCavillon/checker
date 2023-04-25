var url = window.location.href;
eraseCookie('fecha');

var datepicker = document.getElementById('datepicker');
datepicker.addEventListener('change', function(e){
    e.preventDefault();
    var fecha = e.target.value;
    console.log(fecha);
    if(fecha != ""){
        document.cookie = 'fecha='+fecha;
    }
    window.location = url;
});
