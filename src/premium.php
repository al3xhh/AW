<!DOCTYPE html>
<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST"){
   if (isset($_POST["ID_Cuenta"])){
      require_once("../php/controlador.php");
      $usuario = validarEntrada($_POST["ID_Usuario"]);
      $n_cuenta = validarEntrada($_POST["ID_Cuenta"]);
      $cvv =  validarEntrada($_POST["ID_CVV"]);
      $fecha_caducidad_cuenta = validarEntrada($_POST["ID_Fecha_Cad"]);
      $titular = validarEntrada($_POST["ID_Titular"]);
      $contraseña = validarEntrada($_POST["ID_Pass"]);
      $n_meses = validarEntrada($_POST["ID_Num_meses"]);
      $fecha_caducidad_premium = date("Y-m-d", mktime(0, 0, 0, date("m") + $n_meses, date("d"), date("Y")));
   } else if (isset($_SESSION["usuario"])){
      $usuario = validarEntrada($_POST["ID_Usuario"]);
      $fecha_caducidad_premium = date("Y-m-d", mktime(0, 0, 0, date("m") + 1, date("d"), date("Y")));
   }

   if (!aniadir_premium($usuario, $n_cuenta, $cvv, $fecha_caducidad_cuenta, $titular, $n_meses, $fecha_caducidad_premium, $contraseña))
      echo "<div class='alert alert-danger text-center'>
                <h4>Se producido un erro. Revisa los datos introducidos</h4>
            </div>";
   else 
      header("Location: ".htmlspecialchars($_SERVER["PHP_SELF"]));
}
?>

<html lang="es">
   <head>

      <!-- En caso de que este desactivado JavaScript redirigimos a una pagina de error -->
      <noscript>
         <meta http-equiv="refresh" content="0; url=errorJS.html" />
      </noscript>

      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

      <title>Hazte premium!</title>

      <!--Logo para el favicon-->
      <link rel="icon" type="image/png" href="../img/Logo.png"/>
      <!-- Bootstrap -->
      <link href="../css/bootstrap.min.css" rel="stylesheet">
      <link href="../css/webmusic.css" rel="stylesheet">
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="../js/bootstrap.min.js"></script>
      <!-- Archivo con las validaciones locales del formulario -->
      <script src="../js/premium.js"></script>
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

            <!--Cabecera de la pagina-->
            <header id="header-premium">
               <div id="premium-text-header">
                  <h2 class="premium-header-format">Hazte premium!</h2>
                  <h4 class="premium-header-format">Disfruta de toda la música que te gusta de la mejor forma posible.</h4>
               </div>
            </header>

            <!-- Ventajas de ser premium -->
            <div id="info-about-premium">
               <h2 class="title-premium">¡Descubre todas las ventajas de ser Premium!</h2>
               <ul id="premium-list">
                  <li class="li-premium-list premium-text-font">Descargar toda la música que te guste.</li>
                  <li class="li-premium-list premium-text-font">Escuchar todas las canciones, incluidas las premium.</li>
                  <li class="li-premium-list premium-text-font">Tus cancion tendrán preferencia a lo hora de ser mostradas en las diferentes listas de WebMusic.</li>
               </ul>
            </div>
            <!-- Fin ventajas de ser premium -->

            <!-- Linea separadora de contenido -->
            <hr class="separator">

            <!-- Prueba gratuita -->
            <div id="prueba-premium">
               <h2 class="title-premium">¡Pruebalo gratis durante un mes!</h2>
               <p class="premium-text-font p-premium">Si estas dudando si hacerte premium o no prueba gratis todas las ventajas que te ofrecemos durante un mes y convencete.</p>
               <p class="premium-text-font p-premium">Solo tienes que pinchar en este botón.</p>
               <div class="col-sm-2 col-md-2 col-md-push-5 col-sm-push-5">
                  <input type="submit" id="prueba-premium-btn" class="btn center-block btn-primary col-md-12" value="Prueba premium !">
               </div>
            </div>
            <!-- Fin prueba gratuita -->

            <!-- Linea separadora de contenido -->
            <hr class="separator">

            <!-- Formulario para hacerse premium -->
            <div id="hazte-premium">
               <h2 class="title-premium">¡Hazte premium ya!</h2>
               <p class="premium-text-font p-premium">Para hacerte premium ya, solo necesitas rellenar el siguiente formulario.</p>
               <div class="panel-body">
                  <form class="col-md-4 col-md-push-4" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validarPremium()" id="premium-form">
                     <!-- Campo de Nombre de usuario o correo elctronico -->
                     <div class="form-group">
                        <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                           <input form="premium-form" class="form-control" placeholder="Nombre de usuario o correo electronico*" name="ID_Usuario" id="ID_Usuario" type="text" onchange="validarUsuario()">
                        </div>
                        <div class="alert alert-danger alertas-registro" id="ID_Error_Usuario"></div>
                     </div>
                     <!-- Campo de Nª de cuenta -->
                     <div class="form-group">
                        <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-euro"></i></span>
                           <input form="premium-form" class="form-control" placeholder="Número de cuenta *" name="ID_Cuenta" id="ID_Cuenta" type="text" onchange="validarCuenta()">
                        </div>
                        <div class="alert alert-danger alertas-registro" id="ID_Error_Cuenta"></div>
                     </div>
                     <!-- Campo de CVV -->
                     <div class="form-group">
                        <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-euro"></i></span>
                           <input form="premium-form" class="form-control" placeholder="CVV*" name="ID_CVV" id="ID_CVV" type="text" onchange="validarCVV()">
                        </div>
                        <div class="alert alert-danger alertas-registro" id="ID_Error_CVV"></div>
                     </div>
                     <!-- Campo de fecha de caducidad -->
                     <div class="form-group">
                        <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-euro"></i></span>
                           <input form="premium-form" class="form-control" placeholder="Fecha de caducidad*" name="ID_Fecha_Cad" id="ID_Fecha_Cad" type="date" onchange="validarFechaCad()">
                        </div>
                        <div class="alert alert-danger alertas-registro" id="ID_Error_Fecha_Cad"></div>
                     </div>
                     <!-- Campo del titular de la cuenta -->
                     <div class="form-group">
                        <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-euro"></i></span>
                           <input form="premium-form" class="form-control" placeholder="Nombre del titular de la cuenta*" name="ID_Titular" id="ID_Titular" type="text" onchange="validarTitular()">
                        </div>
                        <div class="alert alert-danger alertas-registro" id="ID_Error_Titular"></div>
                     </div>
                     <!-- Campo de la contraseña -->
                     <div class="form-group">
                        <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                           <input form="premium-form" class="form-control" placeholder="Contraseña *" name="ID_Pass" id="ID_Pass" type="password" onchange="validarContrasenya()">
                        </div>
                        <div class="alert alert-danger alertas-registro" id="ID_Error_Pass"></div>
                     </div>
                     <!-- Campo de Nª de meses -->
                     <div class="form-group">
                        <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                           <input form="premium-form" class="form-control" placeholder="Número de meses *" name="ID_Num_meses" id="ID_Num_meses" type="text" onchange="validarMeses()">
                        </div>
                        <div class="alert alert-danger alertas-registro" id="ID_Error_meses"></div>
                     </div>
                     <div class="form-group">
                        <input type="submit" form="premium-form" class="btn btn-primary center-block" value="Hazte premium !">
                     </div>
                  </form>
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
