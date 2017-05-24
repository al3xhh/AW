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

function actualizarGustos(){
	//script de ajax
}

//funciones para validar el formulario de editar perfil
function borrarCampos(){
	$("form_editar_Perfil").find("input").text("");
}
//funcion que valida todo el formulario de editar perfil

function validarNombreUsuario(){
	"use strict";

    var reg_usuario = /^[a-z0-9].{1,15}$/i;
    
	var usuario = document.getElementById("id_nuevo_usuario");
    var usuario_val = usuario.value;

	if(!reg_usuario.test(usuario_val) && !reg_correo.test(usuario_val)){
		document.getElementById("ID_error_nuevo_usuario").style.display = "block";
        document.getElementById("ID_error_nuevo_usuario").innerHTML = "Usuario/Correo incorrecto";
        return false;
	}
	else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                if(this.responseText != ""){
                    document.getElementById("ID_error_nuevo_usuario").style.display = "block";
                    document.getElementById("ID_error_nuevo_usuario").innerHTML = this.responseText;
                }
            }
        };
        xmlhttp.open("GET", "../php/cambiar_usuario.php?usuario="+usuario_val, true);
        xmlhttp.send();
        document.getElementById("ID_error_nuevo_usuario").style.display = "none";
        return true;
    }
}

function validarCorreo(){

   var reg_correo = /^[a-zA-Z0-9._\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,4}$/,
       correo = document.getElementById("id_nuevo_email"),
       correo_val = correo.value;

   if (correo_val === "") {
      document.getElementById("ID_error_email").style.display = "block";
      document.getElementById("ID_error_email").innerHTML = "Debes introducir un correo";
      return false;
   } else if (!reg_correo.test(correo_val)) {
      document.getElementById("ID_error_email").style.display = "block";
      document.getElementById("ID_error_email").innerHTML = "El formato del correo es erróneo";
      return false;
   } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200) {
            if(this.responseText != "") {
               document.getElementById("ID_error_email").style.display = "block";
               document.getElementById("ID_error_email").innerHTML = this.responseText;
            }
         }
      };//COMO COÑO COJO EL USUARIO PARA PASARSELO AL SCRIPT
      xmlhttp.open("GET", "../php/cambiar_correo.php?correo=" + correo_val + ":usuario=" + , true);
      xmlhttp.send();
      document.getElementById("ID_error_email").style.display = "none";
      return true;
   }
}

function validarDatosEditarPerfil(event){
	"use_strict";
	/*
	imagenPerfil
	ImagenEncabezado
	Descripcion
	*/
	var ret = (validarNombreUsuario() & validarCorreo());
    
    if (ret === 0) {
        //esto hace que no haga submit el formulario
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
		actualizarGustos();
    });
	$("#cancelar").on("click", function () {
		edicion = false;
		borrarCampos();
		ocultarEdicionGustos();
    });
	
	//eventos del formulario de editarPerfil
	$("#form_editar_Perfil").bind("submit", function () {
        validarDatosEditarPerfil(event);
    });
});