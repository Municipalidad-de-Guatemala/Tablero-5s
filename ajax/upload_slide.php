<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES["fileToUpload"]["type"])){

	/* Llamar la Cadena de Conexion*/ 
	include ("../config/conexion.php");

	$id_slide=intval($_POST['id']);

	$target_dir = "../img/slider/";
	$carpeta=$target_dir;

	if (!file_exists($carpeta)) {
    	mkdir($carpeta, 0777, true);
	}

	

	$target_file = $carpeta . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
    	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $errors[]= "El archivo es una imagen - " . $check["mime"] . ".";
        $uploadOk = 1;
    }else{
        $errors[]= "El archivo no es una imagen.";
        $uploadOk = 0;
    }
}

	// Check if file already exists
	if (file_exists($target_file)) {
    	$errors[]="Lo sentimos, archivo ya existe.";
    	$uploadOk = 0;
	}
	// Check file size //524288
	if ($_FILES["fileToUpload"]["size"] > 2097152) {
    	$errors[]= "Lo sentimos, el archivo es demasiado grande.  Tamaño máximo admitido: 2MB"; //Tamaño maximo permitido 2 mb (esta dado en byte)
    	$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
    	$errors[]= "Lo sentimos, sólo archivos JPG, JPEG y PNG son permitidos.";
    	$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
    	$errors[]= "Lo sentimos, tu archivo no fue subido.";
		// if everything is ok, try to upload file
	}else{
				
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';

		for ($i = 0; $i < 10; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];       
		}		

		$nombre = basename($_FILES["fileToUpload"]["name"]);

		if($nombre==='info.jpg'){

			$foto 		 = $nombre;
			$target_file = $carpeta . $nombre;

			// unlink($target_file);						

    		if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){       		

				$sql_img=oci_parse($conecta,"SELECT imagen AS imagen FROM TB_CARRUSEL WHERE id='$id_slide'");
				oci_execute($sql_img);
				$ri=oci_fetch_array($sql_img);
				$id_img=$ri['IMAGEN'];
		
				$target_dir = "../img/slider/";
				$carpeta=$target_dir;
			
				if (!file_exists($carpeta)) {
					mkdir($carpeta, 0777, true);
				}
			
				$target_file = $carpeta . $id_img;
				
				if(file_exists($target_file)){				
					unlink($target_file);		
				}

				$ruta = $foto;				
				$messages[]= "El Archivo ha sido subido correctamente.";	   										
	 			$update=oci_parse($conecta,"UPDATE TB_CARRUSEL SET imagen='$ruta' WHERE id='$id_slide'");
	 			oci_execute($update);	   
				

				
    		}else{
       			$errors[]= "Lo sentimos, hubo un error subiendo el archivo.";
    		}
			
		}else{

			$ext 			= $imageFileType;
			$nombre_archivo = $randomString.'.'.$ext; //Asignación de nombre aleatorio con la extensión que le corresponda	 
			$foto 		    = $nombre_archivo;	
			$target_file    = $carpeta . $nombre_archivo;				

    		if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){       	
				
				$sql_img=oci_parse($conecta,"SELECT imagen AS imagen FROM TB_CARRUSEL WHERE id='$id_slide'");
				oci_execute($sql_img);
				$ri=oci_fetch_array($sql_img);
				$id_img=$ri['IMAGEN'];
		
				$target_dir = "../img/slider/";
				$carpeta=$target_dir;
			
				if (!file_exists($carpeta)) {
					mkdir($carpeta, 0777, true);
				}
			
				$target_file = $carpeta . $id_img;
				
				if(file_exists($target_file)){				
					unlink($target_file);		
				}

				$ruta = $foto;
				$messages[]= "El Archivo ha sido subido correctamente.";	   										
	 			$update=oci_parse($conecta,"UPDATE TB_CARRUSEL SET imagen='$ruta' WHERE id='$id_slide'");
	 			oci_execute($update);	   
				
    		}else{
       			$errors[]= "Lo sentimos, hubo un error subiendo el archivo.";
    		}

		}
	}

if (isset($errors)){
	?>
	<div class="alert alert-danger alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Error!</strong> 
	  <?php
	  foreach ($errors as $error){
		  echo"<p>$error</p>";
	  }
	  ?>
	</div>
	<?php
}

if (isset($messages)){
	?>
	<div class="alert alert-success alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Aviso!</strong> 
	  <?php
	  foreach ($messages as $message){
		  echo"<p>$message</p>";
	  }
	  ?>
	</div>
	<?php
}
}
?> 