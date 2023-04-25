var url = window.location.href;

var botones = document.getElementsByName('info');
botones.forEach(btn => {
    btn.addEventListener('click', function(e){
		e.preventDefault();
		var peticion = new XMLHttpRequest();
		peticion.onload = function(){
			var info = JSON.parse(peticion.responseText);
	
			var coordinadores_txt = "<table class='table-alert center'><tbody>";
			var carteras_debito   = "";
			var carteras_credito  = "";

			info['coordinadores'].forEach(coordinador => {
				coordinadores_txt = coordinadores_txt +
									"<tr><td>" +  coordinador['apenom'] + "</td><td><i class='fas fa-phone-alt'></i> " + coordinador['interno'] + "</td></tr>";
			});
			coordinadores_txt = coordinadores_txt + "</tbody></table>";

			info['carteras'].forEach(cartera => {
				if(cartera['tipo'] == 'C'){
					if (carteras_credito == ""){
						carteras_credito = "<h4>CARTERAS DE CRÉDITO</h4>" + cartera['cartera'];
					} else {
						carteras_credito = carteras_credito + " - " + cartera['cartera'];
					}
				}
				if(cartera['tipo'] == 'D'){
					if (carteras_debito == ""){
						carteras_debito = "<h4>CARTERAS DE DÉBITO</h4>" + cartera['cartera'];
					} else {
						carteras_debito = carteras_debito + " - " + cartera['cartera'];
					}
				}
			});

			Swal.fire({
				title: '<strong>BANCO ' + btn.value + '</strong>',
				icon: 'info',
				html: '<div class="data"><h3>COORDINADORES</h3>'+ coordinadores_txt +	
					  '</br>' + carteras_credito + '</br></br>' + carteras_debito + '</div>',
				showConfirmButton: false,	 
				customClass:{
					title: 'title'
				}
			});
		}
		var banco = { 'id': btn.value }; 
		var data = JSON.stringify(banco);
		peticion.open('POST', url + "/get_info", true);
		peticion.setRequestHeader("content-Type", "application/x-www-form-urlencoded");
		peticion.send('data=' + data);
	});
});
