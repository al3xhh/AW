<?php
require_once("modelo.php");

$mysqli = conectar();
$correo = validarEntrada($_GET["correo"]);

errorMysql($mysqli);

$sql = "SELECT email FROM usuarios WHERE email = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $correo);

if (!$stmt->execute()) {
   printf("Errormessage: %s\n", $mysqli->error);
}

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
   echo "Correo ya registrado";
}

$stmt->close();
$mysqli->close();
?>
