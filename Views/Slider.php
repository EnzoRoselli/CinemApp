<?php 
    include('header.php');
    include('nav.php');
?>
<!-- <div class="slider-background">
            <img class="bg-image">
        </div> -->

<div class="slide-contenedor">
        
        <?php
        for($i=0; $i<3 ; $i++){
            ?>
        <div class="miSlider fade">
            <img src="<?php echo "http://image.tmdb.org/t/p/original/" . $moviesList[$i]->getPosterPath(); ?>">
            <p><?php echo $moviesList[$i]->getTitle(); ?></p>
        </div>
        <?php
        }
        ?>
        <div class="direcciones">
            <button href="#" class="atras" onclick="avanzaSlide(-1)">&#10094;</button>
            <button href="#" class="adelante" onclick="avanzaSlide(1)">&#10095;</button>
        </div>
        <div class="barras">
            <span class="barra active-bar" onclick="posicionSlide(1)"></span>
            <span class="barra" onclick="posicionSlide(2)"></span>
            <span class="barra" onclick="posicionSlide(3)"></span>
        </div>
    </div>
    <script src="<?php echo JS_PATH . "/slider.js"?>"></script>
