<?php

require('modelo.php');

//TESTEAR DATOS
function testear($dato){
    return testearDato($dato);
}
//FIN TESTEAR DATOS

//SELECT
//para registro
function buscar($usuario){
    return buscarUsuario($usuario);
}

//para inicio de sesion
function autenticar($usuario, $pass){
    return autenticarUsuario($usuario, $pass);
}
?>