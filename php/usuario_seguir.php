<?php

   //Script php utilizado por ajax para seguir a un usuario.
   require_once("modelo.php");
   session_start();

   $seguidor = validarEntrada($_SESSION['usuario']);
   $seguido =  validarEntrada($_GET['usuario']);

   seguir($seguidor, $seguido);

?>
