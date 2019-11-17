<?php
include('header.php');
include('nav.php');

?>

<body class="admin-body">
<div class="admin-header">
		<h1>My Credit Cards</h1>
	</div>
	<div class="admin-table">
		<table class="content-table">
			<thead>
				<tr>
					<th>Number</th>
					<th>Company</th>
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
								<td><?php  if ($showtime->isSubtitle()) {
									echo "Si";
								}else {
									echo "No";
								}  ?></td>
								<td><?php echo $showtime->getTheater()->getCinema()->getName(); ?></td>
								<td><?php echo $showtime->getTheater()->getName(); ?></td>
								<td><?php echo $showtime->getTicketAvaliable() . '/' . $showtime->getTheater()->getCapacity(); ?></td>
								<td>
									
										<?php if($showtime->getTheater()->getActive() && $showtime->getActive()){
											?>
										<a href=<?php echo  FRONT_ROOT . "/Showtime/desactivate?desactivate=" .  $showtime->getShowtimeId() ?> name="desactivate" class="btn btn-light">
											<i class="fas fa-toggle-on"></i>
										</a>
										<?php }else{
											?>
											<a href="<?php echo  FRONT_ROOT . "/Showtime/activate?activate=" .  $showtime->getShowtimeId() ?>" name="activate" class="btn btn-light">
											<i class="fas fa-toggle-off"></i>
										</a>
										<?php 
										}
										?>
								</td>
							</tr>
				<?php
					}
				}?>
			</tbody>
		</table>
	</div>
</body>
