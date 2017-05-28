<!DOCTYPE html>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
   header("Location: buscar.php?tipo=1&busqueda=".$_POST["busqueda"]);
?>
<html lang="es">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <title>Webmusic</title>

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
         ?><!-- Fin barra superior -->

         <!-- Barra de búsqueda -->
         <div class="container">
            <div class="row">
               <div class="col-sm-6 col-sm-offset-3">
                  <div id="imaginary_container">
                     <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST" id="ID_Formulario">
                        <div class="input-group stylish-input-group">
                           <input type="text" class="form-control"  placeholder="Buscar" name="busqueda">
                           <span class="input-group-addon">
                              <button class="glyphicon glyphicon-search" type="submit"></button>
                           </span>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div><!-- Fin barra de búsqueda -->
      </div>

      <div class="row">
         <div id="container-principal" class="col-md-5 col-md-push-5">
            <a href = "../index.php">Página principal</a>
            <ul>
               <li><a href = "login.php">Login</a>
                  <ul>
                     <li><a href = "home.php">Home</a>
                        <ul>
                           <li><a href = "miperfil.php">Mi perfil</a>
                              <ul>
                                 <li><a href = "premium.php">Premium</a></li>
                                 <li><a href = "usuario.php?usuario=<?php session_start(); echo $_SESSION["usuario"]; ?>">Perfil seguidor/seguidos</a></li>
                                 <li><a href = "#">Reproductor</a></li>
                              </ul>
                           </li>
                           <li><a href = "#">Reproductor</a></li>
                           <li><a href = "buscar.php?tipo=1&busqueda=a">Buscar</a>
                           <li><a href = "listas-reproduccion.php">Listas de reproducción</a>
                              <ul>
                                 <li><a href = "lista-reproduccion-canciones.php">Canciones lista reproducción</a></li>
                              </ul>
                           </li>
                        </ul>
                     </li>
                  </ul>
               </li>
               <li><a href = "registro.php">Registro</a>
                  <ul>
                     <li><a href = "home.php">Home</a></li>
                     <li><a href = "premium.php">Premium</a></li>
                  </ul>
               </li>
               <li><a href = "#">Reproductor</a>
                  <ul>
                     <li><a href = "usuario.php?usuario=<?php session_start(); echo $_SESSION["usuario"]; ?>">Ver perfil del autor</a>
                        <ul>
                           <li><a href = "premium.php">Premium</a></li>
                           <li><a href = "usuario.php?usuario=<?php session_start(); echo $_SESSION["usuario"]; ?>">Perfil seguidor/seguidos</a></li>
                           <li><a href = "#">Reproductor</a></li>
                        </ul>
                     </li>
                  </ul>
               </li>
               <li><a href = "buscar.php?tipo=1&busqueda=a">Buscar</a>
                  <ul>
                     <li><a href = "usuario.php?usuario=<?php session_start(); echo $_SESSION["usuario"]; ?>">Ver perfil del autor</a></li>
                     <li><a href = "#">Reproductor</a></li>
                  </ul>
               </li>
               <li><a href = "mapa.php">Mapa del sitio</a>
            </ul>
         </div>
      </div>

      <div class="row text-center">
         <h5 class="col-md-4 col-md-push-4">Algunos links del mapa, solo funcionan si se ha iniciado sesión</h5>
      </div>
      <div class="row text-center">
         <h5 class="col-md-4 col-md-push-4">El link del reproductor no funciona ya que necesita una canción a reproducir</h5>
      </div>
      <div class="row text-center">
         <h5 class="col-md-4 col-md-push-4">El link de autor te lleva a tu perfil una vez inicies sesión</h5>
      </div>

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
                        <li><a href="#">Mapa del sitio</a></li>
                        <li><a href="https://github.com/christian7007/AW.git">GitHub</a></li>
                        <li><a href="#">Memoria</a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </footer>
      </div>
   </body>
</html>
