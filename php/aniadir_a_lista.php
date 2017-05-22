<?php
require_once("modelo.php");
if (isset($_POST["lista"]) && isset($_POST["cancion"]) && isset($_POST["autor"]) && isset($_POST["usuario"])){
   $cancion = obtenerIdCancion(validarEntrada($_POST["cancion"]), validarEntrada($_POST["autor"]));
   $lista = validarEntrada($_POST["lista"]);
   $usuario = validarEntrada($_POST["usuario"]);
   aniadirCancionALista($cancion, $lista, $usuario);

   echo $cancion, $lista;
}
else
   echo "Error en la peticion";
?>