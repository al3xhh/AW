<!DOCTYPE html>
<html lang="es">
   <head>
      <?php
      require_once("../php/controlador.php");
      session_start();
      if(!isset($_SESSION['usuario']))
         header('Location: login.php');
      
	  $premium = es_premium($_SESSION['usuario']);
      ?>
      <noscript>
         <meta http-equiv="refresh" content="0" url="errorJS.html">
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
	  $nocaratula = false;
      if($_SERVER["REQUEST_METHOD"] == "POST"){
         require_once("../php/controlador.php");
		 require_once("../php/utils.php");

         $nombreCancionUsuario = validar_entrada($_POST['nombreCancion']);
         $nombreCancionCaratulaArchivo = str_replace(" ", "_", validar_entrada($_POST['nombreCancion']));
         $genero = validar_entrada($_POST['genero']);
         $cancion = $_FILES['cancion']['name'];
         $dirTemporalCancion = $_FILES['cancion']['tmp_name'];
         $dirSubidaCancion = "../songs/";

         $caratula = validar_entrada($_FILES['imagenCancion']['name']);
         $dirSubidaImagen = "../img/";
         $dirTemporalCaratula = $_FILES['imagenCancion']['tmp_name'];


         $nombreCancion = $nombreCancionCaratulaArchivo."_".$_SESSION["usuario"].".mp3";
         //inserto en la base de datos la cancion
         //subir_archivo($archivo, $directorioTemporal, $directorioSubida)
         //subir_archivo_renombrar($archivo, $directorioTemporal, $directorioSubida, $nuevoNombre)

		 if(validarCancion($cancion)){
			if($caratula == ""){
				$caratula = "CaratulaPorDefecto.jpg";
				$nocaratula = true;
				$okimagen = true;
			} 
			else {
				if(validarFoto($caratula)){
					$caratula = $nombreCancionCaratulaArchivo."_".$_SESSION['usuario']."_caratula.jpg";
					$okimagen = true;
				}
				else{
					$okimagen = false;
				}
				
			}
			$okcancion = true;
		 }
		 else{
			$okcancion = false;
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
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
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
                                       <input class="form-control" placeholder="Cancion *" id="ID_Cancion" type="text" name="nombreCancion">
                                    </div>
                                    <div class="alert alert-danger alertas-registro" id="ID_Error_Cancion"></div>
                                 </div>
                                 <div class="form-group">
                                    <div class="input-group">
                                       <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                       <input class="form-control" id="ID_Imagen" type="file" name="imagenCancion" enctype="multipart/form-data">
                                    </div>
                                    <div class="alert alert-danger alertas-registro" id="ID_Error_Imagen">Si no pones imagen, se pondra una por defecto</div>
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
                                       <input class="form-control" id="ID_Archivo_Cancion" type="file" name="cancion" enctype="multipart/form-data">
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
                                            if(!$nocaratula){
												if(subir_archivo_renombrar($caratula, $dirTemporalCaratula, $dirSubidaImagen, $nombreCancionCaratulaArchivo."_".$_SESSION['usuario']."_caratula.jpg")){
													if(subir_archivo_renombrar($cancion, $dirTemporalCancion, $dirSubidaCancion, $nombreCancion)){
													   //inserto en la bbdd
													   //insertarCancion($autor, $nombreCancion, $caratula, $duracion, $genero, $archivo, $premium)
													   insertar_cancion($_SESSION['usuario'], $nombreCancionUsuario, $caratula, $genero, $nombreCancion, $premium);
													}
												}
											}
											else{
												if(subir_archivo_renombrar($cancion, $dirTemporalCancion, $dirSubidaCancion, $nombreCancion)){
												   //inserto en la bbdd
												   //insertarCancion($autor, $nombreCancion, $caratula, $duracion, $genero, $archivo, $premium)
												   insertar_cancion($_SESSION['usuario'], $nombreCancionUsuario, $caratula, $genero, $nombreCancion, $premium);
												}
											}												
                                          }
                                       }
                                    }
                                    ?>
									<div class="input-group">
											<audio class="form-control" id="duracion_cancion" name="duracion"></audio>
									</div>
                                 </div>
                                 <div class="form-group">
                                    <label for="genero_cancion">Generos:</label>
                                    <select class="form-control" id="genero_cancion" name="genero">
                                       <?php
                                       require_once("../php/controlador.php");
                                       $result = obtener_generos();
                                       //echo "<option value='Genero'>Generos</option>";
                                       foreach($result as $fila){
                                          echo "<option value='".$fila."'>".$fila."</option>";
                                       }

                                       echo "</select>";
                                       echo "<div class='alert alert-danger alertas-registro' id='ID_Error_Genero'>Tienes que seleccionar un genero</div>";
                                       ?>
                                    </select>
                                    <?php
										if($premium){
										   echo "<div class='form-group'>";
										   echo "<div class='checkbox'>";
										   echo "<label><input type='checkbox' name='premium'>Haz premium tu cancion</label>";
										   echo "</div>";
										   echo "</div>";
										}
                                    ?>
                                    <div class="form-group">
                                       <p>Los campos con * son obligatorios</p>
                                    </div>
                                    <div class="form-group">
                                       <input type="submit" class="btn btn-primary center-block" value="Subir Cancion">
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
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
                        <li><a href="mapa.php">Mapa del sitio</a></li>
                        <li><a href="https://github.com/christian7007/AW.git">GitHub</a></li>
                        <li><a href="../Memoria_Grupo05_Webmusic.pdf" download>Memoria</a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </footer>
      </div><!-- Fin container footer -->
   </body>
</html>
