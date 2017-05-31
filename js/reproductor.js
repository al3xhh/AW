
$(document).ready(function() {
   var path = $("#song").attr("src");
   var song = new Audio(path);
   var duration = getDuration();

   $("#playPauseButton").click(function(e) {
      e.preventDefault();
      //si el boton actual es play lo cambiamos al de pause y reproducimos la cancion
      if ($("#playPauseButtonSpan").hasClass("glyphicon-play")) { 
         $("#playPauseButtonSpan").removeClass("glyphicon-play");
         $("#playPauseButtonSpan").addClass("glyphicon-pause");
         $("#player-progres").attr("max", duration);
         song.play()
      } else { // si es el de pause lo cambiamos el de play y pausamos la cancion
         $("#playPauseButtonSpan").removeClass("glyphicon-pause");
         $("#playPauseButtonSpan").addClass("glyphicon-play");
         song.pause();
      }
   });
   
   //si modificamos la posicion de la barra tambien modificamos el attr currentTime de la cancion
   $("#player-progres").change(function() {
      a = $("#player-progres").val();
      song.currentTime = a;
      $("#player-progres").attr("max", duration);
   });
   
   //cada vez que se actualiza el tiempo de la cancion (se va reproduciendo) vamos moviendo la barra
   song.addEventListener("timeupdate", function() {
      curtime = parseInt(song.currentTime, 10);
      $("#player-progres").val(curtime);
      minutes = Math.floor(curtime / 60);
      seconds = curtime % 60;
      $("#reproducido").text(minutes + ":" + seconds)
   });
   
   //cada vez que pulsamos el boton de enviar comentarios hacemos una peticion con ajax para añadirlo
   $("#comment-btn").click(function() {
      $.post("../php/enviar_comentario.php", {'texto' : $("#texto").val(), 'usuario' : $("#nombre_usuario").text(), 'cancion' : $("#nombre_cancion").text(), 'autor' : $("#autor").text()}, function(data){
         $("#comentarios").html(data);
         $("#texto").val("");
      });

      return false;
   });
   
   //cada vez que seleccionamos una lista de reproduccion hacemos una peticion con ajax para añadir la cancion a la lista
   $("#selList").change(function(){
      $.post("../php/aniadir_a_lista.php", {'lista' : $("#selList :selected").val(), 'cancion' : $("#nombre_cancion").text(), 'autor' : $("#autor").text(), 'usuario' : $("#nombre_usuario").text()}, function(data){
         //volvemos a poner el valor por defecto para que funcione el "onChange"
         $("#selList").val("title");
      })

   });

});


function getDuration(){
   //obtenemos la duracion de la cancion
   var tokens = $("#duracion").text().split(":"),
       minutos = parseInt(tokens[0]),
       segundos = parseInt(tokens[1]);

   return minutos * 60 + segundos;

}




