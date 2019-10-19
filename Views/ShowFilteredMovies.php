<?php 
include('header.php');
    include('nav.php');
?>
    <div class="container">
    <?php

   
    for ($i = 0; $i < count($moviesWithGenres); $i++) {
    
        ?>
        <div class="block">
            <button class="card-image">
                <a href="">
                <img src=<?php echo "http://image.tmdb.org/t/p/w185/" . $moviesWithGenres[$i]->poster_path; ?> class="image">
                </a>
                
                
                <div class="overview">
                    <h2><?php echo $moviesWithGenres[$i]->original_title;?></h2>
                    <p><?php echo $moviesWithGenres[$i]->release_date;?></p>
                </div>
            </button>

        </div>
    <?php
    }
    ?>

</div>
   <?php      
        include('footer.php'); ?>
 