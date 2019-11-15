<?php
include('header.php');
include('nav.php');
?>

<div class="buy-container">
<p id="dto-advice" class="active-dto-advice">Since you're buying on Tuesday and more than one tickets, we'll give you a discount of 25%!</p>
    <div class="showtime-details-container">
            <div class="showtime-details-content-left">
                <p id="buy-day">Day: <?= $showtime->getDate(); ?></p>
                <p>Hour: <?= $showtime->getHour(); ?></p>
                <p>Language: <?= $showtime->getLanguage()->getName(); ?></p>
                <p>Subtitles: <?= $showtime->isSubtitle(); ?></p>
            </div>
            <div class="showtime-details-content-right">
                <p>Cinema: <?= $showtime->getTheater()->getCinema()->getName(); ?></p>
                <p>Theater: <?= $showtime->getTheater()->getName(); ?></p>
                <p>Address: <?= $showtime->getTheater()->getCinema()->getAddress(); ?></p>
                <p>Ticket Value: $<?= $showtime->getTheater()->getTicketValue(); ?></p>
            </div>
    </div>
    <div class="buy-form">
        <form action=<?= FRONT_ROOT . "/Purchase/create" ?> method="POST">
            <div class="buy-amount-total">
                <label id="buy-ticket-value"><?= $showtime->getTheater()->getTicketValue(); ?></label>
                <label>Amount:</label>
                <input type="number" id="buy-amount" name="amount" min="1">
                <button type="button" id="ok-btn-amount">Calculate Total</button>
                <label>Total: $</label>
                <input id="total-price" readonly name="totalPrice"></input>
                <input type="hidden" name="showtime-id" value=<?= $showtime->getShowtimeId() ?>>
                
            </div>
            <div class="select-card">
                <p>Choose your credit card</p>
                <div class="select-card-item">
                <select name="" id="">
                    <option value="" selected >Select a credit card</option>
                    <?php foreach ($CreditCardsList as $cc) { ?>
                        <option name="creditCardId" value=<?= $cc->getId() ?>><?php echo cc->getNumber() ?></option>
                    <?php } ?>
                    
                   
                </select>
                <button>Add</button>
                </div>
                
            </div>
            <div class="buy-actions">
                <a href=<?= FRONT_ROOT . "/Showtime/showSelectShowtime?movie=" . $showtime->getMovie()->getId() ?>>Atras</a>
                <button type="submit">Confirm</button>
            </div>
        </form>
    </div>
</div>
<script src="<?php echo JS_PATH . "/buy.js" ?>"></script>