<?php
	
	require_once('modelo.php');

	$con = conectar();
	if($con != NULL){
		session_start();
		$usuario = $_SESSION['usuario'];
		$imagen = validarEntrada($_POST['nueva_imagen']);
		$nombreFotoPerfil = $usuario.'_'.$imagen;
      	$sql = "UPDATE usuarios SET foto = ? WHERE nombreusuario = ?";
      	$result = $con->prepare($sql);
      	$result->bind_param("ss", $nombreFotoPerfil, $usuario);
      	if(subirArchivo(validarEntrada($_FILES['nueva_imagen']['name']), $_FILES['imagenCancion']['tmp_name'], "../img/")){
      		$result->execute();
      	}
      	else{
      		echo "No se pudo subir la foto";
      	}
   }

?>