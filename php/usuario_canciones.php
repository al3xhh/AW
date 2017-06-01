<?PHP

   //Script php utilizado por ajax para obtener las canciones del usuario dentro del perfil.
   require_once("modelo.php");

   if(isset($_POST['usuario']) && isset($_POST['limite'])) {
      $resultado = obtenerCancionesUsuario(validarEntrada($_POST['usuario']), $_POST['limite']);

      if (empty($resultado)) {
         echo '<h4 class="text-center">El usuario no ha subido ninguna canción</h4>';
      } else {
         foreach ($resultado as $fila) {
            echo '<div class="user-resume">
                   <div>
                       <img class="user-resume-img" src="../img/'.$fila["caratula"].'" width="64" height="64" alt="Imagen usuario">
                   </div>
                   <div class="user-resume-info">
                       <h3>'.$fila["titulo"].'</h3>
                   </div>
                   <div class="user-resume-button">
                      <a href="reproductor.php?titulo='.$fila["titulo"].'&usuario=';echo validarEntrada($_POST['usuario']); echo '"><button type="button" class="btn btn-primary pull-right glyphicon glyphicon-play" data-toggle="tooltip" title="escuchar canción"></button></a>
                   </div>
                </div>';
         }

         if($_POST['limite'] != "")
            echo '<p class="alert alert-info text-center" id="todasCanciones">Mostrar todas las canciones</p>';
      }
   }
?>
