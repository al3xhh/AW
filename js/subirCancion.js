/*
ID_Cancion
ID_Artista
ID_Cancion
*/

function validarCancion() {
    "use strict";
    
	var cancion = document.getElementById("ID_Cancion");
    var cancion_val = cancion.value;

    if (cancion_val.trim() === "") {
        document.getElementById("ID_Error_Cancion").style.display = "block";
        document.getElementById("ID_Error_Cancion").innerHTML = "Debes introducir el nombre de la cancion";
        return false;
    }
	else {
        document.getElementById("ID_Error_Cancion").style.display = "none";
        return true;
    }
}

function validarArtista() {
    "use strict";
    
	var artista = document.getElementById("ID_Artista");
    var artista_val = artista.value;

    if (artista_val.trim() === "") {
        document.getElementById("ID_Error_Artista").style.display = "block";
        document.getElementById("ID_Error_Artista").innerHTML = "Debes introducir el nombre del artista";
        return false;
    }
	else {
        document.getElementById("ID_Error_Artista").style.display = "none";
        return true;
    }
}