<?php

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
  function existeUsuario() {
    $mysqli = new mysqli('127.0.0.1', 'webmusic', 'webmusic', 'WebMusic');
    $usuario = htmlspecialchars(trim(strip_tags($_POST["usuario"])));
    $ret = False;

    errorMysql($mysqli);

    $sql = "SELECT nombreusuario FROM usuarios WHERE nombreusuario = '$usuario'";

    if (!$resultado = $mysqli->query($sql)) {
      printf("Errormessage: %s\n", $mysqli->error);
    }

    if ($resultado->num_rows > 0) {
      $ret = True;
    }

    $mysqli->close();

    return $ret;
  }

  //Función que comprueba si existe el correo electrónico en la aplicación.
  function existeCorreo() {
    $mysqli = new mysqli('127.0.0.1', 'webmusic', 'webmusic', 'WebMusic');
    $correo = htmlspecialchars(trim(strip_tags($_POST["correo"])));
    $ret = False;

    errorMysql($mysqli);

    $sql = "SELECT email FROM usuarios WHERE email = '$correo'";

    if (!$resultado = $mysqli->query($sql)) {
      printf("Errormessage: %s\n", $mysqli->error);
    }

    if ($resultado->num_rows > 0) {
      $ret = True;
    }

    $mysqli->close();

    return $ret;
  }

  //Función que se encarga de realizar el registro de un usuario en la aplicación.
  function registraUsuario() {
    $mysqli = new mysqli('127.0.0.1', 'webmusic', 'webmusic', 'WebMusic');
    $usuario = htmlspecialchars(trim(strip_tags($_POST["usuario"])));
    $correo = htmlspecialchars(trim(strip_tags($_POST["correo"])));
    $contrasenya = hash('sha256', htmlspecialchars(trim(strip_tags($_POST["contrasenya"]))));
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
      $_SESSION['username'] = $usuario;
    }

    $stmt->close();
    $mysqli->close();

    return $ret;
  }

  //Función que recupera el top de novedades para el usuario conectado.
  function tusNovedades() {
    $mysqli = new mysqli('127.0.0.1', 'webmusic', 'webmusic', 'WebMusic');
    $usuario = $_SESSION['username'];

    errorMysql($mysqli);

    //TODO ordenar por fecha de publicación.
    $sql = "SELECT titulo, autor, fechapublicacion
            FROM cancion
            JOIN sigue ON seguido = autor
            WHERE seguidor = ?
            ORDER BY fechapublicacion DESC
            LIMIT 10";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $usuario);

    if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
    }

    $ret = $stmt->get_result();
    $stmt->close();
    $mysqli->close();

    return $ret;
  }

  //Función que recupera el top de canciones según los gustos del usuario.
  function tusTop() {
    $mysqli = new mysqli('127.0.0.1', 'webmusic', 'webmusic', 'WebMusic');
    $usuario = $_SESSION['username'];

    errorMysql($mysqli);

    $sql = "SELECT titulo, autor, numeroreproducciones
            FROM cancion
            JOIN gustos ON cancion.genero = gustos.genero
            WHERE gustos.usuario = ?
            ORDER BY numeroreproducciones DESC
            LIMIT 10";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $usuario);

    if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
    }

    $ret = $stmt->get_result();
    $stmt->close();
    $mysqli->close();

    return $ret;
  }

  //Función que recupera el top social de canciones del usuario.
  function tusTopSocial() {
    $mysqli = new mysqli('127.0.0.1', 'webmusic', 'webmusic', 'WebMusic');
    $usuario = $_SESSION['username'];

    errorMysql($mysqli);

    //TODO ordenar por fecha.
    $sql = "SELECT cancion.titulo, cancion.autor, fechareproduccion
            FROM cancion
            JOIN reproducciones
            ON cancion.autor = reproducciones.autor
            WHERE reproducciones.usuario IN (SELECT seguido
                                             FROM sigue
                                             WHERE seguidor = ?)
            ORDER BY fechareproduccion DESC
            LIMIT 10";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $usuario);

    if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
    }

    $ret = $stmt->get_result();
    $stmt->close();
    $mysqli->close();

    return $ret;
  }
?>
