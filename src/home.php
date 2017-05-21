<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Inicio</title>
        <link rel="icon" type="image/png" href="../img/Logo.png"/>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/webmusic.css" rel="stylesheet">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
          session_start();
          //TODO eliminar esto, está forzado para hacer pruebas.
          $_SESSION['usuario'] = 'alex';
          require_once('../php/controlador.php');
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

            <!-- Pestañas principales -->
            <div id="tab_container_home">

                <input class="input_home" id="tab1" type="radio" name="tabs" checked>
                <label for="tab1" class="label_home">Novedades</label>

                <input class="input_home" id="tab2" type="radio" name="tabs">
                <label for="tab2" class="label_home">Top</label>

                <input class="input_home" id="tab3" type="radio" name="tabs">
                <label for="tab3" class="label_home">Social</label>

                <section id="content1" class="tab-content section_home">
                      <p class="text-center">En esta sección podrás encontrar un top de las nuevas canciones que vayan sacando los artistas a los que sigues.</p>
                      <p class="text-center">Estarán ordenadas por orden de salida y el número máximo será de diez canciones.</p>
                      <p class="text-center">Podrás escuchar la canción pinchando en el título de la misma y visitar el perfil del autor pinchando en su nombre.</p>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12" data-wow-delay="0.2s">
                                <div class="carousel slide quote-carousel" data-ride="carousel" id="qc1">
                                    <div class="text-center">
                                      <h4 class="col-md-3">#</h4>
                                      <h4 class="col-md-3">Título</h4>
                                      <h4 class="col-md-3">Autor</h4>
                                      <h4 class="col-md-3">Fecha publicación</h4>
                                      <hr class="separator">
                                      <?PHP
                                        $resultado = tus_novedades(validar_entrada($_SESSION['usuario']));
                                        $i = 1;

                                        foreach ($resultado as $fila) {
                                          echo '<div class="item active">
                                              <blockquote>
                                                  <div class="row">
                                                      <h5 class="col-md-3">'.$i.'</h5>
                                                      <a href="reproductor.php?titulo='.$fila["titulo"].'?usuario='.$fila["autor"].'" class="link-home-carousel-and-search"><h5 class="col-md-3">'.$fila["titulo"].'</h5></a>
                                                      <a href="usuario.php?usuario='.$fila["autor"].'" class="link-home-carousel-and-search"><h5 class="col-md-3">'.$fila["autor"].'</h5></a>
                                                      <h5 class="col-md-3">'.$fila["fecha"].'</h5>
                                                  </div>
                                              </blockquote>
                                          </div>';

                                          $i ++;
                                        }
                                      ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>

                <section id="content2" class="tab-content section_home">
                    <p class="text-center">En esta sección podrás encontrar un top con canciones relacionadas con tus gustos musicales.</p>
                    <p class="text-center">Estarán ordenadas por número de reproducciones y el número máximo será de diez canciones.</p>
                    <p class="text-center">Podrás escuchar la canción pinchando en el título de la misma y visitar el perfil del autor pinchando en su nombre.</p>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12" data-wow-delay="0.2s">
                                <div class="carousel slide quote-carousel" data-ride="carousel" id="qc2">
                                    <div class="text-center">
                                      <h4 class="col-md-3">#</h4>
                                      <h4 class="col-md-3">Título</h4>
                                      <h4 class="col-md-3">Autor</h4>
                                      <h4 class="col-md-3">Número reproducciones</h4>
                                      <hr class="separator">
                                      <?PHP
                                        $resultado = tus_top(validar_entrada($_SESSION['usuario']));
                                        $i = 1;

                                        foreach ($resultado as $fila) {

                                          echo '<div class="item active">
                                              <blockquote>
                                                  <div class="row">
                                                      <h5 class="col-md-3">'.$i.'</h5>
                                                      <a href="reproductor.php?titulo='.$fila["titulo"].'?usuario='.$fila["autor"].'" class="link-home-carousel-and-search"><h5 class="col-md-3">'.$fila["titulo"].'</h5></a>
                                                      <a href="usuario.php?usuario='.$fila["autor"].'" class="link-home-carousel-and-search"><h5 class="col-md-3">'.$fila["autor"].'</h5></a>
                                                      <h5 class="col-md-3">'.$fila["numeroreproducciones"].'</h5>
                                                  </div>
                                              </blockquote>
                                          </div>';

                                          $i ++;
                                        }
                                      ?>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>

                <section id="content3" class="tab-content section_home">
                  <p class="text-center">Es esta sección podrás encontrar lo que escuha la gente a la que sigues.</p>
                  <p class="text-center">Estarán ordenadas por el momento en el que la escuchen y el número máximo será de diez canciones.</p>
                  <p class="text-center">Podrás escuchar la canción pinchando en el título de la misma y visitar el perfil del autor pinchando en su nombre.</p>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12" data-wow-delay="0.2s">
                                <div class="carousel slide quote-carousel" data-ride="carousel" id="qc3">
                                    <div class="text-center">
                                      <h4 class="col-md-3">#</h4>
                                      <h4 class="col-md-3">Título</h4>
                                      <h4 class="col-md-3">Escuchada por</h4>
                                      <h4 class="col-md-3">Reproducido hace</h4>
                                      <hr class="separator">
                                      <?PHP
                                        $resultado = tus_top_social(validar_entrada($_SESSION['usuario']));
                                        $i = 1;

                                        foreach ($resultado as $fila) {
                                          $fecha = new DateTime($fila["fecha"]);
                                          $ahora = new DateTime();
                                          $tiempo = $fecha->diff($ahora)->format("%m meses, %d días, %h horas and %i minutos");

                                          echo '<div class="item active">
                                              <blockquote>
                                                  <div class="row">
                                                        <h5 class="col-md-3">'.$i.'</h5>
                                                        <a href="reproductor.php?titulo='.$fila["titulo"].'?usuario='.$fila["autor"].'" class="link-home-carousel-and-search"><h5 class="col-md-3">'.$fila["titulo"].'</h5></a>
                                                        <a href="usuario.php?usuario='.$fila["usuario"].'" class="link-home-carousel-and-search"><h5 class="col-md-3">'.$fila["usuario"].'</h5></a>
                                                        <h5 class="col-md-3">'.$tiempo.'</h5>
                                                  </div>
                                              </blockquote>
                                          </div>';

                                          $i ++;
                                        }
                                      ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
          </div>
        </div>

        <!-- Container que contiene el footer de la página -->
        <div class="footer-container">
            <footer class="footer-bs" id="footer">
                <div class="row">
                    <div class="margin-logo-footer col-md-2 footer-brand animated fadeInLeft">
                        <a href="../index.html"><img alt="WebMusic" src="../img/Logo.png" width="180" height="180"></a>
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
