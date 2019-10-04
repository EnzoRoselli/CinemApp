<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Search movies with filters</title>
    <link rel="stylesheet"  href="searchMoviesWithFilters.css">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
  </head>
  <body>
   <form class="form" action="../process/searchMoviesWithFilters.php" method="GET">
  
  <h2>Filtros</h2>
  <div class="inputGroup">
    <input id="option1" name="option1" type="checkbox"/>
    <label for="option1">Option One</label>
  </div>
  
  <div class="inputGroup">
    <input id="option2" name="option2" type="checkbox"/>
    <label for="option2">Option Two</label>
  </div>
  
  <button>Enviar</button>
</form>

</form>
  </body>
</html>
