<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Webmusic</title>

        <link rel="icon" type="image/png" href="img/Logo.png"/>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/webmusic.css" rel="stylesheet">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <div id="container-principal">
           <!-- Barra superior de la página -->
           <?php
             require_once("php/navbar.php");
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
                                    <a href="src/buscar_registrado.html" class="link-home-carousel-and-search"><span class="glyphicon glyphicon-search"></span></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Fin barra de búsqueda -->

            <div class="carousel fade-carousel slide" data-ride="carousel" data-interval="4000" id="bs-carousel">

                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#bs-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#bs-carousel" data-slide-to="1"></li>
                    <li data-target="#bs-carousel" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item slides active">
                        <div class="slide-1"></div>
                        <div class="hero">
                            <h1>Bienvenido</h1>
                            <h3>Descrube y comparte toda tu música</h3>
                        </div>
                    </div>
                    <div class="item slides">
                        <div class="slide-2"></div>
                        <div class="hero">
                            <a href="src/premium.html" class="link-index-carousel">
                                <h1>Hazte premium</h1>
                                <h3>Descubre todas sus ventajas pinchando aquí</h3>
                            </a>
                        </div>
                    </div>
                    <div class="item slides">
                        <div class="slide-3"></div>
                        <div class="hero">
                            <a href="src/registro.html" class="link-index-carousel">
                                <h1>Únete</h1>
                                <h3>Registrate gratis y empieza a disfrutar</h3>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="panel-heading">
                    <h3 class="panel-title">Novedades</h3>
                </div>
                <div class="panel-body">
                   <?php
                      require_once('php/controlador.php');
                      $resultado = obtener_novedades();
                      $i = 1;

                      foreach ($resultado as $fila) {
                        echo '<div class="col-md-3 col-lg-3">
                                 <figure>
                                     <figcaption>
                                         <h4>'.$fila["titulo"].' - '.$fila["autor"].'</h4>
                                     </figcaption>
                                     <a href="src/reproductor.php?titulo='.$fila["titulo"].'&usuario='.$fila["autor"].'"><img class="img-responsive" src="img/'.$fila["caratula"].'" alt="img" title="image" height="200" width="200"/></a>
                                 </figure>
                             </div>';
                     }
                    ?>
                </div>
            </div>

            <div class="container">
                <div class="panel-heading">
                    <h3 class="panel-title">Top</h3>
                </div>
                <div class="panel-body">
                   <?php
                      require_once('php/controlador.php');
                      $resultado = obtener_top();
                      $i = 1;

                      foreach ($resultado as $fila) {
                        echo '<div class="col-md-3 col-lg-3">
                                 <figure>
                                     <figcaption>
                                         <h4>'.$fila["titulo"].' - '.$fila["autor"].'</h4>
                                     </figcaption>
                                     <a href="src/reproductor.php?titulo='.$fila["titulo"].'&usuario='.$fila["autor"].'"><img class="img-responsive" src="img/'.$fila["caratula"].'" alt="img" title="image" height="200" width="200"/></a>
                                 </figure>
                             </div>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="footer-container">
            <footer class="footer-bs" id="footer">
                <div class="row">
                    <div class="margin-logo-footer col-md-2 footer-brand animated fadeInLeft">
                        <img class="img img-responsive" alt="WebMusic" src="img/Logo.png" width="180" height="180">
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
        </div>
    </body>
</html>
