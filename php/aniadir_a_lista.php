<?php
require_once("modelo.php");
//comprobamos que todos los parametros nos llegan correctamente
if (isset($_POST["lista"]) && isset($_POST["cancion"]) && isset($_POST["autor"]) && isset($_POST["usuario"])){
   //validamos la entrada
   $cancion = obtenerIdCancion(validarEntrada($_POST["cancion"]), validarEntrada($_POST["autor"]));
   $lista = validarEntrada($_POST["lista"]);
   $usuario = validarEntrada($_POST["usuario"]);
   //añadimos la cancion a lista de reproduccion
   aniadirCancionALista($cancion, $lista, $usuario);

   echo $cancion, $lista;
}
else
   echo "Error en la peticion";
?>