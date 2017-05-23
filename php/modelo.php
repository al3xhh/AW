<?php

//Transforma el resultado de la consulta SQL en un array.
function obtenerArray($stmt, &$array, $col1_n, $col2_n, $col3_n) {
   $stmt->bind_result($col1, $col2, $col3);

   while ($stmt->fetch()){
      $row = array($col1_n => $col1,
                   $col2_n => $col2,
                   $col3_n => $col3);
      array_push($array, $row);
   }
}

//Función para conectar con la base de datos.
function conectar() {
   return new mysqli('127.0.0.1', 'root', 'joseubuntu', 'webmusic');
}

//Función para limpiar la entrada de cualquier caracter raro.
function validarEntrada($dato) {
   return htmlspecialchars(trim(strip_tags($dato)));
}

//Función que se encarga de mostrar un error en caso de que la
//conexión con la base de datos falle.
function errorMysql($mysqli) {
   if ($mysqli->connect_errno) {

      echo "Lo sentimos, este sitio web está experimentando problemas.";

      echo "Error: Fallo al conectarse a MySQL debido a: \n";
      echo "Errno: " . $mysqli->connect_errno . "\n";
      echo "Error: " . $mysqli->connect_error . "\n";

      exit;
   }
}

//Función que comprueba si existe el nombre de usuario en la aplicación.
function existeUsuario($usuario) {
   $mysqli = conectar();
   $ret = False;

   errorMysql($mysqli);

   $sql = "SELECT nombreusuario FROM usuarios WHERE nombreusuario = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);

   if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
   }

   $resultado = $stmt->get_result();

   if ($resultado->num_rows > 0) {
      $ret = True;
   }

   $stmt->close();
   $mysqli->close();

   return $ret;
}

//Función que comprueba si existe el correo electrónico en la aplicación.
function existeCorreo($correo) {
   $mysqli = conectar();
   $ret = False;

   errorMysql($mysqli);

   $sql = "SELECT email FROM usuarios WHERE email = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $correo);

   if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
   }

   $resultado = $stmt->get_result();

   if ($resultado->num_rows > 0) {
      $ret = True;
   }

   $stmt->close();
   $mysqli->close();

   return $ret;
}

//Función que se encarga de realizar el registro de un usuario en la aplicación.
function registraUsuario($usuario, $correo, $contrasenya) {
   $mysqli = conectar();
   $ret = True;
   $foto = "FotoUsuarioPorDefecto.png";
   $encabezado = "EncabezadoPorDefecto.png";

   errorMysql($mysqli);

   $sql = "INSERT INTO usuarios(email, nombreusuario, contrasenya, foto, encabezado) VALUES (?, ?, ?, ?, ?)";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("sssss", $correo, $usuario, $contrasenya, $foto, $encabezado);

   if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
      $ret = False;
   } else {
      session_start();
      $_SESSION['usuario'] = $usuario;
   }

   $stmt->close();
   $mysqli->close();

   return $ret;
}

//Función que recupera el top de novedades para el usuario conectado.
function tusNovedades($usuario) {
   $mysqli = conectar();
   $hoy = date("Y-m-d");
   $array = array();

   errorMysql($mysqli);

   $sql = "SELECT titulo, autor, date(fecha)
            FROM cancion
            JOIN premium ON usuario = autor
            JOIN sigue ON seguido = autor
            WHERE seguidor = ? AND fechacaducidad > ?
            ORDER BY fecha DESC
            LIMIT 6";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("ss", $usuario, $hoy);

   if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
   }

   obtenerArray($stmt, $array, "titulo", "autor", "fecha");

   $sql = "SELECT titulo, autor, date(fecha)
            FROM cancion
            JOIN sigue ON seguido = autor
            WHERE seguidor = ? AND autor NOT IN (SELECT usuario
                                                FROM premium
                                                WHERE usuario = autor)
            ORDER BY fecha DESC
            LIMIT 4";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);

   if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
   }

   obtenerArray($stmt, $array, "titulo", "autor", "fecha");

   $stmt->close();
   $mysqli->close();

   return $array;
}

//Función que recupera el top de canciones según los gustos del usuario.
function tusTop($usuario) {
   $mysqli = conectar();
   $hoy = date("Y-m-d");
   $array = array();

   errorMysql($mysqli);

   $sql = "SELECT titulo, autor, numeroreproducciones
            FROM cancion
            JOIN premium ON usuario = autor
            JOIN gustos ON cancion.genero = gustos.genero
            WHERE gustos.usuario = ? AND fechacaducidad > ?
            ORDER BY numeroreproducciones DESC
            LIMIT 6";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("ss", $usuario, $hoy);

   if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
   }

   obtenerArray($stmt, $array, "titulo", "autor", "numeroreproducciones");

   $sql = "SELECT titulo, autor, numeroreproducciones
            FROM cancion
            JOIN gustos ON cancion.genero = gustos.genero
            WHERE gustos.usuario = ? AND autor NOT IN (SELECT usuario
                                                FROM premium
                                                WHERE usuario = autor)
            ORDER BY numeroreproducciones DESC
            LIMIT 4";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);

   if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
   }

   obtenerArray($stmt, $array, "titulo", "autor", "numeroreproducciones");

   $stmt->close();
   $mysqli->close();

   return $array;
}

//Función que recupera el top social de canciones del usuario.
function tusTopSocial($usuario) {
   $mysqli = conectar();
   $array = array();

   errorMysql($mysqli);

   $sql = "SELECT cancion.titulo, reproducciones.usuario, reproducciones.fecha
            FROM cancion
            JOIN reproducciones ON cancion.id = reproducciones.cancion
            WHERE reproducciones.usuario IN (SELECT seguido
                                             FROM sigue
                                             WHERE seguidor = ?)
            ORDER BY reproducciones.fecha ASC
            LIMIT 10";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);

   if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
   }

   obtenerArray($stmt, $array, "titulo", "usuario", "fecha");

   $stmt->close();
   $mysqli->close();

   return $array;
}

//Función que obtiene los gustos musicales del usuario.
function obtenerGustosMusicales($usuario) {
   $mysqli = conectar();
   $array = array();

   errorMysql($mysqli);

   $sql = "SELECT genero
            FROM gustos
            WHERE usuario = ?";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);

   if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
   }

   $stmt->bind_result($col1);

   while ($stmt->fetch()){
      $row = array("genero" => $col1);
      array_push($array, $row);
   }

   $stmt->close();
   $mysqli->close();

   return $array;
}

//Función que obtiene la foto, el encabezado y la descripción del usuario
function obtenerInformacionUsuario($usuario) {
   $mysqli = conectar();
   $array = array();

   errorMysql($mysqli);

   $sql = "SELECT nombreusuario, foto, encabezado
            FROM usuarios
            WHERE nombreusuario = ?";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);

   if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
   }

   obtenerArray($stmt, $array, "nombreusuario", "foto", "encabezado");

   $stmt->close();
   $mysqli->close();

   return $array;
}

//Función que obtiene la descripción del usuario
function obtenerDescripcionUsuario($usuario) {
   $mysqli = conectar();

   errorMysql($mysqli);

   $sql = "SELECT descripcion
            FROM usuarios
            WHERE nombreusuario = ?";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);

   if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
   }

   $stmt->bind_result($col1);
   $stmt->fetch();

   $stmt->close();
   $mysqli->close();

   return $col1;
}

//Función que obtiene los seguidores del usuario
function obtenerSeguidores($usuario) {
   $mysqli = conectar();
   $array = array();

   errorMysql($mysqli);

   $sql = "SELECT seguidor, foto
            FROM sigue
            JOIN usuarios ON nombreusuario = seguidor
            WHERE seguido = ?";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);

   if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
   }

   $stmt->bind_result($col1, $col2);

   while ($stmt->fetch()){
      $row = array("seguidor" => $col1,
                   "foto" => $col2);
      array_push($array, $row);
   }

   $stmt->close();
   $mysqli->close();

   return $array;
}

//Función que obtiene los seguidos del usuario
function obtenerSeguidos($usuario) {
   $mysqli = conectar();
   $array = array();

   errorMysql($mysqli);

   $sql = "SELECT seguido, foto
            FROM sigue
            JOIN usuarios ON nombreusuario = seguido
            WHERE seguidor = ?";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);

   if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
   }

   $stmt->bind_result($col1, $col2);

   while ($stmt->fetch()){
      $row = array("seguido" => $col1,
                   "foto" => $col2);
      array_push($array, $row);
   }

   $stmt->close();
   $mysqli->close();

   return $array;
}

//Función para obtener las canciones subidas por el usuario
function obtenerCancionesUsuario($usuario) {
   $mysqli = conectar();
   $array = array();

   errorMysql($mysqli);

   $sql = "SELECT titulo, caratula
            FROM cancion
            WHERE autor = ?";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);

   if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
   }

   $stmt->bind_result($col1, $col2);

   while ($stmt->fetch()){
      $row = array("titulo" => $col1,
                   "caratula" => $col2);
      array_push($array, $row);
   }

   $stmt->close();
   $mysqli->close();

   return $array;
}

//Función que indica si un usuario sigue a otro
function sigueA($seguidor, $seguido) {
   $mysqli = conectar();
   $ret = False;

   errorMysql($mysqli);

   $sql = "SELECT seguido
            FROM sigue
            WHERE seguidor = ? AND seguido = ?";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("ss", $seguidor, $seguido);

   if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
   }

   $resultado = $stmt->get_result();

   if ($resultado->num_rows > 0) {
      $ret = True;
   }

   $stmt->close();
   $mysqli->close();

   return $ret;
}

function getInfoCancion($titulo){
   $mysqli = conectar();
   $stmt = $mysqli->prepare("SELECT autor, duracion, numeroreproducciones, archivo FROM cancion WHERE titulo = ?");
   $stmt->bind_param("s", $titulo);
   $stmt->execute();
   $stmt->bind_result($col1, $col2, $col3, $col4);
   $stmt->fetch();
   $ret = array("autor"=>$col1, "duracion" => $col2, "nreproducciones" => $col3, "archivo" => $col4);

   $mysqli->close();

   return $ret;
}

function aniadirPremium($usuario, $n_cuenta, $cvv, $fecha_caducidad_cuenta, $titular, $n_meses, $fecha_caducidad_premium){
   $stmt = $mysqli->prepare("INSERT INTO premium VALUES (?, ?, ?, ?, ?, ?, ?)");
   $stmt->bind_param("sssssss", $usuario, $n_cuenta, $cvv, $fecha_caducidad_cuenta, $titular, $n_meses, $fecha_caducidad_premium);
   $stmt->execute();
   $stmt->close();
}

function autenticarUsuario($usuario, $pass){

   $con = conectar();
   if($con != NULL){

      $sql = "SELECT nombreusuario, contrasenya FROM usuarios where nombreusuario = '$usuario' AND contrasenya = '$pass'";

      $result = $con->query($sql);
      if($result->num_rows > 0){
         $con->close();
		 return true;
      }
      else{
		  $con->close();
         return false;
      }
   }
}

function getGeneros(){
	
	$mysqli = conectar();
	$stmt = $mysqli->prepare("SELECT nombre FROM generos");
	$stmt->execute();
	$stmt->bind_result($col1);
	$ret = array();
   while($stmt->fetch())
      array_push($ret, $col1);
	$stmt->close();
	$mysqli->close();

	return $ret;	
}

function obtener_contrasenia_usuario($usuario){
   $mysqli = conectar();
   $ret = False;

   errorMysql($mysqli);

   $sql = "SELECT  FROM usuarios WHERE nombreusuario = ? OR email = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("ss", $usuario, $usuario);

   $resultado = $stmt->get_result();

   if ($resultado->num_rows > 0) {
      $ret = ;
   }

   $stmt->close();
   $mysqli->close();

   return $ret;
}

function subirArchivo($archivo, $directorioTemporal, $directorioSubida){

	$fichero_subido = $directorioSubida . basename($archivo);
	if (move_uploaded_file($directorioTemporal, $fichero_subido)) {
		return true;
	} else {
		return false;
	}
}
?>
