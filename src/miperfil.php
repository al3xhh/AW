<!DOCTYPE html>
<html lang="es">
    <head>
        <noscript>
            <meta http-equiv="refresh" content="0" url="errorJS.html">
        </noscript>
		<?php
			session_start();
			/*if(!isset($_SESSION['usuario']))
				header('Location: login.php');*/
			
			$_SESSION['usuario'] = "alex";
		?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $_SESSION['usuario']?></title>

        <link rel="icon" type="image/png" href="../img/Logo.png"/>

        <!-- Bootstrap -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/webmusic.css" rel="stylesheet">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/miPerfil.js"></script>
    </head>
    <body>
        <div id="container-principal">

           <!-- Barra superior de la página -->
           <?php
             require_once("../php/navbar.php");
             navbar();
           ?>
           <!-- Fin barra superior -->

            <!-- Barra de búsqueda -->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div id="imaginary_container">
                            <div class="input-group stylish-input-group">
                                <input type="text" class="form-control"  placeholder="Buscar" >
                                <span class="input-group-addon">
                                    <a href="buscar_registrado.html" class="link-home-carousel-and-search"><span class="glyphicon glyphicon-search"></span></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Fin barra de búsqueda -->

            <div class="container-fluid">
                <div class="row">
                <?php
					require_once("../php/controlador.php");
					$resultado = obtener_informacion_usuario(validar_entrada($_SESSION['usuario']));
					echo '<div class="fb-profile">
                           <img class="fb-image-lg" src="../img/'.cargar_Ruta_Foto_Encabezado($resultado[0]["encabezado"]).'" alt="Profile image example" height=400>
                           <img class="fb-image-profile thumbnail" src="../img/'.cargar_Ruta_Foto_Perfil($resultado[0]["foto"]).'" alt="Profile image example">
                           <div class="fb-profile-text">
								<h1>'.$resultado[0]["nombreusuario"].'</h1>
                           </div>
                        <div class="fb-profile-text">';
               ?>
                </div>
            </div> <!-- /container fluid-->

            <div class="container">
                <div class="col-sm-8">
                    <div data-spy="scroll" class="tabbable-panel">
                        <div class="tabbable-line">
                            <ul class="nav nav-tabs ">
                                <li class="active">
                                    <a href="#Descripcion" data-toggle="tab">Descripción</a>
                                </li>
                                <li>
                                    <a href="#Seguidores" data-toggle="tab">Seguidores</a>
                                </li>
                                <li>
                                    <a href="#Seguidos" data-toggle="tab">Seguidos</a>
                                </li>
                                <li>
                                    <a href="#Canciones" data-toggle="tab">Canciones</a>
                                </li>
                                <li>
                                    <a href="#Editar_Perfil" data-toggle="tab">Editar Perfil</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="Descripcion">
									<?php
										$resultado = obtener_descripcion_usuario(validar_entrada($_SESSION['usuario']));
										echo '<p>'.$resultado.'</p>';
									?>
                                </div>
                                <div class="tab-pane" id="Seguidores">
                                    <?php
										$resultado = obtener_seguidores(validar_entrada($_SESSION['usuario']));
										
										foreach ($resultado as $fila){
											if($_SESSION['usuario'] != $fila["seguidor"]) {
												echo '<div class="user-resume">
														<div>
															<img class="user-resume-img" src="../img/'.cargar_Ruta_Foto_Perfil($fila["foto"]).'" width="64" height="64" alt="Imagen usuario">
														</div>
														<div class="user-resume-info">
															<h3>'.$fila["seguidor"].'</h3>
														</div>
														<div class="user-resume-button">
														<button value="';
                                                echo $fila["seguidor"];
                                                echo '"type="submit" class="btn btn-primary pull-right" id="SeguidoresSeguir">';
                                                if(sigueA(validar_entrada($_SESSION['usuario']), validar_entrada($fila["seguidor"]))) {
                                                   echo 'Siguiendo';
                                                } 
												else {
                                                   echo 'Seguir';
                                                }
                                                echo '</button>
                                                       </div>
                                                       </div>';
                                            }
										}
									?>
                                </div>
                                <div class="tab-pane" id="Seguidos">
                                    <?php
										$resultado = obtener_seguidos(validar_entrada($_SESSION['usuario']));

										foreach ($resultado as $fila) {
											if($_SESSION['usuario'] != $fila["seguido"]) {
												echo '<div class="user-resume">
														<div>
															<img class="user-resume-img" src="../img/'.cargar_Ruta_Foto_Perfil($fila["foto"]).'" width="64" height="64" alt="Imagen usuario">
														</div>
														<div class="user-resume-info">
															<h3>'.$fila["seguido"].'</h3>
														</div>
														<div class="user-resume-button">
															<button <button value="';
                                                echo $fila["seguido"];
                                                echo '"type="submit" class="btn btn-primary pull-right" id="SeguidosSeguir">';
												if(sigueA(validar_entrada($_SESSION['usuario']), validar_entrada($fila["seguido"]))){
                                                   echo 'Siguiendo';
                                                } else {
                                                   echo 'Seguir';
                                                }
                                                echo '</button>
                                                      </div>
                                                      </div>';
											}
										}
									?>
                                </div>
                                <div class="tab-pane" id="Canciones">
                                    <?PHP
										$resultado = obtener_canciones_usuario(validar_entrada($_SESSION['usuario']));

										if (empty($resultado)) {
											echo '<h4 class="text-center">El usuario no ha subido aún ninguna canción.</h4>';
										} else {
											foreach ($resultado as $fila) {
												echo '<div class="user-resume">
														<div>
															<img class="user-resume-img" src="../img/'.cargar_caratula_por_defecto($fila["caratula"]).'" width="64" height="64" alt="Imagen usuario">
														</div>
														<div class="user-resume-info">
															<h3>'.$fila["titulo"].'</h3>
														</div>
														<div class="user-resume-button">
															<a href="reproductor.php?titulo='.$fila["titulo"].'"><button type="button" class="btn btn-primary pull-right glyphicon glyphicon-play" data-toggle="tooltip" title="escuchar canción"></button></a>
														</div>
													</div>';
											}
										}
									?>
                                </div>
                                <div class="tab-pane" id="tab_default_5">

                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Nombre:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Apellido:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Nombre de usuario:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Email:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Imagen de perfil:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" type="file">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Imagen de encabezado:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" type="file">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-danger btn-block">Guardar cambios</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="menu_title">
                            Gustos musicales
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12" id="panelGustos">
                                    <div class="form-group">
                                        <label>Pop:</label>
										<p>Caca</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Rock</label>
										<p></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Hip-Hop</label>
										<p></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Reagge</label>
										<p></p>
                                    </div>
                                    <div class="form-group">
                                        <label>House</label>
										<p></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Música clásica</label>
										<p></p>
                                    </div>
                                    <button id="habilitar_edicion" class="btn btn-danger btn-block">Editar gustos musicales</button>
                                </div>
                                <div class="col-lg-12" id="editarGustos">
                                    <div class="form-group">
                                        <label>Pop:</label>
                                        <input class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Rock:</label>
                                        <input class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Hip-Hop:</label>
                                        <input class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Reagge:</label>
                                        <input class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>House:</label>
                                        <input class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Musica clasica:</label>
                                        <input class="form-control">
                                    </div>

                                    <button id="guardar_cambios" class="btn btn-danger btn-block">Guardar</button>
                                    <button id="cancelar" class="btn btn-danger btn-block">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
