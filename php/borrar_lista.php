<?php
session_start();
require_once("../php/controlador.php");
require_once("../php/modelo.php");
$_SESSION["usuario"] = "alex";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	//HAY QUE VALIDAR LA ENTRADA SEGUN ME DICE CHRISTIAN
	$id = validarEntrada($_POST['id']);
	borrar_lista($id);	
}
	header ("location: listas-reproduccion.php");

?>