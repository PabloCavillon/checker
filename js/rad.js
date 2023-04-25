var url = window.location.href;
eraseCookie('periodo');

var datepicker = document.getElementById('datepicker');
datepicker.addEventListener('change', function(e){
    e.preventDefault();
    var periodo = e.target.value;
    if(periodo != ""){
        document.cookie = 'periodo='+periodo;
    }
    window.location = url;
});