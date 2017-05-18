<?php
require_once("modelo.php");
session_start();

$mysqli = conectar();
$seguidor = validarEntrada($_SESSION['usuario']);
$seguido =  validarEntrada($_GET['usuario']);

errorMysql($mysqli);

$sql = "INSERT INTO sigue VALUES (?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $seguidor, $seguido);

if (!$stmt->execute()) {
   echo $mysqli->error;
}

$stmt->close();
$mysqli->close();

?>
