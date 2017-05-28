<?php

require_once("modelo.php");

function validar_entrada($dato) {
   return validarEntrada($dato);
}

function cerrar_sesion() {
   cerrarSesion();
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

function aniadir_premium($usuario, $n_cuenta, $cvv, $fecha_caducidad_cuenta, $titular, $n_meses, $fecha_caducidad_premium, $pass) {
   if (existeUsuario($usuario)){
      if (autenticarUsuario($usuario, $pass))
         return aniadirPremium($usuario, $n_cuenta, $cvv, $fecha_caducidad_cuenta, $titular, $n_meses, $fecha_caducidad_premium);
      else
         return false;
   }
   else
      return false;
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

function obtener_top() {
   return obtenerTop();
}

function obtener_novedades() {
   return obtenerNovedades();
}

function obtener_listas_reproduccion_usuario($usuario){
   return obtenerListasReproduccionUsuario($usuario);
}

function obtener_info_comentarios_cancion($cancion, $usuario){

   return obtenerInfoComentariosCancion($cancion, $usuario);
}

function existe_cancion($titulo, $autor){
   return existeCancion($titulo, $autor);
}

function get_siguiente_cancion($titulo, $autor, $lista){
   return getSiguienteCancion($titulo, $autor, $lista);
}

function get_cancion_anterior($titulo, $autor, $lista){
   return getCancionAnterior($titulo, $autor, $lista);
}

function aumentar_reproducciones($titulo, $autor){
   aumentarReproducciones($titulo, $autor);
}

function lista_reproduccion($usuario){
  return listaReproduccion($usuario);
}

function lista_reproduccion_canciones($id){
  return listaReproduccionCanciones($id);
}

function buscar($tipo, $busqueda){
  return buscar_cancion($tipo, $busqueda);
}

function aniadir_lista($lista, $usuario){
  return aniadirLista($lista, $usuario);
}

function borrar_lista($id){
  return borrarLista($id);
}

function sacar_foto($usuario){
  return sacarFoto($usuario);
}

function borrar_cancion_lista($id, $cancion){
  return borrarCancionLista($id, $cancion);
}

function aniadir_cancion_lista($autor, $titulo_cancion, $lista){
  return aniadirCancionLista($autor, $titulo_cancion, $lista);
}

function obtener_generos(){
	return getGeneros();
}

function autenticar_con_correo($correo, $pass){
	return autenticarUsuarioConCorreo($correo, $pass);
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

function insertar_cancion($autor, $nombreCancion, $caratula, $duracion, $genero, $archivo, $premium){
	return insertarCancion($autor, $nombreCancion, $caratula, $duracion, $genero, $archivo, $premium);
}

function actualizar_perfil($archivo, $directorioTemporal, $directorioSubida, $nuevoNombre){
	return actualizarPerfil($archivo, $directorioTemporal, $directorioSubida, $nuevoNombre);
}

function actualizar_premium($usuario, $cuenta, $cvv, $fechaCad, $titular, $meses, $caducidadPremium){
	return actualizarPremium($usuario, $cuenta, $cvv, $fechaCad, $titular, $meses, $caducidadPremium);
}

function cambiar_foto_perfil($usuario, $archivo){
	return cambiarFotoDePerfil($usuario, $archivo);
}

function cambiar_foto_encabezado($usuario, $archivo){
	return cambiarFotoEncabezado($usuario, $archivo);
}

function es_premium($usuario){
	return esPremium($usuario);
}
?>
