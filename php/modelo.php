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

    /*if(existeUsuario($usuario)) {
      //print ("El nombre de usuario ya está en uso.");
      //header("Location: ../src/registro.html");
      //echo '<div class="alert alert-danger alertas-registro" id="ID_Error_Usuario">Patata</div>';
      $ret = False;
    } else if (existeCorreo($correo)) {
      //print ("El correo electrónico ya está en uso.");
      $ret = False;
    } else {*/
    if (!$stmt->execute()) {
      printf("Errormessage: %s\n", $mysqli->error);
      $ret = False;
    }

    $stmt->close();
    $mysqli->close();

    return $ret;
  }
?>
