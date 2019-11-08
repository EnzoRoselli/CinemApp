<div class="container">
    <?php
    foreach ($moviesList as $movie) {
        $genres = $this->genresDAO->getGenresByMovieId($movie->getId());
        ?>
        <div class="block">
            <button class="card-image">
                <a href="">
                    <img src=<?php echo "http://image.tmdb.org/t/p/w185/" . $movie->getPosterPath(); ?> class="image">
                </a>
                <div class="movie-title">
                    <h2><?php echo $movie->getTitle(); ?></h2>
                </div>
               
                <div class="overlay-card">
                    <div class="overlay-card-background"></div>
                    <p><?php echo $genres[0]; ?></p>
                    <div class="movie-card-details">
                        <a href="">View Details</a> 
                    </div>
                </div>
            </button>
        </div>
    <?php
    }
    ?>
</div>