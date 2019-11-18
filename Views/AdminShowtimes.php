<?php
include('header.php');
include('nav.php');

?>

<body class="admin-body">
	<div class="admin-header">
		<h1>Listado de showtimes</h1>
		<div class="select-cinema-showtime">
			<form action=<?= FRONT_ROOT . "/Showtime/getCinema" ?> method="POST">
				<label>Cinema</label>
				<select name="idCinema" class="form-control">
					<?php foreach ($cinemasList as $cine) { ?>
						<option value=<?= $cine->getId() ?>><?= $cine->getName() ?></option>
					<?php } ?>
				</select>
				<button id="btn-abrir-popup" type="submit" class="btn-small"><i class="fas fa-plus"></i></button>
			</form>
		</div>
		
	</div>

	<div class="admin-table">

		<table class="content-table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Day</th>
					<th>Date</th>
					<th>Movie</th>
					<th>Language</th>
					<th>Subtitle</th>
					<th>Cinema</th>
					<th>Theater</th>
					<th>Tickets</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php

				if (!empty($showtimes)) {
					foreach ($showtimes as $showtime) {
						?>
						<tr>
							<td><?php echo $showtime->getShowtimeId(); ?></td>
							<td><?php echo $showtime->getDate(); ?></td>
							<td><?php echo $showtime->getHour(); ?></td>
							<td><?php echo $showtime->getMovie()->getTitle(); ?></td>
							<td><?php echo $showtime->getLanguage()->getName(); ?></td>
							<td><?php if ($showtime->isSubtitle()) {
											echo 'Yes';
										} else {
											echo 'No';
										}  ?></td>
							<td><?php echo $showtime->getTheater()->getCinema()->getName(); ?></td>
							<td><?php echo $showtime->getTheater()->getName(); ?></td>
							<td><?php echo $showtime->getTicketAvaliable() . '/' . $showtime->getTheater()->getCapacity(); ?></td>
							<td>

								<?php if ($showtime->getTheater()->getActive() && $showtime->getActive()) {
											?>
									<a href=<?php echo  FRONT_ROOT . "/Showtime/desactivate/" .  $showtime->getShowtimeId() ?> name="desactivate" class="btn btn-light">
										<i class="fas fa-toggle-on"></i>
									</a>
								<?php } else {
											?>
									<a href="<?php echo  FRONT_ROOT . "/Showtime/activate/" .  $showtime->getShowtimeId() ?>" name="activate" class="btn btn-light">
										<i class="fas fa-toggle-off"></i>
									</a>
								<?php
										}
										?>
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

<!--CREATE SHOWTIME-->
<?php if ($openPopUp) {?>
	<div class="overlay" id="overlay">
		<div class="popup" id="popup">

			<a href="<?php echo FRONT_ROOT . "/Showtime/ShowShowtimeMenu" ?>" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>

			<h3><?= "Create a Showtime in " . $cinemaTheaters[0]->getCinema()->getName() ?></h3>


			<form action="<?php echo  FRONT_ROOT . "/Showtime/create" ?>" method="POST">
				<div class="contenedor-inputs">

					<div class="form-group">
						<label>Theater</label>
						<select name="idTheater" class="form-control">
							<?php foreach ($cinemaTheaters as $theater) { ?>
								<option value=<?= $theater->getId() ?>><?= $theater->getName() ?></option>
							<?php } ?>
						</select>
					</div>

					<div class="form-group">
						<label>Movie</label>
						<select name="idMovie" class="form-control">
							<?php foreach ($moviesList as $movie) { ?>
								<option value=<?= $movie->getId() ?>><?= $movie->getTitle() ?></option>
							<?php } ?>
						</select>
					</div>

					<div class="language-subtitle">
						<div class="form-group">
							<label>Language</label>
							<select name="nameLanguage" class="form-control">
								<?php foreach ($languagesList as $language) { ?>
									<option value=<?= $language->getName() ?>><?= $language->getName() ?></option>
								<?php } ?>
							</select>
						</div>

						<div class="form-group">
							<label>Subtitle</label>
							<select name="subtitle" style="width:50px">
								<option value="No">No</option>
								<option value="Yes">Yes</option>
							</select>
						</div>
					</div>


					<div class="form-group">
						<label>Date</label>
						<input type="date" required min="<?= date('Y-m-d'); ?>" class="form-control" name="date">
					</div>

					<div class="form-group">
						<label>Hour</label>
						<input type="time" required class="form-control" name="hour">
					</div>


				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-med btn-light"><a href="<?php echo FRONT_ROOT . "/Showtime/ShowShowtimeMenu" ?>" class="btn-cerrar-popup" id="cancel-button-showtime">Cancelar</a></button>

					<button type="submit" class="btn btn-med btn-light">Aceptar</button>
				</div>
			</form>
		</div>
	</div>

<?php } ?>
<script src="<?php echo JS_PATH . "/popup.js" ?>"></script>
</div>