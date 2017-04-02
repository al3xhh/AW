function getRandomInt(min, max) {
    "use strict";
    
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function validarRegistro() {
    "use strict";
    
    var reg_correo = /^[a-zA-Z0-9._\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,4}$/,
        usuario = document.getElementById("ID_Usuario"),
        usuario_val = usuario.value,
        correo = document.getElementById("ID_Correo"),
        correo_val = correo.value,
        pass = document.getElementById("ID_Pass"),
        pass_val = pass.value,
        pass1 = document.getElementById("ID_Pass1"),
        pass1_val = pass1.value,
        resultado = document.getElementById("ID_Resultado_Suma"),
        resultado_val = parseInt(resultado.value, 10),
        sumandos = document.getElementById("ID_Suma").innerHTML.split(" "),
        sumando1 = parseInt(sumandos[0], 10),
        sumando2 = parseInt(sumandos[2], 10),
        ret = true;

    if (usuario_val === "") {
        document.getElementById("ID_Error_Usuario").style.display = "block";
        document.getElementById("ID_Error_Usuario").innerHTML = "Debes introducir un nombre de usuario";
        ret = false;
    } else {
        document.getElementById("ID_Error_Usuario").style.display = "none";
    }

    if (correo_val === "" || !reg_correo.test(correo_val)) {
        document.getElementById("ID_Error_Correo").style.display = "block";
        document.getElementById("ID_Error_Correo").innerHTML = "El formato del correo es erróneo";
        ret = false;
    } else {
        document.getElementById("ID_Error_Correo").style.display = "none";
    }

    if (pass_val === "" || pass_val.length < 5 || pass_val.length > 15) {
        document.getElementById("ID_Error_Pass").style.display = "block";
        document.getElementById("ID_Error_Pass").innerHTML = "La contraseña debe tener una longitud entre 5 y 15";
        ret = false;
    } else {
        document.getElementById("ID_Error_Pass").style.display = "none";
    }

    if (pass1_val === "" || pass1_val.length < 5 || pass1_val.length > 15) {
        document.getElementById("ID_Error_Pass1").style.display = "block";
        document.getElementById("ID_Error_Pass1").innerHTML = "La contraseña debe tener una longitud entre 5 y 15";
        ret = false;
    } else {
        document.getElementById("ID_Error_Pass1").style.display = "none";
    }

    if (pass_val !== pass1_val || (pass_val === "" || pass1_val === "")) {
        document.getElementById("ID_Error_Pass1").style.display = "block";
        document.getElementById("ID_Error_Pass1").innerHTML = "Las contraseñas no coinciden";
        ret = false;
    } else {
        document.getElementById("ID_Error_Pass1").style.display = "none";
    }
    
    if (resultado_val !== (sumando1 + sumando2)) {
        document.getElementById("ID_Error_Suma").style.display = "block";
        document.getElementById("ID_Error_Suma").innerHTML = "Error en la suma";
        ret = false;
    } else {
        document.getElementById("ID_Error_Suma").style.display = "none";
    }

    return ret;
}

window.onload = function () {
    "use strict";
    
    var sumando1 = getRandomInt(0, 100),
        sumando2 = getRandomInt(0, 100);
    
    document.getElementById("ID_Error_Usuario").style.display = "none";
    document.getElementById("ID_Error_Correo").style.display = "none";
    document.getElementById("ID_Error_Pass").style.display = "none";
    document.getElementById("ID_Error_Pass1").style.display = "none";
    document.getElementById("ID_Error_Suma").style.display = "none";
    document.getElementById("ID_Suma").innerHTML = "* " + sumando1 + " + " + sumando2 + " =";
};