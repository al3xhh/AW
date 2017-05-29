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

function validarImagen(){

/*
ID_Imagen
ID_Error_Imagen
*/
	"use strict";
	
	var imagen = document.getElementById("ID_Imagen");
     var uploadImg = imagen.value;
		if(uploadImg.trim() === ""){
			document.getElementById("ID_Error_Imagen").style.display = "block";
            document.getElementById("ID_Error_Imagen").innerHTML = "Si no subes foto, se pondra una por defecto";
            return true;
		}
        else if(!(/\.(jpg)$/i).test(uploadImg)){
            document.getElementById("ID_Error_Imagen").style.display = "block";
            document.getElementById("ID_Error_Imagen").innerHTML = "La extension del archivo no se soporta. Solo jpg y png";
            return false;
        }
		else if(imagen.size > 31457280){
			document.getElementById("ID_Error_Imagen").style.display = "block";
            document.getElementById("ID_Error_Imagen").innerHTML = "El archivo no puede superar los 30MB";
            return false;
		}
        else{
            document.getElementById("ID_Error_Imagen").style.display = "none";
            return true;
        }
}

function validarArchivoCancion(){
		
		"use strict";
		var cancion = document.getElementById("ID_Archivo_Cancion");
        var uploadCancion = cancion.value;
		
		if(uploadCancion.trim() === ""){
			document.getElementById("ID_Error_Archivo_Cancion").style.display = "block";
            document.getElementById("ID_Error_Archivo_Cancion").innerHTML = "Debes subir una cancion";
            return false;
		}
        else if(!(/\.(mp3)$/i).test(uploadCancion)){
            document.getElementById("ID_Error_Archivo_Cancion").style.display = "block";
            document.getElementById("ID_Error_Archivo_Cancion").innerHTML = "La extension de la cancion no se soporta. Solo mp3";
            return false;
        }
		else if(cancion.size > 31457280){
			document.getElementById("ID_Error_Archivo_Cancion").style.display = "block";
            document.getElementById("ID_Error_Archivo_Cancion").innerHTML = "El archivo no puede superar los 30MB";
            return false;
		}
        else{
            document.getElementById("ID_Error_Archivo_Cancion").style.display = "none";
            return true;
        }
 
}

function validarGenero(){

	var genero = document.getElementById("genero_cancion");
	
		var indice = genero.selectedIndex;
		if(indice < 0 || indice > genero.lenght){
			document.getElementById("ID_Error_Genero").style.display = "block";
			document.getElementById("ID_Error_Genero").innerHTML = "Tienes que seleccionar un genero";
			return false;
		}
		else{
			return true;
		}
}

function validarFormCancion(){
    "use strict";

    var ok = (validarCancion() & validarImagen() & validarArchivoCancion() & validarGenero());

    if(ok == 0){
		event.preventDefault();
        return false;
    }
    else{
        return true;
    }

}
/*

*/
$( document ).ready(function() {
    $("#ID_Cancion").bind("change", function () {
        validarCancion();
    });
    $("#ID_Imagen").bind("change", function () {
        validarImagen();
    });
	$("#ID_Archivo_Cancion").bind("change", function () {
        validarArchivoCancion();
    });
	$("#genero_cancion").bind("change", function () {
        validarGenero();
    });
    $("form").bind("submit", function () {
        validarFormCancion(event);
    });
});
