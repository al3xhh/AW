<?php session_start();
require_once("../php/controlador.php");
require_once("../php/modelo.php");
$_SESSION["usuario"] = "alex";

if ($_SERVER["REQUEST_METHOD"] == "GET"){
	//HAY QUE VALIDAR LA ENTRADA SEGUN ME DICE CHRISTIAN
	$id = validarEntrada($_GET["lista"]);
	$autor = validarEntrada($_GET["autor"]);
	$nombre = validarEntrada($_GET["nombre"]);
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Canciones de lista (nombre de la lista)</title>

        <link rel="icon" type="image/png" href="../img/Logo.png"/>

        <!-- Bootstrap -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/webmusic.css" rel="stylesheet">

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>
    </head>
    <body>
        <div id="container-principal">
            <!-- Barra superior de la página -->
           <?php
             require_once("../php/navbar.php");
             navbar();
           ?>
           <!-- Fin barra superior -->

            <div class="container-fluid">
                <div class="separar-filas">
					<?PHP
					  require_once("../php/controlador.php");
					  $res = sacar_foto($autor);
					  echo"
						<div class='col-md-2 col-md-push-2'>
							<img  class='img-responsive' src='../img/".$res."' alt='img' title='image'/>
						</div>
						<div class='separar-filas-arriba'>
							<div class='col-md-3 col-md-push-2'>
								<div class='negrita'>

									Nombre del autor: ".$autor."
									<div class='salto-de-linea'></div>
									Nombre de la lista: ".$nombre."

                            </div>
                        </div>
                    </div>";
					?>
                </div>
            </div>



            <div class="container-fluid">
				<div class='separar-filas-arriba'>
					<div class="col-md-2 col-md-push-2">Titulo</div>
					<div class="col-md-1 col-md-push-2">Autor</div>
					<div class="col-md-2 col-md-push-2">Fecha</div>
					<div class="col-md-1 col-md-push-2">Duracion</div>
				</div>
				<?PHP
					require_once("../php/controlador.php");
					$resultado = lista_reproduccion_canciones($id);
					foreach ($resultado as $fila) {
					  echo
						 "<div class='item active'>
						  <blockquote>
							 <hr class='separador-fino'>
								<div class='col-md-2 col-md-push-2'><a class='link-home-carousel-and-search' href='reproductor.php?titulo=".$fila['titulo']."&usuario=".$fila['autor']."&lista=".$nombre."'>".$fila['titulo']."</a></div>
								<div class='col-md-1 col-md-push-2'><a class='link-home-carousel-and-search' href='usuario.php'>".$fila['autor']."</a></div>
								<div class='col-md-2 col-md-push-2'>".$fila['fecha']."</div>
								<div class='col-md-1 col-md-push-2'>".$fila['duracion']."</div>
								<div class='col-md-1 col-md-push-2'>
									<form action='../php/borrar_cancion_lista.php' method='post'>
										<input type='hidden' name='id' value='".$id."' />
										<input type='hidden' name='autor' value='".$autor."' />
										<input type='hidden' name='nombrelista' value='".$nombre."' />
										<input type='hidden' name='cancion' value='".$fila['id']."' />
										<button type='submit' class='btn btn-danger btn-xs' data-title='Delete' data-toggle='modal' data-target='#delete' ><span class='glyphicon glyphicon-trash'></span></button>
									</form>
								</div>
						  </blockquote>
					  </div>";
					}
				?>

            </div>


    </body>
</html>
