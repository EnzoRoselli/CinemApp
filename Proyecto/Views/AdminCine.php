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

        var_dump($cineUpdate->getCapacity());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/cineView.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <title>CineView</title>
</head>
<body>
    
</body>
</html>


    <main class="p-5">
        <div class="container">
            <h1 class="mb-5">Listado de cines</h1>
            <button id="btn-abrir-popup" class="btn-abrir-popup">Nuevo Cine</button>
                <div class="form-group mb-4">
                </div>
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
            <a href="#" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>
            <h3>Registrar/Modificar cine</h3>

            <form class="modal-content" action="../Controllers/CineController.php" method="POST">
                <div class="contenedor-inputs">
                    <input type="hidden" name=<?php echo CINE_ID ?> value=<?php if (isset($cineUpdate)) { echo $cineUpdate->getId();} else {echo null;} ?>>

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


<?php include('footer.php'); ?>