<!DOCTYPE html>
<html lang="es">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <title>Reproductor-Nombre Cancion</title>

      <link rel="icon" type="image/png" href="../img/Logo.png"/>

      <!-- Bootstrap -->
      <link href="../css/bootstrap.min.css" rel="stylesheet">
      <link href="../css/webmusic.css" rel="stylesheet">
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="../js/bootstrap.min.js"></script>
      <script src="../js/reproductor.js"></script>
   </head>
   <body>
      <?php if(isset($_GET["titulo"]) && isset($_GET["usuario"])) : ?>
      <div id="container-principal">
         <!-- En caso de que no haya JavaScript avisamos al usuario de que la pagina podria ir mal pero no redirigimos a error ya que no podrian introducir datos maliciosos por falta de validaciones -->
         <noscript>
            <div class="alert alert-danger text-center">
               <h4>Esta página requiere JavaScript para su correcto funcionamiento. Compruebe si JavaScript está deshabilitado en el navegador.</h4>
            </div>
         </noscript>
         <!-- Barra superior de la página -->
         <?php
         require_once("../php/navbar.php");
         navbar();
         ?>
         <!-- Fin barra superior -->

         <div class="container-fluid">
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

            <!-- Cabecera del reproductor-->
            <div id="player-header" class="col-md-10 col-md-push-2">
               <div>
                  <?php
                  require_once("../php/controlador.php");
                  $info = info_cancion_reproductor($_GET["titulo"], $_GET["usuario"]);

                  if ($info["caratula"])
                     echo "<img src='../img/".$info["caratula"]."' width='150' height='150' alt='Imagen usuario'>";
                  else
                     echo "<img src='../img/CaratulaPorDefecto.jpg' width='150' height='150' alt='Imagen usuario'>";
                  ?>

               </div>
               <div id="player-header-info">
                  <?php
                  echo "<audio src=../songs/".$info["archivo"]." id='song'></audio>";
                  echo "<p id='nombre_cancion'>".$_GET["titulo"]."</p>\n";
                  echo "<p id='autor'>".$info["autor"]."</p>";
                  echo "<p>Nº reproducciones: ".$info["nreproducciones"]."</p>";
                  ?>

                  <?php if(isset($_SESSION["usuario"])) : ?>

                  <div class="form-group">
                     <label for="selList">Añadir a lista:</label>
                     <form action="addGusto.php" method="POST" id="addList-form">
                        <div class="col-md-12">
                           <select id="selList" class="form-control" form="addList-form" name="genero" type="submit">
                              <?php
                              $listas = obtener_listas_reproduccion_usuario($_SESSION["usuario"]);

                              foreach($listas as $lista)
                                 echo "<option>".$lista."</option>";

                              ?>
                           </select>
                        </div>
                     </form>
                  </div>
                  <?php endif; ?>
               </div>
            </div>

            <!-- Barra de control del reproductor -->
            <div id="bar-player" class="col-md-10 col-md-push-2">
               <!-- Botones para el control del reproducotor -->
               <div id="player-buttons">
                  <!-- Boton para volver a la cancion anterior -->
                  <button type="button" class="btn btn-default" aria-label="Left Align">
                     <span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span>
                  </button>

                  <!-- Boton de play/pause -->
                  <button id="playPauseButton"type="button" class="btn btn-default" aria-label="Left Align">
                     <span id="playPauseButtonSpan" class="glyphicon glyphicon-play" aria-hidden="true"></span>
                  </button>

                  <!-- Boton para pasar a la siguiente cancion -->
                  <button type="button" class="btn btn-default" aria-label="Left Align">
                     <span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span>
                  </button>
               </div>

               <!-- Barra de estado de la cancion -->
               <div id="info-player">
                  <p id="reproducido" class="info-player-time">0:0</p>
                  <div id="player-progres" class="progress">
                     <div id="myBar" class="progress-bar" role="progressbar" aria-valuenow="70"
                          aria-valuemin="0" aria-valuemax="100">
                     </div>
                  </div>
                  <p class="info-player-time" id="duracion"><?php echo  floor($info["duracion"] / 60), ":", $info["duracion"] % 60; ?></p>
               </div>
            </div>

            <h3 id="comment-title" class="col-md-10 col-md-push-2">Comentarios</h3>
            <?php if(isset($_SESSION["usuario"])) : ?>
            <div class="comment-content col-xs-12 col-md-8 col-md-push-2">
               <div class="row">
                  <div class="panel panel-primary">
                     <div class="panel-heading comment-heading">
                        <img src="../img/FotoUsuarioPorDefecto.png" class="img-circle img-responsive comment-img" alt="user profile image">
                        <div>
                           <h4 id="nombre_usuario"><?php echo $_SESSION["usuario"] ?></h4>
                        </div>
                     </div>
                     <div class="panel-body">
                        <textarea id="texto" class="col-md-12 form-control" form="comment-form"></textarea>
                        <button type="submit" id="comment-btn" class="btn btn-primary pull-right">Comentar</button>
                     </div>
                  </div>
               </div>
            </div>
            <?php endif; ?>
            <div id="comentarios">
               <?php
               $comentarios = obtener_info_comentarios_cancion($_GET["titulo"], $_GET["usuario"]);
               foreach($comentarios as $comentario){
                  echo "<div class='comment-content col-md-8 col-md-push-2 col-xs-12'>
                           <div class='row'>
                              <div class='panel panel-primary'>
                                 <div class='panel-heading comment-heading'>";
                  if ($comentario["foto"])
                     echo "         <img src='../img/".$comentario["foto"]."' class='img-circle img-responsive comment-img' alt='user profile image'>";
                  else
                     echo "         <img src='../img/FotoUsuarioPorDefecto.png' class='img-circle img-responsive comment-img' alt='user profile image'>";

                  echo "            <div>
                                       <h4>".$comentario["usuario"]."</h4>
                                       <h6>".$comentario["fecha"]."</h6>
                                    </div>
                                 </div>
                              <div class='panel-body'>
                                 <p>".$comentario["texto"]."</p>
                              </div>
                           </div>
                        </div>
                     </div>";
               }

               ?>
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
      <?php else : ?>
      <div class="alert alert-danger text-center">
         <h4>Has accedido a la pagina de forma incorrecta.</h4>
      </div>
      <?php endif; ?>
   </body>
</html>
