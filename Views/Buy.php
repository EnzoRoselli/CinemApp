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
                <div class="number-tickets">
                    <label>Number of Tickets:</label>
                    <input class="btn-input" type="number" id="buy-amount" name="amount" min="1">
                </div>

                <button type="button" id="ok-btn-amount">Calculate Total</button>
                
                <div class="total-amount">
                    <label>Total: $</label>
                    <input class="btn-input" id="total-price" readonly name="totalPrice" name="totalPrice"></input>
                </div>

                <input type="hidden" name="showtimeid" value=<?= $showtime->getShowtimeId() ?>>

            </div>
            <div class="select-card">
                <p>Choose your credit card</p>
                <div class="select-card-item">
                    <select name="creditCardId">
                        <option value="" selected>Select a credit card</option>
                        <?php foreach ($CreditCardsList as $cc) { ?>
                            <option value=<?= $cc->getId() ?>><?php echo $cc->getNumber() ?></option>
                        <?php } ?>
                    </select>
                    <a id="btn-abrir-popup" class="buy-add-cc" href=<?= FRONT_ROOT . "/CreditCards/showAdd/" . $showtime->getShowtimeId() ?>>Add</a>
                </div>

            </div>
            <div class="buy-actions">
                <a class="buy-btn" id="buy-back-btn" href=<?= FRONT_ROOT . "/Showtime/showSelectShowtime/" . $showtime->getMovie()->getId() ?>>Back</a>
                <button class="buy-btn" type="submit">Confirm</button>
            </div>
        </form>
    </div>
</div>
<?php if ($openPopUp) { ?>
    <script type='text/javascript'>
        window.addEventListener('load', function() {
            overlay.classList.add('active');
            popup.classList.add('active');
        })
    </script>
    <div class="overlay" id="overlay">
        <div class="popup" id="popup">
            <a href=<?= FRONT_ROOT . "/Showtime/showBuy/" . $showtime->getShowtimeId() ?> id="btn-cerrar-popup"><i class="fas fa-times"></i></a>
            <h3>Complete</h3>
            <form action=<?= FRONT_ROOT . "/CreditCards/add" ?> method="POST">
                <div class="contenedor-inputs">
                    <input type="hidden" name="id" value=<?= $showtime->getShowtimeId() ?>>
                    <div class="form-group">
                        <label>Card Number</label>
                        <input type="number" class="form-control" name="cc_number" required>
                    </div>
                    <input type="hidden" name="origin" value="buy">
                </div>
                <div class="modal-footer">
                    <a href=<?= FRONT_ROOT . "/Showtime/showBuy/" . $showtime->getShowtimeId() ?> id="btn-cerrar-popup">Cancel</a>
                    <button type="submit" class="btn btn-med btn-light">Confirm</button>

                </div>
            </form>
        </div>
    </div>
<?php } ?>
<script src="<?= JS_PATH . "/buy.js" ?>"></script>

<!-- <script src="<?= JS_PATH . "/popUpCreditCard.js" ?>"></script> -->