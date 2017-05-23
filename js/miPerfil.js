function ocultar(elemento) {
    "use strict";
    document.getElementById(elemento).style.display = "none";
    
}

function mostrar(elemento) {
    "use strict";
    document.getElementById(elemento).style.display = "inline";
}

function ocultarGustos() {
    "use strict";
    ocultar("panelGustos");
    mostrar("editarGustos");
}

function ocultarEdicionGustos() {
    "use strict";
    ocultar("editarGustos");
    mostrar("panelGustos");
}

function actualizarGustos(){
	//script de ajax
}

$( document ).ready(function() {
	var edicion = false;
    $("#habilitar_edicion").on("click", function () {
        if(!edicion){
			ocultarGustos();
			edicion = true;
		}
    });
	$("#guardar_cambios").on("click", function () {
		edicion = false;
		ocultarEdicionGustos();
		actualizarGustos();
    });
	$("#cancelar").on("click", function () {
		edicion = false;
       ocultarEdicionGustos();
    });
});