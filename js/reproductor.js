function activateBar() {
    "use strict";
    
    var elem = document.getElementById("myBar"),
        duracion_val = document.getElementById("duracion").innerHTML,
        tokens = duracion_val.split(":"),
        minutos = parseInt(tokens[0]),
        segundos = parseInt(tokens[1]),
        totalTime = minutos * 60 + segundos,
        width = 1,
        //multiplicamos por 250 en vez de 1000 (el tiempo se expresa en ms) para que se llame a la funcion con mayor frecuencia y la barra no vaya a tirones tambien aumentamos solo un 0.25 en vez de un 1 el tamaño
        id = setInterval(frame, (totalTime/100) * 250);
        
        function frame() {
            if (width >= 100){
                clearInterval(id);
            } else {
                width += 0.25;
                elem.style.width = width + "%";
            }
        }  
}

function playSong() {
    "use strict";
    document.getElementById("song").play();
}

function onPlay() {
    activateBar();
    playSong();
}