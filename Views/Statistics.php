<?php
include('header.php');
include('nav.php');

?>

<body class="admin-body">
	<div class="admin-header">
        <h1>Statistics</h1>
        
	</div>

	
	
	<div class="admin-table">
	<form action="<?= FRONT_ROOT . '/Statistic/showStats'?>" method="POST">
		<p>MinDate:</p>
			<input type="date" name="minDate">
		<p>MaxDate:</p>
			<input type="date" name="maxDate">
		
		<button type="submit">Aceptar</button>
	</form>
	<h2>Cinemas</h2>
	
		<table class="content-table">

			<thead>
				<tr>
					<th style="width: 3%;">Cinema</th>
					<th style="width: 10%;">Address</th>
					<th style="width: 20%;">Tickets sold</th>
					<th style="width: 24%;">Amount</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($statsCinemas as $value){
						?>
						<tr>

							<td><?= $value->getName(); ?></td>
							<td><?= $value->getAddress(); ?></td>
							<td><?= $value->getTotalTickets(); ?></td>
							<td><?= $value->getTotalSales(); ?></td>
						</tr>
				<?php 
				} ?>
			</tbody>
		</table>
	</div>
	
	<div class="admin-table">
	<h2>Movies</h2>
		<table class="content-table">

			<thead>
				<tr>
					<th style="width: 3%;">Name</th>
					<th style="width: 20%;">Tickets sold</th>
					<th style="width: 24%;">Amount</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($statsMovies as $value){
						?>
						<tr>

							<td><?= $value->getTitle(); ?></td>
							<td><?= $value->getTotalTickets(); ?></td>
							<td><?= $value->getTotalSales(); ?></td>
						</tr>
				<?php 
				} ?>
			</tbody>
		</table>
	</div>
</body>