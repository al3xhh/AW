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

function validarImagen(imagen){

/*
ID_Imagen
ID_Error_Imagen
*/

    "use strict";

    if(imagen != null){

        var uploadImg = imagen.files[0];
        if(!(/\.(jpg|png)$/i).test(uploadImg.name)){
            document.getElementById("ID_Error_Imagen").style.display = "block";
            document.getElementById("ID_Error_Imagen").innerHTML = "La extension del archivo no se soporta. Solo jpg y png";
            return false;
        }
        else{
            document.getElementById("ID_Error_Imagen").style.display = "block";
            return true;
        }
    }
    else{
        document.getElementById("ID_Error_Imagen").style.display = "none";
        return true;
    }
}

function validarArchivoCancion(){
    "use strict";
    var cancion = document.getElementById("ID_Archivo_Cancion");
    if(cancion != null){
        var uploadCancion = cancion.value;
        if(!(/\.(mp3|mp4|wav)$/i).test(uploadCancion)){
            document.getElementById("ID_Error_Archivo_Cancion").style.display = "block";
            document.getElementById("ID_Error_Archivo_Cancion").innerHTML = "La extension de la cancion no se soporta. Solo mp3, mp4 y wav";
            return false;
        }
        else{
            document.getElementById("ID_Error_Archivo_Cancion").style.display = "none";
            return true;
        }
    }
    else{
        document.getElementById("ID_Error_Archivo_Cancion").style.display = "block";
        document.getElementById("ID_Error_Archivo_Cancion").innerHTML = "No puedes dejar vacio el campo cancion";
        return false;
    }
}

function validarFormCancion(){
    "use strict";

    var ok = (validarCancion() & validarArtista() & validarImagen() & validarArchivoCancion());

    if(ok == 0){
        return false;
    }
    else{
        return true;
    }

}