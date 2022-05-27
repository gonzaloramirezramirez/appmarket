<?php

class ControladorUsuarios{

	/*=============================================
	INGRESO DE USUARIO $_POST["ingPassword"]
	=============================================*/

	public function ctrIngresoUsuario(){

		if(isset($_POST["ingUsuario"])){

			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){

			   	$encriptar = crypt($_POST["ingPassword"], '$2a$07$usesomesillystringforsalt$');

				$tabla = "adm_tusuario";

				$item = "usua_login";
				$valor = $_POST["ingUsuario"];

				$respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

				if($respuesta["usua_login"] == $_POST["ingUsuario"] && $respuesta["usua_password"] == $encriptar){

					$_SESSION["iniciarSesion"] = "ok";
					$_SESSION["id"] = $respuesta["usua_usuario"];
					$_SESSION["nombre"] = $respuesta["usua_nombre"];
					$_SESSION["usuario"] = $respuesta["usua_login"];
					$_SESSION["foto"] = $respuesta["usua_foto"];"";
					$_SESSION["perfil"] = $respuesta["usua_perfil"];

					echo '<script>

						window.location = "inicio";

					</script>';

				}else{

					echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';

				}

			}	

		}

	}

	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/
	public static function ctrCrearUsuario(){
		
		if(isset($_POST["nuevoUsuario"])){
			if(preg_match('/^[a-zA-Z0-9ÑñáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
				preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoUsuario"]) &&
				preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoContrasenia"])){

				$ruta = "";
				
				//Validar foto
		    	if(isset($_FILES["nuevaFoto"]["tmp_name"]) && !empty($_FILES["nuevaFoto"]["tmp_name"])){
					list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);
					
					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					Creacion del directorio
					=============================================*/
					$directorio = "vistas/img/usuarios/".$_POST["nuevoUsuario"];

					mkdir($directorio, 0755);

					/*=============================================
					De acuerdo al tipo de imagen se aplican las funciones de PHP
					=============================================*/

					if($_FILES["nuevaFoto"]["type"] == "image/jpeg"){

						/*=============================================
						Guardar imagen en el directorio
						=============================================*/
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".jpg";


						$origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagejpeg($destino, $ruta);

					}

					if($_FILES["nuevaFoto"]["type"] == "image/png"){

						/*=============================================
						Guardar imagen en el directorio $_POST["nuevoContrasenia"],
						=============================================*/
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/usuarios/".$_POST["nuevoUsuario"]."/".$aleatorio.".png";


						$origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagepng($destino, $ruta);

					}
				}
				

				$tabla = "adm_tusuario";

				$encriptar = crypt($_POST["nuevoContrasenia"], '$2a$07$usesomesillystringforsalt$');

				$datos = array('usua_nombre' => $_POST["nuevoNombre"], 
						       'usua_login' => $_POST["nuevoUsuario"],
						   	   'usua_password' => $encriptar, 
						   	   'usua_perfil' => $_POST["nuevoPerfil"],
						   	   'usua_estado' => $_POST["nuevoEstado"],
						   	   'usua_foto' => $ruta);

				$respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);

				if($respuesta == "ok"){
					echo '<script>
						swal({
							type: "success",
							title: "!El usuario ha sido guardado correstamente!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "usuarios";
								}
							});
					</script>';
				}
			}
			else{
				echo '<script>
						swal({
							type: "error",
							title: "!El usuario no puede ir vacio o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "usuarios";
								}
							});
					</script>';
			}
		}
	}


	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/
	public static function ctrMostrarUsuarios($item, $valor){
		$tabla = "adm_tusuario";
		$respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

		return $respuesta;
	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/
	public static function ctrEditarUsuario(){
		
		if(isset($_POST["editarUsuario"])){
			if(preg_match('/^[a-zA-Z0-9ÑñáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])){

				$ruta = $_POST["fotoActual"];
				
				//Validar foto
		    	if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){
					list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);
					
					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					Creacion del directorio
					=============================================*/
					$directorio = "vistas/img/usuarios/".$_POST["editarUsuario"];

					//Primero preguntamos si existe una foto en la base de datos
					if(!empty($_POST["fotoActual"])){
						unlink($_POST["fotoActual"]);
					}
					else{
						mkdir($directorio, 0755);
					}

					/*=============================================
					De acuerdo al tipo de imagen se aplican las funciones de PHP
					=============================================*/

					if($_FILES["editarFoto"]["type"] == "image/jpeg"){

						/*=============================================
						Guardar imagen en el directorio
						=============================================*/
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".jpg";


						$origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagejpeg($destino, $ruta);

					}

					if($_FILES["editarFoto"]["type"] == "image/png"){

						/*=============================================
						Guardar imagen en el directorio $_POST["nuevoContrasenia"],
						=============================================*/
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/usuarios/".$_POST["editarUsuario"]."/".$aleatorio.".png";


						$origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagepng($destino, $ruta);

					}
				}
				

				$tabla = "adm_tusuario";

				if($_POST["editarContrasenia"] != ""){
					if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarContrasenia"])) {
						$encriptar = crypt($_POST["editarContrasenia"], '$2a$07$usesomesillystringforsalt$');
					}
					else{
						echo '<script>
								swal({
									type: "error",
									title: "!La contrasenia no puede ir vacia o llevar caracteres especiales!",
									showConfirmButton: true,
									confirmButtonText: "Cerrar",
									closeOnConfirm: false
								}).then((result)=>{
										if(result.value){
											window.location = "usuarios";
										}
									});
							  </script>';
					}
					
				}
				else{
					$encriptar = $_POST["passwordActual"];
				}
				

				$datos = array('usua_nombre' => $_POST["editarNombre"], 
						       'usua_login' => $_POST["editarUsuario"],
						   	   'usua_password' => $encriptar, 
						   	   'usua_perfil' => $_POST["editarPerfil"],
						   	   'usua_estado' => $_POST["editarEstado"],
						   	   'usua_foto' => $ruta);

				$respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);

				if($respuesta == "ok"){
					echo '<script>
						swal({
							type: "success",
							title: "!El usuario ha sido editado correctamente!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "usuarios";
								}
							});
					</script>';
				}
			}
			else{
				echo '<script>
						swal({
							type: "error",
							title: "!El nombre no puede ir vacio o llevar caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "usuarios";
								}
							});
					</script>';
			}
		}
	}

}
	


