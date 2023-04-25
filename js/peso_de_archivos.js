var url = window.location.href;
eraseCookie('mes');
eraseCookie('year');
eraseCookie('cartera');

var mes = document.getElementById('month');
mes.addEventListener('change', function(e){
    e.preventDefault();
    cargar_peso_de_archivos();
});

var year = document.getElementById('year');
year.addEventListener('change', function(e){
    e.preventDefault();
    cargar_peso_de_archivos();
});

var cartera = document.getElementById('cartera');
cartera.addEventListener('change', function(e){
    e.preventDefault();
    cargar_peso_de_archivos();
});

function cargar_peso_de_archivos(){
    document.cookie = 'mes=' + mes.value;
    document.cookie = 'year=' + year.value;
    document.cookie = 'cartera=' + cartera.value;
    
    window.location = url;
}

var tabla_preli = document.getElementById('tabla_preli');
var tabla_liqui = document.getElementById('tabla_liqui');

var btn_preli = document.getElementById('preli');
btn_preli.addEventListener('click', function(e){
    e.preventDefault();
    toggle_clases();
});

var btn_liqui = document.getElementById('liqui');
btn_liqui.addEventListener('click', function(e){
    e.preventDefault();
    toggle_clases();
});

function toggle_clases(){
    tabla_preli.classList.toggle('hide');
    tabla_liqui.classList.toggle('hide');
    btn_preli.classList.toggle('hide');
    btn_liqui.classList.toggle('hide');
}