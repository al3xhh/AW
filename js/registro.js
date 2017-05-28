/*Función que se encarga de validar el nombre usuario. Comprueba que no sea vacío,
que sólo contenga caracteres alfanuméricos y que la longitud sea menor que 17.
*/
function validarUsuario() {
   "use strict";

   var reg_usuario = /^[a-zA-Z ]{2,30}$/,
       usuario = $("#ID_Usuario"),
       usuario_val = usuario.val();

   $("#ID_Error_Usuario").hide();
   $("#ID_Error_Usuario_1").hide();
   $("#ID_Error_Usuario_2").hide();

   if (usuario_val === "") {
      $("#ID_Error_Usuario").show();
      $("#ID_Error_Usuario").html("Debes introducir un nombre de usuario");
      return false;
   } else if (!reg_usuario.test(usuario_val)) {
      $("#ID_Error_Usuario").show();
      $("#ID_Error_Usuario").html("El usuario sólo puede contener números y letras y debe tener una longitud menor a 17");
      return false;
   } else {
      var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200) {
            if(this.responseText != "") {
               $("#ID_Error_Usuario").show();
               $("#ID_Error_Usuario").html(this.responseText);
            }
         }
      };

      xmlhttp.open("GET", "../php/registro_usuario.php?usuario=" + usuario_val, true);
      xmlhttp.send();

      return true;
   }
}

//Función que se encarga de validar que el formato del correo sea válido.
function validarCorreo() {
   "use strict";

   var reg_correo = /^[a-zA-Z0-9._\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,4}$/,
       correo = $("#ID_Correo"),
       correo_val = correo.val();

   $("#ID_Error_Correo").hide();
   $("#ID_Error_Correo_1").hide();
   $("#ID_Error_Correo_2").hide();

   if (correo_val === "") {
      $("#ID_Error_Correo").show()
      $("#ID_Error_Correo").html("Debes introducir un correo");
      return false;
   } else if (!reg_correo.test(correo_val)) {
      $("#ID_Error_Correo").show();
      $("#ID_Error_Correo").html("El formato del correo es erróneo");
      return false;
   } else {
      var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200) {
            if(this.responseText != "") {
               $("#ID_Error_Correo").show();
               $("#ID_Error_Correo").html(this.responseText);
            }
         }
      };

      xmlhttp.open("GET", "../php/registro_correo.php?correo=" + correo_val, true);
      xmlhttp.send();

      return true;
   }
}

/*
Función que se encarga de validar la contraseña. Comprueba que no sea vacía,
que contenga al menos una mayúscula y una minúscula. Y que su longitud esté entre 5 y 15.
*/
function validarContrasenya() {
   "use strict";

   var reg_contrasenya = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,15}$/,
       pass = $("#ID_Pass"),
       pass_val = pass.val();

   $("#ID_Error_Pass").hide();
   $("#ID_Error_Pass_1").hide();

   if (pass_val === "") {
      $("#ID_Error_Pass").show();
      $("#ID_Error_Pass").html("Debes introducir una contraseña");
      return false;
   } else if (!reg_contrasenya.test(pass_val)) {
      $("#ID_Error_Pass").show();
      $("#ID_Error_Pass").html("La contraseña debe tener una longitud entre 5 y 15, al menos una mayúscula, una minúscula y un número");
      return false;
   } else {
      return true;
   }
}

//Función que comprueba que las contraseña coincidan.
function validarReContrasenya() {
   "use strict";

   var pass = $("#ID_Pass"),
       pass_val = pass.val(),
       pass1 = $("#ID_Pass1"),
       pass1_val = pass1.val(),
       ret = true;

   $("#ID_Error_Pass1").hide();
   $("#ID_Error_Pass1_1").hide();

   if (pass1_val === "") {
      $("#ID_Error_Pass1").show();
      $("#ID_Error_Pass1").html("Debes volver a introducir la contraseña");
      ret = false;
   }
   if (pass_val !== pass1_val && (pass_val !== "" && pass1_val !== "")) {
      $("#ID_Error_Pass1").show();
      $("#ID_Error_Pass1").html("Las contraseñas no coinciden");
      ret = false;
   }

   return ret;
}

//Función que comprueba que el usuario ha completado el captcha.
function validarCaptcha() {
   "use strict";

   var captcha_response = grecaptcha.getResponse();
   if (captcha_response.length === 0) {
      $("#ID_Error_Captcha").show();
      $("#ID_Error_Captcha").html("El captcha es obligatorio");
      return false;
   } else {
      $("#ID_Error_Captcha").hide();
      return true;
   }
}

//Función que valida el registro entero con ayuda de las funciones anteriores.
function validarRegistro(event) {
   "use strict";

   var ret = (validarUsuario() & validarCorreo() & validarContrasenya() & validarReContrasenya() & validarCaptcha());

   if (ret === 0) {
      event.preventDefault();
      return false;
   } else {
      return true;
   }
}

$( document ).ready(function() {
   $("#ID_Usuario").bind("change", function () {
      validarUsuario();
   });
   $("#ID_Correo").bind("change", function () {
      validarCorreo();
   });
   $("#ID_Pass").bind("change", function () {
      validarContrasenya();
   });
   $("#ID_Pass1").bind("change", function () {
      validarReContrasenya();
   });
   $("#ID_Formulario").bind("submit", function () {
      validarRegistro(event);
   });
});
