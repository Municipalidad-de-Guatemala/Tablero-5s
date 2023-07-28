<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$title="Configuración Tablero 5's";
/* Llamar la Cadena de Conexion*/ 
include ("config/conexion.php");
$active="active";

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $title;?></title>

    <!-- Latest compiled and minified CSS -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"> -->
	<link rel="stylesheet" href="css/bootstrap336.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	
	 
	
  </head>
  <body>
  <?php include("top_menu.php");?>
  <br/><br/><br/>

  
    <div class="row-fluid">
    <div class="container">
        <!-- <div class="col-xs-12 col-sm-6 col-md-6 col-lg-9"> -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div id="carousel-example-captions" class="carousel slide" data-ride="carousel"> 
				<?php					
					$sql_slider=oci_parse($conecta,"SELECT * FROM TB_CARRUSEL WHERE estado=1 AND imagen!='info.jpg' ORDER BY orden");
					$nums_slides=oci_num_rows($sql_slider);						
					oci_execute($sql_slider);					
				?>
					<ol class="carousel-indicators">
						<?php 
						for ($i=0; $i<$nums_slides; $i++){
							$active="active";
							?>
							<li data-target="#carousel-example-captions" data-slide-to="<?php echo $i;?>" class="<?php echo $active;?>"></li>
							<?php
							$active="";							
						}
						?>
						
					</ol> 
				<div class="carousel-inner" role="listbox"> 
				<?php
					$active="active";					
					while ($rw_slider=oci_fetch_array($sql_slider)){
				?>
						<div class="item <?php echo $active;?>"> 
							<img data-src="holder.js/900x500/auto/#777:#777" alt="900x500" src="img/slider/<?php echo $rw_slider['IMAGEN'];?>" data-holder-rendered="true"> 
							<div class="carousel-caption"> 
							
								<h2><?php echo $rw_slider['TITULO'];?></h2>
								<h3><?php echo $rw_slider['DESCRIPCION'];?></h3>
								
							</div> 
						</div>
						<?php
						$active="";
					}
				?>
					
					 
					
				</div> 				
				<a class="left carousel-control"  href="#carousel-example-captions" role="button" data-slide="prev"> <span class="fa-solid fa-caret-left fa-xl"  aria-hidden="true"></span> <span class="sr-only">Anterior</span> </a> 
				<a class="right carousel-control" href="#carousel-example-captions" role="button" data-slide="next"> <span class="fa-solid fa-caret-right fa-xl" aria-hidden="true"></span> <span class="sr-only">Siguiente</span> </a> 

				

			</div>
        </div>		

          
    </div>
	
</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
	<script src="js/jquery1113.js"></script>
    <!-- Latest compiled and minified JavaScript -->
	<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script> -->
	<script src="js/bootstrap336.js"></script>
	
  </body>
</html>

