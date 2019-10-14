<?php
namespace Views;

    include('header.php');
    include('nav.php');

require "../Config/Autoload.php";

use config\autoload as autoload;

autoload::Start();

use DAO\InfoAPI\genresAPI as genresAPI;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Search movies with filters</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
</head>

<body>
  <br>
  <PRE>   <h1>             Select your genres</h1></PRE>

  <div>
      <form class="form" action="../Controllers/searchMovieWithFiltersController.php" method="GET">
        <table>
          <?php $genres = genresAPI::getGenres();
          for ($i = 0; $i < count($genres); $i++) {
            $genreName = $genres[$i]->name; ?>
            <tr>
              <td>
                <div class='inputGroup' id="first-input">
                  <input value=<?php echo "$genreName"; ?> id=<?php echo "$genreName"; ?> name="genres[]" type='checkbox' />

                  <label for=<?php echo "$genreName"; ?>> <?php echo "$genreName"; ?> </label>
                </div>
              </td>
              <?php if ((count($genres) - $i) == 1) { ?>
            </tr>
          <?php break;
            } else {
              $genreName = $genres[($i += 1)]->name;
              ?>
            <td>
              <div class='inputGroup'  id="second-input">
                <input value=<?php echo "$genreName"; ?> id=<?php echo "$genreName"; ?> name="genres[]" type='checkbox' />
                <label for=<?php echo "$genreName"; ?>> <?php echo "$genreName"; ?> </label>
              </div>
            </td>
            </tr>
        <?php }
        } ?>
        </table>
        
        <button id="btn-searchWithFilters">Filter</button>
      </form>
      </div>
      <!-- <div class='dateFilter'>
          <label for="date">Select Date:</label>
          <input type="date"  min="<?php /*echo date('Y-m-d',strtotime(date('Y-m-d',time())));*/?>" name="date">         
        </div> -->


</body>

</html>