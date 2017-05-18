<?php
require_once("modelo.php");

function validar_entrada($dato) {
   return validarEntrada($dato);
}

function existe_usuario($usuario) {
   return existeUsuario($usuario);
}

function existe_correo($correo) {
   return existeCorreo($correo);
}

function registra_usuario($usuario, $correo, $contrasenya) {
   return registraUsuario($usuario, $correo, $contrasenya);
}

function tus_novedades($usuario) {
   return tusNovedades($usuario);
}

function tus_top($usuario) {
   return tusTop($usuario);
}

function tus_top_social($usuario) {
   return tusTopSocial($usuario);
}

function info_cancion($titulo) {

   return getInfoCancion($titulo);
}

function aniadir_premium($usuario, $n_cuenta, $cvv, $fecha_caducidad_cuenta, $titular, $n_meses, $fecha_caducidad_premium) {

   return aniadirPremium($usuario, $n_cuenta, $cvv, $fecha_caducidad_cuenta, $titular, $n_meses, $fecha_caducidad_premium);
}

function autenticar($usuario, $pass) {
   return autenticarUsuario($usuario, $pass);
}
?>
