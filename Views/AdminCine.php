<?php
include('header.php');
include('nav.php');

?>

<body class="admin-body">
	<div class="admin-header">
		<h1>Listado de cines</h1>
		<form action="<?= FRONT_ROOT . "/Cine/createCinema " ?>" method="POST">
			<button id="btn-abrir-popup" class="btn-small btn-abrir-popup-cinema"><i class="fas fa-plus"></i></button>
		</form>
	</div>

	<div class="admin-table">

		<table class="content-table">

			<thead>
				<tr>
					<th style="width: 3%;">ID</th>
					<th style="width: 10%;">Name</th>
					<th style="width: 20%;">Address</th>
					<th style="width: 24%;">Theaters</th>
					<th style="width: 4%;">Capacity</th>
					<th style="width: 47%; padding-left: 100px;">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if (!empty($cines)) {
					foreach ($cines as $cine) {

						?>
						<tr>

							<td><?= $cine->getId(); ?></td>
							<td><?= $cine->getName(); ?></td>
							<td><?= $cine->getAddress(); ?></td>
							<td><?php foreach ($cine->getTheaters() as $theater) {
											echo $theater->getName() . " - ";
										} ?></td>
							<td><?= $cine->getCapacity(); ?></td>
							<td style="padding-left: 100px;">
								<!-- ----------------------- EDIT ----------------------- -->
								<a href="<?= FRONT_ROOT . "/Cine/getCinemaToUpdate/" .  $cine->getId() ?>" name="update" class="btn btn-light">
									<i class="fas fa-edit"></i>
								</a>

								<!-- ----------------------- ACTIVATE ----------------------- -->
								<?php if ($cine->getActive()) { ?>
									<a href="<?= FRONT_ROOT . "/Cine/desactivate/" .  $cine->getId() ?>" name="desactivate" class="btn btn-light">
										<i class="fas fa-toggle-on"></i>
									</a>
								<?php } else { ?>
									<!-- ----------------------- DESACTIVATE ----------------------- -->
									<a href="<?= FRONT_ROOT . "/Cine/activate/" .  $cine->getId() ?>" name="activate" class="btn btn-light">
										<i class="fas fa-toggle-off"></i>
									</a>
								<?php } ?>
								<!-- ----------------------- DELETE ----------------------- -->
								<a href="<?= FRONT_ROOT . "/Cine/delete/" .  $cine->getId() ?>" onclick="return confirm('Are you sure you want to Remove?');" name="delete" class="btn btn-light">
									<i class="fas fa-trash"></i>
								</a>
								<!-- ----------------------- ADD THEATER ----------------------- -->
								<a href="<?= FRONT_ROOT . "/Theater/getCinemaToAddTheater/" .  $cine->getId() ?>" name="addTheater" class="btn btn-light" style="font-size:1rem;">
									Add Theater
								</a>
								<!-- ----------------------- REMOVE THEATER ----------------------- -->
								<a href="<?= FRONT_ROOT . "/Theater/getCinemaToRemoveTheater/" .  $cine->getId() ?>" name="removeTheater" class="btn btn-light" style="font-size:1rem;">
									Remove Theater
								</a>
							</td>
						</tr>
				<?php }
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

<!--CREATE CINE-->
<?php if ($openPopUp) { ?>
	<script type='text/javascript'>
		window.addEventListener('load', function() {
			overlay.classList.add('active');
			popup.classList.add('active');
		})
	</script>
	<div class="overlay" id="overlay">
		<div class="popup" id="popup">

			<a href="<?= FRONT_ROOT . "/Cine/ShowCinemasOnTable" ?>" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>

			<h3>Complete the fields</h3>

			<?php if (!isset($createTheater)) { ?>

				<form action="<?= FRONT_ROOT . "/Cine/determinateUpdateCreate " ?>" method="POST">
					<div class="contenedor-inputs">
						<input type="hidden" name="id" value=<?php if (isset($cineUpdate)) {
																			echo $cineUpdate->getId();
																		} ?>>

						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" name="name" required value=<?php if (isset($cineUpdate)) {
																											echo $cineUpdate->getName();
																										} ?>>
						</div>

						<div class="form-group">
							<label>Address</label>
							<input type="text" class="form-control" name="address" value=<?php if (isset($cineUpdate)) {
																										echo $cineUpdate->getAddress();
																									} ?>>
						</div>
					</div>
					<div class="modal-footer">
					<a href="<?= FRONT_ROOT . "/Cine/ShowCinemasOnTable" ?>" class="btn btn-med btn-light" id="btn-cerrar-popup" style="text-decoration:none">Cancel</a>
						<button type="submit" class="btn btn-med btn-light">Confirm</button>

						

					</div>
				</form>
			<?php } else { ?>
				<form action="<?= FRONT_ROOT . "/Theater/create" ?>" method="POST">
					<div class="contenedor-inputs">
						<p class="pop-up-subtitle"><?= $createTheater->getName(); ?></p>

						<input type="hidden" name="cinema" value=<?= $createTheater->getId(); ?>>

						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" name="name" required>
						</div>

						<div class="form-group">
							<label>Capacity</label>
							<input type="number" class="form-control" name="capacity" min="1" required>
						</div>

						<div class="form-group">
							<label>Ticket Value</label>
							<input type="number" class="form-control" name="ticketValue" min="1" required>
						</div>
					</div>
					<div class="modal-footer">

						<a href="<?= FRONT_ROOT . "/Cine/ShowCinemasOnTable" ?>" class="btn btn-med btn-light" id="btn-cerrar-popup" style="text-decoration:none">Cancel</a>

						<button type="submit" class="btn btn-med btn-light">Confirm</button>

					</div>
				</form>
			<?php } ?>
		</div>
	</div>
<?php } ?>

<?php if ($removeTheater) { ?>
	<script type='text/javascript'>
		window.addEventListener('load', function() {
			overlay.classList.add('active');
			popup.classList.add('active');
		})
	</script>
	<div class="overlay" id="overlay">
		<div class="popup" id="popup">
			<a href="<?= FRONT_ROOT . "/Cine/ShowCinemasOnTable" ?>" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>
			<h3>Complete</h3>
			<form action=<?= FRONT_ROOT . "/Theater/remove" ?> method="POST">
				<div class="contenedor-inputs">
					<div class="form-group">
						<label>Theater</label>
						<select name="select-theater">
							<?php foreach ($cinema->getTheaters() as $theater) { ?>
								<option ><?= $theater->getName() ?></option>
								
							<?php } ?>
							<input type="hidden" name="idTheater" value=<?= $theater->getName(); ?>>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<a href="<?= FRONT_ROOT . "/Cine/ShowCinemasOnTable" ?>" class="btn btn-med btn-light" id="btn-cerrar-popup" style="text-decoration:none">Cancel</a>
					<button type="submit" class="btn btn-med btn-light">Confirm</button>

				</div>
			</form>
		</div>
	</div>
<?php } ?>


<script src="<?= JS_PATH . "/popup.js" ?>"></script>


</div>