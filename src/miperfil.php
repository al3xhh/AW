<!DOCTYPE html>
<html lang="es">
   <head>
      <noscript>
         <meta http-equiv="refresh" content="0" url="errorJS.html">
      </noscript>
      <?php
		  session_start();
		  if(!isset($_SESSION['usuario']))
			  header('Location: login.php');
		  
		  require_once("../php/controlador.php");
		  $premium = es_premium($_SESSION['usuario']);
      ?>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo $_SESSION['usuario']?></title>

      <link rel="icon" type="image/png" href="../img/Logo.png"/>

      <!-- Bootstrap -->
      <link href="../css/bootstrap.min.css" rel="stylesheet">
      <link href="../css/webmusic.css" rel="stylesheet">
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="../js/bootstrap.min.js"></script>
      <script src="../js/miPerfil.js"></script>
      <?php
		if($premium){
			echo "<script src='../js/comprobarPremiumPerfil.js'></script>";
		}
      ?>
   </head>
   <body>
		<?php
			//esto es para lo de editar perfil
			$nuevoCorreo = $nuevaDescripcion = $nuevaImagenPerfil = $nuevoEncabezado = "";
			
			//para los campos de premium
			$cuenta = $cvv = $fechaCad = $titular = $meses = "";
			//$errorCuenta = $errorCvv = $errorFechaCad = $errorTitular = $errorMeses = false;
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				require_once('../php/controlador.php');
				
				//para el perfil
				if(isset($_POST['nuevo_email'])){
					$nuevoCorreo = validar_entrada($_POST['nuevo_email']);
				}
				else{
					$nuevoCorreo = "";
				}
				
				if(isset($_POST['nueva_descripcion'])){
					$nuevaDescripcion = validar_entrada($_POST['nueva_descripcion']);
				}
				else{
					$nuevaDescripcion = "";
				}
				
				if(isset($_FILES['nuevo_perfil'])){
					$nuevaImagenPerfil = $_FILES['nuevo_perfil'];
				}
				else{
					$nuevaImagenPerfil = "";
				}
				
				if(isset($_FILES['nueva_imagen_encabezado'])){
					$nuevoEncabezado = $_FILES['nueva_imagen_encabezado'];
				}
				else{
					$nuevoEncabezado = "";
				}
				
				//para premium
				
				
				if($premium){
					if(isset($_POST['ID_Cuenta'])){
						$cuenta = validar_entrada($_POST['ID_Cuenta']);
					}
					else{
						$cuenta = "";
					}
					
					if(isset($_POST['ID_CVV'])){
						$cvv = validar_entrada($_POST['ID_CVV']);
					}
					else{
						$cvv = "";
					}
					
					if(isset($_POST['ID_Fecha_Cad'])){
						$fechaCad = validar_entrada($_POST['ID_Fecha_Cad']);
					}
					else{
						$fechaCad = "";
					}
					
					if(isset($_POST['ID_Titular'])){
						$titular = validar_entrada($_POST['ID_Titular']);
					}
					else{
						$titular = "";
					}
					
					if(isset($_POST['ID_Num_meses'])){
						$meses = validar_entrada($_POST['ID_Num_meses']);

					}
					else{
						$meses = "";
					}
					
					/*
					
					*/
				}
			
				//header('Location:'.htmlspecialchars($_SERVER['PHP_SELF']));
			}
      ?>
      <div id="container-principal">

         <!-- Barra superior de la página -->
         <?php
         require_once("../php/navbar.php");
         navbar();
         ?>
         <!-- Fin barra superior -->

          <!-- Barra de búsqueda -->
         <div class="container">
            <div class="row">
               <div class="col-sm-6 col-sm-offset-3">
                  <div id="imaginary_container">
                     <form action="buscar.php" method="get" id="ID_Formulario">
                        <div class="input-group stylish-input-group">
                           <input type="text" class="form-control"  placeholder="Buscar" name="busqueda">
                           <input type="hidden" value="1" name="tipo">
                           <span class="input-group-addon">
                              <button class="glyphicon glyphicon-search" type="submit"></button>
                           </span>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div><!-- Fin barra de búsqueda -->


         <div class="container-fluid">
            <div class="row">
               <?php
               require_once("../php/controlador.php");
               $resultado = obtener_informacion_usuario(validar_entrada($_SESSION['usuario']));
               echo '<div class="fb-profile">
                           <img class="fb-image-lg" src="../img/'.cargar_Ruta_Foto_Encabezado($resultado[0]["encabezado"]).'" alt="Profile image example" height=400>
                           <img class="fb-image-profile thumbnail" src="../img/'.cargar_Ruta_Foto_Perfil($resultado[0]["foto"]).'" alt="Profile image example">
                           <div class="fb-profile-text">
								<h1  id="nombreusuario">'.$resultado[0]["nombreusuario"].'</h1>
                           </div>
                        <div class="fb-profile-text"></div></div>';
               ?>
            </div>
         </div> <!-- /container fluid-->

         <div class="container">
            <div class="col-sm-8">
               <div data-spy="scroll" class="tabbable-panel">
                  <div class="tabbable-line">
                     <ul class="nav nav-tabs ">
                        <li class="active">
                           <a href="#Descripcion" data-toggle="tab">Descripción</a>
                        </li>
                        <li>
                           <a href="#Seguidores" data-toggle="tab">Seguidores</a>
                        </li>
                        <li>
                           <a href="#Seguidos" data-toggle="tab">Seguidos</a>
                        </li>
                        <li>
                           <a href="#Canciones" data-toggle="tab">Canciones</a>
                        </li>
                        <li>
                           <a href="#Editar_Perfil" data-toggle="tab">Editar Perfil</a>
                        </li>
                        <?php
                        if($premium){
                           echo "<li>";
                           echo "<a href='#Editar_Premium' data-toggle='tab'>Premium</a>";
                           echo "</li>";
                        }
                        ?>
                     </ul>
                     <div class="tab-content">
                        <div class="tab-pane active" id="Descripcion">
                           <?php
                           $resultado = obtener_descripcion_usuario(validar_entrada($_SESSION['usuario']));
                           echo '<p>'.$resultado.'</p>';
                           ?>
                        </div>
						<div class="tab-pane" id="Seguidores"></div>
                        <div class="tab-pane" id="Seguidos"></div>
                        <div class="tab-pane" id="Canciones"></div>
                        <div class="tab-pane" id="Editar_Perfil">
                           <form class="form-horizontal" id="form_editar_Perfil" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">
                              <div class="form-group">
                                 <label class="col-lg-2 control-label">Email:</label>
                                 <div class="col-lg-8">
                                    <input id="id_nuevo_email" class="form-control" type="text" name="nuevo_email">
                                 </div>
                                 <?php
									if($_SERVER["REQUEST_METHOD"] == "POST"){
										
										require_once('../php/utils.php');
										
										if(trim($nuevoCorreo) != ""){
											if(validarCorreo($nuevoCorreo)){
												//inserto el nuevo correo
												if(!cambiar_email($_SESSION['usuario'], $nuevoCorreo)){
													echo "<div class='alert alert-danger alertas-registro' id='ID_error_email'>El correo no ha podido actualizarse, intentalo mas tarde</div>";
												}
												else{
													echo "<div class='alert alert-success alertas-registro' id='ID_error_email'>El correo se ha cambiado</div>";
												}
											}
											else{
												echo "<div class='alert alert-danger alertas-registro' id='ID_error_email'>El correo es invalido</div>";
											}
										}
									}
									else{
										echo "<div class='alert alert-danger alertas-registro' id='ID_error_email'></div>";
									}
                                 ?>
                              </div>
                              <div class="form-group">
                                 <label class="col-lg-2 control-label">Imagen de perfil:</label>
                                 <div class="col-lg-8">
                                    <input id="nueva_imagen_perfil" class="form-control" type="file" name="nuevo_perfil" enctype="multipart/form-data">
                                 </div>
                                 <?php
									if($_SERVER["REQUEST_METHOD"] == "POST"){
										
										require_once('../php/utils.php');
										
										if(isset($_FILES['nuevo_perfil'])){
											
											if(trim($nuevaImagenPerfil['name']) != ""){
												
												if(validarFoto($nuevaImagenPerfil['name'])){
													//subo la foto
													if(!subir_archivo_renombrar($nuevaImagenPerfil['name'], $nuevaImagenPerfil['tmp_name'], "../img/", $_SESSION['usuario']."_perfil.jpg")){
														echo "<div class='alert alert-danger alertas-registro' id='ID_error_perfil'>La imagen de perfil no ha podido actualizarse, intentalo mas tarde</div>";
													}
													else{
														//actualizo la informacion de la base de datos con la nueva imagen
														if(!cambiar_foto_perfil($_SESSION['usuario'], $_SESSION['usuario']."_perfil.jpg")){
															echo "<div class='alert alert-danger alertas-registro' id='ID_error_perfil'>La imagen de perfil no ha podido actualizarse, intentalo mas tarde</div>";
														}
														else{
															echo "<div class='alert alert-success alertas-registro' id='ID_error_perfil'>La imagen de perfil se ha cambiado</div>";
														}
													}
												}
												else{
													echo "<div class='alert alert-danger alertas-registro' id='ID_error_perfil'>La imagen no es valida, solo vale jpg</div>";
												}
											}
										}
									}
									else{
										echo "<div class='alert alert-danger alertas-registro' id='ID_error_perfil'></div>";
									}
                                 ?>
                              </div>
                              <div class="form-group">
                                 <label class="col-lg-2 control-label">Imagen de encabezado:</label>
                                 <div class="col-lg-8">
                                    <input class="form-control" type="file" name="nueva_imagen_encabezado" id="nuevo_encabezado" enctype="multipart/form-data">
                                 </div>
                                 <?php
                                 if($_SERVER["REQUEST_METHOD"] == "POST"){
										
										require_once('../php/utils.php');
										
										if(isset($_FILES['nueva_imagen_encabezado'])){
											$nuevoEncabezado = $_FILES['nueva_imagen_encabezado'];
											if(trim($nuevoEncabezado['name']) != ""){
												
												if(validarFoto($nuevoEncabezado['name'])){
													
													if(!subir_archivo_renombrar($nuevoEncabezado['name'], $nuevoEncabezado['tmp_name'], "../img/", $_SESSION['usuario']."_encabezado.jpg")){
														echo "<div class='alert alert-danger alertas-registro' id='ID_error_encabezado'>El encabezado no ha podido actualizarse, intentalo mas tarde</div>";
													}
													else{
														if(!cambiar_foto_encabezado($_SESSION['usuario'], $_SESSION['usuario']."_encabezado.jpg")){
															echo "<div class='alert alert-danger alertas-registro' id='ID_error_encabezado'>El encabezado no ha podido actualizarse, intentalo mas tarde</div>";
														}
														else{
															echo "<div class='alert alert-success alertas-registro' id='ID_error_encabezado'>El encabezado se ha cambiado</div>";
														}
													}
												}
												else{
													echo "<div class='alert alert-danger alertas-registro' id='ID_error_encabezado'>El encabezado no es valido, solo vale jpg</div>";
												}
											}
										}
									}
									else{
										echo "<div class='alert alert-danger alertas-registro' id='ID_error_encabezado'></div>";
									}
                                 ?>
                              </div>
                              <div class="form-group">
                                 <label class="col-lg-2 control-label">Descripcion:</label>
                                 <div class="col-lg-8">
                                    <input class="form-control" type="text" name="nueva_descripcion" id="id_descripcion">
                                 </div>
                                 <div class="alert alert-danger alertas-registro" id="ID_error_descripcion"></div>
                                 <?php
                                 if($_SERVER["REQUEST_METHOD"] == "POST"){
										
										require_once('../php/utils.php');
										
										if(trim($nuevaDescripcion) != ""){
											echo "DESCRIPCION NO VACIA\n";
											if(validarDescripcion($nuevaDescripcion)){
												echo "DESCRIPCION validada\n";
												if(!cambiar_descripcion($_SESSION['usuario'], $nuevaDescripcion)){
													echo "<div class='alert alert-danger alertas-registro' id='ID_error_descripcion'>La descripcion no ha podido actualizarse, intentalo mas tarde</div>";
												}
												else{
													echo "DESCRIPCIONsubida\n";
													echo "<div class='alert alert-danger alertas-registro' id='ID_error_descripcion'>La descripcion se ha cambiado se ha cambiado</div>";
												}
											}
											else{
												echo "<div class='alert alert-danger alertas-registro' id='ID_error_descripcion'>La descripcion no es valida, tiene que tener maximo 130 caracteres</div>";
											}
										}
									}
									else{
										echo "<div class='alert alert-danger alertas-registro' id='ID_error_descripcion'></div>";
									}
                                 ?>
                              </div>
                              <button id="cambiar_perfil" class="btn btn-primary btn-block">Guardar cambios</button>
                           </form>
                           <hr>
                           <?php
								if(!$premium){
									echo '<a href="premium.php"><button class="btn btn-primary btn-block">Hacerme premium</button></a>';
								}
							?>
                        </div>
                        <?php 
							$cuenta = $cvv = $fechaCad = $titular = $meses = "";
							$errorCuenta = $errorCvv = $errorFechaCad = $errorTitular = $errorMeses = true;
							if($premium){
								echo "<div class='tab-pane' id='Editar_Premium'>";
									echo "<form class='form-horizontal' id='form_editar_premium' method='post' action=".htmlspecialchars($_SERVER['PHP_SELF']).">";
										echo "<div class='form-group'>";
											echo "<div class='input-group'>";
												echo "<span class='input-group-addon'><i class='glyphicon glyphicon-euro'></i></span>";
												echo "<input class='form-control' placeholder='Número de cuenta *' name='ID_Cuenta' id='ID_Cuenta' type='text'>";
											echo "</div>";
											if($_SERVER["REQUEST_METHOD"] == "POST"){
												if(trim($cuenta) != ""){
													if(strlen($cuenta) == 16){
														if(ctype_digit($cuenta)){
															echo "<div class='alert alert-success alertas-registro' id='ID_Error_Cuenta'>La cuenta esta correcta</div>";
															
														}
														else{
															$errorCuenta = true;
															echo "<div class='alert alert-danger alertas-registro' id='ID_Error_Cuenta'></div>";
														}
													}
													else{
														echo "<div class='alert alert-danger alertas-registro' id='ID_Error_Cuenta'>La cuenta tiene que tener 16 numeros </div>";
													}
												}
												else{
													echo "<div class='alert alert-danger alertas-registro' id='ID_Error_Cuenta'>Tienes que introducir el numero de cuenta</div>";
												}
											}
											else{
												echo "<div class='alert alert-danger alertas-registro' id='ID_Error_Cuenta'></div>";
											}
										echo "</div>";

										echo "<div class='form-group'>";
											echo "<div class='input-group'>";
												echo "<span class='input-group-addon'><i class='glyphicon glyphicon-euro'></i></span>";
												echo "<input class='form-control' placeholder='CVV*' name='ID_CVV' id='ID_CVV' type='text'>";
											echo "</div>";
											if($_SERVER["REQUEST_METHOD"] == "POST"){
												if(trim($cvv) != ""){
													if(strlen($cvv) == 3){
														if(ctype_digit($cvv)){
															echo "<div class='alert alert-success alertas-registro' id='ID_Error_CVV'>El Cvv ha sido cambiado</div>";
															
														}
														else{
															$errorCvv = true;
															echo "<div class='alert alert-danger alertas-registro' id='ID_Error_CVV'>El Cvv solo admite numeros naturales</div>";
														}
													}
													else{
														echo "<div class='alert alert-danger alertas-registro' id='ID_Error_CVV'>El Cvv solo admite 3 numeros</div>";
													}
												}
												else{
													echo "<div class='alert alert-danger alertas-registro' id='ID_Error_CVV'>Tienes que introducir el CVV</div>";
												}
											}
											else{
												echo "<div class='alert alert-danger alertas-registro' id='ID_Error_CVV'></div>";
											}
										echo "</div>";

										echo "<div class='form-group'>";
											echo "<div class='input-group'>";
												echo "<span class='input-group-addon'><i class='glyphicon glyphicon-euro'></i></span>";
												echo "<input class='form-control' placeholder='Fecha de caducidad*' name='ID_Fecha_Cad' id='ID_Fecha_Cad' type='date'>";
											echo "</div>";
											if($_SERVER["REQUEST_METHOD"] == "POST"){
												if(trim($fechaCad) != ""){
													//año-mes-dia
													$dia = $mes = $ano;
													//fecha de caducidad
													list($ano, $mes, $dia) = split("-", $fechaCad);
													//echo date('Y-m-d');
													if(ctype_digit($dia) && ctype_digit($mes) && ctype_digit($ano)){
														if($fechaCad >= date('Y-m-d')){
															echo "<div class='alert alert-danger alertas-registro' id='ID_Error_Fecha_Cad'>La fecha no puede ser menor o igual que el dia actual</div>";
															$errorFechaCad = true;
														}
														else{
															echo "<div class='alert alert-success alertas-registro' id='ID_Error_Fecha_Cad'>La fecha ha sido cambiada</div>";
														}
													}
													else{
														echo "<div class='alert alert-danger alertas-registro' id='ID_Error_Fecha_Cad'>La fecha no esta bien formada</div>";
													}
												}
												else{
													echo "<div class='alert alert-danger alertas-registro' id='ID_Error_Fecha_Cad'>Tienes que introducir la fecha de caducidad</div>";
												}
											}
											else{
												echo "<div class='alert alert-danger alertas-registro' id='ID_Error_Fecha_Cad'></div>";
											}
										echo "</div>";

										echo "<div class='form-group'>";
											echo "<div class='input-group'>";
												echo "<span class='input-group-addon'><i class='glyphicon glyphicon-euro'></i></span>";
												echo "<input class='form-control' placeholder='Nombre del titular de la cuenta*' name='ID_Titular' id='ID_Titular' type='text'>";
											echo "</div>";
											if($_SERVER["REQUEST_METHOD"] == "POST"){
												if(trim($titular) != ""){
													if(strlen($titular) > 100){
														echo "<div class='alert alert-danger alertas-registro' id='ID_Error_Titular'>El titular tiene que tener como mucho 100 caracteres</div>";
														$errorTitular = true;
													}
													else{
														echo "<div class='alert alert-success alertas-registro' id='ID_Error_Titular'>El Cvv solo admite 3 numeros</div>";
													}
												}
												else{
													echo "<div class='alert alert-danger alertas-registro' id='ID_Error_Titular'>Tienes que introducir un titular</div>";
												}
											}
											else{
												echo "<div class='alert alert-danger alertas-registro' id='ID_Error_Titular'></div>";
											}
											echo "</div>";

										echo "<div class='form-group'>";
											echo "<div class='input-group'>";
												echo "<span class='input-group-addon'><i class='glyphicon glyphicon-calendar'></i></span>";
												echo "<input class='form-control' placeholder='Número de meses *' name='ID_Num_meses' id='ID_Num_meses' type='text' onchange='validarMeses()'>";
											echo "</div>";
											if($_SERVER["REQUEST_METHOD"] == "POST"){
												if(trim($meses) != ""){
													if(ctype_digit($meses) && strlen($meses) <= 2){
														echo "<div class='alert alert-success alertas-registro' id='ID_Error_meses'>Los meses han sido cambiados</div>";
														
													}
													else{
														echo "<div class='alert alert-danger alertas-registro' id='ID_Error_meses'>Tienes que introducir meses validos</div>";
														$errorMeses = true;
													}
												}
												else{
													echo "<div class='alert alert-danger alertas-registro' id='ID_Error_meses'>Tienes que introducir los meses</div>";
												}
											}
											else{
												echo "<div class='alert alert-danger alertas-registro' id='ID_Error_meses'></div>";
											}
										echo "</div>";
										echo "<div class='form-group'>";
											echo "<input type='submit' class='btn btn-primary center-block' id='cambiar_premium'>";
										echo "</div>";
									echo "</form>";
								echo "</div>";
							
								if($_SERVER["REQUEST_METHOD"] == "POST"){
									if(!$errorCuenta && !$errorCvv && !$errorFechaCad && !$errorTitular && !$errorMeses){
									   //actualizo la informacion de la tarjeta
									   $fecha_caducidad_premium = date("Y-m-d", mktime(0, 0, 0, date("m") + $meses, date("d"), date("Y")));
									   actualizar_premium($_SESSION['usuario'], $cuenta, $cvv, $fechaCad, $titular, $meses, $fecha_caducidad_premium);		
									}
								}
							}
                        ?>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-4">
               <div class="panel panel-default">
                  <div class="menu_title">
                     Gustos musicales
                  </div>
                  <div class="panel-body">
                     <div class="row">
                        <div class="col-lg-12" id="panelGustos">
                           <?php
						    if($_SERVER["REQUEST_METHOD"] == "POST"){
								require_once('../php/controlador.php');
								if(isset($_POST['generosSeleccionados'])){
									//echo "Hay generos\n";
									borrar_generos_usuario($_SESSION['usuario']);
									$generosNuevos = $_POST['generosSeleccionados'];
									foreach($generosNuevos as $genero){
										insertar_nuevo_genero_usuario($_SESSION['usuario'], $genero);
									}
								}
							}
								
							$resultado = obtener_gustos_musicales(validar_entrada($_SESSION['usuario']));
							foreach ($resultado as $fila) {
                              echo '<div class="form-group">
                                        <label>'.$fila.'</label>
                                    </div>';
							}
						   
                           ?>
                           <button id="habilitar_edicion" class="btn btn-primary btn-block">Editar gustos musicales</button>
                        </div>
                        <form class="form-horizontal" id="form_gustos" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                           <div class="col-lg-12" id="editarGustos">
                              <?php
								$resultado = obtener_gustos_musicales(validar_entrada($_SESSION['usuario']));
								$generos = obtener_generos();
								
								foreach($generos as $genero){
									if(!in_array($genero, $resultado)){
										echo "<div class='checkbox'>";
										echo "<label><input type='checkbox' name='generosSeleccionados[]' value=".$genero.">".$genero."</label>\n";
										echo "</div>";

									}
									else{
										echo "<div class='checkbox'>";
										echo "<label><input type='checkbox' name='generosSeleccionados[]' value=".$genero." checked>".$genero."</label>\n";
										echo "</div>";
									}
								}
                              ?>
                              <button type="submit" id="guardar_cambios" class="btn-primary btn-block">Guardar</button>
                              <input id="cancelar" class="btn btn-primary btn-block" value="Cancelar"></input>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Container que contiene el footer de la página -->
      <div class="footer-container">
         <footer class="footer-bs" id="footer">
            <div class="row">
               <div class="margin-logo-footer col-md-2 footer-brand animated fadeInLeft">
                  <img class="img img-responsive" alt="WebMusic" src="../img/Logo.png" width="180" height="180">
               </div>
               <div class="col-md-10 footer-nav animated fadeInUp">
                  <div class="col-md-3">
                     <h4>Acerca de</h4>
                     <p>Webmusic es una página creada para el proyecto de la asignatura Aplicaciones Web, optativa del intinerario tecnologías de la información de la carrera Ingeniería Informática de la UCM.</p>
                  </div>
                  <div class="col-md-4 col-md-push-2">
                     <h4>Miembros</h4>
                     <ul class="list">
                        <li>José Ángel Garrido Montoya</li>
                        <li>Christian Gónzalez García-Muñoz</li>
                        <li>Alejandro Huertas Herrero</li>
                        <li>Héctor Valverde Bourgon</li>
                     </ul>
                  </div>
                  <div class="col-md-4 col-md-push-2">
                     <h4>Enlaces</h4>
                     <ul class="list">
                        <li><a href="mapa.php">Mapa del sitio</a></li>
                        <li><a href="https://github.com/christian7007/AW.git">GitHub</a></li>
                        <li><a href="../Memoria_Grupo05_Webmusic.pdf" download>Memoria</a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </footer>
      </div><!-- Fin container footer -->
   </body>
</html>
