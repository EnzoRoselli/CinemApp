<?php
include('header.php');
include('nav.php');

?>

<body class="admin-body">
	<div class="admin-header">
		<h1>Listado de cines</h1>
		<form action="<?php echo  FRONT_ROOT . "/Cine/createCinema " ?>" method="POST">
			<button id="btn-abrir-popup" class="btn-small"><i class="fas fa-plus"></i></button>
		</form>
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
									<!-- ----------------------- EDIT ----------------------- -->
									<a href="<?php echo  FRONT_ROOT . "/Cine/getCinemaToUpdate?update=" .  $cine->getId()?>" name="update" class="btn btn-light">
											<i class="fas fa-edit"></i>
									</a>

									<!-- ----------------------- ACTIVATE ----------------------- -->
									<?php if($cine->getActive()){?>
										<a href="<?php echo  FRONT_ROOT . "/Cine/desactivate?desactivate=" .  $cine->getId()?>"  name="desactivate" class="btn btn-light">
											<i class="fas fa-toggle-on"></i>
										</a>
										<?php }else{ ?>
									<!-- ----------------------- DESACTIVATE ----------------------- -->
										<a href="<?php echo  FRONT_ROOT . "/Cine/activate?activate=" .  $cine->getId()?>" name="activate"  class="btn btn-light" >
											<i class="fas fa-toggle-off"></i>
										</a>
									<?php } ?>	
									<!-- ----------------------- DELETE ----------------------- -->
									<a href="<?php echo  FRONT_ROOT . "/Cine/delete?delete=" .  $cine->getId()?>" onclick="return checkDelete()" name="delete" class="btn btn-light">
											<i class="fas fa-trash"></i>
									</a>
							
								</td>
							</tr>
				<?php } }?>
			</tbody>
		</table>
	</div>
</body>



<!--CREATE CINE-->

<div class="overlay" id="overlay">
	<div class="popup" id="popup">
		
		<a href="<?php echo FRONT_ROOT . "/Cine/ShowCinemasOnTable" ?>" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>

		<h3>Registrar/Modificar cine</h3>


		<form action="<?php echo  FRONT_ROOT . "/Cine/determinateUpdateCreate " ?>" method="POST">
			<div class="contenedor-inputs">
				<input type="hidden" name=<?php echo CINE_ID ?> value=<?php if (isset($cineUpdate)) {echo $cineUpdate->getId();
																		} ?>>

				<div class="form-group">
					<label>Nombre</label>
					<input type="text" class="form-control" name=<?php echo CINE_NAME ?> required value=<?php if (isset($cineUpdate)) {
																									echo $cineUpdate->getName();
																								} ?>>
				</div>

				<div class="form-group">
					<label>Dirección</label>
					<input type="text" class="form-control" name=<?php echo CINE_ADDRESS ?> value=<?php if (isset($cineUpdate)) {
																										echo $cineUpdate->getAddress();
																									} ?>>
				</div>

				<div class="form-group">
					<label>Capacidad</label>
					<input type="number" class="form-control" name=<?php echo CINE_CAPACITY ?> min="1" required value=<?php if (isset($cineUpdate)) {
																											echo (int) $cineUpdate->getCapacity();
																										} ?>>
				</div>

				<div class="form-group">
					<label>Valor de Entrada</label>
					<input type="number" class="form-control" name=<?php echo CINE_TICKETVALUE ?> min="1" required value=<?php if (isset($cineUpdate)) {
																											echo (int) $cineUpdate->getTicketValue();
																										} ?>>
				</div>
			</div>
			<div class="modal-footer">

				<a href="<?php echo FRONT_ROOT . "/Cine/ShowCinemasOnTable" ?>" class="btn btn-med btn-light" id="btn-cerrar-popup"><i class="fas fa-times"></i></a>

				<button type="submit" class="btn btn-med btn-light">Aceptar</button>


			</div>
		</form>
	</div>
</div>
<script src="<?php echo JS_PATH . "/popup.js" ?>"></script>

</div>

<?php include('footer.php'); ?>