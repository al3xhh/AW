<?php
session_start();
require_once("../php/controlador.php");

if(!isset($_SESSION["usuario"])) {
   header("Location: accesodenegado.html");
} else {
   if ($_SERVER["REQUEST_METHOD"] == "GET"){
      $id = validar_entrada($_GET["lista"]);
      $autor = validar_entrada($_GET["autor"]);
      $nombre = validar_entrada($_GET["nombre"]);
   }
}
?>
<!DOCTYPE html>
<html lang="es">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <title>Canciones de lista <?php echo " ".$nombre; ?></title>

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
         <div class="container-fluid">
            <div class="separar-filas">
               <?PHP
               require_once("../php/controlador.php");
               $res = sacar_foto($autor);
               echo"
						<div class='col-md-2 col-md-push-2'>
							<img  class='img-responsive' src='../img/".$res."' alt='img' title='image'/>
						</div>
						<div class='separar-filas-arriba'>
							<div class='col-md-3 col-md-push-2'>
								<div class='negrita'>

									Nombre del autor: ".$autor."
									<div class='salto-de-linea'></div>
									Nombre de la lista: ".$nombre."

                            </div>
                        </div>
                    </div>";
               ?>
            </div>
         </div>
         <div class="container-fluid">
            <?PHP
            require_once("../php/controlador.php");
            $resultado = lista_reproduccion_canciones($id);

            if(empty($resultado)) {
               echo '<div class="text-center"><h3>La lista no tiene canciones</h3></div>';
            } else {
               echo '<div class="separar-filas-arriba">
                        <div class="col-md-2 col-md-push-2">Titulo</div>
                        <div class="col-md-1 col-md-push-2">Autor</div>
                        <div class="col-md-2 col-md-push-2">Fecha</div>
                     </div>';
               foreach ($resultado as $fila) {
                  echo
                     "<div class='item active'>
   						  <blockquote>
   							 <hr class='separador-fino'>
   								<div class='col-md-2 col-md-push-2'><a class='link-home-carousel-and-search' href='reproductor.php?titulo=".$fila['titulo']."&usuario=".$fila['autor']."&lista=".$id."'>".$fila['titulo']."</a></div>
   								<div class='col-md-1 col-md-push-2'><a class='link-home-carousel-and-search' href='usuario.php'>".$fila['autor']."</a></div>
   								<div class='col-md-2 col-md-push-2'>".$fila['fecha']."</div>
   								<div class='col-md-1 col-md-push-2'>
   									<form action='../php/borrar_cancion_lista.php' method='post'>
   										<input type='hidden' name='id' value='".$id."' />
   										<input type='hidden' name='autor' value='".$autor."' />
   										<input type='hidden' name='nombrelista' value='".$nombre."' />
   										<input type='hidden' name='cancion' value='".$fila['id']."' />
   										<button type='submit' class='btn btn-danger btn-xs' data-title='Delete' data-toggle='modal' data-target='#delete' ><span class='glyphicon glyphicon-trash'></span></button>
   									</form>
   								</div>
   						  </blockquote>
   					  </div>";
               }
            }
            ?>

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
   </body>
</html>
