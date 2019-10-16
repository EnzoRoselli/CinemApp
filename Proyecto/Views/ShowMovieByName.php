

<?php

include('header.php');
include('nav.php');

 ?>

            <div class="container">
                <div class="block">
                    <button class="card-image">
                        <a href="">
                            <img src=<?php echo "http://image.tmdb.org/t/p/w185/" . $comprobationMovie->poster_path; ?> class="image">
                        </a>
                        <div class="overview">
                            <h2><?php echo $comprobationMovie->original_title; ?></h2>
                            <p><?php echo $comprobationMovie->release_date; ?></p>
                        </div>
                    </button>

                </div>



            </div>

        <?php
                        //echo "window.location= '../views/home.php'; </script> ";
                
                
                
                include('footer.php');
                
             ?>