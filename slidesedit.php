<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$title="Editar Slide";
/* Llamar la Cadena de Conexion*/ 
include ("config/conexion.php");
//Insert un nuevo producto
$imagen_demo="noimagen.jpg";
$id_slide=intval($_GET['id']);
// $sql=mysqli_query($con,"select * from slider where id='$id_slide' limit 0,1");
$sql=oci_parse($conecta,"SELECT * FROM TB_CARRUSEL WHERE id='$id_slide'");
$count=oci_num_rows($sql);
oci_execute($sql);

//  if ($count==0){
//  	header("location: sliderslist.php");
//  	exit;
//  }

$rw=oci_fetch_array($sql);

$titulo=$rw['TITULO'];
$descripcion=$rw['DESCRIPCION'];
// $texto_boton=$rw['texto_boton'];
// $url_boton=$rw['url_boton'];
// $estilo_boton=$rw['estilo_boton'];
$url_image=$rw['IMAGEN'];
$tiempo=intval($rw['TIEMPO']);
$orden=intval($rw['ORDEN']);
$estado=intval($rw['ESTADO']);
$active_config="active";
$active_slider="active";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
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
  
		<!-- <ol class="breadcrumb">
		  <li><a href="sliderslist.php">Slider</a></li>
		  <li class="active">Editar</li>
		</ol> -->
		 <div class="col-md-7">
		 <h3 ><span class="glyphicon glyphicon-edit"></span> Editar slide</h3>
			<form class="form-horizontal" id="editar_slide">
				 
			 
			  
			  <div class="form-group">
				<label for="titulo" class="col-sm-3 control-label">Titulo</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="titulo" value="<?php echo $titulo;?>" required name="titulo" autofocus="">
				  <input type="hidden" class="form-control" id="id_slide" value="<?php echo intval($id_slide);?>" name="id_slide">
				</div>
			  </div>
			  
			 <div class="form-group">
				<label for="descripcion" class="col-sm-3 control-label">Descripción</label>
				<div class="col-sm-9">
				  <textarea class="form-control " rows="2" id="descripcion" required name="descripcion"><?php echo $descripcion;?></textarea>
				</div>
			  </div>

			  <div class="form-group">
				<label for="orden" class="col-sm-3 control-label">Orden</label>
				<div class="col-sm-9">
				  <input type="number" class="form-control" id="orden" name="orden" value="<?php echo $orden;?>">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Tiempo</label>
				<div class="col-sm-9">
				  <select class="form-control" id="tiempo" required name="tiempo">			

				    <option value="0"        <?php echo ($tiempo == "15000")   ? 'selected = "selected"' : '' ;?> >Sin Tiempo</option>
					<option value="15000"   <?php echo ($tiempo == "15000")   ? 'selected = "selected"' : '' ;?> >15 Segundos</option>
					<option value="30000"   <?php echo ($tiempo == "30000")   ? 'selected = "selected"' : '' ;?> >30 Segundos</option>
					<option value="60000"   <?php echo ($tiempo == "60000")   ? 'selected = "selected"' : '' ;?> >1 Minuto</option>
					<option value="300000"  <?php echo ($tiempo == "300000")  ? 'selected = "selected"' : '' ;?> >5 Minutos</option>
					<option value="900000"  <?php echo ($tiempo == "900000")  ? 'selected = "selected"' : '' ;?> >15 Minutos</option>
					<option value="1800000" <?php echo ($tiempo == "1800000") ? 'selected = "selected"' : '' ;?> >1/2 Hora</option>

				 </select>
				</div>
			  </div>	
			  
			  <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-9">
				  <select class="form-control" id="estado" required name="estado">

				  <option value="1" <?php echo ($estado == "1") ? 'selected = "selected"' : '' ;?> >Activo</option>
				  <option value="0" <?php echo ($estado == "0") ? 'selected = "selected"' : '' ;?> >Inactivo</option>				  	

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
									  <img class="img-rounded" src="./img/slider/<?php echo $url_image;?>" />
									  <!-- <input type="text" class="form-control" id="img" name="img" value="<?php echo $url_image;?>" readonly="">  -->
									  
								  </div>
								  <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 250px; max-height: 250px;"></div>
								  <div>
									<!-- <span class="btn btn-info btn-file"><span class="fileinput-new">Selecciona una imagen</span> -->
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
					url: "ajax/upload_slide.php",   // Url to which the request is send
					type: "POST",             		// Type of request to be send, called as method
					data: data, 			  		// Data sent to server, a set of key/value pairs (i.e. form fields and values)
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

	

