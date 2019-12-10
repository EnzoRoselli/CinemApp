<?php
include('header.php');
include('nav.php');
?>

<div id="last-arrival-container">
    <div class="bg-image"></div>

    <div class="headline">

        <h2 class="headlight">Last Arrival</h2>

        <div class="outstanding-container">

            <div class="movie-img">
                <img src="http://image.tmdb.org/t/p/w780//zFYYFEhKS6JZvNW7gXeKeqnbcS7.jpg" alt="">
            </div>

            <div class="movie-data-arrival">
                <div class="movie-details">
                    <h3><?= $lastMovie->getTitle()?></h3>
                    <p><?= $lastMovie->getReleaseDate()?></p>
                </div>

                <div class="movie-overview">
                    <p><?=$lastMovie->getOverview()?></p>
                </div>

                <div class="movie-buttons">
                    <a class="btn-dark-md" href=<?=FRONT_ROOT . "/Showtime/showSelectShowtime/" . $lastMovie->getId()?>>See Showtimes</a>
                </div>
            </div>
        </div>
    </div>
</div>