/*=============================================
SideBar Menu
=============================================*/
$('.nuevaFoto').change(function(){
	var imagen = this.files[0];

	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){
		$('.nuevaFoto').val("");
		swal({
			title: "Error al subir la imagen",
			text: "La imagen debe estar en formato JPG o PNG",
			type: "error",
			confirmButtonText: "!Cerrar!"
		});
	}else if(imagen["size"] > 2000000){
		$('.nuevaFoto').val("");
		swal({
			title: "Error al subir la imagen",
			text: "La imagen no debe pesar mas de 2 MB",
			type: "error",
			confirmButtonText: "!Cerrar!"
		});
	}else{
		var datosImagen = new FileReader;
		datosImagen.readAsDataURL(imagen);

		$(datosImagen).on("load", function(event){
			var rutaImagen = event.target.result;
			$(".previsualizar").attr("src",rutaImagen);
		})
	}
})

/*=============================================
Editar Usuario
=============================================*/

$('.btnEditarUsuario').click(function(){
	var idUsuario = $(this).attr("idUsuario");

	var datos = new FormData();
	datos.append("idUsuario",idUsuario);

	$.ajax({
		url:"ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			$("#editarNombre").val(respuesta["usua_nombre"]);
			$("#editarUsuario").val(respuesta["usua_login"]);
			$("#editarPerfil").html(respuesta["usua_perfil"]);
			$("#editarEstado").html(respuesta["usua_estado"]);
			$("#editarPerfil").val(respuesta["usua_perfil"]);
			$("#editarEstado").val(respuesta["usua_estado"]);
			$("#passwordActual").val(respuesta["usua_password"]);
			$("#fotoActual").val(respuesta["usua_foto"]);

			if(respuesta["usua_foto"] != ""){
				$('.previsualizar').attr("src",respuesta["usua_foto"]);
			}
		}
	});
})