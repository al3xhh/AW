<?php
require_once('modelo.php');

	$con = conectar();
	if($con != NULL){
		session_start();
		$usuario = $_SESSION['usuario'];
		$correo = validarEntrada($_POST['correo_nuevo']);
      	$sql = "UPDATE usuarios SET email = ? WHERE nombreusuario = ?";
      	$result = $con->prepare($sql);
      	$result->bind_param("ss", $correo, $usuario);
      	$result->execute();
   }
?>