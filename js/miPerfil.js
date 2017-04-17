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