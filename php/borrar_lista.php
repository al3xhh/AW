<?php
session_start();
require_once("../php/controlador.php");
require_once("../php/modelo.php");

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$id = validarEntrada($_POST['id']);
	borrar_lista($id);
}
	header ("location: ../src/listas-reproduccion.php");

?>
