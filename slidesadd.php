<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$title="Agregar Slide";
/* Llamar la Cadena de Conexion*/ 
include ("config/conexion.php");

$imagen_demo="noimagen.jpg";

// $sql_slider=oci_parse($con,"SELECT * FROM TB_CARRUSEL WHERE estado=1 ORDER BY orden");
// $nums_slides=oci_num_rows($sql_slider);						
// oci_execute($sql_slider);		
// $insert=mysqli_query($con,"insert into slider (url_image, estado) values ('$imagen_demo','0')");
// $sql_last=mysqli_query($con,"select LAST_INSERT_ID(id) as last from slider order by id desc limit 0,1");
// $rw=mysqli_fetch_array($sql_last);
$sql_max=oci_parse($conecta,"SELECT NVL(MAX(id),0)+1 AS max FROM TB_CARRUSEL ORDER BY id DESC");
oci_execute($sql_max);
$mx=oci_fetch_array($sql_max);
$max_slide= intval($mx['MAX']);

$insert=oci_parse($conecta,"INSERT INTO TB_CARRUSEL(id, imagen, estado) VALUES ($max_slide,'$imagen_demo',1)");
oci_execute($insert);	
$sql_last=oci_parse($conecta,"SELECT NVL(MAX(id),0) AS last FROM TB_CARRUSEL ORDER BY id DESC");
oci_execute($sql_last);
$rw=oci_fetch_array($sql_last);
$id_slide=$rw['LAST'];

$active_config="active";
$active_slider="active";

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../images/ico/favicon.ico">
    <title><?php echo $title;?></title>

    <!-- Bootstrap core CSS -->
    <!-- Latest compiled and minified CSS -->

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Custom styles for this template -->
    <link href="css/navbar-fixed-top.css" rel="stylesheet">
	<link href="css/preview-image.css" rel="stylesheet">

	<style>
		textarea{
			resize: none;
		}
	</style>	

  </head>
  <body>
		<?php include("top_menu.php");?>

    <div class="container">
		
      <!-- Main component for a primary marketing message or call to action -->
      <div class="row">	   	  

		 <div class="col-md-7">
		 <h3 ><span class="glyphicon glyphicon-edit"></span> Editar slide</h3>
			<form class="form-horizontal" id="editar_slide">
				 
			 
			  
			  <div class="form-group">
				<label for="titulo" class="col-sm-3 control-label">Titulo</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="titulo" value="" required name="titulo" autofocus="">
				  <input type="hidden" class="form-control" id="id_slide" value="<?php echo intval($id_slide);?>" name="id_slide">
				</div>
			  </div>
			  
			 <div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Descripción</label>
				<div class="col-sm-9">
				  <textarea class="form-control " rows="2" id="descripcion" required name="descripcion"></textarea>
				</div>
			  </div>

			  <div class="form-group">
				<label for="orden" class="col-sm-3 control-label">Orden</label>
				<div class="col-sm-9">
				  <input type="number" class="form-control" id="orden" name="orden" value="1">
				</div>
			  </div>

			  <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Tiempo</label>
				<div class="col-sm-9">
				  <select class="form-control" id="tiempo" required name="tiempo">
				    <option value="0" >Sin Tiempo</option>
				    <option value="15000" >15 Segundos</option>
					<option value="30000" >30 Segundos</option>
					<option value="60000" >1 Minuto</option>
					<option value="300000" >5 Minutos</option>
					<option value="900000" >15 Minutos</option>
					<option value="1800000" >1/2 Hora</option>
				 </select>
				</div>
			  </div>	
			  
			  <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-9">
				  <select class="form-control" id="estado" required name="estado">
				  	<option value="1" >Activo</option>
					<option value="0" >Inactivo</option>					
				 </select>
				</div>
			  </div>
			  
			  <div class="form-group">
			  <div id='loader'></div>
			  <div class='outer_div'></div>
				<div class="col-sm-offset-3 col-sm-9">				  
				  <button type="submit" class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i> Actualizar Datos</button>				  
				</div>
			  </div>
			</form>
			
			
			
		</div>
		<div class="col-md-5">
		 <h3 ><span class="glyphicon glyphicon-picture"></span> Imagen</h3>
		 
		 <form class="form-vertical">
		 
			<div class="form-group">
				
				<div class="col-sm-12">
				
				 
				 <div class="fileinput fileinput-new" data-provides="fileinput">
								  <div class="fileinput-new thumbnail" style="max-width: 100%;" >
									  <img class="img-rounded" src="./img/slider/<?php echo $imagen_demo;?>" />
								  </div>
								  <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 250px; max-height: 250px;"></div>
								  <div>
									<span class="btn btn-info btn-file"><span class="fileinput-new"><i class="fa-solid fa-upload"></i> Selecciona una Imagen</span>
									
									<span class="fileinput-exists" onclick="upload_image();"><i class="fa-solid fa-arrow-up-from-bracket"></i> Cambiar Imagen</span><input type="file" name="fileToUpload" id="fileToUpload" required onchange="upload_image();"></span>
									<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"><i class="fa-solid fa-ban"></i> Cancelar</a>
								  </div>

								  
					</div>
					<div class="upload-msg"></div>
					
				</div>
				<!-- <p class="text-primary text-center">Tamaño recomendado es de 900 x 500 píxeles.</p> -->
			  </div>
			  
			
			  
			 
			  
			  
		 </form>
		</div>
			
    </div> 
	</div><!-- /container -->

		<?php include("footer.php");?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="js/jasny-bootstrap.min.js"></script>
	
  </body>
</html>
	<script>
			function upload_image(){
				$(".upload-msg").text('Cargando...');
				var id_slide=$("#id_slide").val();
				var inputFileImage = document.getElementById("fileToUpload");
				var file = inputFileImage.files[0];
				var data = new FormData();
				data.append('fileToUpload',file);
				data.append('id',id_slide);
				
				$.ajax({
					url: "ajax/upload_slide.php",	// Url to which the request is send
					type: "POST",             		// Type of request to be send, called as method
					data: data, 			 		// Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       		// The content type used when sending data to the server.
					cache: false,             		// To unable request pages to be cached
					processData:false,        		// To send DOMDocument or non processed data file it is set to false
					success: function(data)   		// A function to be called if request succeeds
					{
						$(".upload-msg").html(data);
						window.setTimeout(function() {
						$(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
						$(this).remove();
						});	}, 5000);
					}
				});
				
			}
			
			function eliminar(id){
				var parametros = {"action":"delete","id":id};
						$.ajax({
							url:'ajax/upload2.php',
							data: parametros,
							 beforeSend: function(objeto){
							$(".upload-msg2").text('Cargando...');
						  },
							success:function(data){
								$(".upload-msg2").html(data);
								
							}
						})
					
				}
				
				
				
				
			
	</script>
	<script>
		$("#editar_slide").submit(function(e) {
			
			  $.ajax({
				  url: "ajax/editar_slide.php",
				  type: "POST",
				  data: $("#editar_slide").serialize(),
				   beforeSend: function(objeto){
					$("#loader").html("Cargando...");
				  },
				  success:function(data){
						$(".outer_div").html(data).fadeIn('slow');
						$("#loader").html("");
					}
			});
			 e.preventDefault();
		});
	</script>

	

