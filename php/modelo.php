<?php

//TRATAMIENTO DE DATOS

function testearDato($dato){
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

//FIN TRATAMIENTO DE DATOS

//FUNCIONES PARA LA BASE DE DATOS

function conectarBBDD(){
    $db = new mysqli("localhost", "root", "joseubuntu", "webmusic");

    if(!$db->connect_error){
      return $db;
    }
    return NULL;
}

function desconectarBBDD($conexion){
    $conexion->close();
}

//FIN DE FUNCIONES PARA LA BASE DE DATOS


//Base de datos
//SELECT

function buscarUsuario($usuario){
    $con = conectarBBDD();
    $encontrado = false;

    if($con != NULL){
    	$result = $con->query("SELECT nombreusuario from usuarios");
    	if($result->num_rows > 0){
    		while($row = $result->fetch_assoc()){
          		$encontrado .= ($row["nombreusuario"] == $usuario);
    		}
        }
    }
    desconectarBBDD($con);
    return $encontrado;
}



//Fin select

function autenticarUsuario($usuario, $pass){

    $con = conectarBBDD();
    if($con != NULL){

        $sql = "SELECT nombreusuario, contrasenya FROM usuarios where nombreusuario = '$usuario'AND contrasenya = '$pass'";

        $result = $con->query($sql);
        if($result->num_rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
}

?>