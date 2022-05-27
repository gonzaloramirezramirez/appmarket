<?php 

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxUsuarios{
	/*=============================================
	Editar Usuario
	=============================================*/

	public $idUsuario;

	public function ajaxEditarUsuario(){
		$item = "usua_usuario";
		$valor = $this->idUsuario;
		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item,$valor);

		echo json_encode($respuesta);

	}
}

//Editar Usuarios
if(isset($_POST["idUsuario"])){
	$editar = new AjaxUsuarios();
	$editar -> idUsuario = $_POST["idUsuario"];
	$editar -> ajaxEditarUsuario();
}