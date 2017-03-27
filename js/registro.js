var correo = document.querySelector('input[name="ID_Correo"]');
var pass = document.querySelector('input[name="ID_Pass"]');
var pass1 = document.querySelector('input[name="ID_Pass1"]');
var usuario = document.querySelector('input[name="ID_Usuario"]');
var boton = document.querySelector('input[name="ID_Boton"]')
correo.setCustomValidity('Debes introducir un correo');
pass.setCustomValidity('Debes introducir una contraseña');
pass1.setCustomValidity('Las contraseñas no coinciden');
usuario.setCustomValidity('Debes introducir un nombre de usuario');

correo.addEventListener('input', function () {
    this.setCustomValidity('');
}, false);

pass.addEventListener('input', function () {
    this.setCustomValidity('');
}, false);

pass1.addEventListener('input', function () {
    this.setCustomValidity('');
}, false);

usuario.addEventListener('input', function () {
    this.setCustomValidity('');
}, false);

correo.addEventListener('keyup', function() {
    var dato_correo = document.getElementById('ID_Correo').value;
    var reg_correo = '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$';

    if(dato_correo == "") {
        this.setCustomValidity("Debes introducir un correo")
    }
    else {
        if(!validarCorreo(dato_correo)) {
            this.setCustomValidity("Error en el formato del correo")    
        }
        else
            this.setCustomValidity("");   
    }
}, false);

pass.addEventListener('keyup', function () {
    var dato_pass = document.getElementById('ID_Pass').value;

    if (dato_pass.length < 5 || dato_pass.length > 15) {
        pass.setCustomValidity("La contraseña debe tener una longitud entre 5 y 15 caracteres");
    }
    else {
        this.setCustomValidity("");
    }
}, false);

pass1.addEventListener('keyup', function () {
    var dato_pass = document.getElementById('ID_Pass').value;
    var dato_pass1 = document.getElementById('ID_Pass1').value;

    if(dato_pass != dato_pass1) {
        this.setCustomValidity("Las contraseñas no coinciden");
    }
    else
        this.setCustomValidity("");
}, false);

function validarCorreo(correo){      
    var reg_correo = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return reg_correo.test(correo); 
} 