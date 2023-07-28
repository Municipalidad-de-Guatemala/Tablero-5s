<!-- Fixed navbar -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<nav class="navbar navbar-light navbar-fixed-top"  style="background-color: #cccccc;">
   <div class="container">
      <div class="navbar-header">
         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Navegación de Palanca</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
         </button>
      </div>

      <div id="navbar" class="navbar-collapse collapse">
         <ul class="nav navbar-nav">
            <li class="<?php if (isset($active)){echo $active;}?>">
               <a href="configura.php"><i class="fa-solid fa-film fa-xl"></i> Carrusel</a>
            </li>
            <li class="<?php if (isset($active)){echo $active;}?>">
               <a href="sliderslist.php"><i class="fa-solid fa-photo-film fa-xl"></i> Imágenes</a>
            </li>
         </ul>
      </div>
   </div>
</nav>