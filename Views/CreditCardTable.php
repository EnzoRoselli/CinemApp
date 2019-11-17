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
                <label>Card Number</label>
                <input type="hidden" name="showtimeId" value="showtimeId">
                <input type="number" class="form-control" name="cc_number" required>
                <input type="hidden" name="origin" value="list">
                <button type="submit">Add</button>
            </form>
        </div>
       
    </div>
    <div class="admin-table">
        <table class="content-table">
            <thead>
                <tr>
                    <th>Number</th>
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
                            <td><?= $credirCard->getNumber() ?></td>
                            <td><?php 
                            switch (substr($credirCard->getNumber(), 0, 1)) {
                                case '3':
                                    echo "Visa";
                                    break;
                                case '4':
                                    echo "MasterCard";
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