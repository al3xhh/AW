
$(document).ready(function() {
   var path = $("#song").attr("src");
   var song = new Audio(path);
   var duration = getDuration();

   $("#playPauseButton").click(function(e) {
      e.preventDefault();
      if ($("#playPauseButtonSpan").hasClass("glyphicon-play")) {
         $("#playPauseButtonSpan").removeClass("glyphicon-play");
         $("#playPauseButtonSpan").addClass("glyphicon-pause");
         $("#player-progres").attr("max", duration);
         song.play()
      } else {
         $("#playPauseButtonSpan").removeClass("glyphicon-pause");
         $("#playPauseButtonSpan").addClass("glyphicon-play");
         song.pause();
      }
   });

   $("#player-progres").change(function() {
      a = $("#player-progres").val();
      song.currentTime = a;
      $("#player-progres").attr("max", duration);
   });

   song.addEventListener("timeupdate", function() {
      curtime = parseInt(song.currentTime, 10);
      $("#player-progres").val(curtime);
      minutes = Math.floor(curtime / 60);
      seconds = curtime % 60;
      $("#reproducido").text(minutes + ":" + seconds)
   });

   $("#comment-btn").click(function() {
      $.post("../php/enviar_comentario.php", {'texto' : $("#texto").val(), 'usuario' : $("#nombre_usuario").text(), 'cancion' : $("#nombre_cancion").text(), 'autor' : $("#autor").text()}, function(data){
         $("#comentarios").html(data);
         $("#texto").val("");
      });

      return false;
   });

   $("#selList").change(function(){
      $.post("../php/aniadir_a_lista.php", {'lista' : $("#selList :selected").text(), 'cancion' : $("#nombre_cancion").text(), 'autor' : $("#autor").text(), 'usuario' : $("#nombre_usuario").text()}, function(data){
         $("#selList").val("title");
      })

   });

});


function getDuration(){
   var tokens = $("#duracion").text().split(":"),
       minutos = parseInt(tokens[0]),
       segundos = parseInt(tokens[1]);

   return minutos * 60 + segundos;

}




