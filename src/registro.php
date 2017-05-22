<!DOCTYPE html>
<html lang="es">
    <head>
        <noscript>
            <meta http-equiv="refresh" content="0; url=errorJS.html" />
        </noscript>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Registro</title>
        <link rel="icon" type="image/png" href="../img/Logo.png"/>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/webmusic.css" rel="stylesheet">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>
        <!-- Archivo con las funciones javascript que se encargan de validar el registro-->
        <script src="../js/registro.js"></script>
        <!-- Java script necesario para que funcione el recaptcha de google-->
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>

    <body>
        <?PHP
          $existe_usuario = False;
          $existe_correo = False;
          $usuario_valido = False;
          $correo_valido = False;
          $contrasenya_valida = False;
          $recontrasenya_valida = False;

          if($_SERVER["REQUEST_METHOD"] == "POST") {
            require_once('../php/controlador.php');
            require_once('../php/utils.php');

            if(existe_usuario(validar_entrada($_POST["usuario"]))) {
              $existe_usuario = True;
            }
            if(existe_correo(validar_entrada($_POST["correo"]))) {
              $existe_correo = True;
            }

            if(validarUsuario(validar_entrada($_POST["usuario"]))) {
               $usuario_valido = True;
            }

            if(validarCorreo(validar_entrada($_POST["correo"]))) {
               $correo_valido = True;
            }

            if(validarContrasenya(validar_entrada($_POST["contrasenya"]))) {
               $contrasenya_valida = True;
            }

            if(validarReContrasenya(validar_entrada($_POST["contrasenya"]), validar_entrada($_POST["recontrasenya"]))) {
               $recontrasenya_valida = True;
            }

            if(!$correo && !$usuario && $usuario_valido && $correo_valido && $contrasenya_valida && $recontrasenya_valida) {
              if(registra_usuario(validar_entrada($_POST["usuario"]),
                                  validar_entrada($_POST["correo"]),
                                  hash('sha256', validar_entrada($_POST["contrasenya"])))) {
                if(isset($_POST['premium'])) {
                   header("Location: ../src/premium.php");
                } else {
                   header("Location: ../src/home.php");
                }
              }
            }
          }
        ?>

        <!-- Barra superior de la página -->
        <?php
          require_once("../php/navbar.php");
          navbar();
        ?><!-- Fin barra superior -->

        <div id="container-principal"><!-- Container principal que contiene todo el registro -->
            <div class="row">
                <div class="col-md-4 col-md-push-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Registro</div>
                        <div class="panel-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST" id="ID_Formulario">
                                <div class="row">
                                    <div class="center-block">
                                        <img class="profile-img" src="../img/ImagenRegistroInterior.png" alt="Imagen Registro">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-md-push-1">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input class="form-control" placeholder="Nombre de usuario *" id="ID_Usuario" name="usuario" type="text"
                                                value=<?php if($_SERVER["REQUEST_METHOD"] == "POST"){echo $_POST["usuario"];} ?>>
                                            </div>
                                            <div class="alert alert-danger alertas-registro" id="ID_Error_Usuario"></div>
                                            <?php
                                                if($existe_usuario) {
                                                   echo '<div class="alert alert-danger" id="ID_Error_Usuario_1">Usuario ya registrado.</div>';
                                                } else if($usuario_valido) {
                                                   echo '<div class="alert alert-danger" id="ID_Error_Usuario_2">Usuario no válido.</div>';
                                                }
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                <input class="form-control" placeholder="Correo electrónico *" id="ID_Correo" name="correo" type="text"
                                                value=<?php if($_SERVER["REQUEST_METHOD"] == "POST"){echo $_POST["correo"];} ?>>
                                            </div>
                                            <div class="alert alert-danger alertas-registro" id="ID_Error_Correo"></div>
                                            <?php
                                                if($existe_correo) {
                                                   echo '<div class="alert alert-danger" id="ID_Error_Correo_1">Correo ya registrado.</div>';
                                                } else if($correo_valido) {
                                                   echo '<div class="alert alert-danger" id="ID_Error_Correo_2">Correo no válido.</div>';
                                                }
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                <input class="form-control" placeholder="Contraseña *" id="ID_Pass" name="contrasenya" type="password">
                                            </div>
                                            <div class="alert alert-danger alertas-registro" id="ID_Error_Pass"></div>
                                            <?php
                                                if($contrasenya_valida) {
                                                   echo '<div class="alert alert-danger" id="ID_Error_Pass_1">Contraseña no válida.</div>';
                                                }
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                <input class="form-control" placeholder="Repite la contraseña *" id="ID_Pass1" name="recontrasenya" type="password">
                                            </div>
                                            <div class="alert alert-danger alertas-registro" id="ID_Error_Pass1"></div>
                                            <?php
                                                if($recontrasenya_valida) {
                                                   echo '<div class="alert alert-danger" id="ID_Error_Pass1_1">Las contraseñas no coinciden.</div>';
                                                }
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="checkbox">
                                                    <label><input type="checkbox" class="checkbox" name="premium" value="">Hacerme premium</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="g-recaptcha" data-sitekey="6LdZVhsUAAAAAA2qkQqHdaL8--EE9iPy0tzretMD"></div>
                                            <div class="alert alert-danger alertas-registro" id="ID_Error_Captcha"></div>
                                        </div>
                                        <div class="form-group">
                                            <p>Los campos con * son obligatorios</p>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary center-block" value="Registrarse" name="registrar">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="panel-footer">
                            Ya tienes cuenta!<a href="login.html"> Inicia sesión aquí </a>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Fin container principal -->


        <!-- Container que contiene el footer de la página -->
        <div class="footer-container">
            <footer class="footer-bs" id="footer">
                <div class="row">
                    <div class="margin-logo-footer col-md-2 footer-brand animated fadeInLeft">
                        <img class="img img-responsive" alt="WebMusic" src="../img/Logo.png" width="180" height="180">
                    </div>
                    <div class="col-md-10 footer-nav animated fadeInUp">
                        <div class="col-md-3">
                            <h4>Acerca de</h4>
                            <p>Webmusic es una página creada para el proyecto de la asignatura Aplicaciones Web, optativa del intinerario tecnologías de la información de la carrera Ingeniería Informática de la UCM.</p>
                        </div>
                        <div class="col-md-4 col-md-push-2">
                            <h4>Miembros</h4>
                            <ul class="list">
                                <li>José Ángel Garrido Montoya</li>
                                <li>Christian Gónzalez García-Muñoz</li>
                                <li>Alejandro Huertas Herrero</li>
                                <li>Héctor Valverde Bourgon</li>
                            </ul>
                        </div>
                        <div class="col-md-4 col-md-push-2">
                            <h4>Enlaces</h4>
                            <ul class="list">
                                <li><a href="#">Mapa del sitio</a></li>
                                <li><a href="#">FAQ</a></li>
                                <li><a href="#">Explicación diseño</a></li>
                                <li><a href="#">Guía de usuario</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div><!-- Fin container footer -->
    </body>
</html>
