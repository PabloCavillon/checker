var url = window.location.href;
eraseCookie('fecha');

var buttons_detalle = document.getElementsByName('expansion_detalle');
buttons_detalle.forEach(btn => {
    btn.addEventListener('click', function(e){
        e.preventDefault();
        var banco = btn.value;
        var trs = document.getElementsByName("detalle_" + banco);
        trs.forEach(tr => {
            tr.classList.toggle('mostrar');
        });
    });
});

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

if ( alertar_PCCGCOE ) {
    Swal.fire({
                title: '<strong class="cartel"> Problemas con los PCCGCOE </strong>',
                icon: 'error',
                html: '<div><h2 class="cartel">Hace más de <span>90 Min.</span> no se generan.</h2>'+
                      '<p class="cartel"> Revisar que ocurre </p></div>',
                showConfirmButton: false,    
                customClass:{
                    title: 'title'
                }
            });
} 