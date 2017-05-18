$( document ).ready(function() {
   $("#Seguir").click(function() {
      var usuario_val = $("#Seguir").val();
      var xmlhttp = new XMLHttpRequest();
      var accion = $("#Seguir").html();

      if(accion == "Seguir") {
         xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
               $("#Seguir").html("Siguiendo");
            }
         };
         xmlhttp.open("GET", "../php/usuario_seguir.php?usuario=" + usuario_val, true);
         xmlhttp.send();
      } else {
         xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
               $("#Seguir").html("Seguir");
            }
         };
         xmlhttp.open("GET", "../php/usuario_dejar_seguir.php?usuario=" + usuario_val, true);
         xmlhttp.send();
      }
   });

   $("#SeguidoresSeguir").click(function() {
      var usuario_val = $("#SeguidoresSeguir").val();
      var xmlhttp = new XMLHttpRequest();
      var accion = $("#SeguidoresSeguir").html();

      if(accion == "Seguir") {
         xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
               $("#SeguidoresSeguir").html("Siguiendo");
            }
         };
         xmlhttp.open("GET", "../php/usuario_seguir.php?usuario=" + usuario_val, true);
         xmlhttp.send();
      } else {
         xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
               $("#SeguidoresSeguir").html("Seguir");
            }
         };
         xmlhttp.open("GET", "../php/usuario_dejar_seguir.php?usuario=" + usuario_val, true);
         xmlhttp.send();
      }
   });

   $("#SeguidosSeguir").click(function() {
      var usuario_val = $("#SeguidosSeguir").val();
      var xmlhttp = new XMLHttpRequest();
      var accion = $("#SeguidosSeguir").html();

      if(accion == "Seguir") {
         xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
               $("#SeguidosSeguir").html("Siguiendo");
            }
         };
         xmlhttp.open("GET", "../php/usuario_seguir.php?usuario=" + usuario_val, true);
         xmlhttp.send();
      } else {
         xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
               $("#SeguidosSeguir").html("Seguir");
            }
         };
         xmlhttp.open("GET", "../php/usuario_dejar_seguir.php?usuario=" + usuario_val, true);
         xmlhttp.send();
      }
   });
});
