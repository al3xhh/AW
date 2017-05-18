<?php
require_once('modelo.php');

$con = conectarBBDD();

if($con != NULL){
   $usu = testearDato($_GET['usuario']);
   $result = $con->query("SELECT nombreusuario from usuarios where nombreusuario = '$usu'");

   if($result->num_rows == 0){
      echo "Usuario no registrado";
   }
}
desconectarBBDD($con);
?>