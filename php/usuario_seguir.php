<?php

   //Script php utilizado por ajax para seguir a un usuario.
   require_once("modelo.php");
   session_start();

   if(isset($_POST['usuario'])) {
      $seguidor = validarEntrada($_SESSION['usuario']);
      $seguido =  validarEntrada($_POST['usuario']);

      seguir($seguidor, $seguido);
   }

?>
