<?php

include('header.php');
include('nav.php');

require "../Config/Autoload.php";
Use Config\Autoload as Autoload;

Autoload::start();

?>



<main class="p-5">
        <div class="container">

            <h1 class="mb-5">Listado de cines</h1>


            <form class="form-inline" action="multiaction.php" method="POST">

                <div class="form-group mb-4">
                    <button type="button" class="btn btn-light mr-4" data-toggle="modal" data-target="#create-post">
                        <object type="image/svg+xml" data="img/plus.svg" width="16" height="16"></object>
                    </button>

                    <label for="">Accion múltiple</label>
                    <select name="action" class="form-control ml-3">
                        <option value="trash">Eliminar</option>
                        <option value="enable">publicar</option>
                        <option value="disable">despublicar</option>
                    </select>
                    <button type="submit" class="btn btn-dark ml-3">Enviar</button>

                    
                </div>
                

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Categoría</th>
                            <th>Fecha</th>
                            <th>Texto</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                            <?php 
                              foreach($postList as $post){
                                ?>
                                        <tr> 
                                        <td><input type="checkbox" name="userschecked[]" /></td>
                                             <td><?php echo $post->getID(); ?></td>
                                             <td><?php echo $post->getTitle(); ?></td>
                                             <td><?php echo $post->getAuthor(); ?></td>
                                             <td><?php echo $post->getCategory(); ?></td>
                                             <td><?php echo $post->getDate(); ?></td>
                                             <td><?php echo $post->getText  (); ?></td>
                                             <td>
                                         <a href="/examen_c1/posts.php?delete=<?php echo $post->getID() ?>" class="btn btn-light">
                                        <object type="image/svg+xml" data="img/trash-2.svg" width="16" height="16">
                                            Your browser does not support SVG
                                        </object>
                                    </a>
                                </td>
                                        </tr>
                                   <?php
                                    }?>
                    </tbody>
                </table>
            </form>

            <!-- Esto como si no existiera -->
            <?php if(isset($successMje) || isset($errorMje)) { ?>
                <div class="alert <?php if(isset($successMje)) echo 'alert-success'; else echo 'alert-danger'; ?> alert-dismissible fade show mt-3" role="alert">
                    <strong><?php if(isset($successMje)) echo $successMje; else echo $errorMje; ?></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>
        </div>
    </main>
    
    <!--
        CREATE POSTS
    -->
    <div class="modal fade" id="create-post" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <form class="modal-content" action="publish.php" method="POST">

                <div class="modal-header">
                    <h5 class="modal-title">Registrar cine</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" class="form-control" name="title" />
                    </div>

                    <div class="form-group">
                        <label>Autor</label>
                        <input type="text" disabled value="<?php echo $user->getName() ?>" class="form-control">
                        <input type="hidden" name="author" value="<?php echo $user->getName() ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Categoría</label>

                        <select name="category">

                            <?php foreach($categories as $cat){
                                echo '<option value=" '. $cat->getName() .' ">' . $cat->getName() . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Fecha</label>
                        <input type="date" class="form-control" name="date" />
                    </div>

                    <div class="form-group">
                        <label>Texto</label>
                        <textarea name="text" class="form-control"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark">Publicar</button>
                </div>
            </form>

        </div>
    </div>

    <?php include('footer.php'); ?>