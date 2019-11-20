<?php
include('header.php');
include('nav.php');

?>

<body class="admin-body">
    <div class="admin-header">
        <h1>My Credit Cards</h1>
        <h2>Add a new Credit Card</h2>
        <div class="form-group">
            <form action=<?= FRONT_ROOT . "/CreditCards/add/" ?> method="POST">
                <div>
                <label>Card Number</label>
                <input type="hidden" name="showtimeId" value="showtimeId">
                <input type="text" class="form-control" name="cc_number" pattern = [0-9]{16} title="16 digits at the front of the card" required>
                </div>
                <div>
                <label>Security Code</label>
                <input type="text" class="form-control" name="cc_sc"  pattern = [0-9]{3} title="3 digits at the back of the card" required>             
                <input type="hidden" name="origin" value="list">
                <button type="submit">Add</button>
                </div>
            </form>
        </div>
       
    </div>
    <div class="admin-table">
        <table class="content-table">
            <thead>
                <tr>
                    <th>Last 4 Numbers</th>
                    <th>Company</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (!empty($creditCardList)) {
                    foreach ($creditCardList as $credirCard) { 
                        ?>
                        <tr>
                            <td><?=$credirCard->getLastFour() ?></td>
                            <td><?php 
                            switch (substr($credirCard->getNumber(), 0, 1)) {
                                case '3':
                                    echo "MasterCard";
                                    break;
                                case '4':
                                    echo "Visa";
                                    break;
                                default:
                                    echo "Other";
                                    break;
                            } ?></td>
                            <td>
                                <a href="<?php echo  FRONT_ROOT . "/CreditCards/delete/" .  $credirCard->getId() ?>" onclick="return checkDelete()" name="delete" class="btn btn-light">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                <?php
                    }
                } ?>
            </tbody>
        </table>
    </div>

</body>

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