<?php
session_start();
require_once("../php/controlador.php");
require_once("../php/modelo.php");

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	//HAY QUE VALIDAR LA ENTRADA SEGUN ME DICE CHRISTIAN
	$id = validarEntrada($_POST['id']);
	$autor = validarEntrada($_POST["autor"]);
	$nombre = validarEntrada($_POST["nombrelista"]);
	$cancion = validarEntrada($_POST["cancion"]);
	borrar_cancion_lista($id, $cancion);
}
	header ("location: ../src/lista-reproduccion-canciones.php?lista=".$id."&autor=".$autor."&nombre=".$nombre."");

?>
