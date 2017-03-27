function validarDatos() {
    var correo = document.getElementById("ID_Correo").value;
    var pass = document.getElementById("ID_Pass").value;
    var pass1 = document.getElementById("ID_Pass1").value;
    var usuario = document.getElementById("ID_Usuario").value;

    if (correo == "") {
        document.getElementById('ID_Correo').setCustomValidity("Debes introducir un correo");
        return false;
    }
    
    if (pass == "") {
        document.getElementById('ID_Pass').setCustomValidity("Debes introducir una contraseña");
        return false;
    }

    if (pass.length > 5 && pass.length < 15) {
        document.getElementById('ID_Pass').setCustomValidity("La contraseña debe tener una longitud entre 5 y 15 caracteres");
        return false;
    }
    
    if(pass != pass1) {
        document.getElementById('ID_Pass1').setCustomValidity("Las contraseñas no coinciden");
        return false;
    }
    
    if (usuario == "") {
        document.getElementById('ID_Usuario').setCustomValidity("Debes introducir un nombre de usuario");
        return false;
    }

    else {
        return true;
    }
}