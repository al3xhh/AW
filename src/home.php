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
        <?PHP
          session_start();
          require_once('../php/controlador.php');
        ?>

        <div id="container-principal">
            <!-- Barra superior de la página -->
            <nav class="navbar navbar-inverse">
                <a class="navbar-brand" href="home.html">Webmusic</a>
                <div class="navbar-header">
                    <a href="home.html"><img src="../img/Logo.png" width="50" height="50" alt="logo"></a>
                    <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div id="navbarCollapse" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="subirCancion.html"><span class="glyphicon glyphicon-upload"></span> Subir canción</a></li>
                        <li><a href="miperfil.html"><span class="glyphicon glyphicon-user"></span> Mi perfil</a></li>
                        <li><a href="../index.html"><span class="glyphicon glyphicon-log-out"></span> Cerrar sesión</a></li>
                    </ul>
                </div>
            </nav><!-- Fin barra superior -->

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
                <label for="tab1" class="label_home">Tus novedades</label>

                <input class="input_home" id="tab2" type="radio" name="tabs">
                <label for="tab2" class="label_home">Tus top</label>

                <input class="input_home" id="tab3" type="radio" name="tabs">
                <label for="tab3" class="label_home">Social</label>

                <section id="content1" class="tab-content section_home">
                    <p class="text-center">En esta sección podrás encontrar un top de las nuevas canciones que vayan sacando los artistas a los que sigues. Estarán ordenados por orden de salida y el número será un top 6 canciones. Podrás escuchar la canción pinchando en el título de la misma, eso te llevará al reproductor dónde también podrás dejar comentarios.</p>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12" data-wow-delay="0.2s">
                                <div class="carousel slide quote-carousel" data-ride="carousel" id="qc1">
                                    <div class="carousel-inner carousel_inner_home text-center">
                                      <?PHP
                                        $result = tus_novedades();
                                        $i = 1;

                                        while($registro = $result->fetch_assoc()) {

                                          echo '<div class="item active">
                                              <blockquote>
                                                  <div class="row">
                                                      <div class="col-sm-8 col-sm-offset-2">
                                                          <a href="reproductor.html" class="link-home-carousel-and-search"><h3>'.$i.": ".$registro["titulo"].'</h3></a>
                                                          <a href="usuario.html" class="link-home-carousel-and-search"><h5>'.$registro["autor"].'</h5></a>
                                                      </div>
                                                  </div>
                                              </blockquote>
                                          </div>';

                                          $i ++;
                                        }
                                        $result->free();
                                      ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>

                <section id="content2" class="tab-content section_home">
                    <p class="text-center">En esta sección podrás encontrar un top con canciones relacionadas con tus gustos musicales, no tendrán ningún orden específico y el número será un top 6 canciones. Podrás escuchar la canción pinchando en el título de la misma, eso te llevará al reproductor dónde también podrás dejar comentarios.</p>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12" data-wow-delay="0.2s">
                                <div class="carousel slide quote-carousel" data-ride="carousel" id="qc2">
                                    <div class="carousel-inner carousel_inner_home text-center">
                                      <?PHP
                                        $result = tus_top();
                                        $i = 1;

                                        while($registro = $result->fetch_assoc()) {

                                          echo '<div class="item active">
                                              <blockquote>
                                                  <div class="row">
                                                      <div class="col-sm-8 col-sm-offset-2">
                                                          <a href="reproductor.html" class="link-home-carousel-and-search"><h3>'.$i.": ".$registro["titulo"].'</h3></a>
                                                          <a href="usuario.html" class="link-home-carousel-and-search"><h5>'.$registro["autor"].'</h5></a>
                                                      </div>
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
                    <p class="text-center">En esta sección podrás encontrar un top de las canciones que estén escuchando tus amigos en ese momento, estarán ordenadas saliendo primero las que estén escuchando en ese momento y después las pasadas, el número será un top 6 canciones. Podrás escuchar la canción pinchando en el título de la misma, eso te llevará al reproductor dónde también podrás dejar comentarios.</p>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12" data-wow-delay="0.2s">
                                <div class="carousel slide quote-carousel" data-ride="carousel" id="qc3">
                                    <!-- Bottom Carousel Indicators -->
                                    <ol class="carousel-indicators">
                                        <li data-target="#qc3" data-slide-to="0" class="active"><img class="img-responsive " src="../img/DiscoPortada.jpg" alt="">
                                        </li>
                                        <li data-target="#qc3" data-slide-to="1"><img class="img-responsive" src="../img/DiscoPortada.jpg" alt="">
                                        </li>
                                        <li data-target="#qc3" data-slide-to="2"><img class="img-responsive" src="../img/DiscoPortada.jpg" alt="">
                                        </li>
                                        <li data-target="#qc3" data-slide-to="3"><img class="img-responsive" src="../img/DiscoPortada.jpg" alt="">
                                        </li>
                                        <li data-target="#qc3" data-slide-to="4"><img class="img-responsive" src="../img/DiscoPortada.jpg" alt="">
                                        </li>
                                        <li data-target="#qc3" data-slide-to="5"><img class="img-responsive" src="../img/DiscoPortada.jpg" alt="">
                                        </li>
                                    </ol>

                                    <!-- Carousel Slides / Quotes -->
                                    <div class="carousel-inner carousel_inner_home text-center">
                                        <!-- Quote 1 -->
                                        <div class="item active">
                                            <blockquote>
                                                <div class="row">
                                                    <div class="col-sm-8 col-sm-offset-2">
                                                        <a href="reproductor.html" class="link-home-carousel-and-search"><h3>Título de la canción 13</h3></a>
                                                    </div>
                                                </div>
                                            </blockquote>
                                        </div>
                                        <!-- Quote 2 -->
                                        <div class="item">
                                            <blockquote>
                                                <div class="row">
                                                    <div class="col-sm-8 col-sm-offset-2">
                                                        <a href="reproductor.html" class="link-home-carousel-and-search"><h3>Título de la canción 14</h3></a>
                                                    </div>
                                                </div>
                                            </blockquote>
                                        </div>
                                        <!-- Quote 3 -->
                                        <div class="item">
                                            <blockquote>
                                                <div class="row">
                                                    <div class="col-sm-8 col-sm-offset-2">
                                                        <a href="reproductor.html" class="link-home-carousel-and-search"><h3>Título de la canción 15</h3></a>
                                                    </div>
                                                </div>
                                            </blockquote>
                                        </div>
                                        <div class="item">
                                            <blockquote>
                                                <div class="row">
                                                    <div class="col-sm-8 col-sm-offset-2">
                                                        <a href="reproductor.html" class="link-home-carousel-and-search"><h3>Título de la canción 16</h3></a>
                                                    </div>
                                                </div>
                                            </blockquote>
                                        </div>
                                        <div class="item">
                                            <blockquote>
                                                <div class="row">
                                                    <div class="col-sm-8 col-sm-offset-2">
                                                        <a href="reproductor.html" class="link-home-carousel-and-search"><h3>Título de la canción 17</h3></a>
                                                    </div>
                                                </div>
                                            </blockquote>
                                        </div>
                                        <div class="item">
                                            <blockquote>
                                                <div class="row">
                                                    <div class="col-sm-8 col-sm-offset-2">
                                                        <a href="reproductor.html" class="link-home-carousel-and-search"><h3>Título de la canción 18</h3></a>
                                                    </div>
                                                </div>
                                            </blockquote>
                                        </div>
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