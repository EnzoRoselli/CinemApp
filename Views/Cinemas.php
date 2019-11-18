<?php
include('header.php');
include('nav.php');
?>

<div class="cinemas-container">
    <div class="cinemas-grid">
    <?php foreach($cinemas as $cinema){ ?>
        <div class="cinema-content">
           
            <p id="cinemas-title"><?=$cinema->getName()?></p>
            <p><?=$cinema->getAddress()?></p>
            <div class="cinemas-theaters">
                <p>Theaters</p>
                <div class="cinemas-theaters-items">
                    <?php foreach($cinema->getTheaters() as $theater) { ?>
                    <p><?=$theater->getName()?></p> <?php } ?>
                </div>
            </div>
            
        </div>
        <?php } ?>
    </div>
</div>
