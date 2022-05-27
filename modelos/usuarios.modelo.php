<?php

require_once "conexion.php";

class ModeloUsuarios{

	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/

	public static  function mdlMostrarUsuarios($tabla, $item, $valor){
		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();

			return $stmt -> fetchAll();
		}

		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	CREAR USUARIOS
	=============================================*/

	public static  function mdlIngresarUsuario($tabla, $datos){
		
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(usua_nombre, usua_login, usua_password, usua_perfil, usua_estado, usua_foto) VALUES (:nombre, :login, :password, :perfil, :estado, :foto)");

		$stmt -> bindParam(":nombre", $datos["usua_nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":login", $datos["usua_login"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["usua_password"], PDO::PARAM_STR);
		$stmt -> bindParam(":perfil", $datos["usua_perfil"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["usua_estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":foto", $datos["usua_foto"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt -> close();
		$stmt = null;
	}


	/*=============================================
	EDITAR USUARIOS
	=============================================*/

	public static  function mdlEditarUsuario($tabla, $datos){
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET usua_nombre = :nombre, usua_password = :password, usua_perfil = :perfil, usua_estado = :estado, usua_foto = :foto WHERE usua_login = :login");

		$stmt -> bindParam(":nombre", $datos["usua_nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["usua_password"], PDO::PARAM_STR);
		$stmt -> bindParam(":perfil", $datos["usua_perfil"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["usua_estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":foto", $datos["usua_foto"], PDO::PARAM_STR);
		$stmt -> bindParam(":login", $datos["usua_login"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt -> close();
		$stmt = null;
	}
}