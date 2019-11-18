<?php
include('header.php');
include('nav.php');
?>

<div class="showtimes-list-container">
<form action="<?= FRONT_ROOT . '/Filters/FilterMovies' ?>" method="POST">
        <div class="showtimes-list-filters">
            <select name="genre" id="">
                <option type="text" value="" selected>Select Genre</option>
                <?php foreach ($genresList as $genre) { ?>
                    <option value="<?= $genre->getId(); ?>"><?= $genre->getName(); ?></option>
                <?php } ?>
            </select>
  
                <input type="date" name="date" min="<?= date('Y-m-d'); ?>">
      
            <button type="submit" class="buy-btn" id="search-filters">Search</button>
        </div>

    </form>

    <?php if (!empty($messages)) {
	foreach ($messages as $message) ?>
	<div class="message-container" id="message-container">
		<div class="message-content">
			<p><?= $message ?></p>
			<button id="button-close">Close</button>
		</div>
	</div>
	<script src="<?= JS_PATH . "/message.js" ?>"></script>
	<script>
		openMessage();
	</script>
<?php } ?>
    
        <?php for ($i = 0; $i < count($moviesList); $i++) {   ?>
            <div class="showtime-row">
                <div class="showtime-row-content">
                    <div class="movie-data">

                        <img src=<?= "http://image.tmdb.org/t/p/w185/" . $moviesList[$i]->getPosterPath(); ?> class="movie-data-image">

                        <div class="movie-data-details">
                            <div class="movie-details-content">
                                <p class="title-highlight"><?= $moviesList[$i]->getTitle() ?></p>
                                <p><?= $moviesList[$i]->getReleaseDate(); ?></p>
                                <p><?= $moviesList[$i]->getDuration() . " min." ?></p>
                                <p><?= $genresByMovie[$i]; ?></p>
                            </div>
                            <div class="movie-content-actions">
                                <div class="movie-content-actions-item">
                                    <p>Tickets</p>
                                    <a href="<?php echo  FRONT_ROOT . "/Showtime/showSelectShowtime/" .  $moviesList[$i]->getId() ?>"><i class="fas fa-ticket-alt fa-2x"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="showtime-data">
                        <?php foreach ($showtimesList as $showtime) {
                                if ($showtime->getMovie()->getTitle() == $moviesList[$i]->getTitle() && $showtime->getTheater()->getActive() == true && $showtime->getActive() == true) { ?>
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