<?php
include('header.php');
include('nav.php');
?>

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
                <div class="showtime-details-content">
                    <div class="showtime-details-content-left">
                        <p>Day: 02/10/2019</p>
                        <p>Hour: 18-00</p>
                        <p>Language: Russian</p>
                        <p>Subtitles: No</p>
                    </div>
                    <div class="showtime-details-content-right">
                        <p>Cinema: Aldrey</p>
                        <p>Theater: Atmos</p>
                        <p>Address: Sarmiento 2685</p>
                    </div>
                </div>
                <div class="showtime-main-buttons">
                    <a href="" class="showtime-main-buttons-buy">BUY</a>
                </div>
            </div>
            <div class="shotime-main-row">
                <div class="showtime-details-content">
                    <div class="showtime-details-content-left">
                        <p>Day: 02/10/2019</p>
                        <p>Hour: 18-00</p>
                        <p>Language: Russian</p>
                        <p>Subtitles: No</p>
                    </div>
                    <div class="showtime-details-content-right">
                        <p>Cinema: Aldrey</p>
                        <p>Theater: Atmos</p>
                        <p>Address: Sarmiento 2685</p>
                    </div>
                </div>
                <div class="showtime-main-buttons">
                    <a href="" class="showtime-main-buttons-buy">BUY</a>
                </div>
            </div>
            <div class="shotime-main-row">
                <div class="showtime-details-content">
                    <div class="showtime-details-content-left">
                        <p>Day: 02/10/2019</p>
                        <p>Hour: 18-00</p>
                        <p>Language: Russian</p>
                        <p>Subtitles: No</p>
                    </div>
                    <div class="showtime-details-content-right">
                        <p>Cinema: Aldrey</p>
                        <p>Theater: Atmos</p>
                        <p>Address: Sarmiento 2685</p>
                    </div>
                </div>
                <div class="showtime-main-buttons">
                    <a href="" class="showtime-main-buttons-buy">BUY</a>
                </div>
            </div>
            <div class="shotime-main-row">
                <div class="showtime-details-content">
                    <div class="showtime-details-content-left">
                        <p>Day: 02/10/2019</p>
                        <p>Hour: 18-00</p>
                        <p>Language: Russian</p>
                        <p>Subtitles: No</p>
                    </div>
                    <div class="showtime-details-content-right">
                        <p>Cinema: Aldrey</p>
                        <p>Theater: Atmos</p>
                        <p>Address: Sarmiento 2685</p>
                    </div>
                </div>
                <div class="showtime-main-buttons">
                    <a href="" class="showtime-main-buttons-buy">BUY</a>
                </div>
            </div>
            <div class="shotime-main-row">
                <div class="showtime-details-content">
                    <div class="showtime-details-content-left">
                        <p>Day: 02/10/2019</p>
                        <p>Hour: 18-00</p>
                        <p>Language: Russian</p>
                        <p>Subtitles: No</p>
                    </div>
                    <div class="showtime-details-content-right">
                        <p>Cinema: Aldrey</p>
                        <p>Theater: Atmos</p>
                        <p>Address: Sarmiento 2685</p>
                    </div>
                </div>
                <div class="showtime-main-buttons">
                    <a href="" class="showtime-main-buttons-buy">BUY</a>
                </div>
            </div>
            <div class="shotime-main-row">
                <div class="showtime-details-content">
                    <div class="showtime-details-content-left">
                        <p>Day: 02/10/2019</p>
                        <p>Hour: 18-00</p>
                        <p>Language: Russian</p>
                        <p>Subtitles: No</p>
                    </div>
                    <div class="showtime-details-content-right">
                        <p>Cinema: Aldrey</p>
                        <p>Theater: Atmos</p>
                        <p>Address: Sarmiento 2685</p>
                    </div>
                </div>
                <div class="showtime-main-buttons">
                    <a href="" class="showtime-main-buttons-buy">BUY</a>
                </div>
            </div>
        </div>

    </div>
</div>