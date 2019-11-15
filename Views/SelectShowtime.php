<?php
include('header.php');
include('nav.php');
?>
<div class="back-to-list">
    <a href=<?= FRONT_ROOT . "/Showtime/showShowtimesListUser" ?> id="back-to-list"><i class="fas fa-chevron-left"></i>Back to List</a>

</div>

<div class="movie-overwiew-container">

    <div class="overview-right-panel">
        <img src=<?= "http://image.tmdb.org/t/p/original/" . $movie->getPosterPath(); ?> class="overview-right-panel-image">
    </div>
    <div class="overview-left-panel">

        <div class="movie-overview-details">
            <h2 class="overview-movie-title"><?= $movie->getTitle() ?></h2>
            <p><?= $movie->getDuration() . " min." ?></p>
        </div>
        <div class="overview-text">
            <p><?= $movie->getOverview() ?></p>
        </div>
        <div class="showtime-main">
            <div class="shotime-main-row">
            
            <?php foreach ($movieShowtimes as $showtime) {
                            if ($showtime->getMovie()->getTitle()==$movie->getTitle() && $showtime->getTheater()->getActive()==true && $showtime->getTicketAvaliable()>0) { ?>
            
                <div class="showtime-details-content">
                    <div class="showtime-details-content-left">
                        <p>Day: <?= $showtime->getDate();?></p>
                        <p>Hour: <?= $showtime->getHour();?></p>
                        <p>Language: <?= $showtime->getLanguage()->getName();?></p>
                        <p>Subtitles: <?= $showtime->isSubtitle();?></p>
                    </div>
                    <div class="showtime-details-content-right">
                        <p>Cinema: <?= $showtime->getTheater()->getCinema()->getName();?></p>
                        <p>Theater: <?= $showtime->getTheater()->getName();?></p>
                        <p>Address: <?= $showtime->getTheater()->getCinema()->getAddress();?></p>
                    </div>
                </div>
                <div class="showtime-main-buttons">
                    <a href="<?=FRONT_ROOT . "/Showtime/showBuy/". $showtime->getShowtimeId() ?>" class="showtime-main-buttons-buy">BUY</a>
                </div>
           
            <?php  } } ?>                     
            
            </div>
        </div>

    </div>
</div>

