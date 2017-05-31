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

//Función para cerrar sesión en la página
function cerrarSesion(){
   session_start();
   session_unset();
   session_destroy();
}

//Función para conectar con la base de datos.
function conectar() {
   //return new mysqli('127.0.0.1', 'id1792365_webmusic', 'webmusic', 'id1792365_webmusic');
   return new mysqli('127.0.0.1', 'root', '', 'webmusic');
   //return new mysqli('sql301.byethost11.com', 'b11_20160063', 'proyecto1995', 'b11_20160063_webmusic');
}

//TODO quitarla de aquí y corregir todas las llamadas que se hagan
//Función para limpiar la entrada de cualquier caracter raro.
function validarEntrada($dato) {
   return htmlspecialchars(trim(strip_tags($dato)));
}

//Función que comprueba si existe el nombre de usuario en la aplicación.
function existeUsuario($usuario) {
   $mysqli = conectar();
   $ret = False;
   $sql = "SELECT nombreusuario FROM usuarios WHERE nombreusuario = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);

   if (!$stmt->execute()) {
      $ret = False;
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
   $sql = "SELECT email FROM usuarios WHERE email = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $correo);

   if (!$stmt->execute()) {
      $ret = False;
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
   $sql = "INSERT INTO usuarios(email, nombreusuario, contrasenya, foto, encabezado) VALUES (?, ?, ?, ?, ?)";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("sssss", $correo, $usuario, $contrasenya, $foto, $encabezado);

   if (!$stmt->execute()) {
      $ret = False;
   } else {
      session_start();
      $_SESSION['usuario'] = $usuario;
      $_SESSION['premium'] = false;
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
   $premium = esPremium($usuario);

   if(!$premium) {
      $sql = "SELECT titulo, autor, date(fecha)
               FROM cancion
               JOIN premium ON usuario = autor
               JOIN sigue ON seguido = autor
               WHERE seguidor = ? AND fechacaducidad > ? AND premium = 0
               ORDER BY fecha DESC
               LIMIT 6";
   } else {
      $sql = "SELECT titulo, autor, date(fecha)
               FROM cancion
               JOIN premium ON usuario = autor
               JOIN sigue ON seguido = autor
               WHERE seguidor = ? AND fechacaducidad > ? AND premium = 1
               ORDER BY fecha DESC
               LIMIT 6";
   }
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("ss", $usuario, $hoy);
   $stmt->execute();

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
   $stmt->execute();

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
   $premium = esPremium($usuario);

   if(!$premium) {
      $sql = "SELECT titulo, autor, numeroreproducciones
               FROM cancion
               JOIN premium ON usuario = autor
               JOIN gustos ON cancion.genero = gustos.genero
               WHERE gustos.usuario = ? AND fechacaducidad > ? AND premium = 0
               ORDER BY numeroreproducciones DESC
               LIMIT 6";
   } else {
      $sql = "SELECT titulo, autor, numeroreproducciones
               FROM cancion
               JOIN premium ON usuario = autor
               JOIN gustos ON cancion.genero = gustos.genero
               WHERE gustos.usuario = ? AND fechacaducidad > ? AND premium = 1
               ORDER BY numeroreproducciones DESC
               LIMIT 6";
   }

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("ss", $usuario, $hoy);
   $stmt->execute();

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
   $stmt->execute();

   obtenerArray($stmt, $array, "titulo", "autor", "numeroreproducciones");

   $stmt->close();
   $mysqli->close();

   return $array;
}

//Función que recupera el top social de canciones del usuario.
function tusTopSocial($usuario) {
   $mysqli = conectar();
   $array = array();
   $sql = "SELECT cancion.titulo, reproducciones.usuario, date(reproducciones.fecha), autor
            FROM cancion
            JOIN reproducciones ON cancion.id = reproducciones.cancion
            WHERE reproducciones.usuario IN (SELECT seguido
                                             FROM sigue
                                             WHERE seguidor = ?)
            ORDER BY reproducciones.fecha ASC
            LIMIT 10";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);
   $stmt->execute();

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
   $sql = "SELECT genero
            FROM gustos
            WHERE usuario = ?";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);
   $stmt->execute();

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
   $sql = "SELECT nombreusuario, foto, encabezado
            FROM usuarios
            WHERE nombreusuario = ?";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);
   $stmt->execute();

   obtenerArray($stmt, $array, "nombreusuario", "foto", "encabezado");

   $stmt->close();
   $mysqli->close();

   return $array;
}

//Función que obtiene la descripción del usuario
function obtenerDescripcionUsuario($usuario) {
   $mysqli = conectar();
   $sql = "SELECT descripcion
            FROM usuarios
            WHERE nombreusuario = ?";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);
   $stmt->execute();

   $stmt->bind_result($col1);
   $stmt->fetch();

   $stmt->close();
   $mysqli->close();

   return $col1;
}

//Función que obtiene los seguidores del usuario
function obtenerSeguidores($usuario, $limite) {
   $mysqli = conectar();
   $array = array();
   $sql = "SELECT seguidor, foto
            FROM sigue
            JOIN usuarios ON nombreusuario = seguidor
            WHERE seguido = ? " . $limite;

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);
   $stmt->execute();

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
function obtenerSeguidos($usuario, $limite) {
   $mysqli = conectar();
   $array = array();
   $sql = "SELECT seguido, foto
            FROM sigue
            JOIN usuarios ON nombreusuario = seguido
            WHERE seguidor = ? " . $limite;

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);
   $stmt->execute();

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
function obtenerCancionesUsuario($usuario, $limite) {
   $mysqli = conectar();
   $array = array();
   $sql = "SELECT titulo, caratula
            FROM cancion
            WHERE autor = ? " .$limite;

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);
   $stmt->execute();

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
   $sql = "SELECT seguido
            FROM sigue
            WHERE seguidor = ? AND seguido = ?";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("ss", $seguidor, $seguido);
   $stmt->execute();

   $resultado = $stmt->get_result();

   if ($resultado->num_rows > 0) {
      $ret = True;
   }

   $stmt->close();
   $mysqli->close();

   return $ret;
}

//Función que permite a un usuario seguir a otro
function seguir($seguidor, $seguido) {
   $mysqli = conectar();
   $sql = "INSERT INTO sigue VALUES (?, ?)";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("ss", $seguidor, $seguido);
   $stmt->execute();

   $stmt->close();
   $mysqli->close();
}

//Función que permite a un usuario dejar de seguir a obtenerGustosMusicales
function dejarDeSeguir($seguidor, $seguido) {
   $mysqli = conectar();
   $sql = "DELETE FROM sigue
            WHERE seguidor = ? AND seguido = ?";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("ss", $seguidor, $seguido);
   $stmt->execute();

   $stmt->close();
   $mysqli->close();
}

//Función que obtiene los top del index
function obtenerTop() {
   $mysqli = conectar();
   $hoy = date("Y-m-d");
   $array = array();

   $sql = "SELECT titulo, autor, caratula
            FROM cancion
            JOIN premium ON usuario = autor
            ORDER BY numeroreproducciones DESC
            LIMIT 2";

   $stmt = $mysqli->prepare($sql);
   $stmt->execute();

   obtenerArray($stmt, $array, "titulo", "autor", "caratula");

   $sql = "SELECT titulo, autor, caratula
            FROM cancion
            WHERE autor NOT IN (SELECT usuario
                                 FROM premium
                                 WHERE usuario = autor)
            ORDER BY numeroreproducciones DESC
            LIMIT 2";

   $stmt = $mysqli->prepare($sql);
   $stmt->execute();

   obtenerArray($stmt, $array, "titulo", "autor", "caratula");

   $stmt->close();
   $mysqli->close();

   return $array;
}

//Función que obtiene las novedades del index
function obtenerNovedades() {
   $mysqli = conectar();
   $hoy = date("Y-m-d");
   $array = array();

   $sql = "SELECT titulo, autor, caratula
            FROM cancion
            JOIN premium ON usuario = autor
            ORDER BY fecha DESC
            LIMIT 2";

   $stmt = $mysqli->prepare($sql);
   $stmt->execute();

   obtenerArray($stmt, $array, "titulo", "autor", "caratula");

   $sql = "SELECT titulo, autor, caratula
            FROM cancion
            WHERE autor NOT IN (SELECT usuario
                                 FROM premium
                                 WHERE usuario = autor)
            ORDER BY fecha DESC
            LIMIT 2";

   $stmt = $mysqli->prepare($sql);
   $stmt->execute();

   obtenerArray($stmt, $array, "titulo", "autor", "caratula");

   $stmt->close();
   $mysqli->close();

   return $array;
}

//Función que indica si un usuario es premium
function esPremium($usuario) {
   $mysqli = conectar();
   $ret = False;
   $sql = "SELECT nombreusuario
            FROM usuarios
            JOIN premium ON usuario = nombreusuario
            WHERE nombreusuario = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);

   if (!$stmt->execute()) {
      $ret = False;
   }

   $resultado = $stmt->get_result();

   if ($resultado->num_rows > 0) {
      $ret = True;
   }

   $stmt->close();
   $mysqli->close();

   return $ret;
}

function getInfoCancion($titulo, $autor){
   $mysqli = conectar();
   $stmt = $mysqli->prepare("SELECT autor, duracion, numeroreproducciones, archivo, caratula FROM cancion WHERE titulo = ? AND autor = ?");
   $stmt->bind_param("ss", $titulo, $autor);
   $stmt->execute();
   $stmt->bind_result($col1, $col2, $col3, $col4, $col5);
   $stmt->fetch();
   $ret = array("autor" => $autor ,"titulo" => $titulo, "autor"=>$col1, "duracion" => $col2, "nreproducciones" => $col3, "archivo" => $col4, "caratula" => $col5);

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
   return true;
}

function desconectar($conexion){
   $conexion->close();
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
   $stmt = $mysqli->prepare("SELECT nombre, id FROM listareproduccion WHERE usuario = ?");
   $stmt->bind_param("s", $usuario);
   $stmt->execute();
   $stmt->bind_result($listas, $id_listas);
   $array = array();

   while($stmt->fetch()){
      $row = array("id" => $id_listas, "nombre" => $listas);
      array_push($array, $row);
   }


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
   $mysqli = conectar();
   $stmt = $mysqli->prepare("INSERT INTO listareproduccioncancion VALUES (?, ?)");
   $stmt->bind_param("ss", $lista, $cancion);
   $stmt->execute();
   $stmt->close();

   desconectar($mysqli);
}

function existeCancion($titulo, $autor){
   $mysqli = conectar();
   $stmt = $mysqli->prepare("SELECT * FROM cancion WHERE titulo = ? AND autor = ?");
   $stmt->bind_param("ss", $titulo, $autor);
   $stmt->execute();
   $stmt->store_result();

   if ($stmt->num_rows > 0){
      $stmt->close();
      return true;
   }
   $stmt->close();
   return false;
}

function getSiguienteCancion($titulo, $autor, $lista){
   $cancion_id = obtenerIdCancion($titulo, $autor);
   $mysqli = conectar();
   $stmt = $mysqli->prepare("SELECT titulo, autor FROM cancion WHERE id = (SELECT cancion FROM listareproduccioncancion WHERE lista = ? AND cancion > ? ORDER BY 1 LIMIT 1)");
   $stmt->bind_param("ii", $lista, $cancion_id);
   $stmt->execute();
   $stmt->bind_result($col1, $col2);

   if ($stmt->fetch())
      return getInfoCancion($col1, $col2);
   else
      return false;
}

function getCancionAnterior($titulo, $autor, $lista){
   $cancion_id = obtenerIdCancion($titulo, $autor);
   $mysqli = conectar();
   $stmt = $mysqli->prepare("SELECT titulo, autor FROM cancion WHERE id = (SELECT cancion FROM listareproduccioncancion WHERE lista = ? AND cancion < ? ORDER BY 1 DESC LIMIT 1)");
   $stmt->bind_param("ii", $lista, $cancion_id);
   $stmt->execute();
   $stmt->bind_result($col1, $col2);

   if ($stmt->fetch())
      return getInfoCancion($col1, $col2);
   else
      return false;
}

function listaReproduccion($usuario) {
   $mysqli = conectar();
   $array = array();
   $sql = "SELECT nombre, usuario, id
   			FROM listareproduccion
   			WHERE usuario = ?";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);
   $stmt->execute();
   $stmt->bind_result($col1, $col2, $col3);

   while ($stmt->fetch()){
      $row = array("nombre" => $col1,
                   "usuario" => $col2,
                   "id" => $col3);
      array_push($array, $row);
   }

   $stmt->close();
   $mysqli->close();

   return $array;
}

function listaReproduccionCanciones($id){
   $mysqli = conectar();
   $array = array();
   $sql = "SELECT titulo, autor, fecha, duracion, id
            FROM cancion
            JOIN listareproduccioncancion ON cancion = id
            WHERE lista = ?
            ORDER BY titulo";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("i", $id);
   $stmt->execute();
   $stmt->bind_result($col1, $col2, $col3, $col4, $col5);

   while ($stmt->fetch()){
      $row = array("titulo" => $col1,
                   "autor" => $col2,
                   "fecha" => $col3,
                   "duracion" => $col4,
                   "id" => $col5);
      array_push($array, $row);
   }

   $stmt->close();
   $mysqli->close();

   return $array;
}


function buscar_cancion($tipo, $busqueda){
   $mysqli = conectar();
   $array = array();
   $sol = "%".$busqueda."%";

   if ($tipo == 1) {//CANCION
      $sql = "SELECT caratula, titulo, autor, DATE(fecha)
               FROM cancion
               WHERE titulo LIKE ?";
   } else if($tipo == 2) {//ARTISTA
      $sql = "SELECT caratula, titulo, autor, DATE(fecha)
               FROM cancion
               WHERE autor LIKE ?";
   } else if($tipo == 3) {//FECHA
      $sql = "SELECT caratula, titulo, autor, DATE(fecha)
               FROM cancion
               WHERE fecha LIKE ?";
   }

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $sol);
   $stmt->execute();
   $stmt->bind_result($col1, $col2, $col3, $col4);

   while ($stmt->fetch()){
      $row = array("caratula" => $col1,
                   "titulo" => $col2,
                   "autor" => $col3,
                   "fecha" => $col4,);
      array_push($array, $row);
   }

   $stmt->close();
   $mysqli->close();

   return $array;
}

function aniadirLista($lista, $usuario){
   $mysqli = conectar();
   $ret = true;
   $sql = "INSERT INTO listareproduccion (usuario, nombre) values (?, ?)";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("ss", $usuario, $lista);

   if (!$stmt->execute()) {
      $ret = False;
   }

   $stmt->close();
   $mysqli->close();

   return $ret;
}

function borrarLista($id){
   $mysqli = conectar();
   $usuario = $_SESSION['username'];
   $ret = true;
   $sql = "DELETE FROM listareproduccion
            WHERE id = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("i", $id);

   if (!$stmt->execute()) {
      $ret = False;
   }

   $stmt->close();
   $mysqli->close();

   return $ret;
}

function borrarCancionLista($id, $cancion){
   $mysqli = conectar();
   $usuario = $_SESSION['username'];
   $ret = true;
   $sql = "DELETE FROM listareproduccioncancion
            WHERE lista = ? AND cancion = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("ii", $id, $cancion);

   if (!$stmt->execute()) {
      $ret = False;
   }

   $stmt->close();
   $mysqli->close();

   return $ret;
}

function sacarFoto($usuario){
   $mysqli = conectar();
   $sql = "SELECT foto
            FROM usuarios
            WHERE nombreusuario = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $usuario);
   $stmt->execute();
   $stmt->bind_result($col1);
   $stmt->fetch();
   $stmt->close();
   $mysqli->close();

   return $col1;
}

function aniadirCancionLista ($autor, $titulo_cancion, $lista){
   $mysqli = conectar();
   $ret = true;
   $slq1 = "INSERT INTO listareproduccioncancion
            SELECT 14, id
            FROM cancion
            WHERE autor = ? AND titulo = ?";
   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("ss", $autor, $titulo_cancion);

   if (!$stmt->execute()) {
      $ret = False;
   }

   $stmt->close();
   $mysqli->close();

   return $ret;

}

function autenticarUsuario($usuario, $pass){
   $pass = hash('sha256', validar_entrada($pass));
   $con = conectar();
   if($con != NULL){

      $sql = "SELECT nombreusuario, contrasenya FROM usuarios where nombreusuario = ? AND contrasenya = ?";
      $result = $con->prepare($sql);
      $result->bind_param("ss", $usuario, $pass);
      $result->execute();
      $rows = $result->get_result();
      if($rows->num_rows > 0){
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

function autenticarUsuarioConCorreo($correo, $pass){
   $pass = hash('sha256', validarEntrada($pass));
   $con = conectar();
   if($con != NULL){

      $sql = "SELECT nombreusuario, email, contrasenya FROM usuarios where (nombreusuario = ? OR email = ?) AND contrasenya = ?";
      $result = $con->prepare($sql);
      $result->bind_param("sss", $correo, $correo, $pass);
      $result->execute();
      $rows = $result->get_result();
      if($rows->num_rows > 0){
         $con->close();
         return true;
      }
      else{
         $con->close();
         return false;
      }
   }
}

function cambiarEmail($usuario, $correo){
   $con = conectar();
   if($con != NULL){
      $sql = "UPDATE usuarios SET email = ? WHERE nombreusuario = ?";
      $result = $con->prepare($sql);
      $result->bind_param("ss", $correo, $usuario);
      $result->execute();
      return true;
   }
   else{
      return false;
   }
}

function cambiarDescripcion($usuario, $descripcion){
   $con = conectar();
   if($con != NULL){
      $sql = "UPDATE usuarios SET descripcion = ? WHERE nombreusuario = ?";
      $result = $con->prepare($sql);
      $result->bind_param("ss", $descripcion, $usuario);
      $result->execute();
      return true;
   }
   else{
      return false;
   }
}

function cargarRutaFotoEncabezado($ruta){

   if($ruta == ""){
      return "EncabezadoPorDefecto.png";
   }
   else{
      return $ruta;
   }
}

function cargarRutaFotoPerfil($ruta){

   if($ruta == ""){
      return "FotoUsuarioPorDefecto.png";
   }
   else{
      return $ruta;
   }
}

function cargarCaratulaPorDefecto($ruta){

   if($ruta == ""){
      return "CaratulaPorDefecto.jpg";
   }
   else{
      return $ruta;
   }
}

function subirArchivo($archivo, $directorioTemporal, $directorioSubida){

   $fichero_subido = $directorioSubida . basename($archivo);
   if (move_uploaded_file($directorioTemporal, $fichero_subido)){
      return true;
   } else {
      return false;
   }
}

function conseguirUsuarioCorreo($correo){
   $mysqli = conectar();
   $sql = "SELECT nombreusuario
            FROM usuarios
            WHERE email = ?";

   $stmt = $mysqli->prepare($sql);
   $stmt->bind_param("s", $correo);
   $stmt->execute();

   $stmt->bind_result($col1);
   $stmt->fetch();

   $stmt->close();
   $mysqli->close();

   return $col1;
}

function insertarCancion($autor, $nombreCancion, $caratula, $duracion, $genero, $archivo, $premium){

   $con = conectar();
   if($con != NULL){
      $sql = "INSERT INTO cancion(autor, titulo, caratula, duracion, genero, archivo, premium) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $result = $con->prepare($sql);
      if($premium == "on")
         $premium = true;
      else
         $premium = false;

      $result->bind_param("sssssss", $autor, $nombreCancion, $caratula, $duracion, $genero, $archivo, $premium);
      $result->execute();
      $rows = $result->get_result();
      return true;
   }
   else{
      return false;
   }
}

function subirArchivoRenombrar($archivo, $directorioTemporal, $directorioSubida, $nuevoNombre){

   $fichero_subido = $directorioSubida . basename($archivo);
   if (move_uploaded_file($directorioTemporal, $fichero_subido)){
      if(rename($fichero_subido, $directorioSubida.basename($nuevoNombre)))
         return true;
      else
         return false;
   } else {
      return false;
   }
}

function actualizarPremium($usuario, $cuenta, $cvv, $fechaCad, $titular, $meses, $caducidadPremium){
   $con = conectar();
   if($con != NULL){
      $sql = "UPDATE premium SET numerotarjeta = ?, cvv = ?, fechacaducidad = ?, $titular = ?, periodo = ?, fechacaducidadpremium = ? WHERE usuario = ?";
      $result = $con->prepare($sql);
      $result->bind_param("sssssss", $cuenta, $cvv, $fechaCad, $titular, $caducidadPremium, $meses, $usuario);
      $result->execute();
      return true;
   }
   else{
      return false;
   }
}

function cambiarFotoDePerfil($usuario, $archivo){
   $con = conectar();
   if($con != NULL){
      $sql = "UPDATE usuarios SET foto = ? WHERE nombreusuario = ?";
      $result = $con->prepare($sql);
      $result->bind_param("ss", $archivo, $usuario);
      $result->execute();
      return true;
   }
   else{
      return false;
   }
}

function cambiarFotoEncabezado($usuario, $archivo){
   $con = conectar();
   if($con != NULL){
      $sql = "UPDATE usuarios SET encabezado = ? WHERE nombreusuario = ?";
      $result = $con->prepare($sql);
      $result->bind_param("ss", $archivo, $usuario);
      $result->execute();
      return true;
   }
   else{
      return false;
   }
}

function aniadirReproduccion($titulo, $autor, $usuario){
   $mysqli = conectar();
   //cogemos el ID de la cancion
   $stmt = $mysqli->prepare("SELECT id FROM cancion WHERE titulo = ? AND autor = ?");
   $stmt->bind_param("ss", $titulo, $autor);
   $stmt->execute();
   $stmt->bind_result($id_cancion);
   $stmt->fetch();
   $stmt->close();
   //insertamos la reproduccion
   $stmt2 = $mysqli->prepare("INSERT INTO reproducciones (usuario, cancion) VALUES (?, ?)");
   $stmt2->bind_param("si", $usuario, $id_cancion);
   $stmt2->execute();
   $stmt2->close();

   desconectar($mysqli);

}

?>
