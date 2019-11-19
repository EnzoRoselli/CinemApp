<?php
include('header.php');
include('nav.php');

?>


<body class="admin-body">
	<div class="admin-header">
        <h1>My Purchases</h1>
        
	</div>
	
	<div class="admin-table">
		<table class="content-table">

			<thead>
				<tr>
					<th style="width: 3%;">Title</th>
					<th style="width: 10%;">Cinema</th>
					<th style="width: 20%;">Theater</th>
					<th style="width: 24%;">Date</th>
					<th style="width: 24%;">Hour</th>
					<th style="width: 24%;">Amount</th>
					<th style="width: 24%;">Total</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($userPurchases as $value){
						?>
						<tr>

							<td><?= $value['title']; ?></td>
							<td><?= $value['cinema_name']; ?></td>
							<td><?= $value['theater_name']; ?></td>
							<td><?= $value['view_date']; ?></td>
							<td><?= $value['hour']; ?></td>
							<td><?= $value['ticketsAmount']; ?></td>
							<td>$<?= $value['total']; ?></td>
						</tr>
				<?php 
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
	
</body>
