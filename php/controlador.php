<?php
require_once("modelo.php");

function existe_usuario() {
   return existeUsuario();
}

function existe_correo() {
   return existeCorreo();
}

function registra_usuario() {
   return registraUsuario();
}

function tus_novedades() {
   return tusNovedades();
}

function tus_top() {
   return tusTop();
}

function tus_top_social() {
   return tusTopSocial();
}

function info_cancion($titulo) {
   
   return getInfoCancion($titulo);
}
?>
