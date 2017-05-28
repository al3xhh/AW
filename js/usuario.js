$( document ).ready(function() {

   //Función para el botón de seguir en la lista de seguidores de un usuario.
   function seguidoresSeguir(id) {
      if($("#" + id).html() == "Seguir") {
         $.post("../php/usuario_seguir.php", {'usuario' : $("#" + id).val()}, function(data) {
            $("#" + id).html("Siguiendo");
         });
      } else {
         $.post("../php/usuario_dejar_seguir.php", {'usuario' : $("#" + id).val()}, function(data) {
            $("#" + id).html("Seguir");
         });
      }
   }

   //Función para el botón de seguir en la lista de seguidos de un usuario.
   function seguidosSeguir(id) {
      if($("#" + id).html() == "Seguir") {
         $.post("../php/usuario_seguir.php", {'usuario' : $("#" + id).val()}, function(data) {
            $("#" + id).html("Siguiendo");
         });
      } else {
         $.post("../php/usuario_dejar_seguir.php", {'usuario' : $("#" + id).val()}, function(data) {
            $("#" + id).html("Seguir");
         });
      }
   }

   //Listener para el botón de seguir a un usuario.
   $("#Seguir").click(function() {
      if($("#Seguir").html() == "Seguir") {
         $.post("../php/usuario_seguir.php", {'usuario' : $("#Seguir").val()}, function(data) {
            $("#Seguir").html("Siguiendo");
         });
      } else {
         $.post("../php/usuario_dejar_seguir.php", {'usuario' : $("#Seguir").val()}, function(data) {
            $("#Seguir").html("Seguir");
         });
      }
   });

   //Listener para las pestañas del perfil de un usuario, para actualizarlas con ajax.
   $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      var target = $(e.target).attr("href");

      if(target == "#tab_default_2") {
         $.post("../php/usuario_seguidores.php", {'usuario' : $("#nombreusuario").html(), 'limite' : "LIMIT 10"}, function(data) {
            $("#tab_default_2").html(data);
            $(".SeguidoresSeguir").bind("click", function () {
               seguidoresSeguir(this.id);
            });
            $("#todosSeguidores").click(function () {
               $.post("../php/usuario_seguidores.php", {'usuario' : $("#nombreusuario").html(), 'limite' : ""}, function(data) {
                  $("#tab_default_2").html(data);
                  $(".SeguidoresSeguir").bind("click", function () {
                     seguidoresSeguir(this.id);
                  });
               });
            });
         });
      } else if (target == "#tab_default_3") {
         $.post("../php/usuario_seguidos.php", {'usuario' : $("#nombreusuario").html(), 'limite' : "LIMIT 10"}, function(data) {
            $("#tab_default_3").html(data);
            $(".SeguidosSeguir").bind("click", function () {
               seguidosSeguir(this.id);
            });
            $("#todosSeguidos").click(function () {
               $.post("../php/usuario_seguidos.php", {'usuario' : $("#nombreusuario").html(), 'limite' : ""}, function(data) {
                  $("#tab_default_3").html(data);
                  $(".SeguidosSeguir").bind("click", function () {
                     seguidosSeguir(this.id);
                  });
               });
            });
         });
      } else if (target == "#tab_default_4") {
         $.post("../php/usuario_canciones.php", {'usuario' : $("#nombreusuario").html(), 'limite' : "LIMIT 10"}, function(data) {
            $("#tab_default_4").html(data);
            $("#todasCanciones").click(function () {
               $.post("../php/usuario_canciones.php", {'usuario' : $("#nombreusuario").html(), 'limite' : ""}, function(data) {
                  $("#tab_default_4").html(data);
                  });
               });
            });
      }
   });
});
