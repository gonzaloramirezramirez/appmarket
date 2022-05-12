<?php

class ControladorUsuarios{

	/*=============================================
	INGRESO DE USUARIO
	=============================================*/

	public function ctrIngresoUsuario(){

		if(isset($_POST["ingUsuario"])){

			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){

			   	$encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$tabla = "adm_tusuario";

				$item = "usua_login";
				$valor = $_POST["ingUsuario"];

				$respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

				if($respuesta["usua_login"] == $_POST["ingUsuario"] && $respuesta["usua_password"] == $_POST["ingPassword"]){

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
				
				if(isset($_FILES["nuevaFoto"]["tmp_name"])){
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
						Guardar imagen en el directorio
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

				$encriptar = crypt($_POST["nuevoContrasenia"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$datos = array('usua_nombre' => $_POST["nuevoNombre"], 
						       'usua_login' => $_POST["nuevoUsuario"],
						   	   'usua_password' => $_POST["nuevoContrasenia"],
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

}
	


