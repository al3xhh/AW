<?php
require_once('modelo.php');

if(existeUsuario(validarEntrada($_GET['usuario']))){
	echo "El nombre de usuario no esta disponible";
}
?>