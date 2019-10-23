<?php
include('header.php');
include('nav.php');

?>

<body class="admin-body">
	<div class="admin-header">
		<h1>Listado de showtimes</h1>
		<button id="btn-abrir-popup" class="btn-small"><i class="fas fa-plus"></i></button>
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
								<td><?php echo $showtime->getMovie(); ?></td>
								<td><?php echo $showtime->getLanguage(); ?></td>
								<td><?php echo $showtime->isSubtitle(); ?></td>
								<td><?php echo $showtime->getCinema(); ?></td>
								<td><?php echo $showtime->getTicketAvialable() . '/' . getCinema()->getCapacity(); ?></td>
								<td>
									<form action="<?php echo  FRONT_ROOT . "/Showtime/ShowShowtimeMenu" ?>">

										
										

										<?php if($cine->getActive()){
											?>
										<button name="desactivate" value="<?php echo $showtime->getId() ?>" class="btn btn-light">
											<i class="fas fa-toggle-on"></i>
										</button>
										<?php }else{
											?>
											<button name="activate" value="<?php echo $showtime->getId() ?>" class="btn btn-light">
											<i class="fas fa-toggle-off"></i>
										</button>
										<?php 
										}
										?>
									</form>
								</td>
							</tr>
				<?php
					}
				}?>
			</tbody>
		</table>
	</div>
</body>

<!--CREATE SHOWTIME-->

<div class="overlay" id="overlay">
	<div class="popup" id="popup">
		<!-- <a href="#" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times"></i></a> -->
		<a href="<?php echo FRONT_ROOT . "/Showtime/ShowShowtimeMenu" ?>" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>

		<h3>Registrar/Modificar showtime</h3>


		<form action="<?php echo  FRONT_ROOT . "/Cine/determinateUpdateCreate " ?>" method="POST">
			<div class="contenedor-inputs">

				<input type="hidden" name=<?php echo SHOWTIME_ID ?> value=<?php if (isset($showtimeUpdate)) {
				
																			echo $showtimeUpdate->getId();
																		} ?>>
				<div class="form-group">
					<label>Cinema</label>
					<select name=<?php echo SHOWTIME_CINEMA ?> class="form-control">
						<option value="">dasdassd</option>
					</select>
				</div>
				
				<div class="form-group">
					<label>Movie</label>
					<select name=<?php echo SHOWTIME_MOVIE ?> class="form-control">
						<option value="">dasdassd</option>
					</select>
				</div>

				<div class="form-group">
					<label>Language</label>
					<select name=<?php echo SHOWTIME_LANGUAGE ?> class="form-control">
						<option value="">dasdassd</option>
					</select>
				</div>

				<div class="form-group">
					<label>Subtitle</label>
					<input type="checkbox" class="form-control" name=<?php echo SHOWTIME_SUBTITLE ?> value=<?php  ?>>
				</div>

				<div class="form-group">
					<label>Date</label>
					<input type="date" class="form-control" name=<?php echo SHOWTIME_DATE ?> value=<?php  ?>>
				</div>

				<div class="form-group">
					<label>Hour</label>
					<input type="time" class="form-control" name=<?php echo SHOWTIME_HOUR ?> value=<?php  ?>>
				</div>

				
			</div>
			<div class="modal-footer">

				<a href="<?php echo FRONT_ROOT . "/Showtime/ShowCinemaMenu" ?>" class="btn btn-med btn-light" id="btn-cerrar-popup"><i class="fas fa-times"></i></a>

				<button type="submit" class="btn btn-med btn-light">Aceptar</button>


			</div>
		</form>
	</div>
</div>
<script src="<?php echo JS_PATH . "/popup.js" ?>"></script>
</div>