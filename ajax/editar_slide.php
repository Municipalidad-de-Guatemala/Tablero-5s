<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["titulo"])){
	/* Llamar la Cadena de Conexion*/ 
	include ("../config/conexion.php");
	// escaping, additionally removing everything that could be (html/javascript-) code
    //  $titulo = mysqli_real_escape_string($con,(strip_tags($_POST['titulo'], ENT_QUOTES)));
	//  $descripcion = mysqli_real_escape_string($con,(strip_tags($_POST['descripcion'], ENT_QUOTES)));
	 
	 //$texto_boton= mysqli_real_escape_string($con,(strip_tags($_POST['texto_boton'], ENT_QUOTES)));
	 //$url_boton = mysqli_real_escape_string($con,($_POST['url_boton']));
	 //$estilo = mysqli_real_escape_string($con,($_POST['estilo']));

	 $id_slide		= intval($_POST['id_slide']);
	 $titulo 		= $_POST['titulo'];
	 $descripcion	= $_POST['descripcion'];
	//  $imagen		= $_POST['imagen_demo'];
	 $tiempo		= intval($_POST['tiempo']);
	 $orden			= intval($_POST['orden']);
	 $estado		= intval($_POST['estado']);
	 
	 //$sql="UPDATE slider SET titulo='$titulo', descripcion='$descripcion', texto_boton='$texto_boton', url_boton='$url_boton', estilo_boton='$estilo', orden='$orden', estado='$estado' WHERE id='$id_slide'";
	//  $sql="UPDATE slider SET titulo='$titulo', descripcion='$descripcion', orden='$orden', estado='$estado' WHERE id='$id_slide'";
	//  $query = mysqli_query($con,$sql);
	// $insert=oci_parse($con,"INSERT INTO TB_CARRUSEL(imagen, estado) VALUES ('$imagen_demo','0')");
	 $sql="UPDATE TB_CARRUSEL SET titulo='$titulo', descripcion='$descripcion', tiempo='$tiempo', orden='$orden', estado='$estado' WHERE id='$id_slide'";
	//  $sql="INSERT INTO TB_CARRUSEL(id, titulo, descripcion, imagen, tiempo, orden, estado) VALUES ($id_slide, '$titulo', '$descripcion', '$imagen', $tiempo, $orden, $estado)";
	 $query = oci_parse($conecta,$sql);
	 oci_execute($query);

	// if user has been added successfully
	if ($query) {
		$messages[] = "Datos  han sido actualizados satisfactoriamente.";
	} else {
		$errors []= "Lo siento algo ha salido mal intenta nuevamente.".oci_error($conecta);
	}
	
	if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
		}
		if (isset($messages)){
			
			?>
			<div class="alert alert-success" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>¡Bien hecho!</strong>
					<?php
						foreach ($messages as $message) {
								echo $message;
							}
						?>
			</div>
			<?php
		}
		
}
?>