var url = window.location.href;
eraseCookie('fecha');

var buttons_rechazos = document.getElementsByName('expansion_rechazos');
buttons_rechazos.forEach(btn => {
    btn.addEventListener('click', function(e){
        e.preventDefault();
        btn.classList.toggle('volteado');
        var banco = btn.value;
        var trs = document.getElementsByName("rechazos_" + banco);
        trs.forEach(tr => {
            tr.classList.toggle('mostrar');
        });
        
    });
}); 

var datepicker = document.getElementById('datepicker');
datepicker.addEventListener('change', function(e){
    e.preventDefault();
    var fecha = e.target.value;
    if(fecha != ""){
        document.cookie = 'fecha='+fecha;
    }
    window.location = url;
});