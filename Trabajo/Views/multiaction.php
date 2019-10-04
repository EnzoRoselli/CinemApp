<?php

require_once"./Config/Autoload.php";


session_start();

if(isset($_SESSION['user'])){
    $data = $_POST;

    call_user_func($data['action'], $data['userschecked']);

}else{
    header("location: index.php");
}

function trash($params = false) {
    
    if($params) {
        return 'Articulos eliminados';        
    } else {
        return 'Olvidaste seleccionar articulos a eliminar';
    }
}

function enable($params = false) {
    
    if($params) {
        return 'Articulos habilitados';
    } else {
        return 'Olvidaste seleccionar articulos a habilitar';
    }
}

function disable($params = false) {
    
    if($params) {
        return 'Articulos inhabilitados';
    } else {
        return 'Olvidaste seleccionar articulos a inhabilitar';
    }
}

?>


<?php include('header.php') ?>
<main>
    <div class="container">
        <div class="card text-center my-5">
            <div class="card-body">
                <?php /*echo $mje*/ ?>
            </div>
        </div>
    </div>
</main>
<?php include('footer.php') ?>