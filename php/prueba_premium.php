<?php
if (isset($_POST["usuario"])){
   require_once("controlador.php");
   $usuario = validarEntrada($_POST["usuario"]);
   $fecha_caducidad_premium = date("Y-m-d", mktime(0, 0, 0, date("m") + 1, date("d"), date("Y")));
   
   //comprobamos si el usuario ya ha sido premium en algun momento
   if (!ha_sido_premium($usuario)){
      //añadimos un mes de prueba premium
      prueba_premium($usuario, $fecha_caducidad_premium);
      header("Location: ../src/home.php");
   }
   else
      header("Location: ../src/error_premium.html");
}
?>
