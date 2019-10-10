<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/GridStyle.css">
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
            <div class="block"><img src=<?php echo "http://image.tmdb.org/t/p/w185/" . $poster; ?> class="imagen" ></div>
        <?php
        }
        ?>

    </div>
</body>

</html>