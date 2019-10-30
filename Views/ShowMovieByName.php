<?php

include('header.php');
include('nav.php');
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
include('footer.php');
?>