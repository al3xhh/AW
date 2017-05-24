<?php
require_once('modelo.php');

	$mysqli = conectar();
	if($mysql->query("UPDATE usuarios SET email = '$correo' WHERE usuario = '$usuario' ") !== TRUE){
		echo "No se pudo actualizar el correo";
	}
?>