<!DOCTYPE html>
<html lang="es">
        <noscript>
            <meta http-equiv="refresh" content="0" url="errorJS.html">
        </noscript>
		<?php
			$errorUsuario = false;
			$errorAutenticacion = false;
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				require_once('../php/controlador.php');
				$usuario = validar_entrada($_POST['usuario']);
				$pass = validar_entrada($_POST['password']);
				
				if(!existe_usuario($usuario)){
					if(!existe_correo($usuario)){
						//error
						$errorUsuario = true;
					}
					else{
						//autentico
						if(autenticar_con_correo($usuario, $pass)){
							$pos = strpos($usuario, '@');
							if($pos === false){
								session_start();
								$_SESSION['usuario']=$usuario;//HACER
								header('Location: miPerfil.php');
							}
							else{
								$auxUsuario = conseguir_usuario_correo($usuario);
								if($auxUsuario != NULL){
									session_start();
									$_SESSION['usuario']=$auxUsuario;//HACER
									header('Location: miPerfil.php');
								}
								else{
									$errorUsuario = true;
								}
							}
						}
						else{
							$errorAutenticacion = true;
						}
					}
				}
				else{
					//autentico
					if(autenticar_con_correo($usuario, $pass)){
						session_start();
						$_SESSION['usuario']=$usuario;
						header('Location: miPerfil.php');
					}
					else{
						$errorAutenticacion = true;
					}
				}
			}
		?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Inicio Sesion</title>
        <link rel="icon" type="image/png" href="../img/Logo.png"/>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/webmusic.css" rel="stylesheet">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>
        <!-- Archivo con las funciones javascript que se encargan de validar el login-->
        <script src="../js/login.js"></script>
    </head>

    <body>
        <div id="container-principal">
           <!-- Barra superior de la página -->
           <?php
             require_once("../php/navbar.php");
             navbar();
           ?>
           <!-- Fin barra superior -->

            <div><!-- Container principal que contiene todos los campos de inicio de sesion -->
                <div class="row">
                    <div class="col-md-4 col-md-push-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">Inicio de Sesion</div>
                            <div class="panel-body">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                                    <div class="row">
                                        <div class="center-block">
                                            <img class="profile-img" src="../img/ImagenRegistroInterior.png" alt="Imagen Registro">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10 col-md-push-1">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                    <input class="form-control" placeholder="Correo electrónico/Usuario *" id="ID_Usuario" type="text" name="usuario">
                                                </div>
                                                <div class="alert alert-danger alertas-registro" id="ID_Error_Usuario"></div>
												<?php
													if($errorUsuario){
														echo "<div class='alert alert-danger alertas-registro' id='ID_Error_Usuario'>Correo/Usuario no registrado</div>";
													}	
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                    <input class="form-control" placeholder="Contraseña *" id="ID_Pass" type="password" name="password">
                                                </div>
                                                <div class="alert alert-danger alertas-registro" id="ID_Error_Pass"></div>
                                                <?php
													if($errorAutenticacion){
														echo "<div class='alert alert-danger alertas-registro' id='ID_Error_Pass'>Contraseña erronea</div>";
													}	
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-plus"></i></span>
                                                    <input class="form-control" placeholder="" id="ID_Suma" type="text">
                                                </div>
                                                <div class="alert alert-danger alertas-registro" id="ID_Error_Suma"></div>
                                            </div>
                                            <div class="form-group">
                                                <p>Los campos con * son obligatorios</p>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary center-block" value="Iniciar Sesion">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Fin container principal -->
        </div>

        <!-- Container que contiene el footer de la página -->
        <!--<div class="footer-container">
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
        </div>Fin container footer -->
    </body>
</html>
