document.addEventListener("DOMContentLoaded", function (event) {
    "use strict";
    
    var element = document.getElementById('container-principal'),
        height = element.offsetHeight,
        width = element.offsetWidth;
    
    if (height < screen.height && width > height) {
        document.getElementById("footer").classList.add('stikybottom');
    }
}, false);