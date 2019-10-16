
<?php
    include('header.php');
    include('nav.php');
?>



  <br>
  <PRE>   <h1>             Select your genres</h1></PRE>

   <div><!--PONER TODOS LOS ACTIONS CON CLASE Y / METODO  -->
      <form class="form" action="<?php echo  FRONT_ROOT."searchMovie/searchByGenres "?>" method="GET">
        <table>
          <?php 
          for ($i = 0; $i < count($this->genres); $i++) {
            $genreName = $this->genres[$i]->name; ?>
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

