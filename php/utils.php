<?php

   //Función que valida que el usuario introducido en el registro sea válido.
   function validarUsuario($usuario) {

      $regexp = "/^[a-zA-Z ]{2,30}$/";

      if (preg_match($regexp, $usuario)) {
         return True;
      } else {
         return False;
      }
   }

   //Función que valida que el correo introducido en el registro sea válido.
   function validarCorreo($correo) {
      $regexp = "/^[a-zA-Z0-9._\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,4}$/";

      if (preg_match($regexp, $correo)) {
         return True;
      } else {
         return False;
      }
   }

   //Función que valida que la contraseña introducida en el registro sea válida.
   function validarContrasenya($contrasenya) {
      $regexp = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,15}$/";

      if (preg_match($regexp, $contrasenya)) {
         return True;
      } else {
         return False;
      }
   }

   //Función que valida que las contraseñas introducidad en el registro coincidan.
   function validarReContrasenya($contrasenya, $recontrasenya) {
      if($contrasenya == $recontrasenya) {
         return True;
      } else {
         return False;
      }
   }
   
	//funcion para validar una foto por la extension
	function validarFoto($nombre){
		$patron = "%\.(jpg)$%i"; 
		if(preg_match($patron, $nombre)){
			return true;
		}
		else{
			return false;
		}
	}
	
	function validarDescripcion($descripcion){
		if(strlen($descripcion) > 130){
			return false;
		}
		else{
			return true;
		}
	}
	
	function validarCancion($cancion){
		$patron = "%\.(mp3)$%i";
		if(preg_match($patron, $cancion)){
			return true;
		}
		else{
			return false;
		}
	}
 ?>
