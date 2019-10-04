<?php 
namespace views;
require_once ('../config/autoload.php');
use config\autoload as autoload;
autoload::Start();

use InfoAPI\genresAPI as genresAPI;





?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Search movies with filters</title>
    <link rel="stylesheet"  href="css/searchMovieStyle.css">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
  </head>
  <body>
   <form class="form" action="../process/searchMoviesWithFilters.php" method="GET">
  
  <h1>Filtros</h1>
  <br>
  <table>
    <h2>Generos<h2>
    
  <?php $genres = genresAPI::getGenres(); for ($i=0; $i < count($genres); $i++) {  $genreName = $genres[$i]->name; ?>
    <tr>
          <td>
       
            <div class='inputGroup'>       
                <input value=<?php echo"$genreName";?> id=<?php echo"$genreName";?> name="genres[]"  type='checkbox'/>
               
                <label for=<?php echo"$genreName";?> > <?php echo"$genreName";?>  </label>
            </div>
          </td>
        <?php if ( (count($genres)-$i)==1) { ?>    
        </tr>
        <?php break;  } else {
          $genreName = $genres[($i+=1)]->name;
          ?>
          <td>
            <div class='inputGroup'>       
              <input value=<?php echo"$genreName";?> id=<?php echo"$genreName";?> name="genres[]"  type='checkbox'/>
              <label for=<?php echo"$genreName";?> > <?php echo"$genreName";?>  </label>
            </div>         
          </td>
        </tr>
        <?php } } ?>
</table>
  
  <button>Enviar</button>
</form>

</form>
  </body>
</html>
