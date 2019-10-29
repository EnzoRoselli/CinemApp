<?php 
include('header.php');
    // include('nav.php');
?>
    <div class="container">
    <?php

   if(!empty($moviesWithGenres)){

       for ($i = 0; $i < count($moviesWithGenres); $i++) {

           ?>
        <div class="block">
            <button class="card-image">
                <a href="">
                <img src=<?php echo "http://image.tmdb.org/t/p/w185/" . $moviesWithGenres[$i]->poster_path; ?> class="image">
                </a>
                
                
                <div class="overview">
                    <h2><?php echo $moviesWithGenres[$i]->original_title;?></h2>
                    <p><?php /*echo $moviesWithGenres[$i]->release_date;*/?></p>
                </div>
            </button>

        </div>
    <?php
        }
    }
    ?>

    <?php

    if(!empty($showtimesByDate)){

        for ($i = 0; $i < count($showtimesByDate); $i++) {

        ?>
        <div class="block">
            <button class="card-image">
                <a href="">
                <img src=<?php echo  "http://image.tmdb.org/t/p/w185/" . $showtimesByDate[$i]->getMovie()->getPosterPath(); ?> class="image">
                </a>
                
                
                <div class="overview">
                    <h2><?php echo $showtimesByDate[$i]->getMovie()->getTitle();?></h2>
                    <p><?php echo $showtimesByDate[$i]->getCinema()->getName(); ?></p>
                </div>
            </button>

        </div>
    <?php
        }
    }
    ?>

</div>
   <?php      
        include('footer.php'); ?>
 