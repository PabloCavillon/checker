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

var buttons = document.getElementsByName("expansion_detalle");
buttons.forEach(btn => {

    btn.addEventListener('click', (e) => {
        e.preventDefault();
        var archivo = btn.value;

        var trs = document.getElementsByName(archivo);

        trs.forEach(tr => {
            tr.classList.toggle('mostrar');
        });

    })

})

var labels = [];
for (var i = 1; i< 366; i++) {
    labels.push(i);
}

new Morris.Line({
  element: 'grafico',
  data: data,
  xkey: 'juliano',
  ykeys: ['fecha'],
  labels: ['fecha'],
  xLabels: "day"
});
