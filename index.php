<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
    
  include("db/conecta.php");        
  
  $sqld ="SELECT direccion, desdireccion,
          ROUND (TO_NUMBER(NVL(SUM(DECODE(TO_CHAR (fecha, 'MM'), '01', porcentaje))/COUNT(DECODE(TO_CHAR(fecha, 'MM'), '01', direccion)),0)),2) ENE,
          ROUND (TO_NUMBER(NVL(SUM(DECODE(TO_CHAR (fecha, 'MM'), '02', porcentaje))/COUNT(DECODE(TO_CHAR(fecha, 'MM'), '02', direccion)),0)),2) FEB,
          ROUND (TO_NUMBER(NVL(SUM(DECODE(TO_CHAR (fecha, 'MM'), '03', porcentaje))/COUNT(DECODE(TO_CHAR(fecha, 'MM'), '03', direccion)),0)),2) MAR,
          ROUND (TO_NUMBER(NVL(SUM(DECODE(TO_CHAR (fecha, 'MM'), '04', porcentaje))/COUNT(DECODE(TO_CHAR(fecha, 'MM'), '04', direccion)),0)),2) ABR,
          ROUND (TO_NUMBER(NVL(SUM(DECODE(TO_CHAR (fecha, 'MM'), '05', porcentaje))/COUNT(DECODE(TO_CHAR(fecha, 'MM'), '05', direccion)),0)),2) MAY,
          ROUND (TO_NUMBER(NVL(SUM(DECODE(TO_CHAR (fecha, 'MM'), '06', porcentaje))/COUNT(DECODE(TO_CHAR(fecha, 'MM'), '06', direccion)),0)),2) JUN,
          ROUND (TO_NUMBER(NVL(SUM(DECODE(TO_CHAR (fecha, 'MM'), '07', porcentaje))/COUNT(DECODE(TO_CHAR(fecha, 'MM'), '07', direccion)),0)),2) JUL,
          ROUND (TO_NUMBER(NVL(SUM(DECODE(TO_CHAR (fecha, 'MM'), '08', porcentaje))/COUNT(DECODE(TO_CHAR(fecha, 'MM'), '08', direccion)),0)),2) AGO,
          ROUND (TO_NUMBER(NVL(SUM(DECODE(TO_CHAR (fecha, 'MM'), '09', porcentaje))/COUNT(DECODE(TO_CHAR(fecha, 'MM'), '09', direccion)),0)),2) SEP,
          ROUND (TO_NUMBER(NVL(SUM(DECODE(TO_CHAR (fecha, 'MM'), '10', porcentaje))/COUNT(DECODE(TO_CHAR(fecha, 'MM'), '10', direccion)),0)),2) OCT,
          ROUND (TO_NUMBER(NVL(SUM(DECODE(TO_CHAR (fecha, 'MM'), '11', porcentaje))/COUNT(DECODE(TO_CHAR(fecha, 'MM'), '11', direccion)),0)),2) NOV,
          ROUND (TO_NUMBER(NVL(SUM(DECODE(TO_CHAR (fecha, 'MM'), '12', porcentaje))/COUNT(DECODE(TO_CHAR(fecha, 'MM'), '12', direccion)),0)),2) DIC
          FROM (SELECT TRIM (enca.direccion) DIRECCION, TRIM (dir.desdireccion) DESDIRECCION, TRUNC (enca.fecha_graba) FECHA, ROUND (SUM (deta.puntaje) / SUM (preg.puntaje) * 100, 2) PORCENTAJE
          FROM TB_METODO_5S met
          INNER JOIN TB_PREGUNTA_5S preg ON met.metodo = preg.metodo
          INNER JOIN TB_ENCA_EVALUA_5S enca
          ON preg.plantilla = enca.plantilla
          INNER JOIN TB_DETA_EVALUA_5S deta
          ON enca.evaluacion = deta.evaluacion
          INNER JOIN TB_DIRECCION_5S dir
          ON enca.direccion = dir.direccion
          INNER JOIN TB_GRUPO_5S gru ON enca.direccion = gru.direccion
          INNER JOIN TB_PERSONA_5S per ON     enca.direccion = per.direccion
          AND enca.persona = per.persona
          AND enca.grupo = gru.grupo
          AND enca.plantilla = deta.plantilla
          AND enca.direccion = deta.direccion
          AND preg.metodo = deta.metodo
          AND preg.pregunta = deta.pregunta
          AND enca.persona = deta.persona
          AND enca.fecha_graba = deta.fecha
          AND TO_CHAR (enca.fecha_graba, 'YYYY') = TO_CHAR (SYSDATE, 'YYYY')
          GROUP BY enca.direccion, dir.desdireccion, enca.fecha_graba)
          WHERE direccion NOT IN (8)
          GROUP BY direccion, desdireccion
          ORDER BY 1";                    

        $queryd = oci_parse($conecta,$sqld);
        oci_execute($queryd);

        $cadenad = [];

        while($datosd = oci_fetch_array($queryd)){                   
            $cadenad[]  = '{ name: "'.$datosd['DESDIRECCION'].'", data: ['.$datosd['ENE'].','.$datosd['FEB'].','.$datosd['MAR'].','.$datosd['ABR'].','.$datosd['MAY'].','.$datosd['JUN'].','
                                                                          .$datosd['JUL'].','.$datosd['AGO'].','.$datosd['SEP'].','.$datosd['OCT'].','.$datosd['NOV'].','.$datosd['DIC'].'] }';        
        }

        $cadenad = implode(',',$cadenad);
        

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablero 5's</title>

    <link rel="stylesheet" href="css/estilo.css">        

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap523.css" rel="stylesheet"/>    

    <!-- Bootstrap JS -->
    <script src="js/bootstrap523.js"></script>

    <!-- Apex Charts -->
    <script src="chart/apexcharts.js"></script>        

     
</head>
<body>    

    <div class="contenedor">

    <div class="titulo contenedor-titulo">
            <img src="img/titulo.png" class="img-titulo" alt="Titulo">
        </div>
        <div class="logo contenedor-logo">
            <img src="img/logo.png" class="img-logo" alt="Logo">
        </div>
        <div class="grafica">
            <div id="chart"></div>
        </div>
        <div class="informacion">            
            <img src="img/slider/info.jpg" class="img-informacion" alt="Información">
        </div>
        

        <div class="carrusel">

            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">

              <?php			
                include ("config/conexion.php");                             
					      $sql_slider=oci_parse($conecta,"SELECT * FROM TB_CARRUSEL WHERE estado=1 AND imagen !='info.jpg' ORDER BY orden");
					      $nums_slides=oci_num_rows($sql_slider);						
					      oci_execute($sql_slider);					
				      ?>            

                <div class="carousel-inner">

                  <?php
                    $active="active";					
                    while ($rw_slider=oci_fetch_array($sql_slider)){
                  ?>
                      <div class="carousel-item <?php echo $active;?>" data-bs-interval="<?php echo $rw_slider['TIEMPO'];?>">                         
                        <img src="img/slider/<?php echo $rw_slider['IMAGEN'];?>" class="img-carrusel" alt="Imágenes">                   
                      </div>
                  <?php
                      $active="";
                  }
                  ?>      
                </div>  
            </div>            
        </div>

        
     
    </div>   

<!-- Custom Apex Charts -->    
<script>

  var options = {
      series: [<?php echo $cadenad; ?>],
      chart: {
        animations: {
          enabled: false,
          easing: 'linear',
          speed: 800,
          animateGradually: {
            enabled: true,
            delay: 150
          },
            dynamicAnimation: {
              enabled: true,
              speed: 350
            },
    },
        height: '100%',
        type: 'line',
        dropShadow: {
        enabled: true,
        color: '#000',
        top: 18,
        left: 7,
        blur: 10,
        opacity: 0.2            
      },
      toolbar: {
        show: false
      }
    },
    colors: ['#93D50A','#070F9E','#F7941D','#F4313F','#92278F','#00A79D','#FFF200','#00AEEF'], //#82684E, #FFF200
    dataLabels: {
      enabled: false,
    },
    stroke: {
      curve: 'straight' //straight, smooth, stepline
    },
    title: {
      text: "5's",
      align: 'left',
      margin:  0,
      offsetX: 0,
      offsetY: 0,
      floating: false,
      style: {
        fontSize:  '14px',
        fontWeight:  'bold',
        fontFamily:  'Arial',
        color:  '#FFFFFF'
},
    },
    grid: {
      borderColor: '#E7E7E7',
      row: {
        colors: ['#F3F3F3', 'transparent'], // takes an array which will be repeated on columns
        opacity: 0.5
      },
      padding: {
        left: 20,
        right: 20
        },
    },
    markers: {
      size: 6
    },
    xaxis: {
      categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
      title: {
        text: '', //Meses
        style: {
            fontSize: '16px',                           
            fontFamily:  'Arial',
            color:  '#CCCCCC'
        },
      },
      labels: {
        style: {
            fontSize: '16px',
            fontWeight:  'bold',
        },
      },
    },
    yaxis: {
      title: {
        text: '', //Porcentaje
        style: {
            fontSize: '16px',                           
            fontFamily:  'Arial',
            color:  '#CCCCCC'
        },
      },
      labels: {
        style: {
            fontSize: '14px',
            fontWeight:  'bold',
        },
   },
      min: 0,
      max: 100
    },
    legend: {
      position: 'top',
      horizontalAlign: 'center',
      floating: true,
      offsetY: -25, //-25
      offsetX: 0,    //-5
      fontSize: '13px',
      fontWeight:  'bold',
    }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
  
</script>        

</body>
</html>

<?php
    oci_close($conecta);    
?>
