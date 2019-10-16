<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/GridStyle.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <?php
        require_once("../config/autoload.php");

        use Config\Autoload as Autoload;

        Autoload::Start();

        use DAO\InfoAPI\moviesAPI as moviesAPI;

        
        $movies = moviesAPI::getMoviesFromApi();
        

        for ($i = 0; $i < count($movies); $i++) {
            $poster = $movies[$i]->poster_path;
            ?>
            <div class="block">
                <button class="card-image">
                    <a href="">
                    <img src=<?php echo "http://image.tmdb.org/t/p/w185/" . $poster; ?> class="image">
                    </a>
                    
                    
                    <div class="overview">
                        <h2><?php echo $movies[$i]->original_title;?></h2>
                        <p><?php echo $movies[$i]->release_date;?></p>
                    </div>
                </button>

            </div>
        <?php
        }
        ?>

    </div>
</body>

</html>
