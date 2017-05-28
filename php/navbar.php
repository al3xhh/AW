<?php

//Fnción que crea la barra superior de la página dependiendo del usuario y del sitio.
function navbar() {
   $URIDirectorio = htmlspecialchars($_SERVER["PHP_SELF"]);
   $path = parse_url($URIDirectorio, PHP_URL_PATH);
   $componentes = explode('/', $path);

   echo '<nav class="navbar navbar-inverse">';

   if (session_status() == PHP_SESSION_ACTIVE)
      $enlace = "home.php";
   else {
      if(!in_array("index.php", $componentes))
         $enlace = "../index.php";
      else
         $enlace = "index.php";
   }

   if(in_array("index.php", $componentes))
      $logo = "img/Logo.png";
   else
      $logo = "../img/Logo.png";

   echo '<a class="navbar-brand" href='.$enlace.'>Webmusic</a>';
   echo '<div class="navbar-header">';
   echo '<a href="'.$enlace.'"><img src="'.$logo.'" width="50" height="50" alt="logo"></a>';
   echo '<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
         </button>
         </div>
         <div id="navbarCollapse" class="collapse navbar-collapse">
             <ul class="nav navbar-nav navbar-right">';

   if (session_status() == PHP_SESSION_ACTIVE) {
      if (!in_array("listas-reproduccion.php", $componentes))
         echo '<li><a href="listas-reproduccion.php"><span class="glyphicon glyphicon-music"></span> Lista reproducción</a></li>';
      if (!in_array("subirCancion.php", $componentes))
         echo '<li><a href="subirCancion.php"><span class="glyphicon glyphicon-upload"></span> Subir canción</a></li>';
      if (!in_array("miperfil.php", $componentes))
         echo '<li><a href="miperfil.php"><span class="glyphicon glyphicon-user"></span> Mi perfil</a></li>';

      echo'<li><a href="../php/cerrar_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Cerrar sesión</a></li>';
   } else {
      echo '<li><a href="src/registro.php"><span class="glyphicon glyphicon-plus"></span> Registrarse</a></li>
      <li><a href="src/login.php"><span class="glyphicon glyphicon-log-in"></span> Iniciar sesión</a></li>';
   }

   echo "</ul>\n";
   echo "</div>\n";
   echo "</nav>\n";
}

?>
