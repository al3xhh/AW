<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Canciones de lista (nombre de la lista)</title>

        <link rel="icon" type="image/png" href="../img/Logo.png"/>

        <!-- Bootstrap -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/webmusic.css" rel="stylesheet">

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>
    </head>
    <body>
        <div id="container-principal">
           <!-- Barra superior de la página -->
           <?php
             require_once("../php/navbar.php");
             navbar();
           ?>
           <!-- Fin barra superior -->

            <div class="container-fluid">
                <div class="separar-filas">
                    <div class="col-md-2 col-md-push-2">
                        <img  class="img-responsive" src="../img/FotoLista.jpg" alt="img" title="image"/>
                    </div>
                    <div class="separar-filas-arriba">
                        <div class="col-md-3 col-md-push-2">
                            <div class="negrita">
                                <p>Nombre del creador: Pablito87</p>
                                <div class="salto-de-linea"></div>
                                <p>Fecha de creacion: 18-04-2017</p>
                                <div class="salto-de-linea"></div>
                                <p>Descripción</p>
                                <div class="salto-de-linea"></div>
                                <p>Las mejores canciones de pop las encontraras en esta lista, si te gusta la buena musica no dudes en unirte ;D</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>



            <div class="container-fluid">
                <div class="separar-filas-arriba">
                    <div class="col-md-2 col-md-push-2"><a class="link-home-carousel-and-search" href="reproductor.html">Nombre1</a></div>
                    <div class="col-md-1 col-md-push-2"><a class="link-home-carousel-and-search" href="usuario.html">Artista1</a></div>
                    <div class="col-md-2 col-md-push-2">01/01/2017</div>
                    <div class="col-md-1 col-md-push-2">3:47</div>
                    <div class="col-md-1 col-md-push-2">
                        <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button>
                    </div>
                </div>
            </div>

            <!-- Linea separadora de contenido -->
            <hr class="separador-fino">

            <div class="container-fluid">
                <div class="col-md-2 col-md-push-2"><a class="link-home-carousel-and-search" href="reproductor.html">Nombre1</a></div>
                <div class="col-md-1 col-md-push-2"><a class="link-home-carousel-and-search" href="usuario.html">Artista1</a></div>
                <div class="col-md-2 col-md-push-2">01/01/2017</div>
                <div class="col-md-1 col-md-push-2">3:47</div>
                <div class="col-md-1 col-md-push-2">
                    <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button>
                </div>
            </div>

            <!-- Linea separadora de contenido -->
            <hr class="separador-fino">

            <div class="container-fluid">
                <div class="col-md-2 col-md-push-2"><a class="link-home-carousel-and-search" href="reproductor.html">Nombre3</a></div>
                <div class="col-md-1 col-md-push-2"><a class="link-home-carousel-and-search" href="usuario.html">Artista3</a></div>
                <div class="col-md-2 col-md-push-2">19/06/2017</div>
                <div class="col-md-1 col-md-push-2">2:47</div>
                <div class="col-md-1 col-md-push-2">
                    <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button>
                </div>
            </div>

            <!-- Linea separadora de contenido -->
            <hr class="separador-fino">

            <div class="container-fluid">
                <div class="separar-filas-abajo">
                    <div class="col-md-2 col-md-push-2"><a class="link-home-carousel-and-search" href="reproductor.html">Nombre4</a></div>
                    <div class="col-md-1 col-md-push-2"><a class="link-home-carousel-and-search" href="usuario.html">Artista1</a></div>
                    <div class="col-md-2 col-md-push-2">16/12/2017</div>
                    <div class="col-md-1 col-md-push-2">4:00</div>
                    <div class="col-md-1 col-md-push-2">
                        <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button>
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
