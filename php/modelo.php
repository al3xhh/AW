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
   return new mysqli('127.0.0.1', 'webmusic', 'webmusic', 'WebMusic');
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

   errorMysql($mysqli);

   $sql = "INSERT INTO usuarios(email, nombreusuario, contrasenya) VALUES (?, ?, ?)";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("sss", $correo, $usuario, $contrasenya);

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
?>
