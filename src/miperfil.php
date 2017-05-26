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
	<?php
	$errorCorreo = $errorDescripcion = $errorPerfil = $errorEncabezado = "";
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		require_once('../php/controlador.php');
		$nuevoCorreo = $nuevaDescripcion = $nuevaImagenPerfil = $nuevoEncabezado = "";
		if(isset($_POST['nuevo_email'])){
			$nuevoCorreo = validar_entrada($_POST['nuevo_email']);
			//meto el nuevo correo
			if($nuevoCorreo != "")
			if(!cambiar_email($_SESSION['usuario'], $nuevoCorreo)){
				$errorCorreo = true;
			}
		}
		if(isset($_POST['nueva_descripcion'])){
			//meto la nueva descripcion
			$nuevaDescripcion = validar_entrada($_POST['nueva_descripcion']);
			if($nuevaDescripcion != "")
			if(!cambiar_descripcion($_SESSION['usuario'], $nuevaDescripcion)){
				$errorDescripcion = true;
			}
		}
		if(isset($_FILES['nuevo_perfil'])){
			//meto la nueva foto de perfil
			$nuevaImagenPerfil = $_FILES['nuevo_perfil'];
			if(!actualizar_perfil($nuevaImagenPerfil['name'], $nuevaImagenPerfil['tmp_name'], "../img/", $_SESSION['usuario']."_perfil.png")){
				$errorPerfil = true;
			}
			else{
				if(!cambiar_foto_perfil($_SESSION['usuario'], $_SESSION['usuario']."_perfil.png")){
					$errorPerfil = true;
				}
			}
		}
		if(isset($_FILES['nueva_imagen_encabezado'])){
			//meto la nueva foto de encabezado
			$nuevoEncabezado = $_FILES['nueva_imagen_encabezado'];
			if(!actualizar_perfil($nuevoEncabezado['name'], $nuevoEncabezado['tmp_name'], "../img/", $_SESSION['usuario']."_encabezado.png")){
				$errorEncabezado = true;
			}
			else{
				if(!cambiar_foto_encabezado($_SESSION['usuario'], $_SESSION['usuario']."_encabezado.png")){
					$errorEncabezado = true;
				}
			}
		}
		if(isset($_POST['generosSeleccionados'])){
			borrar_generos_usuario($_SESSION['usuario']);
			$generosNuevos = $_POST['generosSeleccionados'];
			foreach($generosNuevos as $genero){
				insertar_nuevo_genero_usuario($_SESSION['usuario'], $genero);
			}
		}
		header('Location:'.htmlspecialchars($_SERVER['PHP_SELF']));
	}
	?>
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
                        <div class="fb-profile-text"></div></div>';
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
															<img class="user-resume-img" src="../img/'.cargar_caratula_por_defecto($fila["caratula"]).'width="64" height="64" alt="Imagen usuario">
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
                                <div class="tab-pane" id="Editar_Perfil">
                                    <form class="form-horizontal" id="form_editar_Perfil" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Email:</label>
                                            <div class="col-lg-8">
                                                <input id="id_nuevo_email" class="form-control" type="text" name="nuevo_email">
                                            </div>
											<div class="alert alert-danger alertas-registro" id="ID_error_email"></div>
											<?php
												if($errorCorreo != "" && $errorCorreo){
													echo "<div class='alert alert-danger alertas-registro' id='ID_error_email'>No se pudo guardar el correo</div>";
												}
											?>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Imagen de perfil:</label>
                                            <div class="col-lg-8">
                                                <input id="nueva_imagen_perfil" class="form-control" type="file" name="nuevo_perfil" enctype="multipart/form-data">
                                            </div>
											<div class="alert alert-danger alertas-registro" id="ID_error_perfil"></div>
											<?php
												if($errorPerfil != "" && $errorPerfil){
													echo "<div class='alert alert-danger alertas-registro' id='ID_error_perfil'>No se pudo guardar la nueva imagen</div>";
												}
											?>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Imagen de encabezado:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" type="file" name="nueva_imagen_encabezado" id="nuevo_encabezado" enctype="multipart/form-data">
                                            </div>
											<div class="alert alert-danger alertas-registro" id="ID_error_encabezado"></div>
											<?php
												if($errorEncabezado != "" && $errorEncabezado){
													echo "<div class='alert alert-danger alertas-registro' id='ID_error_encabezado'>No se pudo guardar el encabezado</div>";
												}
											?>
                                        </div>
										<div class="form-group">
                                            <label class="col-lg-2 control-label">Descripcion:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" type="text" name="nueva_descripcion" id="id_descripcion">
                                            </div>
											<div class="alert alert-danger alertas-registro" id="ID_error_descripcion"></div>
											<?php
												if($errorDescripcion != "" && $errorDescripcion){
													echo "<div class='alert alert-danger alertas-registro' id='ID_error_descripcion'>No se pudo guardar la descripcion</div>";
												}
											?>
                                        </div>
                                        <button id="cambiar_perfil" class="btn btn-primary btn-block">Guardar cambios</button>
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
                                    <?php

                                        $resultado = obtener_gustos_musicales(validar_entrada($_SESSION['usuario']));

                                        foreach ($resultado as $fila) {
                                            echo '<div class="form-group">
                                                    <label>'.$fila.'</label>
                                                    </div>';
                                        }
                                    ?>
                                    <button id="habilitar_edicion" class="btn btn-primary btn-block">Editar gustos musicales</button>
                                </div>
                                <form class="form-horizontal" id="form_gustos" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
									<div class="col-lg-12" id="editarGustos">
										<?php
										$resultado = obtener_gustos_musicales(validar_entrada($_SESSION['usuario']));
										$generos = obtener_generos();
										foreach($generos as $genero){
											if(!in_array($genero, $resultado)){
												echo "<div class='checkbox'>";
												echo "<label><input type='checkbox' name='generosSeleccionados[]' value=".$genero.">".$genero."</label>";
												echo "</div>";
												
											}
											else{
												echo "<div class='checkbox'>";
												echo "<label><input name='generosSeleccionados[]' value=".$genero." type='checkbox' checked>".$genero."</label>";
												echo "</div>";
											}
										}
										?>
										<button id="guardar_cambios" class="btn-primary btn-block">Guardar</button>
										<button id="cancelar" class="btn btn-primary btn-block">Cancelar</button>
									</div>
								</form>
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
