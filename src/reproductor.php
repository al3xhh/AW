<!DOCTYPE html>
<?php
session_start();
//comprabamos si esta bien definida la session y si no la cerramos
if (!isset($_SESSION["usuario"])){
   session_unset();
   session_destroy();
}
?>
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
                        <form action="buscar.php" method="get" id="ID_Formulario">
                           <div class="input-group stylish-input-group">
                              <input type="text" class="form-control"  placeholder="Buscar" name="busqueda">
                              <input type="hidden" value="1" name="tipo">
                              <span class="input-group-addon">
                                 <button class="glyphicon glyphicon-search" type="submit"></button>
                              </span>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div><!-- Fin barra de búsqueda -->

            <!-- Cabecera del reproductor-->
            <div id="player-header" class="col-md-10 col-md-push-2">
               <div>
                  <?php
                  require_once("../php/controlador.php");
                  require_once("../php/modelo.php");
                  //cogemos el titulo y el autor de la cancion a reproducir
                  $titulo = validarEntrada($_GET["titulo"]);
                  $autor = validarEntrada($_GET["usuario"]);

                  //comprobamos si existe la cancion
                  if (existe_cancion($titulo, $autor)){
                     $info = info_cancion($titulo, $autor);
                     //comprobamos si el usuario puede reproducir esta cancion en concreto (si la cancion es premium y el usuario tambien)
                     if ($info["premium"] && ((session_status() != PHP_SESSION_ACTIVE) || !$_SESSION["premium"]))
                        echo "<script>window.location.replace('accesodenegado.html');</script>";
                     //si la puede reproducir
                     else{
                        //aumentamos las reproducciones de la cancion
                        aumentar_reproducciones($titulo, $autor);
                        if (session_status() == PHP_SESSION_ACTIVE) //si el usuario esta registrado
                           //añadimos la informacion de que ha escuchado esta cancion
                           aniadir_reproduccion($titulo, $autor, $_SESSION["usuario"]);
                     }
                  }
                  else
                     header("Location: accesodenegado.html");

                  //mostramos la caratula de la cancion
                  if ($info["caratula"])
                     echo "<img src='../img/".$info["caratula"]."' width='150' height='150' alt='Imagen usuario'>";
                  else
                     echo "<img src='../img/CaratulaPorDefecto.jpg' width='150' height='150' alt='Imagen usuario'>";
                  ?>

               </div>
               <div id="player-header-info">

                  <?php
                  //cargamos el audio y mostramos la informacion de la cancion
                  echo "<audio src=../songs/".$info["archivo"]." id='song'></audio>";
                  echo "<p id='nombre_cancion'>".$_GET["titulo"]."</p>\n";
                  echo "<p id='autor'>".$info["autor"]."</p>";
                  echo "<p>Nº reproducciones: ".$info["nreproducciones"]."</p>";
                  ?>

                  <?php if(isset($_SESSION["usuario"])) : ?>
                  <!-- Si el usuario esta registrado mostramos la opcion de añadir la cancion a sus listas de reproduccion -->
                  <div class="form-group">
                     <label for="selList">Añadir a lista:</label>
                     <div class="col-md-12">
                        <select id="selList" class="form-control" form="addList-form" name="genero" type="submit">
                           <option value="title">Añadir a lista</option>
                           <?php
                           $listas = obtener_listas_reproduccion_usuario($_SESSION["usuario"]);

                           foreach($listas as $lista)
                              echo "<option value='".$lista["id"]."'>".$lista["nombre"]."</option>";

                           ?>
                        </select>
                     </div>
                  </div>

                  <?php if(isset($_SESSION["premium"]) && ($_SESSION["premium"] == true)) : ?>
                  <!-- Si el usuario es premium le damos la opcion de descargar la cancion -->
                  <div class="form-group">
                     <label for="selList">Descargar:</label>
                     <div class="col-md-12 container-fluid">
                        <a href="../songs/<?php echo $info["archivo"] ?>" download>
                           <button id="btn-descargar" type="button" class="btn btn-default" aria-label="Left Align">
                              <span class="glyphicon glyphicon glyphicon-save" aria-hidden="true"></span>
                           </button>
                        </a>
                     </div>
                  </div>
                  <?php endif; ?>
                  <?php endif; ?>
               </div>
            </div>

            <!-- Barra de control del reproductor -->
            <div id="bar-player" class="col-md-10 col-md-push-2">
               <!-- Botones para el control del reproducotor -->
               <div id="player-buttons">
                  <!-- Boton para volver a la cancion anterior -->
                  <?php
                  if (isset($_GET["lista"]))
                     $lista = validarEntrada($_GET["lista"]);
                  else
                     $lista = false;

                  $anterior = get_cancion_anterior(validarEntrada($_GET["titulo"]), validarEntrada($_GET["usuario"]), $lista);
                  if(!$lista || !$anterior)
                     echo '<button type="button" class="btn btn-default" aria-label="Left Align" disabled>
                        <span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span>
                        </button>';
                  else{
                     echo '<form id="previous-song" method="get" action="reproductor.php">
                     <input type="hidden" name="titulo" value="'.$anterior["titulo"].'">
                     <input type="hidden" name="usuario" value="'.$anterior["autor"].'">
                     <input type="hidden" name="lista" value="'.$lista.'">
                     </form>
                     <button type="submit" form="previous-song" class="btn btn-default" aria-label="Left Align">
                        <span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span>
                     </button>';
                  }
                  ?>

                  <!-- Boton de play/pause -->
                  <button id="playPauseButton"type="button" class="btn btn-default" aria-label="Left Align">
                     <span id="playPauseButtonSpan" class="glyphicon glyphicon-play" aria-hidden="true"></span>
                  </button>

                  <!-- Boton para pasar a la siguiente cancion -->
                  <?php
                  $siguiente = get_siguiente_cancion(validarEntrada($_GET["titulo"]), validarEntrada($_GET["usuario"]), $lista);
                  if(!$lista || !$siguiente)
                     echo '<button type="button" class="btn btn-default" aria-label="Left Align" disabled>
                     <span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span>
                     </button>';
                  else{
                     echo '<form id="next-song" method="get" action="reproductor.php">
                     <input type="hidden" name="titulo" value="'.$siguiente["titulo"].'">
                     <input type="hidden" name="usuario" value="'.$siguiente["autor"].'">
                     <input type="hidden" name="lista" value="'.$lista.'">
                     </form>
                     <button type="submit" form="next-song" class="btn btn-default" aria-label="Left Align">
                        <span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span>
                     </button>';
                  }
                  ?>


               </div>
               <!-- Barra de estado de la cancion -->
               <div id="info-player">
                  <p id="reproducido" class="info-player-time">0:0</p>
                  <input id="player-progres" type="range" value="0" max="">
                  <p class="info-player-time" id="duracion"><?php echo  floor($info["duracion"] / 60), ":", $info["duracion"] % 60; ?></p>
               </div>
            </div>

            <h3 id="comment-title" class="col-md-10 col-md-push-2">Comentarios</h3>

            <?php if(isset($_SESSION["usuario"])) : ?>
            <div class="comment-content col-xs-12 col-md-8 col-md-push-2">
               <div class="row">
                  <div class="panel panel-primary">
                     <div class="panel-heading comment-heading">
                        <?php
                        $infoUsuario = obtener_informacion_usuario($_SESSION["usuario"]);
                        echo "<img src='../img/".$infoUsuario[0]["foto"]."' class='img-circle img-responsive comment-img' alt='user profile image'>";
                        ?>
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
      <?php else : ?>
      <div class="alert alert-danger text-center">
         <h4>Has accedido a la pagina de forma incorrecta.</h4>
      </div>
      <?php endif; ?>
   </body>
</html>
