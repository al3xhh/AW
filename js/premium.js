function validarUsuario() {
    "use strict";

    var reg_usuario = /^[a-z0-9].{1,15}$/i,
        reg_email = /^[a-zA-Z0-9._\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,4}$/,
        usuario = document.getElementById("ID_Usuario"),
        usuario_val = usuario.value;

    if (usuario_val === "") {
        document.getElementById("ID_Error_Usuario").style.display = "block";
        document.getElementById("ID_Error_Usuario").innerHTML = "Debes introducir un nombre de usuario";
        return false;
    } else if (!reg_usuario.test(usuario_val) && !reg_email.test(usuario_val)) {
        document.getElementById("ID_Error_Usuario").style.display = "block";
        document.getElementById("ID_Error_Usuario").innerHTML = "El formato del email/nombre de usuario es erroneo";
        return false;
    } else {
        document.getElementById("ID_Error_Usuario").style.display = "none";
        return true;
    }
}

function validarContrasenya() {
    "use strict";

    var reg_pass = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,15}$/,
        pass = document.getElementById("ID_Pass"),
        pass_val = pass.value;

    if (pass_val === "") {
        document.getElementById("ID_Error_Pass").style.display = "block";
        document.getElementById("ID_Error_Pass").innerHTML = "Debes introducir una contraseña";
        return false;
    } else if (!reg_pass.test(pass_val)) {
        document.getElementById("ID_Error_Pass").style.display = "block";
        document.getElementById("ID_Error_Pass").innerHTML = "La contraseña debe tener una longitud entre 5 y 15, al menos una mayúscula, una minúscula y un número";
        return false;
    } else {
        document.getElementById("ID_Error_Pass").style.display = "none";
        return true;
    }
}

function validarCuenta() {
    "use strict";

    var cuenta = document.getElementById("ID_Cuenta"),
        cuenta_val = cuenta.value;

    if (cuenta_val === "") {
        document.getElementById("ID_Error_Cuenta").style.display = "block";
        document.getElementById("ID_Error_Cuenta").innerHTML = "Debes introducir un numero de cuenta";
        return false;
    } else if (cuenta_val.length !== 16) {
        document.getElementById("ID_Error_Cuenta").style.display = "block";
        document.getElementById("ID_Error_Cuenta").innerHTML = "La cuenta debe tener 16 digitos";
        return false;
    } else if(isNaN(cuenta_val)) {
        document.getElementById("ID_Error_Cuenta").style.display = "block";
        document.getElementById("ID_Error_Cuenta").innerHTML = "El número de cuenta solo debe contener numeros enteros";
    } else {
        if (meses_val % 1 !== 0){
            document.getElementById("ID_Error_Cuenta").style.display = "block";
            document.getElementById("ID_Error_Cuenta").innerHTML = "El número de cuenta solo debe contener numeros enteros";
        }
        else{
            document.getElementById("ID_Error_Cuenta").style.display = "none";
            return true;
        }
    }
}

function validarMeses() {
    "use strict";

    var meses = document.getElementById("ID_Num_meses"),
        meses_val = meses.value;

    if (meses_val === "") {
        document.getElementById("ID_Error_meses").style.display = "block";
        document.getElementById("ID_Error_meses").innerHTML = "Debes introducir el numero de meses que desas pagar";
        return false;
    } else if (isNaN(meses_val)) {
        document.getElementById("ID_Error_meses").style.display = "block";
        document.getElementById("ID_Error_meses").innerHTML = "Debes introducir un numero entre 1 y 12";
        return false;
    } else {
        if ((meses_val % 1 !== 0) || (meses_val < 0) || (12 < meses_val)) {
            document.getElementById("ID_Error_meses").style.display = "block";
            document.getElementById("ID_Error_meses").innerHTML = "Debes introducir un numero entero entre 1 y 12";
            return false;
        }
        document.getElementById("ID_Error_meses").style.display = "none";
        return true;
    }
}

function validarPremium() {

    var ret = (validarContrasenya() & validarUsuario() & validarCuenta() & validarMeses());

    if (ret === 0) {
        return false;
    } else {
        return true;
    }
}