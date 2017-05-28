<?php
session_start();
require_once("../php/controlador.php");

if(!isset($SESSION["usuario"]))
   header("Location: accesodenegado.html");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $lista = validare_entrada($_POST["listanueva"]);
   aniadir_lista($lista, $_SESSION["usuario"]);
}
?>
<html lang="es">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <title>Listas de reproduccion</title>

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
            <div class="row">
               <div class="separar-filas-abajo">
                  <div class="col-md-4 col-md-push-1">
                     <h1>Listas de reproduccion</h1>
                  </div>
               </div>
            </div>
         </div>

         <!--Este contenedor se usa para ver las siguientes categorias en las que separamos las listas de reproduccion-->
         <div class="container-fluid">
            <div class="separar-filas">
               <div class="col-md-4 col-md-push-4">Nombre</div>
               <div class="col-md-4 col-md-push-4">Autor</div>
            </div>
         </div>

         <!--Contenedo que tiene una lista de reproduccion con sus caracteristicas-->
         <div class="container-fluid">
            <div class="separar-filas">

               <?PHP
               require_once("../php/controlador.php");
               $resultado = lista_reproduccion($_SESSION["usuario"]);
               foreach ($resultado as $fila) {
                  echo
                     "<div class='item active'>
							  <blockquote>
								<hr class='separador-fino'>
									<div class='col-md-4 col-md-push-4'> <a class='link-home-carousel-and-search' href='lista-reproduccion-canciones.php?lista=".$fila['id']."&autor=".$fila['usuario']."&nombre=".$fila['nombre']."'>".$fila['nombre']."</a></div>
									<div class='col-md-4 col-md-push-4'>".$fila['usuario']."</div>
									<div class='col-md-4 col-md-push-2'>
										<form action='borrar_lista.php' method='post'>
											<input type='hidden' name='id' value='".$fila['id']."' />
											<button type='submit' class='btn btn-danger btn-xs' data-title='Delete' data-toggle='modal' data-target='#delete' ><span class='glyphicon glyphicon-trash'></span></button>
										</form>
									</div>

							  </blockquote>
						  </div>";
               }
               ?>
            </div>
         </div>

         <!-- Linea separadora de contenido -->
         <hr class="separador-fino">

         <!--Contenedo que tiene la forma de crear una nueva lisa de reproduccion-->
         <div class="container-fluid">
            <div class="separar-filas">
               <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST">
                  <div class="col-md-4 col-md-push-2">
                     <div class="input-group stylish-input-group">
                        ¿Quieres crear una lista nueva?
                     </div>
                  </div>
                  <div class="col-md-2 col-md-push-1">
                     <div class="input-group stylish-input-group">
                        <input type="text" name="listanueva" class="forma-buscar"  placeholder="Nombre de la lista" >
                     </div>
                  </div>
                  <div class="col-md-1 col-md-push-1">
                     <button type="submit">Crear
                     </button>
                  </div>
               </form>
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
                        <li><a href="#">Memoria</a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </footer>
      </div><!-- Fin container footer -->
   </body>
</html>
