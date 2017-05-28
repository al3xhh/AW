<?php

   //Script php utilizado por ajax para comprobar si el correo ya está registrado.
   require_once("modelo.php");

   $correo = validarEntrada($_GET["correo"]);

   if(existeCorreo($correo)) {
      echo "Correo ya registrado";
   }

?>
