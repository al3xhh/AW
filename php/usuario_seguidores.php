<?PHP

   //Script php utilizado por ajax para mostrar los seguidores de un usuario.
   require_once("modelo.php");
   session_start();
   $estado = "";
   $id = 0;

   if(isset($_POST['usuario']) && isset($_POST['limite'])) {
      $resultado = obtenerSeguidores(validarEntrada($_POST['usuario']), $_POST['limite']);

      if(empty($resultado)) {
         echo '<div class="text-center"><h4>El usuario no tiene seguidores</h4></div>';
      } else {
         foreach ($resultado as $fila) {
            if($_SESSION['usuario'] == $fila["seguidor"]) {
               $estado = " disabled";
            } else {
               $estado = "";
            }
            echo '<div class="user-resume">
                      <div>
                        <img class="user-resume-img" src="../img/'.$fila["foto"].'" width="64" height="64" alt="Imagen usuario">
                      </div>
                      <div class="user-resume-info">
                        <a href="usuario.php?usuario='.$fila["seguidor"].'"class="link-usuario"><h3>'.$fila["seguidor"].'</h3></a>
                      </div>
                      <div class="user-resume-button">
                        <button value="';
            echo $fila["seguidor"];
            echo '"type="submit" class="btn btn-primary pull-right SeguidoresSeguir" id="seguir-'.$id.'"'.$estado.'>';
            if(sigueA(validarEntrada($_SESSION['usuario']), validarEntrada($fila["seguidor"]))) {
               echo 'Siguiendo';
            } else {
               echo 'Seguir';
            }
            echo '</button>
                  </div>
                  </div>';

            $id ++;
         }

         if($_POST['limite'] != "")
            echo '<p class="alert alert-info text-center" id="todosSeguidores">Mostrar todos los seguidores</p>';
      }
   }

?>
