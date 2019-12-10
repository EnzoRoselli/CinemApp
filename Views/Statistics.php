<?php
include('header.php');
include('nav.php');

?>


<body class="admin-body">
	<div class="admin-header">
		<h1>Statistics</h1>

	</div>

	<div class="admin-table">
		<div class="showtimes-list-filters">
			<form action="<?= FRONT_ROOT . '/Statistic/showStats' ?>" method="POST">
				<h2>By View Date:</h2>
				<label for="">Date:</label>
				<input type="date" name="viewDate">
				<h2>By Purchases:</h2>
				<label for="">MinDate:</label>
				<input type="date" name="minDate">
				<label for="">MaxDate:</label>
				<input type="date" name="maxDate">

				<button type="submit" class="buy-btn">Confirm</button>
		</div>

		</form>
		<h2>Cinemas</h2>

		<table class="content-table">

			<thead>
				<tr>
					<th style="width: 25%;">Cinema</th>
					<th style="width: 25%;">Tickets sold</th>
					<th style="width: 25%;">Amount</th>
					<th style="width: 25%;">Address</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($statsCinemas as $value) {
					foreach ($value as $index) {
						?>
						<tr>
							<td><?= $index['cinema_name']; ?></td>
							<td><?= $index['totalTickets']; ?></td>
							<td>$<?= $index['totalSales']; ?></td>
							<td><?= $index['address']; ?></td>
						</tr>
				<?php
					}
				} ?>
			</tbody>
		</table>
	</div>

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

	<div class="admin-table">
		<h2>Movies</h2>
		<table class="content-table">

			<thead>
				<tr>
					<th style="width: 25%;">Name</th>
					<th style="width: 25%;">Tickets sold</th>
					<th style="width: 25%;">Amount</th>
					<th style="width: 25%;"></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($statsMovies as $value) {
					foreach ($value as $index) {
						?>
						<tr>

							<td><?= $index['title']; ?></td>
							<td><?= $index['totalTickets']; ?></td>
							<td>$<?= $index['totalSales']; ?></td>
							<td> </td>
						</tr>
				<?php
					}
				} ?>
			</tbody>
		</table>
	</div>
</body>