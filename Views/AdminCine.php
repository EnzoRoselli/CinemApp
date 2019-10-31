<?php
include('header.php');
include('nav.php');

?>

<body class="admin-body">
	<div class="admin-header">
		<h1>Listado de cines</h1>
		<button id="btn-abrir-popup" class="btn-small"><i class="fas fa-plus"></i></button>
	</div>

	<div class="admin-table">

		<table class="content-table">

			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Address</th>
					<th>Capacity</th>
					<th>TicketValue</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if (!empty($cines)) {
					foreach ($cines as $cine) {

						?>
						<tr>

							<td><?php echo $cine->getId(); ?></td>
							<td><?php echo $cine->getName(); ?></td>
							<td><?php echo $cine->getAddress(); ?></td>
							<td><?php echo $cine->getCapacity(); ?></td>
							<td><?php echo $cine->getTicketValue(); ?></td>
							<td>


								<!-- UPDATE CINE -->
								<!-- <button id="btn-update-cine" name="update" value="<?php echo $cine->getId() ?>" class="btn btn-light">
											<i class="fas fa-edit"></i>
										</button> -->

								<button id="btn-abrir-popup" data-url="<?php echo  FRONT_ROOT . "/Cine/executeAction" ?>" data-id="<?php echo $cine->getId() ?>" data-action="update" name="update" class="btn btn-light btn-aaa">
									<i class="fas fa-edit"></i>
								</button>

								<?php if ($cine->getActive()) {
											?>
									<button name="desactivate" value="<?php echo $cine->getId() ?>" class="btn btn-light">
										<i class="fas fa-toggle-on"></i>
									</button>
								<?php } else {
											?>
<<<<<<< HEAD
									<button name="activate" value="<?php echo $cine->getId() ?>" class="btn btn-light">
										<i class="fas fa-toggle-off"></i>
									</button>

								<?php
										}
										?>
								<!-- DELETE CINE -->

								<button data-url="<?php echo  FRONT_ROOT . "/Cine/executeAction" ?>" data-id="<?php echo $cine->getId() ?>" data-action="delete" name="delete" class="btn btn-light btn-aaa">
									<i class="fas fa-trash"></i>
								</button>

							</td>
						</tr>
=======
											<button name="activate" value="<?php echo $cine->getId() ?>" class="btn btn-light">
											<i class="fas fa-toggle-off"></i>
										</button>
										<?php 
										}
										?>		
										<!-- DELETE CINE -->
											<button id="submitForm" name="delete" value="<?php echo $cine->getId() ?>" class="btn btn-light">
											<i class="fas fa-trash"></i>
										</button>
									</form>
								</td>
							</tr>
>>>>>>> parent of d37f01d... Merge branch 'master' of https://github.com/EnzoRoselli/CinemApp
				<?php
					}
				} ?>
			</tbody>
		</table>
	</div>
</body>



<!--CREATE CINE-->

<div class="overlay" id="overlay">
	<div class="popup" id="popup">
		<!-- <a href="#" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times"></i></a> -->
		<a href="<?php echo FRONT_ROOT . "/Cine/ShowCinemaMenu" ?>" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>

		<h3>Registrar/Modificar cine</h3>


		<form action="<?php echo  FRONT_ROOT . "/Cine/determinateUpdateCreate " ?>" method="POST">
			<div class="contenedor-inputs">
				<input type="hidden" name=<?php echo CINE_ID ?> value=<?php if (isset($cineUpdate)) {

																			echo $cineUpdate->getId();
																		} ?>>

				<div class="form-group">
					<label>Nombre</label>
<<<<<<< HEAD
					<input type="text" class="form-control" name=<?php echo CINE_NAME ?> required value=<?php if (isset($cineUpdate)) {
																											echo $cineUpdate->getName();
																										} ?>>
=======
					<input type="text" class="form-control" name=<?php echo CINE_NAME ?> value=<?php if (isset($cineUpdate)) {
																									echo $cineUpdate->getName();
																								} ?>>
>>>>>>> parent of d37f01d... Merge branch 'master' of https://github.com/EnzoRoselli/CinemApp
				</div>

				<div class="form-group">
					<label>Dirección</label>
					<input type="text" class="form-control" name=<?php echo CINE_ADDRESS ?> value=<?php if (isset($cineUpdate)) {
																										echo $cineUpdate->getAddress();
																									} ?>>
				</div>

				<div class="form-group">
					<label>Capacidad</label>
<<<<<<< HEAD
					<input type="number" class="form-control" name=<?php echo CINE_CAPACITY ?> min="1" required value=<?php if (isset($cineUpdate)) {
																															echo (int) $cineUpdate->getCapacity();
																														} ?>>
=======
					<input type="number" class="form-control" name=<?php echo CINE_CAPACITY ?> value=<?php if (isset($cineUpdate)) {
																											echo (int) $cineUpdate->getCapacity();
																										} ?>>
>>>>>>> parent of d37f01d... Merge branch 'master' of https://github.com/EnzoRoselli/CinemApp
				</div>

				<div class="form-group">
					<label>Valor de Entrada</label>
<<<<<<< HEAD
					<input type="number" class="form-control" name=<?php echo CINE_TICKETVALUE ?> min="1" required value=<?php if (isset($cineUpdate)) {
																																echo (int) $cineUpdate->getTicketValue();
																															} ?>>
=======
					<input type="number" class="form-control" name=<?php echo CINE_TICKETVALUE ?> value=<?php if (isset($cineUpdate)) {
																											echo (int) $cineUpdate->getTicketValue();
																										} ?>>
>>>>>>> parent of d37f01d... Merge branch 'master' of https://github.com/EnzoRoselli/CinemApp
				</div>
			</div>
			<div class="modal-footer">

				<a href="<?php echo FRONT_ROOT . "/Cine/ShowCinemaMenu" ?>" class="btn btn-med btn-light" id="btn-cerrar-popup"><i class="fas fa-times"></i></a>

				<button type="submit" class="btn btn-med btn-light">Aceptar</button>


			</div>
		</form>
	</div>
</div>
<script src="<?php echo JS_PATH . "/popup.js" ?>"></script>

</div>

<?php include('footer.php'); ?>