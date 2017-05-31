<?php
require_once("modelo.php");
//comprobamos todos los parametros
if (isset($_POST["texto"]) && isset($_POST["usuario"]) && isset($_POST["cancion"]) && isset($_POST["autor"])){
   //validamos la entrada
   $autor = validarEntrada($_POST["autor"]);
   $cancion = obtenerIdCancion(validarEntrada($_POST["cancion"]), $autor);
   $texto = validarEntrada($_POST["texto"]);
   $usuario = validarEntrada($_POST["usuario"]);
   //añadimos el comentario
   aniadirComentario($cancion, $texto, $usuario);
   $comentarios = obtenerInfoComentariosCancion(validarEntrada($_POST["cancion"]), $autor);
   
   //devolvemos todos los comentarios para volverlos a mostrar ya con el nuevo añadido
   foreach($comentarios as $comentario){
      echo "<div class='comment-content col-md-8 col-md-push-2 col-xs-12'>
                           <div class='row'>
                              <div class='panel panel-primary'>
                                 <div class='panel-heading comment-heading'>";
      if ($comentario["foto"])
         echo "         <img src='../img/".$comentario["foto"]."' class='img-circle img-responsive comment-img' alt='user profile image'>";
      else
         echo "         <img src='../img/FotoUsuarioPorDefecto.png' class='img-circle img-responsive comment-img' alt='user profile image'>";

      echo "            <div>
                                       <h4>".$comentario["usuario"]."</h4>
                                       <h6>".$comentario["fecha"]."</h6>
                                    </div>
                                 </div>
                              <div class='panel-body'>
                                 <p>".$comentario["texto"]."</p>
                              </div>
                           </div>
                        </div>
                     </div>";
   }
}
else
   echo "Error en la peticion";
?>