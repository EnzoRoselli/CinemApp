
    <div class="container">
        <?php

        use DAO\InfoAPI\moviesAPI as moviesAPI;
      $movies = moviesAPI::getMoviesFromApi();
        

        for ($i = 0; $i < count($movies); $i++) {
            $poster = $movies[$i]->poster_path;
            ?>
            <div class="block">
                <button class="card-image">
                    <a href="">
                    <img src=<?php echo "http://image.tmdb.org/t/p/w185/" . $poster; ?> class="image">
                    </a>
                    
                    
                    <div class="overview">
                        <h2><?php echo $movies[$i]->original_title;?></h2>
                        <p><?php echo $movies[$i]->release_date;?></p>
                    </div>
                </button>

            </div>
        <?php
        }
        ?>

    </div>
