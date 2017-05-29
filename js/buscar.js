$(document).ready(function() {

	$("#noBuscar").hide();

	$("#buscarBusqueda").bind("submit", function (){
		if($("#textoBuscar").val() === ""){
			$("#noBuscar").show();
			$("#noBuscar").text("Debes introducir algo en la busqueda");
			return false;
		}
		else
			return true;
	});

	function aniadirLista(id){
		var res = $("#" + id + "_input").val(),
			 split = res.split(":"),
			 autor = split[0],
			 titulo = split[1];
		$.post("../php/aniadir_a_lista.php", {'lista' : $("#" + id +" :selected").val(), 'cancion' : titulo, 'autor' : autor, 'usuario' : $("#nombre_usuario").val()}, function(data){
         $(".aniadeLista").val("title");
		});
	}

	$(".aniadeLista").bind("change", function () {
		aniadirLista(this.id);
	});
});
