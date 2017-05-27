<?php
   session_start();
   //TODO eliminar esto, está forzado para hacer pruebas.
   $_SESSION['usuario'] = 'alex';

   if(!isset($_SESSION["usuario"]))
      header("Location: ../src/accesodenegado.html");
   if($_SERVER["REQUEST_METHOD"] == "POST")
      header("Location: buscar.php?tipo=1&busqueda=".$_POST["busqueda"]);
?>

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
         
         <div class="container-fluid">
            <div class="row">
               <?php
                  $resultado = obtener_informacion_usuario(validar_entrada($_GET['usuario']));

                  echo '<div class="fb-profile">
                           <img class="img img-responsive fb-image-lg" src="../img/'.$resultado[0]["encabezado"].'" alt="Profile image example" width= 400 height=400>
                           <img class="img img-responsive fb-image-profile thumbnail" src="../img/'.$resultado[0]["foto"].'" alt="Profile image example">
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

                              if($resultado == "") {
                                 echo '<div class="text-center"><h4>El usuario no ha puesto una descripción</h4></div>';
                              } else {
                                 echo '<p>'.$resultado.'</p>';
                              }
                           ?>
                        </div>
                        <div class="tab-pane" id="tab_default_2"></div>
                        <div class="tab-pane" id="tab_default_3"></div>
                        <div class="tab-pane" id="tab_default_4"></div>
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

                           if(empty($resultado)) {
                              echo '<div class="text-center"><h4>El usuario no ha indicado sus gustos musicales</h4></div>';
                           } else {
                              foreach ($resultado as $fila) {
                                 echo '<div class="form-group">
                                                   <label>'.$fila["genero"].'</label>
                                                  </div>';
                              }
                           }
                           if(validar_entrada($_GET['usuario']) != validar_entrada($_SESSION['usuario'])) {
                              echo '<button value="';echo $_GET["usuario"];echo'"type="submit" class="btn btn-primary btn-block" id="Seguir">';

                                 if(sigueA(validar_entrada($_SESSION['usuario']), validar_entrada($_GET['usuario']))) {
                                    echo 'Siguiendo';
                                 } else {
                                    echo 'Seguir';
                                 }
                              echo '</button>';
                           }
                           ?>
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
