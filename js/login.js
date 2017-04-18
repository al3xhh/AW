window.onload = function suma() {
	var num1 = Math.floor(Math.random()*(20 - 0) + 0);
	var num2 = Math.floor(Math.random()*(20 - 0) + 0);
	document.getElementById("ID_Suma").setAttribute("placeholder", num1 + " + " + num2);
}

function validarUsuario() {
    "use strict";

    var reg_usuario = /^[a-z0-9].{1,15}$/i;
	var reg_correo = /^[a-zA-Z0-9._\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,4}$/;
    
	var usuario = document.getElementById("ID_Usuario");
    var usuario_val = usuario.value;

    if (usuario_val === "") {
        document.getElementById("ID_Error_Usuario").style.display = "block";
        document.getElementById("ID_Error_Usuario").innerHTML = "Debes introducir un nombre de usuario o correo";
        return false;
    }
	else if (!reg_usuario.test(usuario_val) && !reg_correo.test(usuario_val)){
		document.getElementById("ID_Error_Usuario").style.display = "block";
        document.getElementById("ID_Error_Usuario").innerHTML = "Usuario/Correo incorrecto";
        return false;
	}
	else {
        document.getElementById("ID_Error_Usuario").style.display = "none";
        return true;
    }
}

/*
Función que se encarga de validar la contraseña. Comprueba que no sea vacía,
que contenga al menos una mayúscula y una minúscula. Y que su longitud esté entre 5 y 15.
*/
function validarContrasenya() {
    "use strict";

    var reg_correo = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,15}$/;
    var pass = document.getElementById("ID_Pass");
    var pass_val = pass.value;

    if (pass_val === "") {
        document.getElementById("ID_Error_Pass").style.display = "block";
        document.getElementById("ID_Error_Pass").innerHTML = "Debes introducir una contraseña";
        return false;
    } else if (!reg_correo.test(pass_val)) {
        document.getElementById("ID_Error_Pass").style.display = "block";
        document.getElementById("ID_Error_Pass").innerHTML = "La contraseña debe tener una longitud entre 5 y 15, al menos una mayúscula, una minúscula y un número";
        return false;
    } else {
        document.getElementById("ID_Error_Pass").style.display = "none";
        return true;
    }
}

//Función que comprueba que el usuario ha completado el captcha.
function validarSuma() {
    "use strict";
	var numeros = document.getElementById("ID_Suma").getAttribute("placeholder");
	numeros = numeros.split(" ");
	numeros = parseInt(numeros[0]) + parseInt(numeros[2]);
    var resultado = document.getElementById("ID_Suma").value;	
	if (resultado.trim() === "") {
        document.getElementById("ID_Error_Suma").style.display = "block";
        document.getElementById("ID_Error_Suma").innerHTML = "Debes introducir el resultado de la suma";
        return false;
    } else if (numeros != resultado) {
        document.getElementById("ID_Error_Suma").style.display = "block";
        document.getElementById("ID_Error_Suma").innerHTML = "El resultado es incorrecto";
        return false;
    } else {
        document.getElementById("ID_Error_Suma").style.display = "none";
        return true;
    }
	
}

//Función que comprueba todos los datos
function validarLogin() {
    "use strict";
    
    var ret = (validarUsuario() & validarContrasenya() & validarSuma());
    
    if (ret === 0) {
        return false;
    } else {
        return true;
    }
}