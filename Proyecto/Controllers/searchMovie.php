<?php
    include('../views/header.php');
    include('../views/nav.php');
require_once("../config/autoload.php");

use config\autoload as Autoload;

Autoload::Start();

use DAO\InfoAPI\moviesAPI as moviesAPI;



if (isset($_GET['title'])) {
    $title = $_GET['title'];
    $allMoviesAPI = moviesAPI::getMoviesFromApi();

    $comprobationMovie = moviesAPI::searchMovieByTitle($allMoviesAPI, $title);
    if ($comprobationMovie != null) { ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link rel="stylesheet" href="../views/css/GridStyle.css">
            <title>Document</title>
        </head>

        <body>

            <div class="container">


                <?php
                        $poster = $comprobationMovie->poster_path;
                        ?>
                <div class="block">
                    <button class="card-image">
                        <a href="">
                            <img src=<?php echo "http://image.tmdb.org/t/p/w185/" . $poster; ?> class="image">
                        </a>


                        <div class="overview">
                            <h2><?php echo $comprobationMovie->original_title; ?></h2>
                            <p><?php echo $comprobationMovie->release_date; ?></p>
                        </div>
                    </button>

                </div>



            </div>

        </body>


        </html>
        <?php
                        //echo "window.location= '../views/home.php'; </script> ";
                    } else {
                        echo "<script> alert('No se encontró la pelicula ingresada!');";
                        echo "window.location= '../views/home.php'; </script> ";
                    }
                }



             ?>