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
    } else if (isNaN(cuenta_val)) {
        document.getElementById("ID_Error_Cuenta").style.display = "block";
        document.getElementById("ID_Error_Cuenta").innerHTML = "El número de cuenta solo debe contener numeros enteros";
        return false;
    } else {
        if (cuenta_val % 1 !== 0) {
            document.getElementById("ID_Error_Cuenta").style.display = "block";
            document.getElementById("ID_Error_Cuenta").innerHTML = "El número de cuenta solo debe contener numeros enteros";
            return false;
        } else {
            document.getElementById("ID_Error_Cuenta").style.display = "none";
            return true;
        }
    }
}

function validarCVV() {
    "use strict";

    var cvv = document.getElementById("ID_CVV"),
        cvv_val = cvv.value;

    if (cvv_val === "") {
        document.getElementById("ID_Error_CVV").style.display = "block";
        document.getElementById("ID_Error_CVV").innerHTML = "Debes introducir un CVV (3 digitos)";
        return false;
    } else if (cvv_val.length !== 3) {
        document.getElementById("ID_Error_CVV").style.display = "block";
        document.getElementById("ID_Error_CVV").innerHTML = "El CVV debe tener 3 digitos, mirar reverso de tarjeta";
        return false;
    } else if (isNaN(cvv_val)) {
        document.getElementById("ID_Error_CVV").style.display = "block";
        document.getElementById("ID_Error_CVV").innerHTML = "El CVV solo debe contener numeros enteros";
        return false;
    } else {
        if (cvv_val % 1 !== 0) {
            document.getElementById("ID_Error_CVV").style.display = "block";
            document.getElementById("ID_Error_CVV").innerHTML = "El número de cuenta solo debe contener numeros enteros";
            return false;
        } else {
            document.getElementById("ID_Error_CVV").style.display = "none";
            return true;
        }
    }

}

function validarFechaCad() {
    "use strict";

    var fecha = document.getElementById("ID_Fecha_Cad"),
        fecha_val = fecha.value,
        reg_fecha = /^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$/,
        tokens = fecha_val.split("-"),
        day = tokens[2],
        month = tokens[1],
        year = tokens[0],
        date = new Date(year, month - 1, day),
        monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ],
        today = new Date();

    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
        monthLength[1] = 29;

    if (fecha_val === "") {
        document.getElementById("ID_Error_Fecha_Cad").style.display = "block";
        document.getElementById("ID_Error_Fecha_Cad").innerHTML = "Debes introducir una fecha de caducidad";
        return false;
    } else if (!reg_fecha.test(fecha_val)) {
        document.getElementById("ID_Error_Fecha_Cad").style.display = "block";
        document.getElementById("ID_Error_Fecha_Cad").innerHTML = "Debes introducir una fecha con formato dd/mm/aaaa";
        return false;
    } else if (year < today.getFullYear() || year > today.getFullYear() + 10 || month <= 0 || month > 12 || today > date) {
        document.getElementById("ID_Error_Fecha_Cad").style.display = "block";
        document.getElementById("ID_Error_Fecha_Cad").innerHTML = "Debes introducir una fecha valida, puede que la tarjeta este caducada (dd/mm/aaaa)";
        return false;
    } else if (!(day > 0 && day <= monthLength[month - 1])) {
        document.getElementById("ID_Error_Fecha_Cad").style.display = "block";
        document.getElementById("ID_Error_Fecha_Cad").innerHTML = "Debes introducir una fecha valida (dd/mm/aaaa)";
        return false;
    } else {
        document.getElementById("ID_Error_Fecha_Cad").style.display = "none";
        return true;
    }

}

function validarTitular(){
    "use strict";

    var titular = document.getElementById("ID_Titular"),
        titular_val = titular.value,
        reg_titular = /^[a-zA-Z-].{1,100}$/i

    if (titular_val === ""){
        document.getElementById("ID_Error_Titular").style.display = "block";
        document.getElementById("ID_Error_Titular").innerHTML = "Debes introducir el nombre del titular de la cuenta";
        return false;
    } else if (!reg_titular.test(titular_val)){
        document.getElementById("ID_Error_Titular").style.display = "block";
        document.getElementById("ID_Error_Titular").innerHTML = "El nombre del titular solo debe contener letras";
        return false;
    } else {
        document.getElementById("ID_Error_Titular").style.display = "none";
        return true;
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

function validarPremium(event){
    "use strict";

    var ret = (validarCuenta() & validarMeses() & validarCVV() & validarFechaCad() & validarTitular());

    if (ret === 0) {
		event.preventDefault();
        return false;
    } else {
        return true;
    }
}

$( document ).ready(function() {
	//eventos del formulario de editar premium
	$("#cambiar_premium").click( function () {
        validarPremium(event);
    });
});