<nav class="nav-container">
  <a href="" class="nav-title">
    <h2>CinemApp</h2>
  </a>
  <form action="../Controllers/searchMovie.php" method="GET">
    <div class="search-wrapper active">
      <div class="input-holder">
        <input name="title" type="text" class="search-input" placeholder="Type to search" />
        <button class="search-icon" onclick="searchToggle(this, event);"></button>
      </div>
      <!-- <span class="close" onclick="searchToggle(this, event);"></span> -->

    </div>
  </form>
  <form action="../views/SearchMoviesWithFilters.php">
    <button class="btn btn-light mr-4">
      <label for="">Búsqueda Avanzada</label>
  </form>
</nav>