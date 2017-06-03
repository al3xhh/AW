$(document).ready(function() {

   $("#ID_Usuario").change( function(e) {
      e.preventDefault();
      return validarUsuario();
   });

   $("#ID_Pass").change( function(e) {
      e.preventDefault();
      return validarContrasenya();
   });

   $("#ID_Cuenta").change( function(e) {
      e.preventDefault();
      return validarCuenta();
   });

   $("#ID_CVV").change( function(e) {
      e.preventDefault();
      return validarCVV();
   });

   $("#ID_Fecha_Cad").change( function(e) {
      e.preventDefault();
      return validarFechaCad();
   });

   $("#ID_Titular").change( function(e) {
      e.preventDefault();
      return validarTitular();
   });

   $("#ID_Num_meses").change( function(e) {
      e.preventDefault();
      return validarMeses();
   });
   
   $("#premium-form").submit( function(e){
      e.preventDefault();
      return validarPremium();
   });
   
   function validarUsuario() {
      "use strict";

      //definimos las expresiones regulares y obtenomos el valor
      var reg_usuario = /^[a-z0-9].{1,15}$/i,
          reg_email = /^[a-zA-Z0-9._\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,4}$/,
          usuario = document.getElementById("ID_Usuario"),
          usuario_val = usuario.value;

      if (usuario_val === "") {//comprovamos si esta vacio
         document.getElementById("ID_Error_Usuario").style.display = "block";
         document.getElementById("ID_Error_Usuario").innerHTML = "Debes introducir un nombre de usuario";
         return false;
      } else if (!reg_usuario.test(usuario_val) && !reg_email.test(usuario_val)) { //comprobamos si cumple la expresion regular
         document.getElementById("ID_Error_Usuario").style.display = "block";
         document.getElementById("ID_Error_Usuario").innerHTML = "El formato del nombre de usuario es erroneo";
         return false;
      } else {
         document.getElementById("ID_Error_Usuario").style.display = "none";
         return true;
      }
   }

   function validarContrasenya() {
      "use strict";

      //definimos las expresiones regulares y obtenomos el valor
      var reg_pass = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,15}$/,
          pass = document.getElementById("ID_Pass"),
          pass_val = pass.value;

      if (pass_val === "") {//comprovamos si esta vacio
         document.getElementById("ID_Error_Pass").style.display = "block";
         document.getElementById("ID_Error_Pass").innerHTML = "Debes introducir una contraseña";
         return false;
      } else if (!reg_pass.test(pass_val)) {//comprovamos si cumple la expresion regular
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

      //obtenemos el valor
      var cuenta = document.getElementById("ID_Cuenta"),
          cuenta_val = cuenta.value;

      if (cuenta_val === "") {//comprovamos si esta vacio
         document.getElementById("ID_Error_Cuenta").style.display = "block";
         document.getElementById("ID_Error_Cuenta").innerHTML = "Debes introducir un numero de cuenta";
         return false;
      } else if (cuenta_val.length !== 16) {//comprobamos la longitud
         document.getElementById("ID_Error_Cuenta").style.display = "block";
         document.getElementById("ID_Error_Cuenta").innerHTML = "La cuenta debe tener 16 digitos";
         return false;
      } else if (isNaN(cuenta_val)) {//comprobamos si no es un numero
         document.getElementById("ID_Error_Cuenta").style.display = "block";
         document.getElementById("ID_Error_Cuenta").innerHTML = "El número de cuenta solo debe contener numeros enteros";
         return false;
      } else {
         if (cuenta_val % 1 !== 0) {//comprobamos que sea un numero entero
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

      //obtenemos el valor
      var cvv = document.getElementById("ID_CVV"),
          cvv_val = cvv.value;

      if (cvv_val === "") {//comprovamos si esta vacio
         document.getElementById("ID_Error_CVV").style.display = "block";
         document.getElementById("ID_Error_CVV").innerHTML = "Debes introducir un CVV (3 digitos)";
         return false;
      } else if (cvv_val.length !== 3) {//comprobamos que la longitud sea correcta
         document.getElementById("ID_Error_CVV").style.display = "block";
         document.getElementById("ID_Error_CVV").innerHTML = "El CVV debe tener 3 digitos, mirar reverso de tarjeta";
         return false;
      } else if (isNaN(cvv_val)) { //comprobamos si no es un numero
         document.getElementById("ID_Error_CVV").style.display = "block";
         document.getElementById("ID_Error_CVV").innerHTML = "El CVV solo debe contener numeros enteros";
         return false;
      } else {
         if (cvv_val % 1 !== 0) { //comprobamos que sea un numero entero
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

      //definimos las expresiones regulares y obtenomos el valor de las variables necesarias
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

      if (fecha_val === "") {//comprovamos si esta vacio
         document.getElementById("ID_Error_Fecha_Cad").style.display = "block";
         document.getElementById("ID_Error_Fecha_Cad").innerHTML = "Debes introducir una fecha de caducidad";
         return false;
      } else if (!reg_fecha.test(fecha_val)) { //comprobamos si cumple la expresion regular
         document.getElementById("ID_Error_Fecha_Cad").style.display = "block";
         document.getElementById("ID_Error_Fecha_Cad").innerHTML = "Debes introducir una fecha con formato dd/mm/aaaa";
         return false;
      } else if (year < today.getFullYear() || year > today.getFullYear() + 10 || month <= 0 || month > 12 || today > date) {//comprobamos si la fecha es valida
         document.getElementById("ID_Error_Fecha_Cad").style.display = "block";
         document.getElementById("ID_Error_Fecha_Cad").innerHTML = "Debes introducir una fecha valida, puede que la tarjeta este caducada (dd/mm/aaaa)";
         return false;
      } else if (!(day > 0 && day <= monthLength[month - 1])) { //comprobamos si el dia es correcto
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

      //definimos las expresiones regulares y obtenomos el valor
      var titular = document.getElementById("ID_Titular"),
          titular_val = titular.value,
          reg_titular = /^[a-zA-Z-].{1,100}$/i

      if (titular_val === ""){//comprovamos si esta vacio
         document.getElementById("ID_Error_Titular").style.display = "block";
         document.getElementById("ID_Error_Titular").innerHTML = "Debes introducir el nombre del titular de la cuenta";
         return false;
      } else if (!reg_titular.test(titular_val)){//comprobamos si cumple la expresion regular
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

      //obtemos el valor
      var meses = document.getElementById("ID_Num_meses"),
          meses_val = meses.value;

      if (meses_val === "") {//comprovamos si esta vacio
         document.getElementById("ID_Error_meses").style.display = "block";
         document.getElementById("ID_Error_meses").innerHTML = "Debes introducir el numero de meses que desas pagar";
         return false;
      } else if (isNaN(meses_val)) { //comprobomas si no es un numero
         document.getElementById("ID_Error_meses").style.display = "block";
         document.getElementById("ID_Error_meses").innerHTML = "Debes introducir un numero entre 1 y 12";
         return false;
      } else {
         if ((meses_val % 1 !== 0) || (meses_val < 0) || (12 < meses_val)) { //comprobamos que esta en el intervalo correcto
            document.getElementById("ID_Error_meses").style.display = "block";
            document.getElementById("ID_Error_meses").innerHTML = "Debes introducir un numero entero entre 1 y 12";
            return false;
         }
         document.getElementById("ID_Error_meses").style.display = "none";
         return true;
      }
   }

   function validarPremium() {
      "use strict";

      //comprobamos que todos los campos estan correctos
      var ret = (validarContrasenya() & validarUsuario() & validarCuenta() & validarMeses() & validarCVV() & validarFechaCad() & validarTitular());

      if (ret === 0) {
         return false;
      } else {
         return true;
      }
   }
});