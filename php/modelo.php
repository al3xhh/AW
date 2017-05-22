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

   $sql = "SELECT cancion.titulo, reproducciones.usuario, reproducciones.fecha, autor
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

   $stmt->bind_result($col1, $col2, $col3, $col4);

   while ($stmt->fetch()){
      $row = array("titulo" => $col1,
                   "usuario" => $col2,
                   "fecha" => $col3,
                   "autor" => $col4);
      array_push($array, $row);
   }

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

//Función que permite a un usuario seguir a otro.
function seguir($seguidor, $seguido) {
   $mysqli = conectar();

   errorMysql($mysqli);

   $sql = "INSERT INTO sigue VALUES (?, ?)";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("ss", $seguidor, $seguido);

   if (!$stmt->execute()) {
      echo $mysqli->error;
   }

   $stmt->close();
   $mysqli->close();
}

//Función que permite a un usuario dejar de seguir a obtenerGustosMusicales
function dejarDeSeguir($seguidor, $seguido) {
   $mysqli = conectar();

   errorMysql($mysqli);

   $sql = "DELETE FROM sigue
            WHERE seguidor = ? AND seguido = ?";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("ss", $seguidor, $seguido);

   if (!$stmt->execute()) {
      echo $mysqli->error;
   }

   $stmt->close();
   $mysqli->close();
}

function getInfoCancion($titulo, $autor){
   $mysqli = conectar();
   $stmt = $mysqli->prepare("SELECT autor, duracion, numeroreproducciones, archivo, caratula FROM cancion WHERE titulo = ? AND autor = ?");
   $stmt->bind_param("ss", $titulo, $autor);
   $stmt->execute();
   $stmt->bind_result($col1, $col2, $col3, $col4, $col5);
   $stmt->fetch();
   $ret = array("autor"=>$col1, "duracion" => $col2, "nreproducciones" => $col3, "archivo" => $col4, "caratula" => $col5);

   desconectar($mysqli);

   return $ret;
}

function aniadirPremium($usuario, $n_cuenta, $cvv, $fecha_caducidad_cuenta, $titular, $n_meses, $fecha_caducidad_premium){
   $mysqli = conectar();
   $stmt = $mysqli->prepare("INSERT INTO premium VALUES (?, ?, ?, ?, ?, ?, ?)");
   $stmt->bind_param("sssssss", $usuario, $n_cuenta, $cvv, $fecha_caducidad_cuenta, $titular, $n_meses, $fecha_caducidad_premium);
   $stmt->execute();
   $stmt->close();
   desconectar($mysqli);
}

function desconectar($conexion){
   $conexion->close();
}

function autenticarUsuario($usuario, $pass){

   $con = conectar();
   if($con != NULL){

      $sql = "SELECT nombreusuario, contrasenya FROM usuarios where nombreusuario = '$usuario'AND contrasenya = '$pass'";

      $result = $con->query($sql);
      if($result->num_rows > 0){
         return true;
      }
      else{
         return false;
      }
   }
}

function aumentarReproducciones($titulo, $autor){
   $mysqli = conectar();
   //cogemos el numero de reproducciones
   $stmt = $mysqli->prepare("SELECT numeroreproducciones FROM cancion WHERE titulo = ? AND autor = ?");
   $stmt->bind_param("ss", $titulo, $autor);
   $stmt->execute();
   $stmt->bind_result($n_reproducciones);
   $stmt->fetch();
   $n_reproducciones += 1;
   $stmt->close();
   //actualizamos el numero de reproducciones
   $stmt2 = $mysqli->prepare("UPDATE cancion SET numeroreproducciones = ? WHERE titulo = ? AND autor = ?");
   $stmt2->bind_param("iss", $n_reproducciones, $titulo, $autor);
   $stmt2->execute();
   $stmt2->close();

   desconectar($mysqli);

}

function obtenerListasReproduccionUsuario($usuario){
   $mysqli = conectar();
   //cogemos el numero de reproducciones
   $stmt = $mysqli->prepare("SELECT nombre FROM listareproduccion WHERE usuario = ?");
   $stmt->bind_param("s", $usuario);
   $stmt->execute();
   $stmt->bind_result($listas);
   $array = array();

   while($stmt->fetch())
      array_push($array, $listas);


   $stmt->close();

   desconectar($mysqli);

   return $array;
}

function obtenerInfoComentariosCancion($cancion, $usuario){
   $mysqli = conectar();
   $stmt = $mysqli->prepare("SELECT texto, fecha, usuario FROM comentario WHERE cancion = (SELECT id FROM cancion WHERE titulo = ? AND autor = ?) ORDER BY 2 DESC");
   $stmt->bind_param("ss",$cancion, $usuario);
   $stmt->execute();
   $stmt->bind_result($col1, $col2, $col3);
   $array = array();

   while($stmt->fetch()){
      $row = array("texto" => $col1, "fecha" => $col2, "usuario" => $col3, "foto" => obtenerImagenUsuario($col3));
      array_push($array, $row);
   }

   $stmt->close();

   desconectar($mysqli);

   return $array;
}

function obtenerImagenUsuario($usuario){
   $mysqli = conectar();
   $stmt = $mysqli->prepare("SELECT foto FROM usuarios WHERE nombreusuario = ?");
   $stmt->bind_param("s", $usuario);
   $stmt->execute();
   $stmt->bind_result($fotousuario);
   $stmt->fetch();
   $stmt->close();

   desconectar($mysqli);

   return $fotousuario;
}

function aniadirComentario($cancion, $texto, $usuario){
   $mysqli = conectar();
   $stmt = $mysqli->prepare("INSERT INTO comentario (cancion, texto, usuario) VALUES (?, ?, ?)");
   $stmt->bind_param("sss", $cancion, $texto, $usuario);
   $stmt->execute();
   $stmt->close();

   desconectar($mysqli);
}

function obtenerIdCancion($titulo, $autor){
   $mysqli = conectar();
   $stmt = $mysqli->prepare("SELECT id FROM cancion WHERE titulo = ? AND autor = ?");
   $stmt->bind_param("ss", $titulo, $autor);
   $stmt->execute();
   $stmt->bind_result($id);
   $stmt->fetch();
   $stmt->close();
   desconectar($mysqli);

   return $id;
}

function aniadirCancionALista($cancion, $lista, $usuario){
   //sacamos el id de la lista
   $mysqli = conectar();
   $stmt = $mysqli->prepare("SELECT id FROM listareproduccion WHERE usuario = ? AND nombre = ?");
   $stmt->bind_param("ss", $usuario, $lista);
   $stmt->execute();
   $stmt->bind_result($lista);
   $stmt->fetch();
   $stmt->close();

   //insetamos la cancion en la lista
   $stmt = $mysqli->prepare("INSERT INTO listareproduccioncancion VALUES (?, ?)");
   $stmt->bind_param("ss", $lista, $cancion);
   $stmt->execute();
   $stmt->close();

   desconectar($mysqli);
}

?>
