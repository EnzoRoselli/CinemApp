<?php session_start();
if (isset($_GET['delete']) && isset($_SESSION['loggedUser'])) {
  session_destroy();
  header("Location:" . $link .= $_SERVER['REQUEST_URI']);
}
?>

<nav class="navbar">

  <div class="home-btn">
    <p>Cinem</p>
    <p>App</p>
  </div>

  <a href="#">
    <i class="fas fa-home fa-2x" id="home-icon"></i>
  </a>
  <form action="<?php echo  FRONT_ROOT . "searchMovie/searchMovieByName " ?>" method="GET">
    <div class="search-bar">
      <input name="title" type="text" class="search-input" placeholder="Type to search" />
      <button class="search-btn">
        <img src="../views/img/search-32.png" alt=""></button>
      </button>
    </div>
  </form>
  <ul class="nav-links">
    <li><a href=<?php echo  FRONT_ROOT . "Cine/showGenresFilter " ?>>Cine</a></li>
    <li><a href=<?php echo  FRONT_ROOT . "genres/showGenresFilter " ?>>Browse</a></li>
    <?php
    if (isset($_SESSION['loggedUser'])) { ?>
      <div class="">
        <p><?php echo substr(strtoupper($_SESSION['loggedUser']), 0, 8); ?></p>
        <a href="../views/Home.php?delete=1">Log out</a>
      </div>
    <?php
    } else {
      ?>


      <li><a href="../views/AdminCine.php">Log-Sig</a></li>
      </form>

    <?php } ?>
  </ul>
</nav>