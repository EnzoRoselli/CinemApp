
    <div class="container">
        <?php
     
        foreach($moviesList as $movie){
            ?>
            <div class="block">
                <button class="card-image">
                    <a href="">
                    <img src=<?php echo "http://image.tmdb.org/t/p/w185/" . $movie->getPosterPath(); ?> class="image">
                    </a>                                        
                    <div class="overview">
                        <h2><?php echo $movie->getTitle();?></h2>
                    </div>
                </button>

            </div>
        <?php
        }
        ?>
    </div>
