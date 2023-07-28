<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$title="Configuración Tablero 5's";
/* Llamar la Cadena de Conexion*/ 
include ("config/conexion.php");
$active="active";

$sql_img=oci_parse($conecta,"DELETE FROM TB_CARRUSEL WHERE imagen='noimagen.jpg'");
oci_execute($sql_img);


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

	<link rel="stylesheet" href="css/bootstrap336.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom styles for this template -->
    <link href="css/navbar-fixed-top.css" rel="stylesheet">
  </head>
  <body>
	<?php include("top_menu.php");?>
	
    <div class="container">
		
      
      <div class="row">	   	  
	
			<div class="row">
			  <div class="col-xs-12 text-right">
				  <a href='slidesadd.php' class="btn btn-warning" ><span class="fa-solid fa-circle-plus fa-xl"></span> Agregar Slide</a>
				  <hr/>
			  </div>
			</div>			
		  
		  <br>
		  <div id="loader" class="text-center"> <span><img src="./img/ajax-loader.gif"></span></div>
		  <!-- Datos ajax Final -->
		  
		  <div class="outer_div"></div>
		  <hr/>
	  </div>

    </div> <!-- /container -->
	
	<?php include("footer.php");?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
	<script src="js/jquery1113.js"></script>
    <!-- Latest compiled and minified JavaScript -->
	<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script> -->
	<script src="js/bootstrap336.js"></script>
  </body>
</html>
<script>
	$(document).ready(function(){
		load(1);
	});
	function load(page){
		var parametros = {"action":"ajax","page":page};
		$.ajax({
			url:'./ajax/slider_ajax.php',
			data: parametros,
			 beforeSend: function(objeto){
			$("#loader").html("<img src='./img/ajax-loader.gif'>");
		  },
			success:function(data){
				$(".outer_div").html(data).fadeIn('slow');
				$("#loader").html("");
			}
		})
	}
	function eliminar_slide(id){
		page=1;
		var parametros = {"action":"ajax","page":page,"id":id};
		if(confirm('Esta acción  eliminará de forma permanente el slide \n\n Desea continuar?')){
		$.ajax({
			url:'./ajax/slider_ajax.php',
			data: parametros,
			 beforeSend: function(objeto){
			$("#loader").html("<img src='./img/ajax-loader.gif'>");
		  },
			success:function(data){
				$(".outer_div").html(data).fadeIn('slow');
				$("#loader").html("");
			}
		})
	}
	}
</script>