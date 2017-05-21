<?php

   //Script php utilizado por ajax para comprobar si el usuario ya está registrado.
   require_once("modelo.php");

   $usuario = validarEntrada($_GET["usuario"]);

   if(existeUsuario($usuario)) {
      echo "Usuario ya registrado";
   }

?>
