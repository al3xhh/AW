function ocultar(elemento) {
    "use strict";
    document.getElementById(elemento).style.display = "none";
    
}

function mostrar(elemento) {
    "use strict";
    document.getElementById(elemento).style.display = "inline";
}

function ocultarGustos() {
    "use strict";
    ocultar("panelGustos");
    mostrar("editarGustos");
}

function ocultarEdicionGustos() {
    "use strict";
    ocultar("editarGustos");
    mostrar("panelGustos");
}

//funciones para validar el formulario de editar perfil
function borrarCampos(){
	$("#form_editar_Perfil").find("input").text("");
}
//funcion que valida todo el formulario de editar perfil

function validarCorreo(){

   var reg_correo = /^[a-zA-Z0-9._\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,4}$/,
       correo = document.getElementById("id_nuevo_email"),
       correo_val = correo.value;
    if(correo_val.trim() === ""){
        return true;
    }
    else if (!reg_correo.test(correo_val)) {
      document.getElementById("ID_error_email").style.display = "block";
      document.getElementById("ID_error_email").innerHTML = "El formato del correo es erróneo";
      return false;
   } else {
      document.getElementById("ID_error_email").style.display = "none";
      return true;
   }
}

function validarDescripcion(){

  var descripcion = document.getElementById("id_descripcion").value;
  if(descripcion.trim() === ""){
      document.getElementById("ID_error_descripcion").style.display = "none";
      return true;
  }
  else if(descripcion.lenght > 140){
      document.getElementById("ID_error_descripcion").style.display = "block";
      document.getElementById("ID_error_descripcion").innerHTML = "La descripcion no puede superar los 140 caracteres";
  }
  else{
      document.getElementById("ID_error_descripcion").style.display = "none";
      return true;
  }
}

function validarNuevaFotoPerfil(){
    "use strict";
    
    var imagen = document.getElementById("nueva_imagen_perfil");
     var uploadImg = imagen.value;
        if(uploadImg.trim() === ""){
            return true;
        }
        else if(!(/\.(jpg)$/i).test(uploadImg)){
            document.getElementById("ID_error_perfil").style.display = "block";
            document.getElementById("ID_error_perfil").innerHTML = "La extension del archivo no se soporta. Solo jpg.";
            return false;
        }
        else if(imagen.size > 31457280){
            document.getElementById("ID_error_perfil").style.display = "block";
            document.getElementById("ID_error_perfil").innerHTML = "El archivo no puede superar los 30MB";
            return false;
        }
        else{
			document.getElementById("ID_error_perfil").style.display = "none";
			return true;
        }
}

function validarEncabezado(){
	"use strict";
    
    var imagen = document.getElementById("nuevo_encabezado");
     var uploadImg = imagen.value;
        if(uploadImg.trim() === ""){
            return true;
        }
        else if(!(/\.(jpg)$/i).test(uploadImg)){
            document.getElementById("ID_error_encabezado").style.display = "block";
            document.getElementById("ID_error_encabezado").innerHTML = "La extension del archivo no se soporta. Solo jpg.";
            return false;
        }
        else if(imagen.size > 31457280){
            document.getElementById("ID_error_encabezado").style.display = "block";
            document.getElementById("ID_error_encabezado").innerHTML = "El archivo no puede superar los 30MB";
            return false;
        }
        else{
            document.getElementById("ID_error_encabezado").style.display = "none";
            return true;
        }
}

function validarDatosEditarPerfil(event){
	"use_strict";
	var ret = (validarCorreo() & validarDescripcion() & validarNuevaFotoPerfil() & validarEncabezado());
    
    if (ret === 0) {
        event.preventDefault();
        return false;
    } else {
        return true;
    }
}

//fin funciones para validar el formulario de editar perfil

$( document ).ready(function() {
	var edicion = false;
    $("#habilitar_edicion").on("click", function () {
        if(!edicion){
			ocultarGustos();
			edicion = true;
		}
    });
	$("#guardar_cambios").on("click", function () {
		edicion = false;
		ocultarEdicionGustos();
		return true;
    });
	$("#cancelar").on("click", function () {
		edicion = false;
		borrarCampos();
		ocultarEdicionGustos();
    });
	
	//eventos del formulario de editarPerfil
	$("#cambiar_perfil").click( function () {
        validarDatosEditarPerfil(event);
    });
});