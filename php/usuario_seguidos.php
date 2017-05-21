<?PHP

   //Script php utilizado por ajax para mostrar los seguidos de un usuario.
   require_once("modelo.php");
   session_start();

   $resultado = obtenerSeguidos(validarEntrada($_GET['usuario']));

   foreach ($resultado as $fila) {
      if($_SESSION['usuario'] != $fila["seguido"]) {
         echo '<div class="user-resume">
               <div>
                    <img class="user-resume-img" src="../img/'.$fila["foto"].'" width="64" height="64" alt="Imagen usuario">
               </div>
               <div class="user-resume-info">
                    <a href="usuario.php?usuario='.$fila["seguido"].'"class="link-usuario"><h3>'.$fila["seguido"].'</h3></a>
               </div>
               <div class="user-resume-button">
                    <button <button value="';
         echo $fila["seguido"];
         echo '"type="submit" class="btn btn-primary pull-right" id="SeguidosSeguir">';
         if(sigueA(validarEntrada($_SESSION['usuario']), validarEntrada($fila["seguido"]))) {
            echo 'Siguiendo';
         } else {
            echo 'Seguir';
         }
         echo '</button>
               </div>
               </div>';
      }
   }
   
?>
