<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" >
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* Llamar la Cadena de Conexion*/ 
include ("../config/conexion.php");
$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

if($action == 'ajax'){
	//Elimino datos
	if (isset($_REQUEST['id'])){
		$id_slide=intval($_REQUEST['id']);

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


		if ($delete=oci_parse($conecta,"DELETE FROM TB_CARRUSEL WHERE id='$id_slide'")){
			oci_execute($delete);
			$message= "Datos eliminados satisfactoriamente";	
		}else{
			$error= "No se pudo eliminar los datos";
		}
	}	
	
	$tables="TB_CARRUSEL";
	$sWhere=" ";
	$sWhere.=" ";
	
	
	$sWhere.=" ORDER BY orden";
	//include pagination file
	// include 'pagination.php'; 
	//pagination variables
	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	$per_page = 12; //how much records you want to show
	$adjacents  = 4; //gap between pages after number of adjacents
	$offset = ($page - 1) * $per_page;
	
	//Count the total number of row in your table*/
	// $count_query   = mysqli_query($con,"SELECT COUNT(*) AS numrows FROM $tables  $sWhere ");	
	// $sql_slider=oci_parse($con,"SELECT * FROM TB_CARRUSEL WHERE estado=1 ORDER BY orden");
	$count_query   = oci_parse($conecta,"SELECT COUNT(*) numrows FROM $tables  $sWhere ");
	oci_execute($count_query);

	if ($row= oci_fetch_array($count_query)){
		$numrows = $row['NUMROWS'];	
	}
	else {echo oci_error($conecta);}
	$total_pages = ceil($numrows/$per_page);
	$reload = './productslist.php';
	//main query to fetch the data
	// $query = mysqli_query($con,"SELECT * FROM  $tables  $sWhere LIMIT $offset,$per_page");
	// $query = oci_parse($con,"SELECT * FROM  $tables  $sWhere LIMIT $offset,$per_page");
	// $query = oci_parse($conecta,"SELECT * FROM  $tables WHERE rownum <=12 $sWhere");
	$query = oci_parse($conecta,"SELECT id, titulo, descripcion, imagen, tiempo, orden, estado, 
								DECODE(tiempo,0,'Sin Tiempo',15000,'15 Segundos',30000,'30 Segundos',60000,'1 Minuto',300000,'5 Minutos',900000,'15 Minutos',1800000,'1/2 Hora') dtiempo,
								DECODE(estado,0,'Inactivo',1,'Activo') destado
								FROM  $tables $sWhere");
	oci_execute($query);
	
	if (isset($message)){
		?>
			<div id="alert" class="alert alert-success alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				<strong>Aviso!</strong> <?php echo $message;?>
			</div>		
		<?php
		}
	if (isset($error)){
		?>
		<div id="alert" class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<strong>Error!</strong> <?php echo $error;?>
		</div>
		
		<?php
	}
	//loop through fetched data
	if ($numrows>0)	{
		?>

	<link rel="stylesheet" href="css/imagenes.css">

	<div class="container">	
	<div class="row display-flex">			

			<?php
				while($row = oci_fetch_array($query)){
					$url_image=$row['IMAGEN'];
					$titulo=$row['TITULO'];
					$descripcion=$row['DESCRIPCION'];
					$id_slide=$row['ID'];
					$tiempo = $row['TIEMPO'];
					$dtiempo = $row['DTIEMPO'];
					$estado = $row['ESTADO'];		
					$destado = $row['DESTADO'];			
					
					if($estado==0){
						$color = 'red';					
					}elseif($estado==1){
						$color = 'green';						
					}


					?>
					
					<div class="col-xs-6 col-sm-6 col-md-3" style="margin-top: 10px;">				

						<div class="thumbnail">
							<img id="<?php echo $url_image;?>" src="img/slider/<?php echo $url_image;?>" alt="Imágenes" style="cursor: zoom-in;">
							<div class="caption">
								<hr/>
								
								<h4><?php echo $titulo;?></h4>
								<!-- <h5><?php echo $descripcion;?></h5> -->
								<h5><?php echo $dtiempo;?></h5>																									
								<h4 style="font-style: italic; color: <?php echo $color;?>"><?php echo $destado;?></h4>
								<hr/>	
								<div>							
								<p class='text-center'><a href="slidesedit.php?id=<?php echo intval($id_slide);?>" class="btn btn-info" role="button"><i class='fa-solid fa-pen-to-square'></i> Editar</a> 
									<button type="button" class="btn btn-danger" onclick="eliminar_slide('<?php echo $id_slide;?>');" role="button"><i class='fa-solid fa-trash-can'></i> Eliminar</button>
								</p>							
								</div>							
						  	</div>
						</div>

						<div id="myModal" class="modal">
							<img class="modal-content" id="img01" width="1000" height="800" style="cursor: zoom-out;">
						</div>				
					
					<script>
						// Get the modal
						var modal = document.getElementById('myModal');

						// Get the image and insert it inside the modal - use its "alt" text as a caption
						var img = document.getElementById('<?php echo $url_image;?>');
						var modalImg = document.getElementById("img01");
						// var captionText = document.getElementById("caption");
						img.onclick = function(){
						modal.style.display = "block";
						modalImg.src = this.src;
						modalImg.alt = this.alt;
						// captionText.innerHTML = this.alt;
						}


						// When the user clicks on <span> (x), close the modal
						modal.onclick = function() {
						img01.className += " out";
						setTimeout(function() {
						modal.style.display = "none";
						img01.className = "modal-content";
						}, 500);

						}    

					</script>						

		</div>
					
					<?php
				}
			?>



		

			<script type="text/javascript">	
				setTimeout(function(){
				// Closing the alert
				$('#alert').alert('close');
				}, 5000);
			</script>			

		  </div>
		  </div>
		
		<div class="table-pagination text-right">
			<!-- Paginacion -->
			<!-- <?php echo paginate($reload, $page, $total_pages, $adjacents);?> -->

		</div>
		<?php
	}
}
?>


