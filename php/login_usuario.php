<?php
require_once('modelo.php');

if(!existeUsuario(validarEntrada($_GET['usuario'])) && !existeCorreo(validarEntrada($_GET['usuario']))){
	echo "Usuario/correo no registrado";
}
?>