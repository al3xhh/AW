<?php
   require_once('modelo.php');

   $usuario = validarEntrada($_GET['usuario']);

   if(strpos($usuario, "@" ) !== false) {
      if(!existeCorreo($usuario))
         echo "Usuario no registrado";
   } else {
      if(!existeUsuario($usuario))
         echo "Usuario no registrado";
   }
?>
