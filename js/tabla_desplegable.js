var abierto = false;
var cartera = "000";

function desplegar(id){
    var h2 = document.getElementById("h2_" + id);
    var div = document.getElementById("div_" + id);

    if (cartera == id || cartera == "000"){
        if (abierto){
            document.getElementById(id).style.display="none";
            h2.innerHTML = "<i class='fas fa-hand-point-down' aria-hidden='true'></i> CARTERA " + id + " <i class='fas fa-hand-point-down' aria-hidden='true'></i>";
            div.classList.toggle('activo');
            cartera = "000";
            abierto = false;
        } else {
            document.getElementById(id).style.display="block";
            h2.innerHTML = "<i class='fas fa-hand-point-up'></i> CARTERA " + id + " <i class='fas fa-hand-point-up'></i>";
            div.classList.toggle('activo');
            cartera = id;
            abierto = true;
        }   
    }

}
