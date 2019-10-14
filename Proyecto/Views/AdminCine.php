<?php

include('header.php');
include('nav.php');

require "../Config/Autoload.php";

use Config\Autoload as Autoload;
use DAO\CineRepository as CineRepository;
use Model\Cine as Cine;

include('../Config/Constants/CineConstants.php');
Autoload::start();


$cinesRepo = new CineRepository();

$cines = $cinesRepo->getAll();

if ($_GET) {

    if (isset($_GET['delete'])) {

        $id = $_GET['delete'];
        $cinesRepo->delete($id);
    }

    if (isset($_GET['update'])) {
        $cineUpdate = new Cine();

        $id = $_GET['update'];

        $cineUpdate = $cinesRepo->searchById($id);
        ?>
        <script>window.addEventListener("load",function(){
	                overlay.classList.add('active');
	                popup.classList.add('active');
        })</script>
        <?php

    }
}
?>

<main class="p-5">
			<div class="container">
				<h1 class="mb-5">Listado de cines</h1>
				<button id="btn-abrir-popup">Nuevo Cine</button>
					<table class="table">
						<thead class="thead-dark">
							<tr>
								
								<th>ID</th>
								<th>Name</th>
								<th>Adress</th>
								<th>Capacity</th>
								<th>TicketValue</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($cines as $cine) {
								if ($cine->getActive() === true) {
									?>
									<tr>
										
										<td><?php echo $cine->getId(); ?></td>
										<td><?php echo $cine->getName(); ?></td>
										<td><?php echo $cine->getAdress(); ?></td>
										<td><?php echo $cine->getCapacity(); ?></td>
										<td><?php echo $cine->getTicketValue(); ?></td>
										<td>
											<!-- UPDATE CINE -->
											<a href="./AdminCine.php?update=<?php echo $cine->getId() ?>" class="btn btn-light">
										   
												<button type="button" width="50" height="50">update</button>
											</a>
											<!-- DELETE CINE -->
											<a href="./AdminCine.php?delete=<?php echo $cine->getId() ?>" class="btn btn-light">
										  
												<button type="button" width="50" height="50">delete</button>
											</a>
										</td>
									</tr>
							<?php
								}
							} ?>
						</tbody>
					</table>
			</div>
		</main>

    <!--CREATE CINE-->

    <div class="overlay" id="overlay">
        <div class="popup" id="popup">
            <!-- <a href="#" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times"></i></a> -->
            <a href="./AdminCine.php" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>
            
            <h3>Registrar/Modificar cine</h3>

            <form class="modal-content" action="../Controllers/CineController.php" method="POST">
                <div class="contenedor-inputs">
                    <input type="hidden" name=<?php echo CINE_ID ?> value=<?php if (isset($cineUpdate)) { echo $cineUpdate->getId();} ?>>

                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" name=<?php echo CINE_NAME ?> value=<?php if (isset($cineUpdate)) {
                                                                                                        echo $cineUpdate->getName();
                                                                                                    } ?>>
                    </div>

                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" class="form-control" name=<?php echo CINE_ADRESS ?> value=<?php if (isset($cineUpdate)) {
                                                                                                            echo $cineUpdate->getAdress();
                                                                                                        } ?>>
                    </div>

                    <div class="form-group">
                        <label>Capacidad</label>
                        <input type="number" class="form-control" name=<?php echo CINE_CAPACITY ?> value=<?php if (isset($cineUpdate)) {
                                                                                                                echo (int) $cineUpdate->getCapacity();
                                                                                                            } ?>>
                    </div>

                    <div class="form-group">
                        <label>Valor de Entrada</label>
                        <input type="number" class="form-control" name=<?php echo CINE_TICKETVALUE ?> value=<?php if (isset($cineUpdate)) {
                                                                                                                echo (int) $cineUpdate->getTicketValue();
                                                                                                            } ?>>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-med btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-med btn-light">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="js/popup.js"></script>
</div>

<!--===============================================================================================-->	
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function(){
			var ps = new PerfectScrollbar(this);

			$(window).on('resize', function(){
				ps.update();
			})
		});
			
		
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

<?php include('footer.php'); ?>