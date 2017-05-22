<!DOCTYPE html>
<html lang="es">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <?php
         require_once('../php/controlador.php');
         echo '<title>';
         echo validar_entrada($_GET['usuario']);
         echo '</title>';
      ?>

      <link rel="icon" type="image/png" href="../img/Logo.png"/>

      <!-- Bootstrap -->
      <link href="../css/bootstrap.min.css" rel="stylesheet">
      <link href="../css/webmusic.css" rel="stylesheet">
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="../js/bootstrap.min.js"></script>
      <script src="../js/usuario.js"></script>
   </head>
   <body>
      <?php
      session_start();
      //TODO eliminar esto, está forzado para hacer pruebas.
      $_SESSION['usuario'] = 'alex';

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
                  $resultado = obtener_informacion_usuario(validar_entrada($_GET['usuario']));

                  echo '<div class="fb-profile">
                           <img class="fb-image-lg" src="../img/'.$resultado[0]["encabezado"].'" alt="Profile image example" height=400>
                           <img class="fb-image-profile thumbnail" src="../img/'.$resultado[0]["foto"].'" alt="Profile image example">
                           <div class="fb-profile-text">
                               <h1 id="nombreusuario">'.$resultado[0]["nombreusuario"].'</h1>
                           </div>
                        <div class="fb-profile-text" id="tesigue">';
                        if(sigueA(validar_entrada($resultado[0]["nombreusuario"]), validar_entrada($_SESSION['usuario']))) {
                           echo 'Te sigue!';
                        }
                        echo '</div>
                              </div>';
               ?>
            </div>
         </div> <!-- /container fluid-->

         <div class="container">
            <div class="col-sm-8">
               <div data-spy="scroll" class="tabbable-panel">
                  <div class="tabbable-line">
                     <ul class="nav nav-tabs ">
                        <li class="active">
                           <a href="#tab_default_1" data-toggle="tab">Descripción</a>
                        </li>
                        <li>
                           <a href="#tab_default_2" data-toggle="tab">Seguidores</a>
                        </li>
                        <li>
                           <a href="#tab_default_3" data-toggle="tab">Seguidos</a>
                        </li>
                        <li>
                           <a href="#tab_default_4" data-toggle="tab">Canciones</a>
                        </li>
                     </ul>
                     <div class="tab-content">
                        <div class="tab-pane active" id="tab_default_1">
                           <?php
                              $resultado = obtener_descripcion_usuario(validar_entrada($_GET['usuario']));
                              echo '<p>'.$resultado.'</p>';
                           ?>
                        </div>
                        <div class="tab-pane" id="tab_default_2">
                        </div>
                        <div class="tab-pane" id="tab_default_3">
                        </div>
                        <div class="tab-pane" id="tab_default_4">
                           <?PHP
                           $resultado = obtener_canciones_usuario(validar_entrada($_GET['usuario']));

                           if (empty($resultado)) {
                              echo '<h4 class="text-center">El usuario no ha subido aún ninguna canción.</h4>';
                           } else {
                              foreach ($resultado as $fila) {
                                 echo '<div class="user-resume">
                                        <div>
                                            <img class="user-resume-img" src="../img/'.$fila["caratula"].'" width="64" height="64" alt="Imagen usuario">
                                        </div>
                                        <div class="user-resume-info">
                                            <h3>'.$fila["titulo"].'</h3>
                                        </div>
                                        <div class="user-resume-button">
                                           <a href="reproductor.php?titulo='.$fila["titulo"].'&usuario=';echo validar_entrada($_GET['usuario']); echo '"><button type="button" class="btn btn-primary pull-right glyphicon glyphicon-play" data-toggle="tooltip" title="escuchar canción"></button></a>
                                        </div>
                                     </div>';
                              }
                           }
                           ?>
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
                        <div class="col-lg-12">
                           <?php
                           $resultado = obtener_gustos_musicales(validar_entrada($_GET['usuario']));

                           foreach ($resultado as $fila) {
                              echo '<div class="form-group">
                                                <label>'.$fila["genero"].'</label>
                                               </div>';
                           }
                           ?>
                           <button value="<?php echo $_GET["usuario"]?>"type="submit" class="btn btn-primary btn-block" id="Seguir">
                              <?php
                              if(sigueA(validar_entrada($_SESSION['usuario']), validar_entrada($_GET['usuario']))) {
                                 echo 'Siguiendo';
                              } else {
                                 echo 'Seguir';
                              }
                              ?>
                           </button>
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
