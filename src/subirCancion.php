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
        <title>Subir Cancion</title>
        <link rel="icon" type="image/png" href="../img/Logo.png"/>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/webmusic.css" rel="stylesheet">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>
        <!-- Script para comprobar los datos de la subida de la cancion -->
        <script src="../js/subirCancion.js"></script>
    </head>

    <body>
    <?php
		$okcancion = $okimagen = "";
        if($_SERVER["REQUEST_METHOD"] == "POST"){

			require_once("../php/controlador.php");
			$caratula = $_FILES['imagenCancion']['name'];
			$dirTemporalImagen = $_FILES['imagenCancion']['tmp_name'];
			$dirSubidaImagen = "../img/";
			$okimagen = subir_archivo(validar_entrada($caratula), validar_entrada($dirTemporalImagen), validar_entrada($dirSubidaImagen));
			
			if($okimagen){
				$cancion = $_FILES['cancion']['name'];
				$dirTemporalCancion = $_FILES['cancion']['tmp_name'];
				$dirSubidaCancion = "../songs/";
				
				$okcancion = subir_archivo(validar_entrada($cancion), validar_entrada($dirTemporalCancion), validar_entrada($dirSubidaCancion));
			}
		}
    ?>
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
                            <div class="panel-heading">Subir Cancion</div>
                            <div class="panel-body">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data" onsubmit="return validarFormCancion()">
                                    <div class="row">
                                        <div class="center-block">
                                            <img class="profile-img" src="../img/ImagenNota.png" alt="Imagen Registro">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10 col-md-push-1">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-font"></i></span>
                                                    <input class="form-control" placeholder="Cancion *" id="ID_Cancion" type="text" name="nombreCancion" onchange="validarCancion()">
                                                </div>
                                                <div class="alert alert-danger alertas-registro" id="ID_Error_Cancion"></div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                    <input class="form-control" placeholder="Artista *" id="ID_Artista" type="text" name="artista" onchange="validarArtista()">
                                                </div>
                                                <div class="alert alert-danger alertas-registro" id="ID_Error_Artista"></div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                                    <input class="form-control" id="ID_Imagen" type="file" name="imagenCancion" enctype="multipart/form-data" onchange="validarImagen()">
                                                </div>
                                                <div class="alert alert-danger alertas-registro" id="ID_Error_Imagen"></div>
												<?php
													if($okimagen != ""){
														if(!$okimagen){
															echo "<div class='alert alert-danger alertas-registro' id='ID_Error_Imagen'>No se pudo subir la imagen</div>";
														}
													}
												?>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-music"></i></span>
                                                    <input class="form-control" id="ID_Archivo_Cancion" type="file" name="cancion" enctype="multipart/form-data" onchange="validarArchivoCancion()">
                                                </div>
                                                <div class="alert alert-danger alertas-registro" id="ID_Error_Archivo_Cancion"></div>
												<?php
													if($okcancion != "" && $okcancion != ""){
														if(!$okimagen){
															echo "<div class='alert alert-danger alertas-registro' id='ID_Error_Archivo_Cancion'>No se subio la cancion porque no se pudo subir la imagen</div>";
														}
														else{
															if(!$okcancion){
																echo "<div class='alert alert-danger alertas-registro' id='ID_Error_Archivo_Cancion'>No se pudo subir la cancion</div>";
															}
															else{
																//aqui se sube la cancion
																
															}
														}
													}
												?>
                                            </div>
                                            <div class="form-group">
                                                <label for="sel1">Generos:</label>
                                                <select class="form-control" id="sel1">
                                                    <?php
    													require_once("../php/controlador.php");
    													$result = obtener_generos();
    													foreach($result as $fila){
    														echo "<option>".$fila."</option>";
    													}
    												?>
                                                </select>
                                            </div>
                                            </div>
                                            <div class="form-group">
                                                </br>
                                                <p>Los campos con * son obligatorios</p>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary center-block" value="Subir Cancion">
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
        </div>-->
    </body>
</html>
