<?php
include('header.php');
include('nav.php');
?>

<div class="showtimes-list-container">
    <div class="header-titles">
        <p class="title-highlight">Movie</p>
        <p>Day</p>
        <p>Hour</p>
        <p>Cinema | Theater</p>
    </div>
    <div class="showtimes-list">
        <?php for ($i = 0; $i < count($moviesList); $i++) { ?>
            <div class="showtime-row">
                <div class="showtime-row-content">
                    <div class="movie-data">

                        <img src=<?= "http://image.tmdb.org/t/p/w185/" . $moviesList[$i]->getPosterPath(); ?> class="movie-data-image">

                        <div class="movie-data-details">
                            <div class="movie-details-content">
                                <p class="title-highlight"><?=$moviesList[$i]->getTitle()?></p>
                                <p><?= $moviesList[$i]->getReleaseDate(); ?></p>
                                <p><?= $moviesList[$i]->getDuration() . " min." ?></p>
                                <p><?= $genresByMovie[$i]; ?></p>
                            </div>
                            <div class="movie-content-actions">
                                <div class="movie-content-actions-item">
                                    <p>Overview</p>
                                    <a href=""><i class="fas fa-info-circle"></i></a>
                                </div>
                                <div class="movie-content-actions-item">
                                    <p>Tickets</p>
                                    <a href="<?php echo  FRONT_ROOT . "/Showtime/showOverview?movie=" .  $moviesList[$i]->getId() ?>"><i class="fas fa-ticket-alt"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="showtime-data">
                        <div class="showtime-data-items">
                            <p>Domingo 2</p>
                            <p>18:00</p>
                            <p>Aldrey | Sala Atmos</p>
                        </div>
                        <div class="showtime-data-items">
                            <p>Domingo 2</p>
                            <p>18:00</p>
                            <p>Aldrey | Sala Atmos</p>
                        </div>
                        <div class="showtime-data-items">
                            <p>Domingo 2</p>
                            <p>18:00</p>
                            <p>Aldrey | Sala Atmos</p>
                        </div>
                        <div class="showtime-data-items">
                            <p>Domingo 2</p>
                            <p>18:00</p>
                            <p>Aldrey | Sala Atmos</p>
                        </div>
                        <div class="showtime-data-items">
                            <p>Domingo 2</p>
                            <p>18:00</p>
                            <p>Aldrey | Sala Atmos</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>