<?php

if (isset($_GET['delete']) && isset($_SESSION['loggedUser'])) {
  session_destroy();
  header("Location:" . $link .= $_SERVER['REQUEST_URI']);
}
?>

<nav>
  <div class="home-btn">
    <a href="<?php echo FRONT_ROOT . "/Home/Index" ?>">
      <div class="home-text">
        <p>Cinem</p>
        <p>App</p>
      </div>

    </a>
  </div>

  <div class="home-icon">
    <a href="<?php echo FRONT_ROOT . "/Home/Index" ?>">
      <i class="fas fa-home" id="home-icon"></i>
    </a>
  </div>

  <div class="menu-icon">
    <a href="<?php echo FRONT_ROOT . "/Home/Index" ?>">
      <i class="fas fa-bars" id="menu-icon"></i>
    </a>
  </div>


  <?php
  if (/*isset($_SESSION['loggedUser'])*/true) { ?>
    <div class="nav-links">
      <ul>
      <li><a href="<?=FRONT_ROOT . "/Showtime/showShowtimesListUser" ?>">Screenings</a></li>
        <li><a href="<?php echo  FRONT_ROOT . "/Cine/showCinemasOnTable" ?>">Cinemas</a></li>
        <li><a href=<?=FRONT_ROOT . "/Home/showMovieGrid" ?>>Movies</a></li>

        <li></li>
      </ul>

    </div>
    <div class="nav-user">
      <ul>
        <li>
          <img src=<?= IMG_PATH . "/user-icon.png" ?> alt="" id="yo">
          <ul id="sub-menu">
            <li class="user-name-li"><?= 'tu vieja' ?></li>
            <li><a href="#">Account</a></li>
            <li><a href="#">My Screenings</a></li>
            <li><a href="#">Credit Cards</a></li>
            <li><a href=<?= FRONT_ROOT . '/user/logoutAction' ?>>Log-out</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  <?php
  } else if (/*isset($_SESSION['loggedAdmin'])*/false) { ?>
    <div class="nav-links">
      <ul>
        <li>
          <div class="nav-user">
            <ul>
              <li>
                Lists
                <ul id="sub-menu" class="sub-menu-admin">
                  <li><a href=<?=FRONT_ROOT . "/Cine/showCinemasOnTable" ?>>Cinemas</a></li>
                  <li><a href=<?=FRONT_ROOT . "/Showtime/showShowtimeMenu" ?>>Screenings</a></li>
                  <li><a href="#">Sales</a></li>
                </ul>
              </li>
            </ul>
          </div>  
        </li>
        <li><a href="<?=FRONT_ROOT . "/Showtime/showShowtimesListUser" ?>">Screenings</a></li>
        <li><a href="<?php echo  FRONT_ROOT . "/Cine/showCinemasOnTable" ?>">Cinemas</a></li>
        <li><a href=<?=FRONT_ROOT . "/Home/showMovieGrid" ?>>Movies</a></li>

        <li></li>
      </ul>

    </div>
    <div class="nav-user">
      <ul>
        <li>
          <img src=<?= IMG_PATH . "/admin-icon.png" ?> alt="" id="yo">
          <ul id="sub-menu">
            <li class="user-name-li"><?= 'admin' ?></li>
            <li><a href=<?= FRONT_ROOT . '/user/logoutAction' ?>>Log-out</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  <?php } else {
    ?>
    <div class="nav-links">
      <ul>
      <li><a href="<?=FRONT_ROOT . "/Showtime/showShowtimesListUser" ?>">Screenings</a></li>
        <li><a href="<?php echo  FRONT_ROOT . "/Cine/showCinemasOnTable" ?>">Cinemas</a></li>
        <li><a href=<?=FRONT_ROOT . "/Home/showMovieGrid" ?>>Movies</a></li>

        <li></li>
      </ul>

    </div>
    <div class="nav-user">
      <ul>
        <li>
        <a href=<?php echo FRONT_ROOT . '/user/showLoginSignup' ?>>Log-Sig</a>
          
        </li>
      </ul>
    </div>
    
  <?php } ?>
</nav>