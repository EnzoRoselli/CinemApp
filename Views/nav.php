<?php

if (isset($_GET['delete']) && isset($_SESSION['loggedUser'])) {
  session_destroy();
  header("Location:" . $link .= $_SERVER['REQUEST_URI']);
}
?>

<nav>
  <div class="home-btn">

    <a href="<?php echo FRONT_ROOT . "/Home/Index" ?>" class="home-text">
      <p>Cinem</p>
      <p>App</p>
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

  <div class="nav-links">
    <ul>
      <li><a href="<?php echo  FRONT_ROOT . "/Showtime/showShowtimesListUser" ?>">Screenings</a></li>
      <li><a href="<?php echo  FRONT_ROOT . "/Cine/showCinemasOnTable" ?>">Cinemas</a></li>
      <li>Movies</li>

      <li></li>
    </ul>

  </div>
  <?php
  if (isset($_SESSION['loggedUser'])) { ?>
    <div class="nav-user">
      <ul>
        <li>
          <img src="./iconfinder_misc-_user_1276843.png" alt="" id="yo">
          <ul id="sub-menu">
          <li class="user-name-li"><?=$_SESSION['loggedUser'] ?></li>
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
  } else {
    ?>
    <a href=<?php echo FRONT_ROOT . '/user/showLoginSignup' ?>>Log-Sig</a>
  <?php } ?>
</nav>



