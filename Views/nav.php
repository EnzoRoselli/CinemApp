<?php

if (isset($_GET['delete']) && isset($_SESSION['loggedUser'])) {
  session_destroy();
  header("Location:" . $link .= $_SERVER['REQUEST_URI']);
}
?>

<nav class="navbar">

  <div class="home-btn">
    <a href="<?php echo FRONT_ROOT."/Home/Index"?>" class="home-ref">
      <p>Cinem</p>
      <p>App</p>
    </a>
    
    <div class="home-icon">
      <a href="<?php echo FRONT_ROOT."/Home/Index"?>">
        <i class="fas fa-home" id="home-icon"></i>
      </a>
    </div>

    <div class="menu-icon">
      <a href="<?php echo FRONT_ROOT."/Home/Index"?>">
      <i class="fas fa-bars" id="menu-icon"></i>
      </a>
    </div>
    

  </div>


  <form action="<?php echo  FRONT_ROOT . "/searchMovie/searchMovieByName " ?>" method="GET">
    <div class="search-bar">
      <input name="title" type="text" class="search-input" placeholder="Type to search" />
      <button class="search-btn">
        <img src="<?php echo IMG_PATH . "/search-32.png" ?>" alt=""></button>
      </button>
    </div>

  </form>
  <ul class="nav-links">
    <li><a href=<?php echo  FRONT_ROOT . "/Cine/showCinemaMenu" ?>>Cine</a></li>
    <li><a href=<?php echo  FRONT_ROOT . "/genres/showGenresFilter " ?>>Browse</a></li>
    <?php
    if (isset($_SESSION['loggedUser'])) { ?>
      <div class="">
        <p><?php echo substr(strtoupper($_SESSION['loggedUser']), 0, 8); ?></p>
        <a href=<?php echo VIEWS_PATH . '/Home.php?delete=1' ?>>Log out</a>
      </div>
    <?php
    } else {
      ?>


      <li><a href=<?php echo VIEWS_PATH . '/AdminCine.php' ?>>Log-Sig</a></li>
      </form>

    <?php } ?>
  </ul>
</nav>