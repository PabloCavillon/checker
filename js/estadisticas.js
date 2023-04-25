var url = window.location.href;
eraseCookie('mes');
eraseCookie('year');

var colors = [ "#044B92","#32C9C0", "#FB5265", "#FFD140", "#FFB038", "#218838", "#803f93", "#a86b2f", "#7F7F7F"];
var colors_frio = ["#218838", "#044B92","#32C9C0", "#7F7F7F"];
var colors_calido = [ "#FB5265", "#FFD140", "#FFB038", "#803f93", "#a86b2f"];

if (tareas.length != 0){
   console.log(tareas);
   var data = [];
   tareas.forEach(tarea => {
      data.push({label: tarea['apellido'], value: tarea['cantidad']});
   });
   new Morris.Donut({
      element: 'tareas',
      data: data, 
      colors: colors,
      resize: "true"
   });
} else {
   graficar_vacio('tareas');
}

if (tareas_ok.length != 0){
   var data = [];
   tareas_ok.forEach(tarea => {
      data.push({label: tarea['apellido'], value: tarea['cantidad']});
   });
   new Morris.Donut({
      element: 'tareas_ok',
      data: data, 
      colors: colors_frio, 
      resize:true
   });
} else {
   graficar_vacio('tareas_ok');
}

if (tareas_error.length != 0){
   var data = [];
   tareas_error.forEach(tarea => {
      data.push({label: tarea['apellido'], value: tarea['cantidad']});
   });
   new Morris.Donut({
      element: 'tareas_error',
      data: data, 
      colors: colors_calido, 
      resize:true
});
} else {
   graficar_vacio('tareas_error');
}

if (liquis.length != 0){
   var data = [];
   liquis.forEach(liqui => {
      data.push({label: liqui['apellido'], value: liqui['cantidad']});
   });
   new Morris.Donut({
      element: 'liquis',
      data: data, 
      colors: colors, 
      resize:true
   });
} else {
   graficar_vacio('liquis');
}

if (liquis_ok.length != 0){
   var data = [];
   liquis_ok.forEach(liqui => {
      data.push({label: liqui['apellido'], value: liqui['cantidad']});
   });
   new Morris.Donut({
      element: 'liquis_ok',
      data: data, 
      colors: colors_frio, 
      resize:true
   });
} else {
   graficar_vacio('liquis_ok');
}

if (liquis_error.length != 0){
   var data = [];
   liquis_error.forEach(liqui => {
      data.push({label: liqui['apellido'], value: liqui['cantidad']});
   });
   new Morris.Donut({
      element: 'liquis_error',
      data: data, 
      colors: colors_calido, 
      resize: 'true'
   });
} else {
   graficar_vacio('liquis_error');
}

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

function cargar_peso_de_archivos(){
   document.cookie = 'mes=' + mes.value;
   document.cookie = 'year=' + year.value;
   
   window.location = url;
}

function graficar_vacio(grafico){
   console.log(grafico);
   new Morris.Donut({
      element: grafico,
      data: [{label: "SIN DATOS", value: 0}], 
      colors: "#ffffff",
      resize: "true"
   });
}