<?PHP

   //Script php utilizado por ajax para mostrar los seguidos de un usuario.
   require_once("modelo.php");
   session_start();
   $estado = "";
   $id = 0;

   if(isset($_POST['usuario']) && isset($_POST['limite'])) {
      $resultado = obtenerSeguidos(validarEntrada($_POST['usuario']), $_POST['limite']);

      foreach ($resultado as $fila) {
         if($_SESSION['usuario'] == $fila["seguido"]) {
            $estado = " disabled";
         } else {
            $estado = "";
         }
         echo '<div class="user-resume">
                   <div>
                     <img class="user-resume-img" src="../img/'.$fila["foto"].'" width="64" height="64" alt="Imagen usuario">
                   </div>
                   <div class="user-resume-info">
                     <a href="usuario.php?usuario='.$fila["seguido"].'"class="link-usuario"><h3>'.$fila["seguido"].'</h3></a>
                   </div>
                   <div class="user-resume-button">
                     <button value="';
         echo $fila["seguido"];
         echo '"type="submit" class="btn btn-primary pull-right SeguidosSeguir" id="seguir-'.$id.'"'.$estado.'>';
         if(sigueA(validarEntrada($_SESSION['usuario']), validarEntrada($fila["seguido"]))) {
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
         echo '<p class="alert alert-info text-center" id="todosSeguidos">Mostrar todos los seguidos</p>';
   }

?>
