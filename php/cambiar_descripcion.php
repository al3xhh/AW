<?php
	require_once('modelo.php');

	$con = conectar();
	if($con != NULL){
		session_start();
		$usuario = $_SESSION['usuario'];
		$descripcion = validarEntrada($_POST['nueva_descripcion']);
      	$sql = "UPDATE usuarios SET descripcion = ? WHERE nombreusuario = ?";
      	$result = $con->prepare($sql);
      	$result->bind_param("ss", $descripcion, $usuario);
      	$result->execute();
    }
?>