<?php
session_start();
require_once("../php/controlador.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
   $tipo = validarEntrada($_GET["tipo"]);
   $busqueda = validarEntrada($_GET["busqueda"]);
}
?>
<!DOCTYPE html>
<html lang="es">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <title>Buscar</title>

      <link rel="icon" type="image/png" href="../img/Logo.png"/>

      <!-- Bootstrap -->
      <link href="../css/bootstrap.min.css" rel="stylesheet">
      <link href="../css/webmusic.css" rel="stylesheet">
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="../js/bootstrap.min.js"></script>
      <script src="../js/buscar.js"></script>
   </head>
   <body>
      <div id="container-principal">
         <!-- Barra superior de la página -->
         <?php
         require_once("../php/navbar.php");
         navbar();
         ?><!-- Fin barra superior -->

         <!--Este es el contenedor que tiene el filtro de la musica que vamos a buscar-->
         <div class="container-fluid">
            <div class="row">
               <div class=" col-md-5"></div>
               <form action="buscar.php" id="buscarBusqueda" method="get">
                  <div class=" col-md-1">
                     <div class="container-option">
                        <div class="negrita">
                           <select name="tipo">
                              <option value="1">Cancion</option>
                              <option value="2">Canciones por artista</option>
                              <option value="3">Fecha de lanzamiento</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="container">
                     <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                           <div id="imaginary_container">
                              <div class="input-group stylish-input-group">
                                 <input type="text" id="textoBuscar" class="form-control" name="busqueda" placeholder="Buscar" >
                                 <span class="input-group-addon">
                                    <button type="submit" class="link-home-carousel-and-search glyphicon glyphicon-search"></a>
                                 </span>
                              </div>
                              <div class="alert alert-danger text-center" id="noBuscar"></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>

         <!--Contenedor que tiene tanto la imagen de la cancion buscada como un poco de informacion de la misma-->
         <?PHP
         $resultado = buscar($tipo, $busqueda);
         $i = 0;

         if(isset($_SESSION["usuario"])) {
            echo '<input type="hidden" id="nombre_usuario" value="'.$_SESSION["usuario"].'">';
         }

         if(empty($resultado)) {
            echo "<div class='text-center'><h2> La búsqueda no obtuvo resultados</h2></div>";
         } else {
            foreach ($resultado as $fila) {
               echo"
								<div class='container-fluid'>
									<div class='separar-filas'>
										<div class='row'>

										<div class=' col-xs-10 col-md-2 col-md-push-1'>
												<a href='reproductor.php?titulo=".$fila['titulo']."&usuario=".$fila['autor']."'><img class='img-responsive' src='../img/".$fila['caratula']."' alt='img' title='image'/></a>
											</div>
											<div class=' col-md-3 col-md-push-1'>
												<div class='negrita'>
													<p id='titulo_cancion' value='".$fila['titulo']."'>Nombre de la canción: ".$fila['titulo']."</p>
													<p>Artista: <a class= 'link-usuario' href='usuario.php?usuario=".$fila['autor']."' id='autor' value='".$fila['autor']."'>".$fila['autor']." </a></p>
													<p>Fecha de lanzamiento: ".$fila['fecha']."</p>
												</div>";

               if(isset($_SESSION["usuario"])) {
                  echo "<div class='form-group'>
														 <label for='aniadeLista'></label>
															<div class='col-md-7'>
																<input id='aniadeLista_".$i."_input"."' type='hidden' name='lista' value='".$fila['autor'].':'.$fila['titulo']."'>
															   <select id='aniadeLista_".$i."' class='form-control aniadeLista' form='addList-form' name='lista' type='submit'>
																  <option value='title'>Añadir a lista</option>";

                  $listas = obtener_listas_reproduccion_usuario($_SESSION['usuario']);
                  foreach($listas as $lista)
                     echo "<option value='".$lista["id"]."'>".$lista["nombre"]."</option>";
                  echo"
															   </select>
															</div>
													</div>";
               }
               echo "</div>
										</div>
								</div>
							</div>
						</div>
					</div>";

               $i ++;
            }
         }
         ?>
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
                        <li><a href="mapa.php">Mapa del sitio</a></li>
                        <li><a href="https://github.com/christian7007/AW.git">GitHub</a></li>
                        <li><a href="../Memoria_Grupo05_Webmusic.pdf" download>Memoria</a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </footer>
      </div>
   </body>
</html>
