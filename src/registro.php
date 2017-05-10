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
          $usuario = False;
          $correo = False;

          if($_SERVER["REQUEST_METHOD"] == "POST") {
            require_once('../php/controlador.php');
            if(existe_usuario()) {
              $usuario = True;
            }
            if(existe_correo()) {
              $correo = True;
            }
            if(!$correo && !$usuario) {
              if(registra_usuario()) {
                header("Location: ../src/home.php");
              }
            }
          }
        ?>
        <!-- Barra superior de la página -->
        <nav  class="navbar navbar-inverse">
            <a class="navbar-brand" href="../index.html">Webmusic</a>
            <div class="navbar-header">
                <img src="../img/Logo.png" width="50" height="50" alt="logo">
                <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="navbarCollapse" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="login.html"><span class="glyphicon glyphicon-log-in"></span> Iniciar sesión</a></li>
                </ul>
            </div>
        </nav><!-- Fin barra superior -->

        <div id="container-principal"><!-- Container principal que contiene todo el registro -->
            <div class="row">
                <div class="col-md-4 col-md-push-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Registro</div>
                        <div class="panel-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST" onsubmit="return validarRegistro()">
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
                                                <input class="form-control" placeholder="Nombre de usuario *" id="ID_Usuario" name="usuario" type="text" onchange="validarUsuario()"
                                                value=<?php if($_SERVER["REQUEST_METHOD"] == "POST"){echo $_POST["usuario"];} ?>>
                                            </div>
                                            <div class="alert alert-danger alertas-registro" id="ID_Error_Usuario"></div>
                                            <?php if($usuario) {
                                              echo '<div class="alert alert-danger" id="ID_Error_Usuario">Usuario ya registrado.</div>';
                                            } ?>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                <input class="form-control" placeholder="Correo electrónico *" id="ID_Correo" name="correo" type="text" onchange="validarCorreo()"
                                                value=<?php if($_SERVER["REQUEST_METHOD"] == "POST"){echo $_POST["correo"];} ?>>
                                            </div>
                                            <div class="alert alert-danger alertas-registro" id="ID_Error_Correo"></div>
                                            <?php if($correo) {
                                              echo '<div class="alert alert-danger" id="ID_Error_Usuario">Correo ya registrado.</div>';
                                            } ?>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                <input class="form-control" placeholder="Contraseña *" id="ID_Pass" name="contrasenya" type="password" onchange="validarContrasenya()">
                                            </div>
                                            <div class="alert alert-danger alertas-registro" id="ID_Error_Pass"></div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                <input class="form-control" placeholder="Repite la contraseña *" id="ID_Pass1" type="password" onchange="validarReContrasenya()">
                                            </div>
                                            <div class="alert alert-danger alertas-registro" id="ID_Error_Pass1"></div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="checkbox">
                                                    <label><input type="checkbox" class="checkbox" value="">Hacerme premium</label>
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
                        <a href="index.html"><img alt="WebMusic" src="../img/Logo.png" width="180" height="180"></a>
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
