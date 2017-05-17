<?php
require_once("modelo.php");

$mysqli = conectar();
$usuario = validarEntrada($_GET["usuario"]);

errorMysql($mysqli);

$sql = "SELECT nombreusuario FROM usuarios WHERE nombreusuario = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $usuario);

if (!$stmt->execute()) {
   printf("Errormessage: %s\n", $mysqli->error);
}

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
   echo "Usuario ya registrado";
}

$stmt->close();
$mysqli->close();
?>
