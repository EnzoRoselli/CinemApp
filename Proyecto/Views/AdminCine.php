<?php

include('header.php');
// include('nav.php');

require "../Config/Autoload.php";

use Config\Autoload as Autoload;
use DAO\CineRepository as CineRepository;
use Model\Cine as Cine;

include('../Config/Constants/CineConstants.php');
Autoload::start();


$cinesRepo = new CineRepository();

$cines = $cinesRepo->getAll();
$cineUpdate = new Cine("","","",""); //FIJENSE PORQUE EL CONSTRUCTOR, LE PIDE PARAMETROS ----------------------------------------------------------------------
/*
if($cinesRepo->exists(null, 'agregado', 'direc')){
    echo 'lo encontr';
}
*/

if($_GET){

    if(isset($_GET['delete'])){

        $id=$_GET['delete'];
        $cinesRepo->delete($id);
    }

    if(isset($_GET['update'])){

        $id=$_GET['update'];

        $cineUpdate=$cinesRepo->searchById($id);

        
    }
}
?>
    
</body>
</html>

<div class="tuvieja">
<main class="p-5">
    <div class="container">

        <h1 class="mb-5">Listado de cines</h1>


        <form class="form-inline" action="multiaction.php" method="POST">

            <div class="form-group mb-4">
                <button type="button" class="btn btn-light mr-4" data-toggle="modal" data-target="#create-post">
                    <object type="image/svg+xml" data="img/plus.svg" width="16" height="16"></object>
                </button>

                <!-- <label for="">Selección</label>
                <select name="action" class="form-control ml-3">
                    <option value="trash">Eliminar</option>
                    <option value="enable">publicar</option>
                    <option value="disable">despublicar</option>
                </select>
                <button type="submit" class="btn btn-dark ml-3">Enviar</button> -->


            </div>


            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th></th>
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
                        if($cine->getActive() === true){
                        ?>
                        <tr>
                            <td><input type="checkbox" name="userschecked[]" /></td>
                            <td><?php echo $cine->getId(); ?></td>
                            <td><?php echo $cine->getName(); ?></td>
                            <td><?php echo $cine->getAdress(); ?></td>
                            <td><?php echo $cine->getCapacity(); ?></td>
                            <td><?php echo $cine->getTicketValue(); ?></td>
                            <td>
                                <!-- UPDATE CINE -->
                                <a href="./AdminCine.php?update=<?php echo $cine->getId() ?>" class="btn btn-light">
                                    <!-- <object type="image/svg+xml" data="img/trash-2.svg" width="50" height="50">
                                        Your browser does not support SVG
                                    </object> -->
                                    <button type="button" width="50" height="50">update</button>
                                </a>
                                <!-- DELETE CINE -->
                                <a href="./AdminCine.php?delete=<?php echo $cine->getId() ?>" class="btn btn-light">
                                    <!-- <object type="image/svg+xml" data="img/trash-2.svg" width="50" height="50">
                                        Your browser does not support SVG
                                    </object> -->
                                    <button type="button" width="50" height="50">delete</button>
                                </a>
                            </td>
                        </tr>
                    <?php
                    }} ?>
                </tbody>
            </table>
        </form>

        <!-- Esto como si no existiera -->
        <?php if (isset($successMje) || isset($errorMje)) { ?>
            <div class="alert <?php if (isset($successMje)) echo 'alert-success';
                                    else echo 'alert-danger'; ?> alert-dismissible fade show mt-3" role="alert">
                <strong><?php if (isset($successMje)) echo $successMje;
                            else echo $errorMje; ?></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>
    </div>
</main>

<!--CREATE POSTS-->
<div class="modal fade" id="create-post" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <form class="modal-content" action="../Controllers/CineController.php" method="POST">

            <div class="modal-header">
                <h5 class="modal-title">Registrar cine</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name=<?php echo CINE_NAME ?> />
                </div>

                <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" class="form-control" name=<?php echo CINE_ADRESS ?> />
                </div>

                <div class="form-group">
                    <label>Capacidad</label>
                    <input type="number" class="form-control" name=<?php echo CINE_CAPACITY ?> />
                </div>

                <div class="form-group">
                    <label>Valor de Entrada</label>
                    <input type="number" class="form-control" name=<?php echo CINE_TICKETVALUE ?> />
                </div>



            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-med btn-light" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-med btn-light">Aceptar</button>
            </div>
        </form>

    </div>
</div>

<!--UPDATE POSTS-->
<div class="modal fade" id="create-post" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <form class="modal-content" action="../Controllers/CineController.php" method="POST">

            <div class="modal-header">
                <h5 class="modal-title">Modificar cine</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                
                <!-- <div class="form-group">
                    <label>Cine ID</label> -->
                    <input type="hidden" name=<?php echo CINE_ID . "update"; ?> value=<?php echo $cineUpdate->getId() ?> />
                <!-- </div> -->
            
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name=<?php echo CINE_NAME . "update" ?> value=<?php echo $cineUpdate->getName() ?> />
                </div>

                <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" class="form-control" name=<?php echo CINE_ADRESS . "update" ?> value=<?php echo $cineUpdate->getAdress() ?> />
                </div>

                <div class="form-group">
                    <label>Capacidad</label>
                    <input type="number" class="form-control" name=<?php echo CINE_CAPACITY . "update" ?> value=<?php echo $cineUpdate->getCapacity() ?> />
                </div>

                <div class="form-group">
                    <label>Valor de Entrada</label>
                    <input type="number" class="form-control" name=<?php echo CINE_TICKETVALUE . "update" ?> value=<?php echo $cineUpdate->getTicketValue() ?> />
                </div>



            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-med btn-light" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-med btn-light">Aceptar</button>
            </div>
        </form>

    </div>
</div>

</div>


<?php include('footer.php'); ?>