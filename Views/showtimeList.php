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
                                    <a href="<?php echo  FRONT_ROOT . "/Showtime/showSelectShowtime?movie=" .  $moviesList[$i]->getId() ?>"><i class="fas fa-info-circle"></i></a>
                                </div>
                                <div class="movie-content-actions-item">
                                    <p>Tickets</p>
                                    <a href="<?php echo  FRONT_ROOT . "/Showtime/showSelectShowtime?movie=" .  $moviesList[$i]->getId() ?>"><i class="fas fa-ticket-alt"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="showtime-data">
                        <?php foreach ($showtimesList as $showtime) {
                            if ($showtime->getMovie()->getTitle() == $moviesList[$i]->getTitle() && $showtime->getTheater()->getActive()==true) { ?>
                                <div class="showtime-data-items">
                            <p><?= $showtime->getDate(); ?></p>
                            <p><?= $showtime->getHour(); ?></p>
                            <p><?= $showtime->getTheater()->getCinema()->getName(); ?> | <?= $showtime->getTheater()->getName(); ?></p>
                        </div>
                         <?php  } ?>
                            
                        <?php } ?>
                        
                       
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>