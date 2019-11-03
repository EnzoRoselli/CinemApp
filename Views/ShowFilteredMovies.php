<?php
include('header.php');
include('nav.php');
?>

<?php

if (!empty($comprobationMovie)) {

    ?>
    <div class="container">
        <div class="block">
            <button class="card-image">
                <a href="">
                    <img src=<?php echo "http://image.tmdb.org/t/p/w185/" . $comprobationMovie->getPosterPath(); ?> class="image">
                </a>
                <div class="overview">
                    <h2><?php echo $comprobationMovie->getTitle(); ?></h2>
                    <p><?php echo $comprobationMovie->getReleaseDate(); ?></p>
                </div>
            </button>
        </div>
    </div>
<?php

}
?>

<div class="container">
    <?php

    if (!empty($moviesByGenres)) {

        for ($i = 0; $i < count($moviesByGenres); $i++) {

            ?>
            <div class="block">
                <button class="card-image">
                    <a href="">
                        <img src=<?php echo "http://image.tmdb.org/t/p/w185/" . $moviesByGenres[$i]->getPosterPath(); ?> class="image">
                    </a>
                    <div class="overview">
                        <h2><?php echo $moviesByGenres[$i]->getTitle(); ?></h2>
                        <p><?php /*echo $moviesWithGenres[$i]->release_date;*/ ?></p>
                    </div>
                </button>

            </div>
    <?php
        }
    }
    ?>
    <div>

        <div class="container">
            <?php

            if (!empty($showtimesByDate)) {

                for ($i = 0; $i < count($showtimesByDate); $i++) {
                    ?>
                    <div class="block">
                        <button class="card-image">
                            <a href="">
                                <img src=<?php echo  "http://image.tmdb.org/t/p/w185/" . $showtimesByDate[$i]->getMovie()->getPosterPath(); ?> class="image">
                            </a>
                            <div class="overview">
                                <h2><?php echo $showtimesByDate[$i]->getMovie()->getTitle(); ?></h2>
                                <p><?php echo $showtimesByDate[$i]->getCinema()->getName(); ?></p>
                            </div>
                        </button>
                    </div>
            <?php
                }
            }
            ?>
        </div>

        <?php
        include('footer.php'); ?>