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

function obtener_generos(){
	return getGeneros();
}

function autenticar_con_correo($usuario, $correo, $pass){
	return autenticarUsuarioConCorreo($usuario, $correo, $pass);
}

function borrar_generos_usuario($usuario){
	return borrarGenerosUsuario($usuario);
}

function insertar_nuevo_genero_usuario($usuario, $genero){
	insertarNuevoGeneroUsuario($usuario, $genero);
}

function conseguir_usuario_correo($correo){
	return conseguirUsuarioCorreo($correo);
}

function cambiar_email($usuario, $correo){
	return cambiarEmail($usuario, $correo);
}

function cambiar_descripcion($usuario, $descripcion){
	return cambiarDescripcion($usuario, $descripcion);
}

function cargar_Ruta_Foto_Encabezado($ruta){
	return cargarRutaFotoEncabezado($ruta);
}

function cargar_Ruta_Foto_Perfil($ruta){
	return cargarRutaFotoPerfil($ruta);
}

function cargar_caratula_por_defecto($ruta){
	return cargarCaratulaPorDefecto($ruta);
}
function subir_archivo($archivo, $directorioTemporal, $directorioSubida){
	return subirArchivo($archivo, $directorioTemporal, $directorioSubida);
}

function actualizar_perfil($archivo, $directorioTemporal, $directorioSubida, $nuevoNombre){
	return actualizarPerfil($archivo, $directorioTemporal, $directorioSubida, $nuevoNombre);
	
}

function cambiar_foto_perfil($usuario, $archivo){
	return cambiarFotoDePerfil($usuario, $archivo);
}

function cambiar_foto_encabezado($usuario, $archivo){
	return cambiarFotoEncabezado($usuario, $archivo);
}
?>
