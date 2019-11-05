
    <div class="container">
        <?php
        foreach($moviesList as $movie){
            ?>
            <div class="block">
                <button class="card-image">
                    <a href="">
                    <img src=<?php echo "http://image.tmdb.org/t/p/w185/" . $movie->getPosterPath(); ?> class="image">
                    </a>                                        
                    <div class="movie-title">
                        <h2><?php echo $movie->getTitle();?></h2>
                    </div>
                </button>
                <div class="overlay-card">
                    <div class="overlay-card-background"></div>
                    <p>Drama</p>
                    <button>View Details</button>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
