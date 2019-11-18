<?php
include('header.php');
include('nav.php');
?>
<div class="container">
    <?php var_dump($moviesList);
    for ($i=0; $i < count($moviesList); $i++) { 
        ?>
        <div class="block">
            <button class="card-image">
                <a href="">
                    <img src=<?="http://image.tmdb.org/t/p/w185/" . $moviesList[$i]->getPosterPath(); ?> class="image">
                </a>
                <div class="movie-title">
                    <h2><?=$moviesList[$i]->getTitle(); ?></h2>
                </div>
               
                <div class="overlay-card">
                    <div class="overlay-card-background"></div>
                    <p><?=$genresByMovie[$i]; ?></p>
                    <div class="movie-card-details">
                        <a href="<?php echo  FRONT_ROOT . "/Showtime/showSelectShowtime?movie=" . $moviesList[$i]->getId() ?>">View Details</a> 
                    </div>
                </div>
            </button>
        </div>
    <?php
    }
    ?>
</div>