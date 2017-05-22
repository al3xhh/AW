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

   function info_cancion($titulo, $autor) {

      return getInfoCancion($titulo, $autor);
   }

   function aniadir_premium($usuario, $n_cuenta, $cvv, $fecha_caducidad_cuenta, $titular, $n_meses, $fecha_caducidad_premium) {

      return aniadirPremium($usuario, $n_cuenta, $cvv, $fecha_caducidad_cuenta, $titular, $n_meses, $fecha_caducidad_premium);
   }

   function autenticar($usuario, $pass) {
      return autenticarUsuario($usuario, $pass);
   }

   function obtener_gustos_musicales($usuario) {
      return obtenerGustosMusicales($usuario);
   }

   function obtener_informacion_usuario($usuario) {
      return obtenerInformacionUsuario($usuario);
   }

   function obtener_descripcion_usuario($usuario) {
      return obtenerDescripcionUsuario($usuario);
   }

   function obtener_seguidores($usuario) {
      return obtenerSeguidores($usuario);
   }

   function obtener_seguidos($usuario) {
      return obtenerSeguidos($usuario);
   }

   function obtener_canciones_usuario($usuario) {
      return obtenerCancionesUsuario($usuario);
   }


   function sigue_a($seguidor, $seguido) {
      return sigueA($seguidor, $seguido);
   }

   function obtener_listas_reproduccion_usuario($usuario){
      return obtenerListasReproduccionUsuario($usuario);
   }

   function obtener_info_comentarios_cancion($cancion, $usuario){

      return obtenerInfoComentariosCancion($cancion, $usuario);
   }

?>
